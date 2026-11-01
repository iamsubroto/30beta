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
    "--remote-debugging-port=9227",
    "--user-data-dir=C:\\tmp\\chrome_rv1_9227",
    "--disable-gpu",
    "--allow-file-access-from-files",
    "about:blank"
], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(2)

try:
    async def measure():
        req = urllib.request.urlopen("http://127.0.0.1:9227/json")
        targets = json.loads(req.read().decode())
        target = [t for t in targets if t.get("type") == "page"][0]
        async with websockets.connect(target["webSocketDebuggerUrl"]) as ws:
            mid = 1
            async def call(m, p={}):
                nonlocal mid; cur = mid; mid += 1
                await ws.send(json.dumps({"id": cur, "method": m, "params": p}))
                while True:
                    resp = json.loads(await ws.recv())
                    if resp.get("id") == cur: return resp.get("result", {})
            await call("Page.enable")
            for w in [1920, 1440, 991, 768, 430, 390]:
                await call("Emulation.setDeviceMetricsOverride", {"width": w, "height": 1000, "deviceScaleFactor": 1, "mobile": w < 768})
                await call("Page.navigate", {"url": "file:///C:/bakcup/30beta/index.html"})
                await asyncio.sleep(1.5)
                js = """
                (function(){
                    var box = document.querySelector('[builder-id="builder-f17307f9ac1f491cbf82626333b7666a"]') || document.querySelector('.sj-rv1');
                    var txt = document.querySelector('[builder-id="builder-6fbffb48bf074596be5dd28dbf2803b4"]');
                    if (!box || !txt) return { error: 'not found', hasBox: !!box, hasTxt: !!txt };
                    var br = box.getBoundingClientRect();
                    var tr = txt.getBoundingClientRect();
                    var p = txt.querySelector('p');
                    var pr = p ? p.getBoundingClientRect() : null;
                    var boxStyle = window.getComputedStyle(box);
                    var txtStyle = window.getComputedStyle(txt);
                    return {
                        width: window.innerWidth,
                        box_left: Math.round(br.left),
                        box_right: Math.round(br.right),
                        box_width: Math.round(br.width),
                        box_flex_dir: boxStyle.flexDirection,
                        txt_left: Math.round(tr.left),
                        txt_right: Math.round(tr.right),
                        txt_width: Math.round(tr.width),
                        p_right: pr ? Math.round(pr.right) : null,
                        p_width: pr ? Math.round(pr.width) : null,
                        overflows_box: Math.round(tr.right) > Math.round(br.right) || (pr && Math.round(pr.right) > Math.round(br.right)),
                        diff: Math.round(tr.right) - Math.round(br.right),
                        txt_flex: txtStyle.flex,
                        txt_flexShrink: txtStyle.flexShrink
                    };
                })()
                """
                res = await call("Runtime.evaluate", {"expression": js, "returnByValue": True})
                print(f"=== VIEWPORT {w}px ===")
                print(json.dumps(res.get("result", {}).get("value", {}), indent=2))
    asyncio.run(measure())
finally:
    proc.terminate()
