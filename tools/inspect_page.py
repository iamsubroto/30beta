with open("fetched.html", "r", encoding="utf-8") as f:
    content = f.read()

print("Length:", len(content))
print("Start:")
print(content[:600])
print("...")
print("End:")
print(content[-600:])
