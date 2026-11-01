import json
import sys

# Ensure UTF-8 output
sys.stdout.reconfigure(encoding='utf-8')

with open("next_data.json", "r", encoding="utf-8") as f:
    props = json.load(f)

landing_data = props.get("landing", {}).get("data", {})

print("Title:", landing_data.get("title"))
print("Description:", landing_data.get("description"))

custom_codes = []
images = []

def collect(node):
    comp = node.get("component", {})
    if comp:
        cname = comp.get("name")
        if cname == "Custom Code":
            code = comp.get("options", {}).get("code", "")
            custom_codes.append((node.get("id"), code))
        elif cname == "Image":
            img = comp.get("options", {}).get("image", "")
            images.append((node.get("id"), img))
    for child in node.get("children", []):
        collect(child)

for b in landing_data.get("blocks", []):
    collect(b)

print(f"Total Custom Code blocks: {len(custom_codes)}")
for i, (cid, code) in enumerate(custom_codes):
    print(f"\n--- Custom Code {i} (id: {cid}) ---")
    print(code[:300] + ("..." if len(code) > 300 else ""))

print(f"\nTotal Images: {len(images)}")
for i, (iid, img) in enumerate(images):
    print(f"Image {i}: {img}")
