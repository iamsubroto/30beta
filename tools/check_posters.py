import os
import glob
from curl_cffi import requests

posters = [
  "d8b90bceb6464755b0b477f0f91b4580",
  "3a52181f6ca245c69f9a56d19be682c6",
  "4f2e697f49cd4180a01f29d263226507",
  "e3f918189fea40b48e61cac195399cbc",
  "7b9aecfcc1ee41218be95c269f5fe8c9",
  "e16a970adf0e4440ba3ee2d51b0be9d1",
  "88531704c2a54eadbd7946f3db315b16",
  "6807dd0f90e64b5db594d9b7baec715c"
]

for p in posters:
    matches = glob.glob(f"assets/images/{p}*")
    if matches:
        print(f"Poster {p} found: {matches[0]}")
    else:
        url = f"https://cdn.builder.io/api/v1/image/assets%2Ffdb4d79bfbfd478d89398007f8c29424%2F{p}?format=webp&width=400&quality=80"
        local_p = f"assets/images/{p}.webp"
        print(f"Downloading poster {p}...")
        r = requests.get(url, impersonate="chrome124")
        if r.status_code == 200:
            with open(local_p, "wb") as f:
                f.write(r.content)
            print(f"Saved {local_p}")
        else:
            print(f"Failed {r.status_code}")
