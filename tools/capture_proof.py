import subprocess
import time
from PIL import Image

CHROME = r"C:\Program Files\Google\Chrome\Application\chrome.exe"
PORT = 8091

server_proc = subprocess.Popen(["python", "-m", "http.server", str(PORT)], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(1.5)

try:
    for w, h, name in [(1440, 900, "proof_1440.png"), (768, 1024, "proof_768.png"), (390, 844, "proof_390.png")]:
        cmd = [
            CHROME,
            "--headless=new",
            "--disable-gpu",
            "--hide-scrollbars",
            f"--window-size={w},{h}",
            f"--screenshot=C:\\bakcup\\30beta\\verification_screenshots\\{name}",
            f"http://127.0.0.1:{PORT}/index.html"
        ]
        subprocess.run(cmd, timeout=15)
finally:
    server_proc.terminate()

print("Captured screenshots.")
