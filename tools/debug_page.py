import asyncio
import json
import subprocess
import time
import urllib.request
import websockets

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"

async def run():
    req = urllib.request.urlopen("http://127.0.0.1:9225/json")
    target = json.loads(req.read().decode())[0]
    async with websockets.connect(target["webSocketDebuggerUrl"]) as ws:
        mid = 1
        async def call(m, p={}):
            nonlocal mid
            cur = mid; mid += 1
            await ws.send(json.dumps({"id": cur, "method": m, "params": p}))
            while True:
                resp = json.loads(await ws.recv())
                if resp.get("id") == cur:
                    return resp.get("result", {})
        
        await call("Page.enable")
        await call("Page.navigate", {"url": "file:///C:/bakcup/30beta/index.html"})
        await asyncio.sleep(2)
        res = await call("Runtime.evaluate", {
            "expression": "JSON.stringify({ title: document.title, url: window.location.href, bodyLen: document.body.innerHTML.length, classes: Array.from(document.querySelectorAll('[class*=\"proof\"]')).map(e => e.className) })",
            "returnByValue": True
        })
        print(res.get("result", {}).get("value"))

def main():
    chrome_proc = subprocess.Popen([
        CHROME,
        "--headless=new",
        "--remote-debugging-port=9225",
        "--user-data-dir=C:\\tmp\\chrome_test_debug_9225",
        "--disable-gpu",
        "--allow-file-access-from-files",
        "about:blank"
    ], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    time.sleep(2)
    try:
        asyncio.run(run())
    finally:
        chrome_proc.terminate()

if __name__ == "__main__":
    main()
