import asyncio
import json
import subprocess
import time
import urllib.request
import websockets
import os

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
PORT = 8096

async def measure(width):
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
        
        doc = await call("Runtime.evaluate", {"expression": "document.title", "returnByValue": True})
        print("Page title:", doc.get("result", {}).get("value"))

        js = """
        (function(){
            var el = document.querySelector('.sj-proof') || document.querySelector('[class*="builder-6f5d765b877345e3aa80e93cd1450b14"]');
            if (!el) return { error: 'not found', totalDivs: document.querySelectorAll('div').length };
            var r = el.getBoundingClientRect();
            var cs = window.getComputedStyle(el);
            var cards = [];
            Array.prototype.forEach.call(el.children, function(c, idx){
                var cr = c.getBoundingClientRect();
                var ccs = window.getComputedStyle(c);
                var textDiv = c.querySelector('.css-q2qocb') || c.children[1];
                var tr = textDiv ? textDiv.getBoundingClientRect() : null;
                var tcs = textDiv ? window.getComputedStyle(textDiv) : null;
                var p1 = c.querySelectorAll('p')[0];
                var p1r = p1 ? p1.getBoundingClientRect() : null;
                var p2 = c.querySelectorAll('p')[1];
                var p2r = p2 ? p2.getBoundingClientRect() : null;
                cards.push({
                    idx: idx,
                    card_box: { top: Math.round(cr.top), bottom: Math.round(cr.bottom), left: Math.round(cr.left), right: Math.round(cr.right), w: Math.round(cr.width), h: Math.round(cr.height) },
                    card_styles: { display: ccs.display, flex: ccs.flex, padding: ccs.padding, border: ccs.border, overflow: ccs.overflow },
                    text_box: tr ? { top: Math.round(tr.top), bottom: Math.round(tr.bottom), left: Math.round(tr.left), right: Math.round(tr.right), w: Math.round(tr.width), h: Math.round(tr.height) } : null,
                    text_styles: tcs ? { display: tcs.display, flex: tcs.flex, width: tcs.width, overflow: tcs.overflow } : null,
                    p1_box: p1r ? { top: Math.round(p1r.top), bottom: Math.round(p1r.bottom), left: Math.round(p1r.left), right: Math.round(p1r.right), w: Math.round(p1r.width), h: Math.round(p1r.height) } : null,
                    p2_box: p2r ? { top: Math.round(p2r.top), bottom: Math.round(p2r.bottom), left: Math.round(p2r.left), right: Math.round(p2r.right), w: Math.round(p2r.width), h: Math.round(p2r.height) } : null,
                    p1_text: p1 ? p1.innerText : '',
                    p2_text: p2 ? p2.innerText : ''
                });
            });
            return {
                proof_box: { top: Math.round(r.top), bottom: Math.round(r.bottom), left: Math.round(r.left), right: Math.round(r.right), w: Math.round(r.width), h: Math.round(r.height) },
                proof_styles: { display: cs.display, flexDir: cs.flexDirection, borderTop: cs.borderTop, borderBottom: cs.borderBottom, overflow: cs.overflowX },
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
        "--user-data-dir=C:\\tmp\\chrome_measure",
        "--disable-gpu",
        "about:blank"
    ], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    time.sleep(2)
    
    try:
        for w in [1440, 768, 390]:
            data = asyncio.run(measure(w))
            print(f"\n==================== WIDTH: {w}px ====================")
            print(json.dumps(data, indent=2))
    finally:
        chrome_proc.terminate()
        server_proc.terminate()

if __name__ == "__main__":
    main()
