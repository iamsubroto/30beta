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
    "--remote-debugging-port=9243",
    "--user-data-dir=C:\\tmp\\chrome_vertical_proof_9243",
    "--disable-gpu",
    "--allow-file-access-from-files",
    "about:blank"
], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(2)

try:
    async def measure():
        req = urllib.request.urlopen("http://127.0.0.1:9243/json")
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
            
            for w in [1440, 768, 430, 390]:
                await call("Emulation.setDeviceMetricsOverride", {"width": w, "height": 1000, "deviceScaleFactor": 1, "mobile": w < 768})
                await call("Page.navigate", {"url": "file:///C:/bakcup/30beta/index.html"})
                await asyncio.sleep(1.5)
                
                js = """
                (function(){
                    var proof = document.querySelector('.sj-proof');
                    if (!proof) return { error: 'not found' };
                    var cs = window.getComputedStyle(proof);
                    var pr = proof.getBoundingClientRect();
                    var cards = [];
                    for (var i = 0; i < proof.children.length; i++) {
                        var c = proof.children[i];
                        var cr = c.getBoundingClientRect();
                        cards.push({
                            index: i,
                            left: Math.round(cr.left),
                            right: Math.round(cr.right),
                            top: Math.round(cr.top),
                            bottom: Math.round(cr.bottom),
                            width: Math.round(cr.width),
                            height: Math.round(cr.height),
                            fits_horizontally: Math.round(cr.left) >= 0 && Math.round(cr.right) <= window.innerWidth,
                            text: c.innerText.replace(/\\s+/g, ' ').substring(0, 40)
                        });
                    }
                    var is_vertical = cards.length === 3 && cards[1].top >= cards[0].bottom && cards[2].top >= cards[1].bottom;
                    var is_horizontal = cards.length === 3 && cards[1].left >= cards[0].right && cards[2].left >= cards[1].right;
                    return {
                        viewport: window.innerWidth,
                        flexDirection: cs.flexDirection,
                        proof_width: Math.round(pr.width),
                        is_vertical: is_vertical,
                        is_horizontal: is_horizontal,
                        all_fit_horizontally: cards.every(function(c){ return c.fits_horizontally; }),
                        cards: cards
                    };
                })()
                """
                res = await call("Runtime.evaluate", {"expression": js, "returnByValue": True})
                print(f"=== VIEWPORT {w}px ===")
                print(json.dumps(res.get("result", {}).get("value", {}), indent=2))

    asyncio.run(measure())
finally:
    proc.terminate()
