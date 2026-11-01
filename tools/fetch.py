from curl_cffi import requests

headers = {
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8",
    "Accept-Language": "es-US,es;q=0.9,en;q=0.8",
}

try:
    r = requests.get(
        "https://www.immunotec.com/es-US/momentum/page/she-join",
        impersonate="chrome124",
        headers=headers,
        timeout=30
    )
    print("Status:", r.status_code)
    print("Length:", len(r.text))
    print("Title in html:", "<title>" in r.text)
    with open("fetched.html", "w", encoding="utf-8") as f:
        f.write(r.text)
except Exception as e:
    print("Error:", e)
