import json
import re
from bs4 import BeautifulSoup # let's check if bs4 or regex can be used

# Let's inspect __NEXT_DATA__
with open("fetched.html", "r", encoding="utf-8") as f:
    html = f.read()

# Find __NEXT_DATA__
match = re.search(r'<script id="__NEXT_DATA__" type="application/json">(.*?)</script>', html)
if match:
    data = json.loads(match.group(1))
    print("Found __NEXT_DATA__!")
    print("Keys in data:", data.keys())
    page_props = data.get("props", {}).get("pageProps", {})
    print("Keys in pageProps:", page_props.keys())
    with open("next_data.json", "w", encoding="utf-8") as out:
        json.dump(page_props, out, indent=2, ensure_ascii=False)
    print("Saved next_data.json")

# Find stylesheets
css_links = re.findall(r'<link[^>]*rel="stylesheet"[^>]*href="([^"]+)"', html)
print("CSS links:", css_links)

# Find style tags
styles = re.findall(r'<style[^>]*>(.*?)</style>', html, re.DOTALL)
print("Style tags count:", len(styles))
