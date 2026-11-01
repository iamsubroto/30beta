with open("script.js", "r", encoding="utf-8") as f:
    lines = f.readlines()

poster_code = """  var POSTER_MAP = {
    "d8b90bceb6464755b0b477f0f91b4580": "./assets/images/d8b90bceb6464755b0b477f0f91b4580.png",
    "3a52181f6ca245c69f9a56d19be682c6": "./assets/images/3a52181f6ca245c69f9a56d19be682c6.webp",
    "4f2e697f49cd4180a01f29d263226507": "./assets/images/4f2e697f49cd4180a01f29d263226507.png",
    "e3f918189fea40b48e61cac195399cbc": "./assets/images/e3f918189fea40b48e61cac195399cbc.webp",
    "7b9aecfcc1ee41218be95c269f5fe8c9": "./assets/images/7b9aecfcc1ee41218be95c269f5fe8c9.png",
    "e16a970adf0e4440ba3ee2d51b0be9d1": "./assets/images/e16a970adf0e4440ba3ee2d51b0be9d1.png",
    "88531704c2a54eadbd7946f3db315b16": "./assets/images/88531704c2a54eadbd7946f3db315b16.png",
    "6807dd0f90e64b5db594d9b7baec715c": "./assets/images/6807dd0f90e64b5db594d9b7baec715c.webp"
  };
  function esc(t){ var A = String.fromCharCode(38); return String(t).replace(/[&<>"]/g, function(c){ return A + ({"&":"amp","<":"lt",">":"gt","\\"":"quot"})[c] + ";"; }); }
  function card(v){
    var src = VIMEO + v.vimeo + "?h=" + v.h + "&autoplay=1&title=0&byline=0&portrait=0&dnt=1";
    var cap = v.name ? "<figcaption><b>" + esc(v.name) + "</b>" + (v.line ? "<span>" + esc(v.line) + "<sup>**</sup></span>" : "") + "</figcaption>" : "";
    var posterUrl = v.poster ? (POSTER_MAP[v.poster] || ("./assets/images/" + v.poster + ".webp")) : "";
    var img = posterUrl ? "<img src=\\"" + esc(posterUrl) + "\\" alt=\\"\\" decoding=\\"async\\" loading=\\"lazy\\">" : "";
    return "<figure class=\\"vsl-card\\"><div class=\\"vsl-thumb\\" data-src=\\"" + esc(src) + "\\">" + img + "<button class=\\"vsl-play\\" type=\\"button\\" aria-label=\\"Reproducir " + esc(v.name || "video") + "\\"></button></div>" + cap + "</figure>";
  }
"""

new_lines = []
skip = False
for line in lines:
    if 'var POSTER = "./assets/images/";' in line:
        new_lines.append(poster_code)
        skip = True
    elif skip and '/* A poster and a button, not a player' in line:
        skip = False
        new_lines.append(line)
    elif not skip:
        new_lines.append(line)

with open("script.js", "w", encoding="utf-8") as f:
    f.writelines(new_lines)

print("Updated script.js successfully!")
