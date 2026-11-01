import re

with open("immunotec_next.css", "r", encoding="utf-8") as f:
    css = f.read()

# Find all rules mentioning .builder-
builder_rules = re.findall(r'(\.[^{]*builder-[^{]*\{[^}]+\})', css)
print("Builder rules count in immunotec_next.css:", len(builder_rules))
for r in builder_rules[:15]:
    print(" ", r)

# Also check for .sj- rules in immunotec_next.css
sj_rules = re.findall(r'(\.[^{]*sj-[^{]*\{[^}]+\})', css)
print("SJ rules count in immunotec_next.css:", len(sj_rules))
for r in sj_rules[:15]:
    print(" ", r)
