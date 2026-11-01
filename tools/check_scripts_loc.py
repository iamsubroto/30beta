from bs4 import BeautifulSoup
import json

with open("rendered_builder.html", "r", encoding="utf-8") as f:
    soup = BeautifulSoup(f.read(), "html.parser")

scripts = soup.find_all("script")
print("Total script tags in rendered_builder.html:", len(scripts))
for i, s in enumerate(scripts):
    print(f"Script {i} parent:", s.parent.name, s.parent.get("class"))
    print(f"  preview: {s.get_text()[:100]}...\n")

with open("custom_codes.json", "r", encoding="utf-8") as f:
    ccs = json.load(f)

print("Custom codes count:", len(ccs))
for i, c in enumerate(ccs):
    if "<script" in c["code"]:
        print(f"CC {i} ({c['id']}) has script!")
