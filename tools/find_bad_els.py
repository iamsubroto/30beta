import asyncio
import json
import urllib.request
import websockets
import subprocess
import time

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
proc = subprocess.Popen([
    CHROME,
    "--headless=new",
    "--remote-debugging-port=9241",
    "--user-data-dir=C:\\tmp\\chrome_layout_9241",
    "--disable-gpu",
    "--allow-file-access-from-files",
    "about:blank"
], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(2)

try:
    async def run():
        req = urllib.request.urlopen("http://127.0.0.1:9241/json")
        target = [t for t in json.loads(req.read().decode()) if t.get("type") == "page"][0]
        async with websockets.connect(target["webSocketDebuggerUrl"]) as ws:
            mid = 1
            async def call(m, p={}):
                nonlocal mid; cur = mid; mid += 1
                await ws.send(json.dumps({"id": cur, "method": m, "params": p}))
                while True:
                    resp = json.loads(await ws.recv())
                    if resp.get("id") == cur: return resp.get("result", {})
            await call("Page.enable")
            await call("Emulation.setDeviceMetricsOverride", {"width": 390, "height": 844, "deviceScaleFactor": 1, "mobile": True})
            await call("Page.navigate", {"url": "file:///C:/bakcup/30beta/index.html"})
            await asyncio.sleep(2)
            
            js = """
            (function(){
                var bad = [];
                document.querySelectorAll('*').forEach(function(el){
                    var r = el.getBoundingClientRect();
                    if (r.right > 390 + 2) {
                        bad.push({
                            tag: el.tagName,
                            id: el.getAttribute('builder-id') || el.id,
                            cls: el.className,
                            right: Math.round(r.right),
                            diff: Math.round(r.right - 390),
                            txt: (el.innerText || '').substring(0, 30)
                        });
                    }
                });
                return bad;
            })()
            """
            res = await call("Runtime.evaluate", {"expression": js, "returnByValue": True})
            print(json.dumps(res.get("result", {}).get("value", []), indent=2))
    asyncio.run(run())
finally:
    proc.terminate()
