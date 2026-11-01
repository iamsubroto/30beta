import json

with open("custom_codes.json", "r", encoding="utf-8") as f:
    ccs = json.load(f)

for i in [0, 1, 2, 4, 6, 7, 11]:
    cc = ccs[i]
    print(f"\n==================== CC {i} ====================")
    print(cc["code"])
