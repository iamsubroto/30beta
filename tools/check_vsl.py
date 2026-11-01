with open("custom_codes.json", "r", encoding="utf-8") as f:
    import json
    ccs = json.load(f)

print(ccs[7]["code"])
