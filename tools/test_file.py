import asyncio
import json
import subprocess
import time
import urllib.request
import websockets

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"

async def run():
    req = urllib.request.urlopen("http://127.0.0.1:9224/json")
    targets = json.loads(req.read().decode())
    target = [t for t in targets if t.get("type") == "page"][0]
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
        for width in [1920, 1440, 991, 768, 430, 390]:
            await call("Emulation.setDeviceMetricsOverride", {
                "width": width,
                "height": 1000,
                "deviceScaleFactor": 1,
                "mobile": width < 768
            })
            await call("Page.navigate", {"url": "file:///C:/bakcup/30beta/index.html"})
            await asyncio.sleep(1.5)
            
            js = """
            (function() {
                var el = document.querySelector('.sj-proof');
                if (!el) return { error: 'sj-proof not found' };
                var r = el.getBoundingClientRect();
                var cards = [];
                for (var i = 0; i < el.children.length; i++) {
                    var c = el.children[i];
                    var cr = c.getBoundingClientRect();
                    var textDiv = c.querySelector('.css-q2qocb') || c.children[1];
                    var tr = textDiv ? textDiv.getBoundingClientRect() : null;
                    var p = textDiv ? textDiv.querySelector('p') : null;
                    var pr = p ? p.getBoundingClientRect() : null;
                    cards.push({
                        idx: i,
                        card_left: Math.round(cr.left),
                        card_right: Math.round(cr.right),
                        card_width: Math.round(cr.width),
                        text_left: tr ? Math.round(tr.left) : null,
                        text_right: tr ? Math.round(tr.right) : null,
                        text_width: tr ? Math.round(tr.width) : null,
                        p_right: pr ? Math.round(pr.right) : null,
                        p_width: pr ? Math.round(pr.width) : null,
                        fits_card: tr ? (Math.round(tr.right) <= Math.round(cr.right)) : true,
                        p_fits_card: pr ? (Math.round(pr.right) <= Math.round(cr.right)) : true,
                        snippet: c.innerText.replace(/\\s+/g, ' ').substring(0, 45)
                    });
                }
                return {
                    width: window.innerWidth,
                    proof_width: Math.round(r.width),
                    cards: cards
                };
            })()
            """
            res = await call("Runtime.evaluate", {"expression": js, "returnByValue": True})
            print(f"=== VIEWPORT {width}px ===")
            print(json.dumps(res.get("result", {}).get("value", {}), indent=2))

def main():
    chrome_proc = subprocess.Popen([
        CHROME,
        "--headless=new",
        "--remote-debugging-port=9224",
        "--user-data-dir=C:\\tmp\\chrome_test_file_9224",
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
