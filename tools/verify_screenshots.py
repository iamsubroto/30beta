import subprocess
import time
import urllib.request
import os

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
PORT = 8085

server_proc = subprocess.Popen(["python", "-m", "http.server", str(PORT)], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(1.5)

try:
    resp = urllib.request.urlopen(f"http://127.0.0.1:{PORT}/index.html")
    print(f"Local server responding on port {PORT}: status {resp.status}")

    viewports = [
        ("1440", 1440, 900),
        ("1920", 1920, 1080),
        ("768", 768, 1024),
        ("390", 390, 844),
        ("430", 430, 932)
    ]

    out_dir = os.path.abspath("verification_screenshots")
    os.makedirs(out_dir, exist_ok=True)

    for name, w, h in viewports:
        out_png = os.path.join(out_dir, f"screenshot_{name}.png")
        print(f"Capturing viewport {name} ({w}x{h})...")
        cmd = [
            CHROME,
            "--headless=new",
            "--disable-gpu",
            "--hide-scrollbars",
            f"--window-size={w},{h}",
            f"--screenshot={out_png}",
            f"http://127.0.0.1:{PORT}/index.html"
        ]
        res = subprocess.run(cmd, capture_output=True, text=True, timeout=15)
        if os.path.exists(out_png) and os.path.getsize(out_png) > 0:
            print(f"  Saved {out_png} ({os.path.getsize(out_png)} bytes)")
        else:
            print(f"  Failed for {name}: {res.stderr}")

finally:
    server_proc.terminate()
    print("Local server stopped.")
