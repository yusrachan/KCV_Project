/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
// import './public/assets/styles/app.css';

//rajouter le .css bootstrap
// import '~bootstrap/dist/css/bootstrap.css';
import './styles/app.css';
// import './public/assets/styles/app.css';
import './styles/kcv.css';
// import './public/assets/styles/kcv.css';

// jquery
const $ = require ('jquery');
window.jQuery = $;
window.$ = $;
// importer bootstrap
import 'bootstrap';