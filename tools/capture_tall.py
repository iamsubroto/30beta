import subprocess
import time
import os

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
PORT = 8087

server_proc = subprocess.Popen(["python", "-m", "http.server", str(PORT)], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(1.5)

try:
    out_dir = os.path.abspath("verification_screenshots")
    out_tall_1440 = os.path.join(out_dir, "tall_1440.png")
    out_tall_390 = os.path.join(out_dir, "tall_390.png")

    print("Capturing tall desktop (1440x14000)...")
    cmd1 = [
        CHROME,
        "--headless=new",
        "--disable-gpu",
        "--hide-scrollbars",
        "--window-size=1440,14000",
        f"--screenshot={out_tall_1440}",
        f"http://127.0.0.1:{PORT}/index.html"
    ]
    subprocess.run(cmd1, capture_output=True, text=True, timeout=20)
    print(f"Tall desktop saved: {os.path.getsize(out_tall_1440)} bytes")

    print("Capturing tall mobile (390x18000)...")
    cmd2 = [
        CHROME,
        "--headless=new",
        "--disable-gpu",
        "--hide-scrollbars",
        "--window-size=390,18000",
        f"--screenshot={out_tall_390}",
        f"http://127.0.0.1:{PORT}/index.html"
    ]
    subprocess.run(cmd2, capture_output=True, text=True, timeout=20)
    print(f"Tall mobile saved: {os.path.getsize(out_tall_390)} bytes")

finally:
    server_proc.terminate()
