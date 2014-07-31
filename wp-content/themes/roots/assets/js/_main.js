/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can 
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function($) {

// Use this variable to set up the common and page specific functions. If you 
// rename this variable, you will also need to rename the namespace below.
var Roots = {
  // All pages
  common: {
    init: function() {
      // JavaScript to be fired on all pages
      function vertically_center_element(e, offset_h){
        if(!e.length) {return false;}
        else {
          if(isNaN(offset_h)) {
            offset_h=0;
          }
          var foo=(document.documentElement.clientHeight-e.innerHeight()-offset_h)/2;
          console.log( document.documentElement.clientHeight+"-"+e.innerHeight()+"/2="+foo);
          e.css({"top":(foo>0 ? foo : 0)+"px"});
        }
      }
      
      function position_footer(){
        if($(document).height() > window.innerHeight ) {
          $('footer').css({"position":"relative"});
        } else {
          $('footer').css({"position":"absolute", "bottom":"1px"});
        }
      }
      
      function init_fullscreen_modal (iteration){
        // this function ensures that the resizing of the modal presentation happens before you see it. All the sizing can only happen with the modal is active. Otherwise the sizes are all zero.
        if( $("#goldring-modal-carousel .carousel-inner .item").first().innerHeight() === 0){
          console.log("not ready:"+iteration);
          $("#goldring-modal-carousel").css({"opacity":"0"});
          setTimeout(function(){init_fullscreen_modal(iteration++);},500);
        } else  {
          console.log("ready!");
          vertically_center_element( $("#goldring-modal-carousel") , $('.modal-header').innerHeight() );
          make_modal_presentation_big();
          $("#goldring-modal-carousel").css({"opacity":"1" , "transition":"opacity .5s ease"});
        }
      }
      $(".open_fullscreen_presentation").on("click", function(){
        init_fullscreen_modal(0);
      });

      $("#footer_info_button").on("click mouseenter",function(e){
        $("footer").addClass("active");
        window.setTimeout(function(){
          $.scrollTo('100%', {duration:500});
        }, 500);
      });
      $('footer').on('mouseleave', function(){
        $("footer").removeClass("active");
      });
      
      function make_modal_presentation_big(){
        $("#goldring-modal-carousel .background_image_container").each(function(){
          // this function sizes the carousel images to the size of the parent container divs
          if( $(this).parent().css("display")==="none"){
            // this is because elements with display:none have zero height 
            $(this).parent().css({display:"block",visibility:"hidden"}); // hack!
          }
          $(this).height($(this).parent().height()); // this sets the height of the image div to the max height of the container

          var parent_h=$(this).parent().height();
          var parent_w=$(this).parent().width();
          
          // the following gets the background image dimensions so we can set the background-size so that it doesn't get cut off
          var img = new Image();
          img.src = $(this).css('background-image').replace(/url\(|\)$/ig, "");
          // console.log(img.width+" x "+img.height);
          if( parent_h / parent_w > img.height/img.width ){
            $(this).css({'background-size':'100% auto'});
          } else {
            $(this).css({'background-size':'auto 100%'});
          }
          if( $(this).parent().attr('style') ){
            $(this).parent().removeAttr('style'); // unhack!
          }
        });
      }
      $(window).resize( function(){
        vertically_center_element( $("#feature_carousel"), $('main').offset().top );
        vertically_center_element( $("#goldring-modal-carousel") , $('.modal-header').innerHeight() );
        if($('#goldring-modal-carousel').length) { make_modal_presentation_big(); }
        position_footer();
      });
      // first run...
      vertically_center_element( $("#feature_carousel"), $('main').offset().top );
      // vertically_center_element( $("#goldring-modal-carousel") , $('.modal-header').innerHeight() );
      position_footer();
      
    }
  },
  // Home page
  home: {
    init: function() {
      // JavaScript to be fired on the home page
      
    }
  },
  // About us page, note the change from about-us to about_us.
  about_us: {
    init: function() {
      // JavaScript to be fired on the about us page
    }
  }
};

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
var UTIL = {
  fire: function(func, funcname, args) {
    var namespace = Roots;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {
    UTIL.fire('common');

    $.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
    });
  }
};

$(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.

