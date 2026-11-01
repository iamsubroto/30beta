import asyncio
import json
import urllib.request
import websockets
import subprocess
import time
from PIL import Image

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
proc = subprocess.Popen([
    CHROME,
    "--headless=new",
    "--remote-debugging-port=9235",
    "--user-data-dir=C:\\tmp\\chrome_rv1_find_9235",
    "--disable-gpu",
    "--allow-file-access-from-files",
    "about:blank"
], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(2)

try:
    async def find_pos():
        req = urllib.request.urlopen("http://127.0.0.1:9235/json")
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
            # Same parameters as capture_tall: window size 390x18000 without emulation
            # or with emulation? In capture_tall: "--window-size=390,18000"
            await call("Page.navigate", {"url": "file:///C:/bakcup/30beta/index.html"})
            await asyncio.sleep(2)
            
            js = """
            (function(){
                var el = document.querySelector('[builder-id="builder-f17307f9ac1f491cbf82626333b7666a"]');
                var r = el.getBoundingClientRect();
                return JSON.stringify({
                    top: Math.round(r.top + window.pageYOffset),
                    bottom: Math.round(r.bottom + window.pageYOffset),
                    left: Math.round(r.left),
                    right: Math.round(r.right),
                    width: Math.round(r.width),
                    height: Math.round(r.height),
                    text: el.innerText.replace(/\\s+/g, ' ').substring(0, 60)
                });
            })()
            """
            res = await call("Runtime.evaluate", {"expression": js, "returnByValue": True})
            return json.loads(res.get("result", {}).get("value", "{}"))

    pos = asyncio.run(find_pos())
    print("Pos:", pos)

    im = Image.open("verification_screenshots/tall_390.png")
    y1 = max(0, pos["top"] - 30)
    y2 = min(im.height, pos["bottom"] + 30)
    crop = im.crop((0, y1, 390, y2))
    crop.save("verification_screenshots/botanicos_mobile_final.png")
    print("Saved crop:", y1, y2)

finally:
    proc.terminate()
