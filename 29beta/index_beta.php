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

$template = 194;
include_once('../../subdominio_ini.php');
$userIdBySubdomain = $rowUSU["clave"] ?? '';
$video = !empty($video) ? $video : 'https://chatvk.s3.us-west-2.amazonaws.com/General_Horizontalv1.mp4';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Programa de Afiliados ChatVioniko | Gana Comisiones Recomendando IA</title>
  <meta name="description" content="Conoce el programa de afiliados de ChatVioniko, prueba la plataforma gratis y accede al apartado de afiliados al activar tu suscripcion.">
  <meta property="og:title" content="Programa de Afiliados ChatVioniko | Gana Comisiones Recomendando IA">
  <meta property="og:description" content="Prueba ChatVioniko, descubre sus herramientas de IA y conoce como funciona el programa de afiliados para suscriptores activos.">
  <meta property="og:type" content="website">
  <meta name="theme-color" content="#030711">
  <link rel="stylesheet" href="style.css?v=1.0.6">
</head>
<body>

  <!-- Hidden Campaign Tracking Inputs -->
  <input type="hidden" id="pais" name="pais" value="<?= htmlspecialchars($pais ?? '') ?>">
  <input type="hidden" id="ciudad" name="ciudad" value="<?= htmlspecialchars($ciudad ?? '') ?>">
  <input type="hidden" id="estado" name="estado" value="<?= htmlspecialchars($estado ?? '') ?>">
  <input type="hidden" id="usuario" name="usuario" value="<?= htmlspecialchars($userIdBySubdomain ?? '') ?>">
  <input type="hidden" id="template" name="template" value="<?= htmlspecialchars($template ?? 194) ?>">
  <input type="hidden" id="idioma" name="idioma" value="es">

  <!-- Fixed Top Header Navigation -->
  <header class="site-header">
    <div class="header-inner">
      <a href="#inicio" class="header-logo" aria-label="ChatVioniko afiliados, volver al inicio">
        <img src="logos/logo_chico.png" alt="ChatVioniko" width="40" height="40">
        <span class="header-logo-text">ChatVioniko</span>
      </a>

      <nav class="header-nav" aria-label="Principal">
        <a href="#como-funciona">Como funciona</a>
        <a href="#ganancias">Ganancias</a>
        <a href="#que-incluye">Que incluye</a>
        <a href="#afiliados">Afiliados</a>
        <a href="#preguntas">Preguntas</a>
      </nav>

      <div class="header-cta">
        <a href="https://chatvioniko.com" class="btn btn-primary btn-header" target="_blank" rel="noopener">Probar gratis</a>
      </div>

      <button type="button" class="hamburger" aria-label="Abrir menu" aria-expanded="false">
        <span class="hamburger-icon" aria-hidden="true">
          <span></span>
          <span></span>
          <span></span>
        </span>
      </button>
    </div>

    <!-- Mobile Drawer Menu -->
    <nav class="mobile-nav" aria-label="Principal movil">
      <div class="mobile-nav-inner">
        <a href="#como-funciona">Como funciona</a>
        <a href="#ganancias">Ganancias</a>
        <a href="#que-incluye">Que incluye</a>
        <a href="#afiliados">Afiliados</a>
        <a href="#preguntas">Preguntas</a>
        <a href="https://chatvioniko.com" class="btn btn-primary btn-full" style="margin-top: 0.75rem;" target="_blank" rel="noopener">Probar gratis</a>
      </div>
    </nav>
  </header>

  <main id="inicio">

    <!-- Section 1: Hero Section -->
    <section class="section" style="padding-top: 6rem; padding-bottom: 4rem;">
      <div class="ambient-field" style="position: absolute; inset: 0;" aria-hidden="true"></div>
      
      <div class="container">
        <!-- Hero Logo Badge Header -->
        <div class="reveal" style="display: flex; justify-content: center; margin-bottom: 2rem; position: relative; z-index: 10;">
          <div class="hero-logo-glow" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
            <div class="hero-logo-box">
              <img src="logos/logo_chico.png" alt="ChatVioniko" width="56" height="56">
            </div>
            <p class="hero-title gradient-text">ChatVioniko</p>
            <p style="margin-top: 0.75rem; font-size: 0.875rem; font-weight: 900; text-transform: uppercase; color: var(--mist);">
              Programa de afiliados
            </p>
          </div>
        </div>

        <!-- 2-Column Hero Grid: Left Content + Right Visual Mockup Widget -->
        <div class="hero-content-grid">
          <div class="reveal">
            <span class="eyebrow-badge">Programa de afiliados</span>
            <h1 class="hero-main-title">
              Gana comisiones<br>
              <span class="gradient-text">recomendando ChatVioniko</span>
            </h1>
            <p style="margin-top: 1.5rem; max-width: 42rem; font-size: 1.125rem; line-height: 1.75rem; color: var(--mist);">
              Comparte una plataforma completa de inteligencia artificial y recibe comisiones por las nuevas suscripciones que generes con tu enlace cuando tengas una suscripcion activa y el programa habilitado dentro de tu cuenta.
            </p>

            <!-- Stat Pills Grid -->
            <div class="stat-pills-grid">
              <div class="stat-pill">
                <p class="stat-pill-val">20%</p>
                <p class="stat-pill-label">Nivel 1</p>
              </div>
              <div class="stat-pill">
                <p class="stat-pill-val">5%</p>
                <p class="stat-pill-label">Nivel 2 certificado</p>
              </div>
              <div class="stat-pill">
                <p class="stat-pill-val">29 USD</p>
                <p class="stat-pill-label">Precio lanzamiento</p>
              </div>
            </div>

            <!-- Action Buttons Stack -->
            <div class="hero-btn-stack">
              <a href="https://chatvioniko.com" class="btn btn-primary" target="_blank" rel="noopener">Probar ChatVioniko gratis</a>
              <a href="#como-funciona" class="btn btn-secondary">Ver como funciona el programa</a>
            </div>

            <p style="margin-top: 1.5rem; max-width: 42rem; font-size: 0.875rem; font-weight: 700; line-height: 1.5rem; color: var(--mist);">
              Prueba ChatVioniko gratis. Si luego activas tu suscripcion, tendras disponible el Programa de Afiliados dentro de tu cuenta.
            </p>
            <p style="margin-top: 0.75rem; max-width: 42rem; font-size: 0.875rem; line-height: 1.5rem; color: rgba(184, 199, 220, 0.8);">
              Ideal para creadores de contenido, marketers, emprendedores, comunidades, agencias y personas que ya recomiendan herramientas digitales.
            </p>
          </div>

          <!-- Right Column: HeroAffiliateVisual Widget Box -->
          <div class="reveal">
            <div class="hero-visual" style="border-radius: 0.5rem; border: 1px solid rgba(34, 211, 238, 0.2); background: rgba(8, 17, 32, 0.4); box-shadow: var(--shadow-glow);">
              <div class="system-grid" style="position: absolute; inset: 0.75rem; border-radius: 0.5rem; border: 1px solid rgba(255, 255, 255, 0.1);"></div>

              <!-- Floating Card 1: Tu Enlace -->
              <div style="position: absolute; left: 1.5rem; top: 1.75rem; width: 58%; border-radius: 0.5rem; border: 1px solid rgba(139, 92, 246, 0.3); background: rgba(8, 17, 32, 0.9); padding: 1rem; box-shadow: var(--shadow-glow);">
                <p style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: #ddd6fe;">Tu enlace</p>
                <div style="margin-top: 1rem; border-radius: 0.375rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.04); padding: 0.75rem;">
                  <span style="display: block; height: 0.5rem; border-radius: 0.25rem; background: rgba(34, 211, 238, 0.5);"></span>
                  <span style="display: block; height: 0.5rem; width: 80%; border-radius: 0.25rem; background: rgba(255, 255, 255, 0.2); margin-top: 0.5rem;"></span>
                </div>
                <p style="margin-top: 1rem; font-size: 0.75rem; font-weight: 700; color: var(--mist);">Comparte ChatVioniko</p>
              </div>

              <!-- Floating Card 2: Nivel 1 -->
              <div style="position: absolute; right: 1.5rem; top: 5rem; width: 43%; border-radius: 0.5rem; border: 1px solid rgba(34, 211, 238, 0.3); background: rgba(8, 17, 32, 0.9); padding: 1rem; box-shadow: var(--shadow-cyan);">
                <p style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: var(--cyan-glow);">Nivel 1</p>
                <p style="margin-top: 1rem; font-size: 2.25rem; font-weight: 900; color: #fff;">20%</p>
                <p style="margin-top: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--mist);">suscripcion directa</p>
              </div>

              <!-- Floating Card 3: Ejemplo -->
              <div style="position: absolute; bottom: 6rem; left: 2.5rem; width: 47%; border-radius: 0.5rem; border: 1px solid rgba(163, 230, 53, 0.25); background: rgba(8, 17, 32, 0.9); padding: 1rem; box-shadow: var(--shadow-lime);">
                <p style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: var(--lime-glow);">Ejemplo</p>
                <p style="margin-top: 1rem; font-size: 1.875rem; font-weight: 900; color: #fff;">5.80 USD</p>
                <p style="margin-top: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--mist);">por suscripcion</p>
              </div>

              <!-- Floating Card 4: Nivel 2 Certificado -->
              <div style="position: absolute; bottom: 2rem; right: 2rem; width: 56%; border-radius: 0.5rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(8, 17, 32, 0.9); padding: 1rem;">
                <p style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: #fff;">Nivel 2 certificado</p>
                <div style="margin-top: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                  <span style="border-radius: 0.375rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.1); padding: 0.5rem; font-size: 0.6875rem; font-weight: 700; color: var(--mist);">Tu</span>
                  <span style="border-radius: 0.375rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.1); padding: 0.5rem; font-size: 0.6875rem; font-weight: 700; color: var(--mist);">Afiliado</span>
                  <span style="border-radius: 0.375rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.1); padding: 0.5rem; font-size: 0.6875rem; font-weight: 700; color: var(--mist);">Suscriptor</span>
                </div>
                <p style="margin-top: 1rem; font-size: 0.875rem; font-weight: 900; color: var(--cyan-glow);">5% segundo nivel</p>
              </div>

              <!-- Pulsing Connector Lines -->
              <span class="pulse-line" style="position: absolute; left: 18%; top: 39%; height: 1px; width: 58%; transform: rotate(12deg); background: rgba(34, 211, 238, 0.7);"></span>
              <span class="pulse-line" style="position: absolute; bottom: 37%; left: 27%; height: 1px; width: 44%; transform: rotate(-12deg); background: rgba(139, 92, 246, 0.7);"></span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- MAIN VIDEO -->
    <section class="section" style="padding-top:3rem;">
      <div class="container">
        <div class="reveal">
          <!-- <div class="section-heading"><p class="eyebrow">Mira lo que vas a aprender</p></div> -->
          <div style="margin-top:2rem;">
            <button type="button" class="video-preview video-preview--wide" data-src="<?= $video; ?>" data-title="Video general de Academia Vioniko" aria-label="Abrir video: Video general de Academia Vioniko">
              <video src="<?= $video; ?>#t=0.001" muted playsinline webkit-playsinline preload="auto" aria-hidden="true"></video>
              <span class="video-preview-overlay"></span>
              <span class="video-grid-overlay video-grid"></span>
              <span class="video-preview-play">
                <span class="play-btn"><span class="play-triangle"></span></span>
              </span>
            </button>
          </div>
          <!-- <div style="margin-top:1.5rem; max-width: 36rem; margin-left: auto; margin-right: auto;">
            <a href="#contact" class="video-section__cta-btn">
              Quiero ser de los primeros: CLICK Aqui para Ver Webinar
            </a>
          </div> -->
        </div>
      </div>
    </section>

    <!-- Section 2: Potential Earnings Section -->
    <section id="ganancias" class="section">
      <div class="container">
        <div class="reveal">
          <div class="section-heading">
            <span class="eyebrow">Cuanto puedes ganar</span>
            <h2>Cuanto podrias generar?</h2>
            <p class="subtitle">Veamos algunos ejemplos utilizando el precio de lanzamiento actual de 29 USD.</p>
          </div>
        </div>

        <div class="earnings-section-grid">
          <div class="reveal">
            <div style="border-radius: 0.5rem; border: 1px solid rgba(139, 92, 246, 0.3); background: rgba(8, 17, 32, 0.75); padding: 1.5rem; box-shadow: var(--shadow-glow);">
              <p style="font-size: 0.875rem; font-weight: 900; text-transform: uppercase; color: var(--cyan-glow);">Comision directa</p>
              <h3 style="margin-top: 1rem; font-size: 2.25rem; font-weight: 900; text-transform: uppercase; color: #fff;">
                29 USD x 20% = <span class="gradient-text">5.80 USD</span>
              </h3>
              <p style="margin-top: 1.25rem; font-size: 1rem; line-height: 1.75rem; color: var(--mist);">
                Cada nueva suscripcion directa puede generar 5.80 USD de comision residual.
              </p>
            </div>
          </div>

          <div class="reveal">
            <div class="earnings-grid">
              <article class="earnings-card">
                <p class="earnings-count">5</p>
                <p class="earnings-label">suscripciones</p>
                <p class="earnings-amount">29 USD</p>
              </article>
              <article class="earnings-card">
                <p class="earnings-count">10</p>
                <p class="earnings-label">suscripciones</p>
                <p class="earnings-amount">58 USD</p>
              </article>
              <article class="earnings-card">
                <p class="earnings-count">25</p>
                <p class="earnings-label">suscripciones</p>
                <p class="earnings-amount">145 USD</p>
              </article>
              <article class="earnings-card">
                <p class="earnings-count">50</p>
                <p class="earnings-label">suscripciones</p>
                <p class="earnings-amount">290 USD</p>
              </article>
              <article class="earnings-card" style="grid-column: 1 / -1;">
                <p class="earnings-count">100</p>
                <p class="earnings-label">suscripciones</p>
                <p class="earnings-amount">580 USD</p>
              </article>
            </div>
          </div>
        </div>

        <div class="reveal" style="margin-top: 2rem;">
          <div style="border-radius: 0.5rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.04); padding: 1rem; font-size: 0.875rem; line-height: 1.5rem; color: var(--mist);">
            Estos son ejemplos matematicos basados en una comision del 20% sobre una suscripcion de 29 USD. No representan ingresos garantizados.
          </div>
        </div>

        <!-- Interactive Calculator Widget -->
        <div class="reveal" style="margin-top: 2rem;">
          <div class="calculator-panel">
            <div class="calculator-header">
              <div>
                <p style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: var(--cyan-glow);">Calculadora rapida</p>
                <h3 style="margin-top: 0.5rem; font-size: 1.25rem; font-weight: 900; text-transform: uppercase; color: #fff;">Suscripciones directas</h3>
                <p style="margin-top: 0.5rem; font-size: 0.875rem; line-height: 1.5rem; color: var(--mist);">Ajusta el escenario para ver un ejemplo de comision potencial.</p>
              </div>
              <div class="calculator-result-box">
                <p style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: var(--mist);">Comision potencial</p>
                <p id="calculator-potential-result" style="margin-top: 0.25rem; font-size: 1.875rem; font-weight: 900; color: var(--lime-glow);">$145</p>
              </div>
            </div>

            <label htmlFor="affiliate-subscriptions" style="display: block; margin-top: 1.5rem; font-size: 0.875rem; font-weight: 700; color: #fff;">
              Cuantas suscripciones podrias generar?
            </label>

            <div class="calculator-controls">
              <input id="affiliate-subscriptions" type="range" min="1" max="150" value="25" class="calculator-slider">
              <input id="affiliate-subscriptions-number" type="number" min="1" max="999" value="25" class="calculator-number-input" aria-label="Cantidad de suscripciones">
            </div>

            <div style="margin-top: 1.25rem; border-radius: 0.5rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.04); padding: 1rem;">
              <p id="calculator-breakdown-text" style="font-size: 0.875rem; font-weight: 700; color: #fff;">
                25 suscripciones x $5.80 = <span class="text-lime-glow">$145</span>
              </p>
              <p style="margin-top: 0.5rem; font-size: 0.75rem; line-height: 1.25rem; color: rgba(184, 199, 220, 0.8);">
                Ejemplo matematico basado en una comision del 20% sobre una suscripcion de 29 USD. No representa ingresos garantizados.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 3: Nivel 2 Certificado Section -->
    <section id="afiliados" class="section">
      <div class="container">
        <div class="reveal">
          <div class="tier2-box">
            <div class="tier2-grid">
              <div>
                <p style="font-size: 0.875rem; font-weight: 900; text-transform: uppercase; color: var(--cyan-glow);">Nivel 2 certificado</p>
                <h2 class="banner-title">
                  Y si construyes<br>
                  <span class="gradient-text">tu propia red?</span>
                </h2>
                <p style="margin-top: 1.25rem; font-size: 1rem; line-height: 1.75rem; color: var(--mist);">
                  Los afiliados oficiales certificados pueden acceder al Nivel 2 y recibir un 5% del primer pago de las suscripciones generadas por sus referidos.
                </p>

                <div style="margin-top: 1.5rem; border-radius: 0.5rem; border: 1px solid rgba(163, 230, 53, 0.25); background: rgba(163, 230, 53, 0.1); padding: 1.25rem;">
                  <p style="font-size: 1.125rem; font-weight: 900; color: var(--lime-glow);">29 USD x 5% = 1.45 USD</p>
                  <p style="margin-top: 0.5rem; font-size: 0.875rem; line-height: 1.5rem; color: var(--mist);">
                    20 suscripciones indirectas = 29 USD adicionales como ejemplo de comision potencial.
                  </p>
                </div>
                <p style="margin-top: 1rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: rgba(184, 199, 220, 0.8);">
                  Nivel 2 sujeto a certificacion y aprobacion.
                </p>
              </div>

              <div style="border-radius: 0.5rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.04); padding: 1.25rem;">
                <div style="border-radius: 0.5rem; border: 1px solid rgba(34, 211, 238, 0.2); background: rgba(8, 17, 32, 0.8); padding: 1.25rem; text-align: center; box-shadow: var(--shadow-cyan);">
                  <p style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: var(--cyan-glow);">01</p>
                  <p style="margin-top: 0.5rem; font-size: 1.25rem; font-weight: 900; text-transform: uppercase; color: #fff;">Tu</p>
                </div>
                <div style="display: grid; place-items: center; padding: 0.75rem 0; font-size: 1.5rem; font-weight: 900; color: var(--violet-glow);">↓</div>

                <div style="border-radius: 0.5rem; border: 1px solid rgba(34, 211, 238, 0.2); background: rgba(8, 17, 32, 0.8); padding: 1.25rem; text-align: center; box-shadow: var(--shadow-cyan);">
                  <p style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: var(--cyan-glow);">02</p>
                  <p style="margin-top: 0.5rem; font-size: 1.25rem; font-weight: 900; text-transform: uppercase; color: #fff;">Afiliado referido</p>
                </div>
                <div style="display: grid; place-items: center; padding: 0.75rem 0; font-size: 1.5rem; font-weight: 900; color: var(--violet-glow);">↓</div>

                <div style="border-radius: 0.5rem; border: 1px solid rgba(34, 211, 238, 0.2); background: rgba(8, 17, 32, 0.8); padding: 1.25rem; text-align: center; box-shadow: var(--shadow-cyan);">
                  <p style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: var(--cyan-glow);">03</p>
                  <p style="margin-top: 0.5rem; font-size: 1.25rem; font-weight: 900; text-transform: uppercase; color: #fff;">Nuevo suscriptor</p>
                </div>

                <div style="margin-top: 1.25rem; display: grid; gap: 0.75rem; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));">
                  <p style="border-radius: 0.375rem; border: 1px solid rgba(163, 230, 53, 0.25); background: rgba(163, 230, 53, 0.1); padding: 0.75rem; text-align: center; font-size: 0.875rem; font-weight: 900; color: var(--lime-glow);">20% directo</p>
                  <p style="border-radius: 0.375rem; border: 1px solid rgba(34, 211, 238, 0.25); background: rgba(34, 211, 238, 0.1); padding: 0.75rem; text-align: center; font-size: 0.875rem; font-weight: 900; color: var(--cyan-glow);">5% segundo nivel</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 4: What You Recommending Section -->
    <section id="que-incluye" class="section">
      <div class="container">
        <div class="reveal">
          <div class="section-heading">
            <span class="eyebrow">Que estas recomendando</span>
            <h2>No estas recomendando solo un chat</h2>
            <p class="subtitle">ChatVioniko reune multiples herramientas de inteligencia artificial dentro de una sola suscripcion.</p>
          </div>
        </div>

        <div class="feature-grid">
          <div class="reveal">
            <article class="feature-card feature-card--cyan">
              <h3>Chat IA personalizable</h3>
              <p>Cada conversacion puede configurarse con instrucciones, contexto, estilo de respuesta y nivel de creatividad.</p>
            </article>
          </div>

          <div class="reveal">
            <article class="feature-card feature-card--violet">
              <h3>Biblioteca de prompts</h3>
              <p>Prompts preparados que pueden personalizarse y enviarse directamente al chat.</p>
            </article>
          </div>

          <div class="reveal">
            <article class="feature-card feature-card--lime">
              <h3>Escritura guiada</h3>
              <p>Define producto, audiencia, objetivo, formato y tono para generar varias propuestas de contenido.</p>
            </article>
          </div>

          <div class="reveal">
            <article class="feature-card feature-card--cyan">
              <h3>Keyword research</h3>
              <p>Investigacion de palabras clave, intencion de busqueda, ideas de titulos y meta descriptions para SEO.</p>
            </article>
          </div>

          <div class="reveal">
            <article class="feature-card feature-card--violet">
              <h3>Generacion de imagenes con IA</h3>
              <p>Creacion de piezas visuales mediante prompts directamente desde la plataforma.</p>
            </article>
          </div>

          <div class="reveal">
            <article class="feature-card feature-card--lime">
              <h3>Estudio de video con IA</h3>
              <p>Creacion de videos con estrategia, guion, voz, modelos de video y diferentes formatos.</p>
            </article>
          </div>

          <div class="reveal">
            <article class="feature-card feature-card--cyan">
              <h3>Avatares con IA</h3>
              <p>Posibilidad de generar videos utilizando avatares que hablan.</p>
            </article>
          </div>

          <div class="reveal">
            <article class="feature-card feature-card--violet">
              <h3>Asistentes IA</h3>
              <p>Asistentes configurables para investigacion, creacion de contenido, monitoreo, correo, recordatorios y otras tareas.</p>
            </article>
          </div>

          <div class="reveal">
            <article class="feature-card feature-card--lime">
              <h3>Creacion de chatbots</h3>
              <p>Chatbots personalizados para WordPress, paginas corporativas, landing pages, sitios de servicios, negocios y atencion al cliente.</p>
            </article>
          </div>

          <!-- Featured Academia Card -->
          <div class="reveal" style="grid-column: 1 / -1;">
            <article class="academy-card">
              <div class="panel-lines" style="position: absolute; inset: 0;" aria-hidden="true"></div>
              <div class="academy-grid" style="position: relative;">
                <div>
                  <span class="eyebrow-badge" style="border-color: rgba(163, 230, 53, 0.25); background: rgba(163, 230, 53, 0.1); color: var(--lime-glow);">Academia incluida</span>
                  <h3 style="margin-top: 1rem; font-size: 1.875rem; font-weight: 900; text-transform: uppercase; color: #fff;">Academia Vioniko</h3>
                  <p style="margin-top: 1rem; font-size: 1rem; line-height: 1.75rem; color: var(--mist);">
                    Tu suscripcion a ChatVioniko tambien incluye acceso a Academia Vioniko, donde aprenderas a utilizar inteligencia artificial de forma practica mediante clases en vivo todas las semanas.
                  </p>
                </div>

                <div style="display: grid; gap: 0.75rem; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                  <p style="border-radius: 0.375rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.04); padding: 0.75rem; font-size: 0.875rem; font-weight: 700; color: var(--mist);">
                    <span style="color: var(--lime-glow); margin-right: 0.5rem;" aria-hidden="true">✓</span> Clases semanales en vivo
                  </p>
                  <p style="border-radius: 0.375rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.04); padding: 0.75rem; font-size: 0.875rem; font-weight: 700; color: var(--mist);">
                    <span style="color: var(--lime-glow); margin-right: 0.5rem;" aria-hidden="true">✓</span> Aprendizaje practico
                  </p>
                  <p style="border-radius: 0.375rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.04); padding: 0.75rem; font-size: 0.875rem; font-weight: 700; color: var(--mist);">
                    <span style="color: var(--lime-glow); margin-right: 0.5rem;" aria-hidden="true">✓</span> Ejercicios
                  </p>
                  <p style="border-radius: 0.375rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.04); padding: 0.75rem; font-size: 0.875rem; font-weight: 700; color: var(--mist);">
                    <span style="color: var(--lime-glow); margin-right: 0.5rem;" aria-hidden="true">✓</span> Aplicaciones reales con IA
                  </p>
                  <p style="border-radius: 0.375rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.04); padding: 0.75rem; font-size: 0.875rem; font-weight: 700; color: var(--mist);">
                    <span style="color: var(--lime-glow); margin-right: 0.5rem;" aria-hidden="true">✓</span> Comunidad
                  </p>
                  <p style="border-radius: 0.375rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.04); padding: 0.75rem; font-size: 0.875rem; font-weight: 700; color: var(--mist);">
                    <span style="color: var(--lime-glow); margin-right: 0.5rem;" aria-hidden="true">✓</span> Acompanamiento
                  </p>
                  <p style="border-radius: 0.375rem; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.04); padding: 0.75rem; font-size: 0.875rem; font-weight: 700; color: var(--mist); grid-column: 1 / -1;">
                    <span style="color: var(--lime-glow); margin-right: 0.5rem;" aria-hidden="true">✓</span> Certificado de finalizacion
                  </p>
                </div>
              </div>
            </article>
          </div>
        </div>

        <!-- Trial Callout Banner: "Ahora pruebalo tu" (max-w-5xl) -->
        <div class="reveal" style="margin-top: 2.5rem;">
          <div class="banner-box-callout max-w-5xl">
            <p style="font-size: 0.875rem; font-weight: 900; text-transform: uppercase; color: var(--cyan-glow);">Ahora pruebalo tu</p>
            <h2 class="banner-title">
              Descubre todo lo que puedes hacer<br>
              <span class="gradient-text">con ChatVioniko</span>
            </h2>
            <p style="margin: 1.25rem auto 0; max-width: 48rem; font-size: 1rem; line-height: 1.75rem; color: var(--mist);">
              Conoce la plataforma mas a fondo, explora sus herramientas y empieza con una prueba gratuita. Puedes registrarte y probar ChatVioniko antes de contratar la suscripcion.
            </p>
            <div style="margin-top: 2rem;">
              <a href="https://chatvioniko.com" class="btn btn-primary" target="_blank" rel="noopener">Probar ChatVioniko gratis</a>
            </div>
            <p style="margin: 1.25rem auto 0; max-width: 48rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; line-height: 1.25rem; color: rgba(184, 199, 220, 0.8);">
              Cuando activas tu suscripcion desbloqueas todas las funcionalidades de ChatVioniko, incluyendo Academia Vioniko y el acceso al Programa de Afiliados.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 5: Ecosystem Value Block Section (Full Container Width max-w-7xl) -->
    <section class="section">
      <div class="container">
        <div class="reveal">
          <div class="banner-box-callout" style="border-color: rgba(34, 211, 238, 0.25);">
            <p style="font-size: 0.875rem; font-weight: 900; text-transform: uppercase; color: var(--cyan-glow);">Bloque de valor</p>
            <h2 class="banner-title">
              Todo en una<br>
              <span class="gradient-text">sola suscripcion</span>
            </h2>
            <p style="margin: 1.25rem auto 0; max-width: 54rem; font-size: 1rem; line-height: 1.75rem; color: var(--mist);">
              En lugar de explicar ChatVioniko como otro chat de IA, puedes mostrar que reune creacion de contenido, investigacion, imagenes, video, asistentes, chatbots, productividad y formacion dentro del mismo ecosistema.
            </p>
            
            <div style="margin-top: 2rem; display: flex; flex-wrap: wrap; justify-content: center; gap: 0.75rem;">
              <span class="chip-tag">Chat IA</span>
              <span class="chip-tag">Prompts</span>
              <span class="chip-tag">Imagenes</span>
              <span class="chip-tag">Video</span>
              <span class="chip-tag">SEO</span>
              <span class="chip-tag">Asistentes</span>
              <span class="chip-tag">Chatbots</span>
              <span class="chip-tag">Academia Vioniko</span>
            </div>

            <p style="margin-top: 2rem; font-size: 2.25rem; font-weight: 900; text-transform: uppercase; color: #fff;">
              = <span class="gradient-text">una sola suscripcion</span>
            </p>
            <p style="margin-top: 1.25rem; display: inline-flex; border-radius: 0.375rem; border: 1px solid rgba(163, 230, 53, 0.25); background: rgba(163, 230, 53, 0.1); padding: 0.75rem 1rem; font-size: 0.875rem; font-weight: 900; text-transform: uppercase; color: var(--lime-glow);">
              29 USD / mes · precio de lanzamiento
            </p>
            <p style="margin: 1.25rem auto 0; max-width: 48rem; font-size: 0.875rem; font-weight: 700; line-height: 1.5rem; color: var(--mist);">
              Puedes registrarte gratis y probar la plataforma. Con la suscripcion activa se desbloquea el acceso completo, incluyendo Academia Vioniko y la seccion del Programa de Afiliados.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 6: How It Works Section (Full Container Width max-w-7xl) -->
    <section id="como-funciona" class="section">
      <div class="container">
        <div class="reveal">
          <div class="section-heading">
            <span class="eyebrow">Como funciona</span>
            <h2>Empezar es simple</h2>
            <p class="subtitle">Primero conoces la plataforma. Luego, con tu suscripcion activa, habilitas el apartado de afiliados dentro de tu cuenta.</p>
          </div>
        </div>

        <div class="steps-grid">
          <div class="reveal">
            <article class="step-card">
              <span class="step-number">01</span>
              <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 900; text-transform: uppercase; color: #fff;">Prueba ChatVioniko</h3>
              <p style="margin-top: 0.75rem; font-size: 0.875rem; line-height: 1.5rem; color: var(--mist);">Crea tu cuenta y conoce la plataforma mediante la prueba gratuita.</p>
            </article>
          </div>

          <div class="reveal">
            <article class="step-card">
              <span class="step-number">02</span>
              <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 900; text-transform: uppercase; color: #fff;">Activa tu suscripcion</h3>
              <p style="margin-top: 0.75rem; font-size: 0.875rem; line-height: 1.5rem; color: var(--mist);">Al contratar ChatVioniko desbloqueas las herramientas, Academia Vioniko y el acceso al apartado de afiliados.</p>
            </article>
          </div>

          <div class="reveal">
            <article class="step-card">
              <span class="step-number">03</span>
              <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 900; text-transform: uppercase; color: #fff;">Activa el programa</h3>
              <p style="margin-top: 0.75rem; font-size: 0.875rem; line-height: 1.5rem; color: var(--mist);">Dentro de tu cuenta entra al apartado Programa de Afiliados y completa el formulario correspondiente.</p>
            </article>
          </div>

          <div class="reveal">
            <article class="step-card">
              <span class="step-number">04</span>
              <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 900; text-transform: uppercase; color: #fff;">Obten tu enlace</h3>
              <p style="margin-top: 0.75rem; font-size: 0.875rem; line-height: 1.5rem; color: var(--mist);">Una vez habilitado, utiliza tu enlace personal para recomendar ChatVioniko.</p>
            </article>
          </div>

          <div class="reveal">
            <article class="step-card">
              <span class="step-number">05</span>
              <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 900; text-transform: uppercase; color: #fff;">Genera comisiones</h3>
              <p style="margin-top: 0.75rem; font-size: 0.875rem; line-height: 1.5rem; color: var(--mist);">Las nuevas suscripciones conseguidas mediante tu enlace pueden generar la comision correspondiente segun las condiciones del programa.</p>
            </article>
          </div>
        </div>

        <div class="reveal" style="margin-top: 2.5rem; text-align: center;">
          <a href="https://chatvioniko.com" class="btn btn-primary" target="_blank" rel="noopener">Empezar prueba gratuita</a>
        </div>
      </div>
    </section>

    <!-- Section 7: Target Audience Section (max-w-5xl chip container) -->
    <section class="section">
      <div class="container">
        <div class="reveal">
          <div class="section-heading">
            <h2>Este programa es para ti?</h2>
            <p class="subtitle">No necesitas tener millones de seguidores. Lo importante es poder mostrar de forma clara como ChatVioniko puede ayudar a otras personas.</p>
          </div>
        </div>

        <div class="max-w-5xl" style="margin-top: 3rem; display: flex; flex-wrap: wrap; justify-content: center; gap: 0.75rem;">
          <div class="reveal"><span class="chip-tag">Creadores de contenido</span></div>
          <div class="reveal"><span class="chip-tag">Marketers</span></div>
          <div class="reveal"><span class="chip-tag">Emprendedores</span></div>
          <div class="reveal"><span class="chip-tag">Agencias</span></div>
          <div class="reveal"><span class="chip-tag">Educadores</span></div>
          <div class="reveal"><span class="chip-tag">Comunidades</span></div>
          <div class="reveal"><span class="chip-tag">Freelancers</span></div>
          <div class="reveal"><span class="chip-tag">Personas interesadas en IA</span></div>
          <div class="reveal"><span class="chip-tag">Personas que recomiendan herramientas digitales</span></div>
        </div>
      </div>
    </section>

    <!-- Section 8: Action Callout Banner (Full Container Width max-w-7xl) -->
    <section class="section">
      <div class="container">
        <div class="reveal">
          <div class="banner-box-callout" style="position: relative; overflow: hidden; border-color: rgba(139, 92, 246, 0.4); background: rgba(8, 17, 32, 0.8); box-shadow: var(--shadow-glow);">
            <div class="panel-lines" style="position: absolute; inset: 0;" aria-hidden="true"></div>
            <div style="position: relative;">
              <h2 class="banner-title" style="margin-top: 0;">
                Ya tienes personas a las que podria servirles ChatVioniko?
              </h2>
              <p style="margin: 1.25rem auto 0; max-width: 48rem; font-size: 1rem; line-height: 1.75rem; color: var(--mist);">
                Empieza probando la plataforma, descubre que puedes recomendar y, cuando actives tu suscripcion, accede al Programa de Afiliados desde tu cuenta.
              </p>
              <div style="margin-top: 2rem;">
                <a href="https://chatvioniko.com" class="btn btn-primary" target="_blank" rel="noopener">Empieza con ChatVioniko</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 9: FAQ Section (Full Container Width max-w-7xl) -->
    <section id="preguntas" class="section">
      <div class="container">
        <div class="reveal">
          <div class="section-heading">
            <h2>Preguntas frecuentes</h2>
          </div>
        </div>

        <div class="reveal" style="margin-top: 3rem;">
          <div class="faq-grid">
            <!-- Group 1: Programa -->
            <div class="faq-group">
              <h3 class="faq-group-title">Programa</h3>
              <div class="faq-stack">
                <details class="faq-item">
                  <summary class="faq-toggle">
                    <span>Cuanto cuesta ChatVioniko?</span>
                    <span class="faq-icon" aria-hidden="true">+</span>
                  </summary>
                  <p class="faq-answer">Actualmente tiene un precio de lanzamiento de 29 USD mensuales.</p>
                </details>

                <details class="faq-item">
                  <summary class="faq-toggle">
                    <span>Necesito tener ChatVioniko para ser afiliado?</span>
                    <span class="faq-icon" aria-hidden="true">+</span>
                  </summary>
                  <p class="faq-answer">Si. Para participar del Programa de Afiliados necesitas tener una suscripcion activa de ChatVioniko. Una vez suscripto tendras acceso al apartado de afiliados dentro de la plataforma.</p>
                </details>

                <details class="faq-item">
                  <summary class="faq-toggle">
                    <span>Donde me registro como afiliado?</span>
                    <span class="faq-icon" aria-hidden="true">+</span>
                  </summary>
                  <p class="faq-answer">El registro se realiza directamente dentro de ChatVioniko. Con tu suscripcion activa podras ingresar al apartado Programa de Afiliados, completar tus datos y solicitar la activacion.</p>
                </details>

                <details class="faq-item">
                  <summary class="faq-toggle">
                    <span>Puedo probar ChatVioniko antes de pagar?</span>
                    <span class="faq-icon" aria-hidden="true">+</span>
                  </summary>
                  <p class="faq-answer">Si. Puedes crear tu cuenta y realizar una prueba gratuita para conocer ChatVioniko antes de activar tu suscripcion.</p>
                </details>

                <details class="faq-item">
                  <summary class="faq-toggle">
                    <span>Cuanto recibo por una suscripcion directa?</span>
                    <span class="faq-icon" aria-hidden="true">+</span>
                  </summary>
                  <p class="faq-answer">El Nivel 1 ofrece un 20% del primer pago de cada suscripcion directa generada mediante tu enlace. Con el precio de 29 USD, el ejemplo actual equivale a 5.80 USD.</p>
                </details>

                <details class="faq-item">
                  <summary class="faq-toggle">
                    <span>Que es el Nivel 2?</span>
                    <span class="faq-icon" aria-hidden="true">+</span>
                  </summary>
                  <p class="faq-answer">Los afiliados certificados y aprobados pueden obtener un 5% del primer pago de suscripciones generadas por sus referidos.</p>
                </details>

                <details class="faq-item">
                  <summary class="faq-toggle">
                    <span>La comision es recurrente?</span>
                    <span class="faq-icon" aria-hidden="true">+</span>
                  </summary>
                  <p class="faq-answer">Segun las condiciones mostradas actualmente, la comision corresponde al primer pago. No se presenta como una comision recurrente.</p>
                </details>

                <details class="faq-item">
                  <summary class="faq-toggle">
                    <span>Que obtengo al activar mi suscripcion?</span>
                    <span class="faq-icon" aria-hidden="true">+</span>
                  </summary>
                  <p class="faq-answer">Obtienes acceso a las funciones disponibles de ChatVioniko, incluyendo herramientas de IA para contenido, investigacion, imagenes, video, asistentes, chatbots y otras funcionalidades. La suscripcion tambien incluye Academia Vioniko y acceso al apartado del Programa de Afiliados.</p>
                </details>
              </div>
            </div>

            <!-- Group 2: Condiciones -->
            <div class="faq-group">
              <h3 class="faq-group-title">Condiciones</h3>
              <div class="faq-stack">
                <details class="faq-item">
                  <summary class="faq-toggle">
                    <span>Gano comision por los creditos?</span>
                    <span class="faq-icon" aria-hidden="true">+</span>
                  </summary>
                  <p class="faq-answer">No. Las comisiones aplican a las suscripciones, no a compras de creditos.</p>
                </details>

                <details class="faq-item">
                  <summary class="faq-toggle">
                    <span>Necesito muchos seguidores?</span>
                    <span class="faq-icon" aria-hidden="true">+</span>
                  </summary>
                  <p class="faq-answer">No necesariamente. El programa tambien puede utilizarse mediante contactos, comunidades, contenido educativo, clientes o audiencias especificas.</p>
                </details>

                <details class="faq-item">
                  <summary class="faq-toggle">
                    <span>Que incluye ChatVioniko?</span>
                    <span class="faq-icon" aria-hidden="true">+</span>
                  </summary>
                  <p class="faq-answer">Incluye chat IA personalizable, biblioteca de prompts, escritura guiada, keyword research, generacion de imagenes, generacion de video, avatares, asistentes IA, creacion de chatbots, Academia Vioniko con clases en vivo y otras herramientas disponibles dentro de la plataforma.</p>
                </details>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 10: Final CTA Panel (max-w-5xl) -->
    <section class="section" style="padding-bottom: 6rem;">
      <div class="container">
        <div class="reveal">
          <div class="banner-box-callout max-w-5xl" style="border-color: rgba(139, 92, 246, 0.4); background: rgba(8, 17, 32, 0.8); box-shadow: var(--shadow-glow);">
            <p style="font-size: 0.875rem; font-weight: 900; text-transform: uppercase; color: var(--cyan-glow);">Programa de afiliados</p>
            <h2 class="banner-title">
              Todo empieza<br>
              <span class="gradient-text">conociendo ChatVioniko</span>
            </h2>
            <p style="margin: 1.5rem auto 0; max-width: 48rem; font-size: 1rem; line-height: 1.75rem; color: var(--mist);">
              Prueba la plataforma, descubre las herramientas que tendras para recomendar y, cuando actives tu suscripcion, podras acceder al Programa de Afiliados directamente desde tu cuenta.
            </p>
            <div style="margin-top: 2rem;">
              <a href="https://chatvioniko.com" class="btn btn-primary" target="_blank" rel="noopener">Probar ChatVioniko gratis</a>
            </div>

            <div style="margin-top: 1.5rem; display: flex; flex-wrap: wrap; justify-content: center; gap: 0.75rem; font-size: 0.75rem; font-weight: 900; text-transform: uppercase;">
              <span style="border-radius: 0.375rem; border: 1px solid rgba(139, 92, 246, 0.25); background: rgba(139, 92, 246, 0.1); padding: 0.5rem 0.75rem; color: #ddd6fe;">29 USD / mes precio de lanzamiento</span>
              <span style="border-radius: 0.375rem; border: 1px solid rgba(163, 230, 53, 0.25); background: rgba(163, 230, 53, 0.1); padding: 0.5rem 0.75rem; color: var(--lime-glow);">20% Nivel 1</span>
              <span style="border-radius: 0.375rem; border: 1px solid rgba(34, 211, 238, 0.25); background: rgba(34, 211, 238, 0.1); padding: 0.5rem 0.75rem; color: var(--cyan-glow);">5% Nivel 2 para afiliados certificados</span>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <footer class="site-footer">
    <div class="footer-inner">
      <p class="footer-brand">ChatVioniko Afiliados</p>
      <nav class="footer-links" aria-label="Footer">
        <a href="#como-funciona">Como funciona</a>
        <a href="#ganancias">Ganancias</a>
        <a href="#que-incluye">Que incluye</a>
        <a href="#preguntas">Preguntas frecuentes</a>
      </nav>
      <p style="font-size: 0.875rem; color: var(--mist);">© ChatVioniko</p>
    </div>
  </footer>

  <!-- ========== VIDEO MODAL ========== -->
  <div class="video-modal" id="video-modal" role="presentation">
    <div class="video-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modal-title">
      <div class="video-modal-header">
        <h3 class="video-modal-title" id="modal-title"></h3>
        <button class="video-modal-close" id="modal-close" type="button" aria-label="Cerrar video">X</button>
      </div>
      <div class="video-modal-body">
        <video id="modal-video" controls autoplay playsinline webkit-playsinline preload="auto">
          Tu navegador no puede reproducir este video.
        </video>
      </div>
    </div>
  </div>

  <!-- Modal Form Popup -->
  <div id="form-popup-modal" class="form-popup-modal" aria-hidden="true" style="display: none;">
    <div class="form-popup-overlay"></div>
    <div class="form-popup-card">
      <button type="button" class="form-popup-close" aria-label="Close modal">&times;</button>
      <div class="form-popup-inner">
        <div class="temp-form">
          <div class="form-title" data-id="landing-page-form-title">
            <h2>🔴 Descubre la Experiencia Completa</h2>
          </div>
          <div class="form-subtitle" data-id="landing-page-form-sub-title">
            <p class="modal-sub-heading">Sé de los primeros en conocer esta nueva propuesta</p>
          </div>
          <form action="../../registro_prospecto_subdominio_autoresponder.php" method="post" class="cf op-optin-validation" id="myForm">
            <div class="form-group">
              <input type="text" name="nombre" class="form-control" id="name" required="" placeholder="Nombre">
              <small class="error-beta" style="display: none;">You must enter your name.</small>
            </div>

            <div class="form-group" id="whatsapp_field_div">
              <label for="phone" class="form-label-whatsapp">Whatsapp</label>
              <div class="iti iti--allow-dropdown iti--show-flags">
                <input type="tel" name="telefono_casa" class="form-control" id="phone" autocomplete="off" placeholder="01812-345678">
              </div>
            </div>

            <div class="form-group">
              <input type="email" name="email" class="form-control" required="" id="e-mail" placeholder="E-mail">
              <small class="error-beta" style="display: none;">You must enter a e-mail.</small>
            </div>

            <div class="form-group btn-submit-group">
              <button style="background: #ff1717" type="submit" data-id="landing-page-form-submit-button" class="btn btn-default btn-submit">
                <span>CLICK AQUI para ACCESAR AHORA</span>
              </button>
            </div>

            <input type="hidden" name="pais" id="pais" value="<?php echo to_utf8($geo["geoplugin_countryName"] ?? ''); ?>">
            <input type="hidden" name="ciudad" id="ciudad" value="<?php echo to_utf8($geo["geoplugin_city"] ?? ''); ?>">
            <input type="hidden" name="estado" id="estado" value="<?php echo to_utf8($geo["geoplugin_regionName"] ?? ''); ?>">
            <?php include('../campana_user.php'); ?>
            <input type="hidden" name="usuario" id="usuario" value="<?= htmlspecialchars($userIdBySubdomain ?? ''); ?>">
            <input type="hidden" name="template" id="template" value="<?= htmlspecialchars($template ?? 194); ?>">
            <input type="hidden" name="idioma" id="idioma" value="es">
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="script.js?v=1.0.6"></script>
</body>
</html>