# Project Memory: She+ Landing Page (HTML to PHP Conversion - 30beta)

> Project instructions and context for AI coding assistants. Read this before starting any work in a new session.

---

## 📌 Project Overview

| Field | Value |
|---|---|
| **Project Name** | `sheplus-landing-php` (She+ Landing Page - 30beta) |
| **Current Task** | Converting static `index.html` into dynamic PHP format (`index_beta.php`) |
| **Target Directory** | `30beta/` (All work, additions, edits, and deletions happen exclusively here) |
| **Reference Directory** | `29beta/` (Read-only reference for PHP coding structure - **DO NOT MODIFY**) |
| **Template ID** | `$template = 195;` (Sequential: 27beta=192, 28beta=193, 29beta=194, 30beta=195) |
| **Language** | Spanish (`es-US` / `es`) |

---

## 🚨 Critical Rules & Scope Restrictions

1. **Strict Target Directory Boundary**:
   - All additions, edits, and deletions MUST be made exclusively inside the `30beta/` folder.
   - Do NOT modify `29beta/` or any other sibling directories (`07-Aug`, `22-Sep`, `23-Aug`, `27-june`). `29beta/` is strictly for reference.
2. **Standalone Self-Sufficiency**:
   - `30beta/` must contain all required assets (`assets/fonts`, `assets/icons`, `assets/images`), `style.css`, and `script.js` so it functions autonomously without missing dependencies.

---

## 🏗️ Architecture & Target Files in `30beta/`

```
30beta/
├── index_beta.php        # Primary dynamic PHP landing page
├── style.css             # Standalone stylesheet (synced with root style.css)
├── script.js             # Standalone JavaScript (synced with root script.js)
└── assets/               # Complete local static assets
    ├── fonts/            # Akzidenz-Grotesk BQ woff2 fonts
    ├── icons/            # SVG icons (favicon.svg)
    └── images/           # Local WebP / PNG images (0 external 404s)
```

---

## ⚙️ PHP Dynamic Integration Specifications

Follow the exact coding pattern from `29beta/index_beta.php`:

### 1. PHP Header Block (Line 1 of `index_beta.php`)
```php
<?php 
header('Content-Type: text/html; charset=UTF-8');

function to_utf8($str) {
    if ($str === null || $str === '') return '';
    if (function_exists('mb_check_encoding') && mb_check_encoding($str, 'UTF-8')) {
        return $str;
    }
    if (function_exists('mb_convert_encoding')) {
        return mb_convert_encoding($str, 'UTF-8', 'Windows-1252');
    }
    if (function_exists('iconv')) {
        return iconv('Windows-1252', 'UTF-8//IGNORE', $str);
    }
    return utf8_encode($str);
}

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

if (isset($_GET['mode']) && $_GET['mode'] === 'edit') {
    $subdominio = $_GET['subdominio'] ?? '';

    header("Location: https://vioniko.com/landingpage/3beta/index_beta.php?subdominio=" . urlencode($subdominio) . "&mode=edit");
    exit;
}

$template = 195;
include_once('../../subdominio_ini.php');
$userIdBySubdomain = $rowUSU["clave"] ?? '';
$video = !empty($video) ? $video : 'https://chatvk.s3.us-west-2.amazonaws.com/General_Horizontalv1.mp4';
?>
```

### 2. Campaign Tracking Inputs (Immediately following `<body>`)
```html
  <!-- Hidden Campaign Tracking Inputs -->
  <input type="hidden" id="pais" name="pais" value="<?= htmlspecialchars($pais ?? '') ?>">
  <input type="hidden" id="ciudad" name="ciudad" value="<?= htmlspecialchars($ciudad ?? '') ?>">
  <input type="hidden" id="estado" name="estado" value="<?= htmlspecialchars($estado ?? '') ?>">
  <input type="hidden" id="usuario" name="usuario" value="<?= htmlspecialchars($userIdBySubdomain ?? '') ?>">
  <input type="hidden" id="template" name="template" value="<?= htmlspecialchars($template ?? 195) ?>">
  <input type="hidden" id="idioma" name="idioma" value="es">
```

### 3. Lead Form Hidden Fields (Inside `.sj-gform` instances before `</form>`)
```html
  <input type="hidden" name="pais" id="pais" value="<?php echo to_utf8($geo["geoplugin_countryName"] ?? ''); ?>">
  <input type="hidden" name="ciudad" id="ciudad" value="<?php echo to_utf8($geo["geoplugin_city"] ?? ''); ?>">
  <input type="hidden" name="estado" id="estado" value="<?php echo to_utf8($geo["geoplugin_regionName"] ?? ''); ?>">
  <?php include('../campana_user.php'); ?>
  <input type="hidden" name="usuario" id="usuario" value="<?= htmlspecialchars($userIdBySubdomain ?? ''); ?>">
  <input type="hidden" name="template" id="template" value="<?= htmlspecialchars($template ?? 195); ?>">
  <input type="hidden" name="idioma" id="idioma" value="es">
```

---

## 📋 New Session Startup Checklist

When starting a new session:
1. **Verify Target Scope**: Inspect `30beta/` directory. Ensure no modifications leak to `29beta/`, `index.html`, or other root files.
2. **Keep `index.html` Untouched**: Confirm root `index.html` remains unmodified and frozen as the baseline.
3. **Verify PHP Integrity**: Check `30beta/index_beta.php` for correct template ID (`195`), required includes (`subdominio_ini.php`, `campana_user.php`), and encoding.
4. **Check Assets**: Ensure all font and image references (`./assets/...`) resolve without 404s within `30beta/assets/`.
5. **Preserve Markup**: When making updates, never modify existing CSS rules, JavaScript handlers, or HTML layout structures.
