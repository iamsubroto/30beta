with open("index.html", "r", encoding="utf-8") as f:
    s = f.read()

s = s.replace(
    '<link rel="stylesheet" href="style.css">',
    '<link rel="icon" href="./assets/icons/favicon.svg" type="image/svg+xml">\n  <link rel="stylesheet" href="style.css">'
)

with open("index.html", "w", encoding="utf-8") as f:
    f.write(s)

print("Updated index.html with favicon link!")
