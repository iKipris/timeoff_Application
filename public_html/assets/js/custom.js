!(function (s) {
   "use strict";
   s("#sidebarToggle, #sidebarToggleTop").on("click", function (e) {

         s("body").toggleClass("sidebar-toggled"), s(".sidebar").toggleClass("toggled"), s(".sidebar").hasClass("toggled") && s(".sidebar .collapse").collapse("hide");
      }),
      s(window).resize(function () {
         s(window).width() < 768 && s(".sidebar .collapse").collapse("hide"),
            s(window).width() < 480 && !s(".sidebar").hasClass("toggled") && (s("body").addClass("sidebar-toggled"), s(".sidebar").addClass("toggled"), s(".sidebar .collapse").collapse("hide"));

      });

   $(window).bind("resize", function () {

      if ($(window).width() < 750) {

         document.getElementById("accordionSidebar").classList.add("toggled");
         $('#mysearchbar').removeClass('searchbarwidth2');
         $('#mysearchbar').addClass('searchbarwidth1');
      }

      if ($(window).width() < 450) {
         $('#mysearchbar').removeClass('searchbarwidth1');
         $('#mysearchbar').addClass('searchbarwidth2');
      }

      if ($(window).width() > 750) {

         $('#mysearchbar').removeClass('searchbarwidth1');
         $('#mysearchbar').removeClass('searchbarwidth2');
         $('#mysearchbar').removeClass('searchbarwidth3');
         $('#mysearchbar').removeClass('searchbarwidth4');
      }
      if ($(window).width < 392) {
         $('#mysearchbar').removeClass('searchbarwidth1');
         $('#mysearchbar').removeClass('searchbarwidth2');
         $('#mysearchbar').addClass('searchbarwidth3');

      }
      if ($(window).width < 317) {
         $('#mysearchbar').removeClass('searchbarwidth2');
         $('#mysearchbar').removeClass('searchbarwidth1');
         $('#mysearchbar').removeClass('searchbarwidth3');
         $('#mysearchbar').addClass('searchbarwidth4');

      }


   })

   if ($(window).width() < 750) {

      document.getElementById("accordionSidebar").classList.add("toggled");

      $('#mysearchbar').addClass('searchbarwidth1');
      if ($(window).width() < 450) {
         $('#mysearchbar').addClass('searchbarwidth2');
      }
      if ($(window).width() < 392) {
         $('#mysearchbar').removeClass('searchbarwidth2');
         $('#mysearchbar').addClass('searchbarwidth3');

      }
      if ($(window).width < 316) {
         $('#mysearchbar').removeClass('searchbarwidth3');
         $('#mysearchbar').addClass('searchbarwidth4');

      }
   }

})(jQuery);
