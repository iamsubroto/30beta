from PIL import Image

im1440 = Image.open("verification_screenshots/tall_1440.png")
# In tall_1440, hero ends around y=1100.
# Let's crop y=700 to y=1200
crop1440 = im1440.crop((0, 700, 1440, 1200))
crop1440.save("verification_screenshots/proof_crop_1440.png")
print("Saved proof_crop_1440.png")

im390 = Image.open("verification_screenshots/tall_390.png")
# In tall_390, where is the hero proof section?
# Let's crop y=800 to y=1800
crop390 = im390.crop((0, 800, 390, 1800))
crop390.save("verification_screenshots/proof_crop_390.png")
print("Saved proof_crop_390.png")
