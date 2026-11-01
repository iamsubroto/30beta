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
    "--remote-debugging-port=9232",
    "--user-data-dir=C:\\tmp\\chrome_rv1_shot_9232",
    "--disable-gpu",
    "--allow-file-access-from-files",
    "about:blank"
], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(2)

try:
    async def capture(width, height, is_mobile, filename):
        req = urllib.request.urlopen("http://127.0.0.1:9232/json")
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
            await call("Emulation.setDeviceMetricsOverride", {"width": width, "height": height, "deviceScaleFactor": 1, "mobile": is_mobile})
            await call("Page.navigate", {"url": "file:///C:/bakcup/30beta/index.html"})
            await asyncio.sleep(2)
            
            rect_res = await call("Runtime.evaluate", {
                "expression": """
                (function(){
                    var el = document.querySelector('[builder-id="builder-f17307f9ac1f491cbf82626333b7666a"]');
                    el.scrollIntoView(true);
                    var r = el.getBoundingClientRect();
                    return JSON.stringify({
                        x: Math.max(0, Math.round(r.left) - 10),
                        y: Math.max(0, Math.round(r.top) - 10),
                        width: Math.round(r.width) + 20,
                        height: Math.round(r.height) + 20,
                        scale: 1,
                        scrollY: window.scrollY
                    });
                })()
                """,
                "returnByValue": True
            })
            val = json.loads(rect_res.get("result", {}).get("value", "{}"))
            print(f"{filename} Rect:", val)
            
            clip = {
                "x": val["x"],
                "y": val["y"],
                "width": val["width"],
                "height": val["height"],
                "scale": 1
            }
            shot = await call("Page.captureScreenshot", {"format": "png", "clip": clip})
            data = base64.b64decode(shot.get("data", ""))
            with open(f"verification_screenshots/{filename}", "wb") as f:
                f.write(data)
            print(f"Saved verification_screenshots/{filename}")

    asyncio.run(capture(1440, 900, False, "botanicos_desktop_1440.png"))
    asyncio.run(capture(390, 844, True, "botanicos_mobile_390.png"))

finally:
    proc.terminate()
