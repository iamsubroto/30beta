from PIL import Image

# Let's crop tall_1440.png around the proof section
im = Image.open("verification_screenshots/tall_1440.png")
# Let's find exactly where builder-6f5d765b877345e3aa80e93cd1450b14 is located
# We can search for the text or check the crop
crop1 = im.crop((0, 750, 1440, 1150))
crop1.save("verification_screenshots/proof_desktop_1440.png")

# Now mobile tall_390.png
im_m = Image.open("verification_screenshots/tall_390.png")
crop_m = im_m.crop((0, 1300, 390, 1900))
crop_m.save("verification_screenshots/proof_mobile_390.png")

print("Saved proof_desktop_1440.png and proof_mobile_390.png")
