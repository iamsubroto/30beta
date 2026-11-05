const fs = require('fs');
let s = fs.readFileSync('30beta/index_beta.php', 'utf8');

const targetStart = '<div builder-id="builder-fe7eb59c5a8f44228b95ca4c05b75a15" class="builder-block builder-fe7eb59c5a8f44228b95ca4c05b75a15 css-17zabp4">';
const targetEnd = '<div builder-id="builder-6f80156ba3444a6aaa8c019fd6e7ff5f" class="builder-block builder-6f80156ba3444a6aaa8c019fd6e7ff5f css-2ks0li">';

const p1 = s.indexOf(targetStart);
const p2 = s.indexOf(targetEnd);

console.log('p1:', p1, 'p2:', p2);
if (p1 === -1 || p2 === -1) {
  console.error("Targets not found!");
  process.exit(1);
}

const newSection = `          <!-- "¿Todavía no estás lista?" Section (Menopause Survival Guide + Palafox Conference) -->
          <div builder-id="builder-fe7eb59c5a8f44228b95ca4c05b75a15" class="builder-block builder-fe7eb59c5a8f44228b95ca4c05b75a15 todavia-section">
            <div class="todavia-container">
              <div class="todavia-grid">
                <!-- Left Column: Book & Laptop Mockup -->
                <div class="todavia-media-col">
                  <div class="todavia-image-wrap">
                    <img 
                      src="./assets/images/guia_menopausia_laptop.png" 
                      alt="Menopause Survival Guide con Conferencia del Científico Palafox" 
                      class="todavia-mockup-img" 
                      loading="lazy" 
                      decoding="async"
                    />
                  </div>
                </div>

                <!-- Right Column: Content & Lead Capture Form -->
                <div class="todavia-content-col">
                  <!-- Top Pill Badge with horizontal glowing line -->
                  <div class="todavia-badge-wrap">
                    <div class="todavia-glow-line" aria-hidden="true"></div>
                    <div class="todavia-badge">
                      <span>DESCARGA GRATIS</span>
                      <span class="todavia-badge-dot">·</span>
                      <span>ACCESO INMEDIATO</span>
                    </div>
                  </div>

                  <!-- Headline -->
                  <h2 class="todavia-heading">
                    <span class="todavia-heading-white">Tu Guía de Supervivencia</span>
                    <span class="todavia-heading-pink">para la Menopausia</span>
                  </h2>

                  <!-- Subtitle -->
                  <p class="todavia-subtext">
                    Descubre, en un lenguaje claro y práctico, cómo afrontar esta etapa con más energía, equilibrio hormonal y bienestar integral.
                  </p>

                  <!-- Bullet Checklist -->
                  <ul class="todavia-checklist">
                    <li>
                      <span class="todavia-chk-icon">
                        <svg viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M1.5 6L5.5 10L14.5 1.5" stroke="#FF1E6C" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </span>
                      <span>¿Estoy en la perimenopausia? Cómo saberlo</span>
                    </li>
                    <li>
                      <span class="todavia-chk-icon">
                        <svg viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M1.5 6L5.5 10L14.5 1.5" stroke="#FF1E6C" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </span>
                      <span>Por qué tienes calor, cansancio y niebla mental</span>
                    </li>
                    <li>
                      <span class="todavia-chk-icon">
                        <svg viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M1.5 6L5.5 10L14.5 1.5" stroke="#FF1E6C" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </span>
                      <span>Qué hacer con la pancita, el peso y la energía</span>
                    </li>
                    <li>
                      <span class="todavia-chk-icon">
                        <svg viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M1.5 6L5.5 10L14.5 1.5" stroke="#FF1E6C" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </span>
                      <span>Sexo y libido: qué cambió y cómo recuperarlo</span>
                    </li>
                  </ul>

                  <!-- Exclusive Bonus Box -->
                  <div class="todavia-bonus-box">
                    <div class="todavia-bonus-tv">
                      <svg viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2" y="5" width="40" height="26" rx="4" stroke="#FF2D7A" stroke-width="2.2" fill="rgba(255, 45, 122, 0.06)"/>
                        <polygon points="19,13 29,18 19,23" fill="#FFFFFF"/>
                        <path d="M22 31v5M15 36h14" stroke="#FF2D7A" stroke-width="2.2" stroke-linecap="round"/>
                      </svg>
                    </div>
                    <div class="todavia-bonus-divider" aria-hidden="true"></div>
                    <div class="todavia-bonus-body">
                      <div class="todavia-bonus-head">
                        <span class="todavia-bonus-tag">BONO EXCLUSIVO:</span>
                        <span class="todavia-bonus-title">Conferencia Científica</span>
                      </div>
                      <div class="todavia-bonus-speaker">con el Científico Palafox</div>
                      <p class="todavia-bonus-desc">
                        Acceso inmediato a su conferencia, donde explica todos los componentes de la formulación y qué hace tan especial este producto para el bienestar de la mujer en esta etapa.
                      </p>
                    </div>
                    <div class="todavia-bonus-flask">
                      <svg viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 6h10M25 6v9L14 34c-1.8 3.2 0.5 7 4.2 7h17.6c3.7 0 6-3.8 4.2-7L29 15V6" stroke="#FF2D7A" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18 31c3-1.8 6.5 0.8 10-0.8s6 0.8 9.5-0.8" stroke="#FF5A9E" stroke-width="1.8" stroke-linecap="round"/>
                        <circle cx="41" cy="8" r="2.2" fill="#FF5A9E"/>
                        <circle cx="49" cy="13" r="2.2" fill="#FF5A9E"/>
                        <circle cx="47" cy="22" r="2.2" fill="#FF5A9E"/>
                        <circle cx="37" cy="19" r="2.2" fill="#FF5A9E"/>
                        <line x1="41" y1="8" x2="49" y2="13" stroke="#FF5A9E" stroke-width="1.6"/>
                        <line x1="49" y1="13" x2="47" y2="22" stroke="#FF5A9E" stroke-width="1.6"/>
                        <line x1="47" y1="22" x2="37" y2="19" stroke="#FF5A9E" stroke-width="1.6"/>
                        <line x1="37" y1="19" x2="41" y2="8" stroke="#FF5A9E" stroke-width="1.6"/>
                        <line x1="33" y1="15" x2="37" y2="19" stroke="#FF5A9E" stroke-width="1.6"/>
                      </svg>
                    </div>
                  </div>

                  <!-- Form Capture -->
                  <div class="todavia-form-wrap">
                    <div class="sj-glead sj-gclose">
                      <form class="sj-gform todavia-gform" data-pdf="https://cdn.builder.io/o/assets%2Ffdb4d79bfbfd478d89398007f8c29424%2Ffc5571e722e0421197e017b04c290126?alt=media&amp;token=204ddd84-f1ef-45dd-8392-c36abac237a5&amp;apiKey=fdb4d79bfbfd478d89398007f8c29424" novalidate="">
                        <div class="todavia-inputs-row">
                          <div class="todavia-input-group">
                            <span class="todavia-input-icon">
                              <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                              </svg>
                            </span>
                            <input type="text" name="nombre" class="todavia-input" placeholder="Tu nombre" aria-label="Tu nombre" autocomplete="name" />
                          </div>
                          <div class="todavia-input-group">
                            <span class="todavia-input-icon">
                              <svg viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                              </svg>
                            </span>
                            <input type="email" name="email" class="todavia-input" placeholder="Tu email" aria-label="Tu email" autocomplete="email" required />
                          </div>
                        </div>

                        <button type="submit" class="todavia-submit-btn">
                          <span class="todavia-btn-text">Quiero mi guía y conferencia gratis</span>
                          <span class="todavia-btn-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round">
                              <line x1="5" y1="12" x2="19" y2="12"></line>
                              <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                          </span>
                        </button>

                        <input type="hidden" name="pais" id="pais" value="<?php echo to_utf8($geo["geoplugin_countryName"] ?? ''); ?>">
                        <input type="hidden" name="ciudad" id="ciudad" value="<?php echo to_utf8($geo["geoplugin_city"] ?? ''); ?>">
                        <input type="hidden" name="estado" id="estado" value="<?php echo to_utf8($geo["geoplugin_regionName"] ?? ''); ?>">
                        <?php include('../campana_user.php'); ?>
                        <input type="hidden" name="usuario" id="usuario" value="<?= htmlspecialchars($userIdBySubdomain ?? ''); ?>">
                        <input type="hidden" name="template" id="template" value="<?= htmlspecialchars($template ?? 195); ?>">
                        <input type="hidden" name="idioma" id="idioma" value="es">
                      </form>
                      <p class="sj-gerr" style="display:none;color:#ff6b6b;font-size:14px;margin-top:10px;text-align:center;"></p>
                      <p class="sj-gok" hidden="" style="color:#ffffff;font-size:15px;margin-top:12px;text-align:center;">
                        Tu guía se está abriendo en una pestaña nueva. <a href="https://cdn.builder.io/o/assets%2Ffdb4d79bfbfd478d89398007f8c29424%2Ffc5571e722e0421197e017b04c290126?alt=media&amp;token=204ddd84-f1ef-45dd-8392-c36abac237a5&amp;apiKey=fdb4d79bfbfd478d89398007f8c29424" rel="noopener" target="_blank" style="color:#FF2D6C;font-weight:600;text-decoration:underline;">Abrir la guía</a>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          `;

s = s.substring(0, p1) + newSection + s.substring(p2);
fs.writeFileSync('30beta/index_beta.php', s, 'utf8');
console.log('Successfully replaced section in 30beta/index_beta.php!');
