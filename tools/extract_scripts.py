import json
import re

with open("custom_codes.json", "r", encoding="utf-8") as f:
    ccs = json.load(f)

extracted_scripts = []

for i, cc in enumerate(ccs):
    code = cc["code"]
    script_matches = re.findall(r'<script[^>]*>([\s\S]*?)<\/script>', code)
    for sm in script_matches:
        extracted_scripts.append({
            "source_cc": i,
            "id": cc["id"],
            "script": sm.strip()
        })

print(f"Total extracted script blocks: {len(extracted_scripts)}")
for idx, s in enumerate(extracted_scripts):
    print(f"--- Script {idx} (from CC {s['source_cc']}, {s['id']}) --- length: {len(s['script'])}")
    print(s['script'][:200] + "...\n")
