import asyncio
import json
import urllib.request
import websockets
import subprocess
import time
import base64

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
proc = subprocess.Popen([
    CHROME,
    "--headless=new",
    "--remote-debugging-port=9236",
    "--user-data-dir=C:\\tmp\\chrome_rv1_mshot_9236",
    "--disable-gpu",
    "--allow-file-access-from-files",
    "about:blank"
], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(2)

try:
    async def capture_mobile():
        req = urllib.request.urlopen("http://127.0.0.1:9236/json")
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
            # Set height to 9000 so the entire section is in viewport
            await call("Emulation.setDeviceMetricsOverride", {"width": 390, "height": 9000, "deviceScaleFactor": 1, "mobile": True})
            await call("Page.navigate", {"url": "file:///C:/bakcup/30beta/index.html"})
            await asyncio.sleep(2)
            
            rect_res = await call("Runtime.evaluate", {
                "expression": """
                (function(){
                    var el = document.querySelector('[builder-id="builder-f17307f9ac1f491cbf82626333b7666a"]');
                    var r = el.getBoundingClientRect();
                    return JSON.stringify({
                        x: Math.max(0, Math.round(r.left) - 10),
                        y: Math.max(0, Math.round(r.top) - 10),
                        width: Math.round(r.width) + 20,
                        height: Math.round(r.height) + 20,
                        scale: 1
                    });
                })()
                """,
                "returnByValue": True
            })
            clip = json.loads(rect_res.get("result", {}).get("value", "{}"))
            print("Mobile Clip in 9000 viewport:", clip)
            
            shot = await call("Page.captureScreenshot", {"format": "png", "clip": clip})
            data = base64.b64decode(shot.get("data", ""))
            with open("verification_screenshots/botanicos_mobile_exact.png", "wb") as f:
                f.write(data)
            print("Saved verification_screenshots/botanicos_mobile_exact.png")

    asyncio.run(capture_mobile())
finally:
    proc.terminate()
