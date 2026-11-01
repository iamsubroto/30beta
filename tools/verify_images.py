import os
import json

with open("image_map.json", "r", encoding="utf-8") as f:
    m = json.load(f)

downloaded = 0
missing = 0
for u, p in m.items():
    if os.path.exists(p) and os.path.getsize(p) > 0:
        downloaded += 1
    else:
        missing += 1
        print("Missing or 0-byte:", u, "->", p)

print(f"Total mapped: {len(m)}, Downloaded: {downloaded}, Missing: {missing}")
