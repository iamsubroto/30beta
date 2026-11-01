from curl_cffi import requests

headers = {
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8",
    "Accept-Language": "es-US,es;q=0.9,en;q=0.8",
}

r = requests.get(
    "https://www.immunotec.com/es-US/momentum/page/she-join",
    impersonate="chrome124",
    headers=headers,
    timeout=30
)

raw_bytes = r.content
print("Decoded with utf-8:")
text_utf8 = raw_bytes.decode("utf-8", errors="replace")
# Check title in text_utf8
import re
m = re.search(r'"title":"([^"]+)"', text_utf8)
if m:
    print("Title in UTF-8:", repr(m.group(1)))

with open("fetched_clean.html", "wb") as f:
    f.write(raw_bytes)

print("Saved fetched_clean.html")
