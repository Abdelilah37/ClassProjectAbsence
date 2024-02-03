window.addEventListener('DOMContentLoaded', function () {
  var preloader = document.querySelector('.preloader');
  if (preloader) {
    preloader.style.display = 'none'; // or preloader.remove();
  }
});
// jQuery(document).ready(function() {
//   var preloader = jQuery('.preloader');
//   if (preloader.length) {
//       preloader.css('opacity', '0');
//       setTimeout(function() {
//           preloader.hide();
//       }, 200); // Adjust the time to match the transition duration
//   }
// });