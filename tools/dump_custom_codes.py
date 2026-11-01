import json

with open("next_data.json", "r", encoding="utf-8") as f:
    props = json.load(f)

landing_data = props.get("landing", {}).get("data", {})

custom_codes = []

def collect(node):
    comp = node.get("component", {})
    if comp and comp.get("name") == "Custom Code":
        custom_codes.append({
            "id": node.get("id"),
            "code": comp.get("options", {}).get("code", "")
        })
    for child in node.get("children", []):
        collect(child)

for b in landing_data.get("blocks", []):
    collect(b)

with open("custom_codes.json", "w", encoding="utf-8") as f:
    json.dump(custom_codes, f, indent=2, ensure_ascii=False)

print(f"Saved {len(custom_codes)} custom codes to custom_codes.json")
for i, cc in enumerate(custom_codes):
    code = cc["code"]
    has_script = "<script" in code
    has_style = "<style" in code
    print(f"CC {i} (id: {cc['id']}): len={len(code)}, has_style={has_style}, has_script={has_script}")
