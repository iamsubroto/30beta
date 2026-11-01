with open("custom_codes.json", "r", encoding="utf-8") as f:
    import json
    ccs = json.load(f)

print("--- CC 2 (Convo) ---")
print(ccs[2]["code"][:1500])
print("\n--- CC 6 (Chart) ---")
print(ccs[6]["code"][:1500])
