with open("fetched_clean.html", "rb") as f:
    b = f.read()

idx = b.find(b'"title":"')
if idx != -1:
    snippet = b[idx:idx+60]
    print("Raw bytes around title:", snippet)
