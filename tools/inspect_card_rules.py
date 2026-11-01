import asyncio
import json
import subprocess
import time
import urllib.request
import websockets

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
PORT = 8097

async def inspect():
    req = urllib.request.urlopen("http://127.0.0.1:9222/json")
    targets = json.loads(req.read().decode())
    target = targets[0]
    ws_url = target["webSocketDebuggerUrl"]
    
    async with websockets.connect(ws_url) as ws:
        msg_id = [1]
        async def call(m, p={}):
            mid = msg_id[0]
            msg_id[0] += 1
            await ws.send(json.dumps({"id": mid, "method": m, "params": p}))
            while True:
                resp = json.loads(await ws.recv())
                if resp.get("id") == mid:
                    return resp.get("result", {})

        await call("Page.enable")
        await call("Page.navigate", {"url": f"http://127.0.0.1:{PORT}/index.html"})
        await asyncio.sleep(2)
        
        js = """
        (function(){
            var el = document.querySelector('.builder-6f5d765b877345e3aa80e93cd1450b14');
            var card1 = el.children[1];
            var textDiv = card1.querySelector('.css-q2qocb');
            var p = textDiv.querySelector('p');
            
            // test applying inline styles directly
            return {
                card1_width: card1.offsetWidth,
                card1_clientW: card1.clientWidth,
                textDiv_offsetW: textDiv.offsetWidth,
                textDiv_scrollW: textDiv.scrollWidth,
                p_offsetW: p.offsetWidth,
                matchedCSSRules: window.getComputedStyle(textDiv).flexGrow + ' ' + window.getComputedStyle(textDiv).flexShrink + ' ' + window.getComputedStyle(textDiv).flexBasis
            };
        })();
        """
        res = await call("Runtime.evaluate", {"expression": js, "returnByValue": True})
        return res.get("result", {}).get("value", {})

def main():
    server_proc = subprocess.Popen(["python", "-m", "http.server", str(PORT)], cwd=r"C:\bakcup\30beta", stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    chrome_proc = subprocess.Popen([
        CHROME,
        "--headless=new",
        "--remote-debugging-port=9222",
        "--user-data-dir=C:\\tmp\\chrome_inspect",
        "--disable-gpu",
        "--window-size=1440,1000",
        "about:blank"
    ], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    time.sleep(2)
    
    try:
        data = asyncio.run(inspect())
        print(json.dumps(data, indent=2))
    finally:
        chrome_proc.terminate()
        server_proc.terminate()

if __name__ == "__main__":
    main()
