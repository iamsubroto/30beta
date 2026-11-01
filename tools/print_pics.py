from bs4 import BeautifulSoup

with open("rendered_builder.html", "r", encoding="utf-8") as f:
    soup = BeautifulSoup(f.read(), "html.parser")

pics = soup.find_all("picture")
for i, p in enumerate(pics[:3]):
    print(f"--- Picture {i} ---")
    print(p.prettify())
