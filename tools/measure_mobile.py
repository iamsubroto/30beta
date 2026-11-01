import asyncio
import json
import subprocess
import time
import urllib.request
import websockets

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
PORT = 8098

async def measure_single(width):
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
        await call("Emulation.setDeviceMetricsOverride", {
            "width": width,
            "height": 1000,
            "deviceScaleFactor": 1,
            "mobile": width < 768
        })
        await call("Page.navigate", {"url": f"http://127.0.0.1:{PORT}/index.html"})
        await asyncio.sleep(2)

        js = """
        (function(){
            var el = document.querySelector('.sj-proof') || document.querySelector('[class*="builder-6f5d765b877345e3aa80e93cd1450b14"]');
            if (!el) return { error: 'not found' };
            var r = el.getBoundingClientRect();
            var cards = [];
            Array.prototype.forEach.call(el.children, function(c, idx){
                var cr = c.getBoundingClientRect();
                var textDiv = c.querySelector('.css-q2qocb') || c.children[1];
                var tr = textDiv ? textDiv.getBoundingClientRect() : null;
                cards.push({
                    idx: idx,
                    card_left: Math.round(cr.left),
                    card_right: Math.round(cr.right),
                    card_width: Math.round(cr.width),
                    text_left: tr ? Math.round(tr.left) : null,
                    text_right: tr ? Math.round(tr.right) : null,
                    text_width: tr ? Math.round(tr.width) : null,
                    is_within_box: tr ? (Math.round(tr.right) <= Math.round(cr.right)) : true,
                    text: c.innerText.replace(/\\n/g, ' ')
                });
            });
            return {
                width: window.innerWidth,
                proof_w: Math.round(r.width),
                cards: cards
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
        "--user-data-dir=C:\\tmp\\chrome_measure_390",
        "--disable-gpu",
        "about:blank"
    ], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    time.sleep(2)
    
    try:
        for w in [390, 430]:
            data = asyncio.run(measure_single(w))
            print(f"\n==================== WIDTH: {w}px ====================")
            print(json.dumps(data, indent=2))
    finally:
        chrome_proc.terminate()
        server_proc.terminate()

if __name__ == "__main__":
    main()
