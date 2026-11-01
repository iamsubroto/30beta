import json

with open("next_data.json", "r", encoding="utf-8") as f:
    props = json.load(f)

landing = props.get("landing", {})
print("landing keys:", landing.keys())
print("landing title/name:", landing.get("title"), landing.get("name"))

# Let's see what components/blocks/sections are in landing
for k, v in landing.items():
    if isinstance(v, (list, dict)):
        print(f"Key: {k}, type: {type(v)}, len: {len(v) if isinstance(v, list) else list(v.keys())}")
    else:
        print(f"Key: {k}, value: {str(v)[:100]}")
