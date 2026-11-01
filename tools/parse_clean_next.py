import json
import re

with open("fetched_clean.html", "r", encoding="utf-8") as f:
    html = f.read()

match = re.search(r'<script id="__NEXT_DATA__" type="application/json">(.*?)</script>', html)
if match:
    data = json.loads(match.group(1))
    page_props = data.get("props", {}).get("pageProps", {})
    with open("next_data.json", "w", encoding="utf-8") as out:
        json.dump(page_props, out, indent=2, ensure_ascii=False)
    print("Saved clean next_data.json!")
