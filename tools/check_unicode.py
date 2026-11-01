import json

with open("next_data.json", "r", encoding="utf-8") as f:
    d = json.load(f)

title = d.get("landing", {}).get("data", {}).get("title")
print("Title:", repr(title))

# Check some text in blocks
for b in d.get("landing", {}).get("data", {}).get("blocks", []):
    txt = b.get("component", {}).get("options", {}).get("text", "")
    if "perimenopausia" in txt.lower():
        print("Found text:", repr(txt[:100]))
        break
