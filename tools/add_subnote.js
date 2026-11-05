const fs = require('fs');
let s = fs.readFileSync('30beta/index_beta.php', 'utf8');

const target = '</button>';
const targetInput = '<input type="hidden" name="pais" id="pais"';

const p1 = s.lastIndexOf(target);
const p2 = s.indexOf(targetInput, p1);

if (p1 === -1 || p2 === -1) {
  console.error("Targets not found in index_beta.php!");
  process.exit(1);
}

const snippet = `</button>
                        <p class="todavia-subnote">Recibe de <strong>inmediato</strong> tu guía gratuita y el acceso a la conferencia en tu correo.</p>

                        `;

s = s.substring(0, p1) + snippet + s.substring(p2);
fs.writeFileSync('30beta/index_beta.php', s, 'utf8');
console.log('Successfully added todavia-subnote to 30beta/index_beta.php!');
