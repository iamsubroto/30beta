from PIL import Image

im_user = Image.open("mobile_layout_problem.png")
im_curr = Image.open("verification_screenshots/hero_mobile_current.png")

print("User image size:", im_user.size)
print("Current image size:", im_curr.size)

# Let's crop hero_mobile_current to match the content of mobile_layout_problem
# Find where the image starts in hero_mobile_current
# The image of the two women starts around y = 280
crop_curr = im_curr.crop((0, 275, 390, 890))
crop_curr.save("verification_screenshots/comparison_curr.png")

# Let's also resize comparison_curr or user image to inspect differences
print("Saved comparison_curr.png")
