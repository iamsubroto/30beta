const fs = require('fs');
let s = fs.readFileSync('30beta/script.js', 'utf8');
const oldSnippet = 'var box=form.parentNode,email=form.querySelector("input[type=email]")||form.querySelector("input"),err=box.querySelector(".sj-gerr"),ok=box.querySelector(".sj-gok");';
const newSnippet = 'var box=form.parentNode,email=form.querySelector("input[type=email]")||form.querySelector("input"),nameInput=form.querySelector("input[name=nombre]")||form.querySelector("input[name=name]"),err=box.querySelector(".sj-gerr"),ok=box.querySelector(".sj-gok");';
const oldFetch = 'body:JSON.stringify({email:v,culture:CULTURE,webalias:WEBALIAS,formName:FORM_NAME})';
const newFetch = 'body:JSON.stringify(Object.assign({email:v,culture:CULTURE,webalias:WEBALIAS,formName:FORM_NAME},nameInput&&nameInput.value.trim()?{name:nameInput.value.trim(),firstName:nameInput.value.trim()}:{}))';

if (s.includes(oldSnippet) && s.includes(oldFetch)) {
  s = s.replace(oldSnippet, newSnippet).replace(oldFetch, newFetch);
  fs.writeFileSync('30beta/script.js', s, 'utf8');
  console.log('script.js updated successfully!');
} else {
  console.log('Snippet not matched');
}
