from bs4 import BeautifulSoup

with open("rendered_builder.html", "r", encoding="utf-8") as f:
    soup = BeautifulSoup(f.read(), "html.parser")

for cls_name in ["sjc", "sj-marq", "sjb-chart", "sjv", "sj-gform", "sj-pk"]:
    found = soup.find(class_=cls_name)
    print(f"Class '{cls_name}' found:", found is not None)
    if found:
        print(f"  Tag: {found.name}, classes: {found.get('class')}")
        print(f"  Inner preview: {str(found)[:150]}...")
