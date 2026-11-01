import re

with open("immunotec_next.css", "r", encoding="utf-8") as f:
    css = f.read()

font_faces = re.findall(r'@font-face\s*\{[^}]+\}', css)
print("Font faces count:", len(font_faces))
for ff in font_faces:
    print(ff)

# Look for font-family in root or body
root_rules = re.findall(r':root\s*\{[^}]+\}', css)
for rr in root_rules:
    print("Root rule:", rr[:200])

body_rules = re.findall(r'body\s*\{[^}]+\}', css)
for br in body_rules:
    print("Body rule:", br)

# Search for font-family usages
ff_matches = set(re.findall(r'font-family:\s*([^;}]+)', css))
print("Font families used in immunotec_next.css:")
for f in ff_matches:
    print("  ", f)
