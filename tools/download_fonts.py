import os
from curl_cffi import requests

os.makedirs("assets/fonts", exist_ok=True)
os.makedirs("assets/images", exist_ok=True)
os.makedirs("assets/icons", exist_ok=True)

fonts = [
    ("803c464be3d2b727-s.p.woff2", "https://www.immunotec.com/_next/static/media/803c464be3d2b727-s.p.woff2"),
    ("a78f026cb920db78-s.p.woff2", "https://www.immunotec.com/_next/static/media/a78f026cb920db78-s.p.woff2"),
    ("10e68fcded945cbf-s.p.woff2", "https://www.immunotec.com/_next/static/media/10e68fcded945cbf-s.p.woff2"),
]

for name, url in fonts:
    path = os.path.join("assets/fonts", name)
    if not os.path.exists(path):
        print("Downloading font:", name)
        r = requests.get(url, impersonate="chrome124")
        if r.status_code == 200:
            with open(path, "wb") as f:
                f.write(r.content)
            print("Saved", path, len(r.content), "bytes")
        else:
            print("Failed to download font", name, r.status_code)
