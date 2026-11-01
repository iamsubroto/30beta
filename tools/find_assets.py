import re

with open("fetched.html", "r", encoding="utf-8") as f:
    html = f.read()

links = re.findall(r'<link[^>]+>', html)
for l in links:
    print(l)

scripts = re.findall(r'<script[^>]+src="([^"]+)"', html)
for s in scripts:
    print("Script:", s)
