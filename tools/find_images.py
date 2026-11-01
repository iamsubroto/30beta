import re
import os
import urllib.parse
from curl_cffi import requests

with open("rendered_builder.html", "r", encoding="utf-8") as f:
    html = f.read()

# Find all src and srcset images
srcs = re.findall(r'src="([^"]+)"', html)
bg_imgs = re.findall(r'url\([\'"]?([^\'")]+)[\'"]?\)', html)

all_urls = set()
for s in srcs:
    if s.startswith("http") or s.startswith("//") or s.startswith("/"):
        all_urls.add(s)

for b in bg_imgs:
    if b.startswith("http") or b.startswith("//"):
        all_urls.add(b)

print(f"Total unique image URLs found: {len(all_urls)}")
for u in sorted(all_urls):
    print(u)
