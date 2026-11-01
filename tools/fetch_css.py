from curl_cffi import requests

headers = {
    "Accept": "text/css,*/*;q=0.1",
    "Referer": "https://www.immunotec.com/es-US/momentum/page/she-join"
}

url = "https://www.immunotec.com/_next/static/css/9388ea78c23b6582.css"
r = requests.get(url, impersonate="chrome124", headers=headers)
print("CSS Status:", r.status_code, "Length:", len(r.text))
with open("immunotec_next.css", "w", encoding="utf-8") as f:
    f.write(r.text)
