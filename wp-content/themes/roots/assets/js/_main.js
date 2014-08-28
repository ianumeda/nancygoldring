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
      var resize_delay; // used to throttle resizing functions
      // JavaScript to be fired on all pages
      function vertically_center_element(e, offset_h){
        if(!e.length) {return false;}
        else {
          if(isNaN(offset_h)) {
            offset_h=0;
          }
          var foo=(document.documentElement.clientHeight-e.innerHeight()-offset_h)/2;
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
        if($("#goldring-modal-carousel .carousel-inner .item").first().innerHeight() === 0){
          $("#goldring-modal-carousel").css({"opacity":"0"});
          console.log("item height === 0, "+iteration);
          setTimeout(function(){init_fullscreen_modal(iteration+1);},500);
        } else  {
          vertically_center_element( $("#goldring-modal-carousel") , $('.modal-header').innerHeight() );
          make_background_carousel_fit($("#goldring-modal-carousel"));
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
      $('#post_content_modal').on('click',function(event){
        event.stopPropagation();
      });
      $('html').click(function() {
        $("#post_content_modal").collapse('hide');
        //Hide the about text if visible
      });
      // initialize art about collapse 
      $("#post_content_modal").collapse({ toggle: false });
      
      
      function make_background_carousel_fit(el){
        el.find(".background_image_container").each(function(){
          // this function sizes the carousel images to the size of the parent container divs
          if( $(this).parent().css("display")==="none"){
            // this is because elements with display:none have zero height 
            $(this).parent().css({display:"block",visibility:"hidden"}); // hack!
          }
          adjustment=$(this).parent().find('.carousel-caption').outerHeight();
          $(this).height($(this).parent().height()-adjustment); // this sets the height of the image div to the max height of the container

          var parent_h=$(this).parent().height();
          var parent_w=$(this).parent().width();
          
          // the following gets the background image dimensions so we can set the background-size so that it doesn't get cut off
          var img = new Image();
          img.src = $(this).css('background-image').replace(/url\(|\)$/ig, "");
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
      
      // make carousel-indicators one row and follow selected image...

      function carousel_thumbnail_snazziness(el){
        if(el===undefined){
          el=$('body');
        }
        var thumbnails=el.find(".carousel-indicators").first();
        var one_thumbnail_width=thumbnails.children().first().outerWidth()+10;
        var all_thumbnails_width=one_thumbnail_width*thumbnails.children().length; // thumbnails are one_thumbnail_width wide each
        thumbnails.css({"text-align":"left", width:all_thumbnails_width+"px"});
        thumbnails.on("click","li",function(event){
          center_active_thumb($(this));
        });
        var snazzy_id=thumbnails.parent().attr("id"); // this assumes that .carousel-indicators is within the carousel div
        $('.carousel-control[href="#'+snazzy_id+'"]').on("click", function(event){
          // this makes it work with the left/right controls
          center_active_thumb(thumbnails,false,$(this).attr("data-slide"));
        });
        thumbnails.css({left:center_active_thumb(thumbnails,true)+"px"});
        setTimeout(function(){
          // have to delay setting the transitions on first run or else the thumbnails sweep in from the left when there are fewer than fill the screen
          thumbnails.css({transition:"left 1s ease, opacity 1s ease", opacity:1});
        },500);
      }
      function center_active_thumb(el,return_value,nextprev){
        // pass in the clicked thumbnail or the thumbnail container div and we'll figure out which is the active thumbnail from the class
        if(el===undefined) { return false; }
        else if(el.parent().hasClass("carousel-indicators")){
          active_li=el;
        } else if(el.hasClass("carousel-indicators")){
          active_li=el.find("li.active");
        } else {
          active_li=el.find(".carousel-indicators li.active");
        }
        if(nextprev==="next"){
          if(active_li.is(':last-child')){
            active_li=active_li.siblings(":first-child");
          } else {
            active_li=active_li.next();
          }
        } else if(nextprev==="prev"){
          if(active_li.is(':first-child')){
            active_li=active_li.siblings(":last-child");
          } else {
            active_li=active_li.prev();
          }
        }
        var container_width=active_li.parent().parent().innerWidth();
        var thumbnails_width = active_li.parent().innerWidth();
        var center_thumbnail_in_view= (thumbnails_width < container_width ? (container_width-thumbnails_width)/2 : active_li.position().left<container_width/2 ? 0 : (active_li.position().left>thumbnails_width-container_width/2 ? -thumbnails_width+container_width : -active_li.position().left-active_li.outerWidth()/2+container_width/2));
        if(return_value){
          return center_thumbnail_in_view;
        } else {
          active_li.parent().css({left:center_thumbnail_in_view+'px'});
        }
      }
      
      if($(".snazzy_thumbnails").length){
        carousel_thumbnail_snazziness($(".snazzy_thumbnails")); // this initiates snazzy_thumbnails in any element with the class
      }
      function on_resize(){
        vertically_center_element( $("#feature_carousel"), $('main').offset().top );
        vertically_center_element( $("#goldring-modal-carousel") , $('.modal-header').innerHeight() );
        if($('#goldring-modal-carousel').length) { make_background_carousel_fit($('#goldring-modal-carousel')); }
        if($('#GoldringCarousel').length) {
          make_background_carousel_fit($('#GoldringCarousel'));
          vertically_center_element( $("#GoldringCarousel") , $('header').innerHeight() );
        }
        if($("#feature_carousel").length) { make_background_carousel_fit($("#feature_carousel")); }
        setTimeout(function(){
          position_footer();
        },5);
        if($(".snazzy_thumbnails").length){
          center_active_thumb($(".snazzy_thumbnails")); // this initiates snazzy_thumbnails in any element with the class
        }
      }

      $(window).resize( function(){
        if(resize_delay){
          window.clearTimeout(resize_delay);
          resize_delay=0;
        }
        resize_delay=setTimeout(on_resize, 500);
      });

      // first run...
      vertically_center_element( $("#feature_carousel"), $('main').offset().top );
      vertically_center_element( $("#GoldringCarousel") , $('header').innerHeight() );
      setTimeout(function(){
        position_footer();
      },5);
      on_resize();
      
      // the following moves the art_post_buttons into the .breadcrumbs div in the art_posts
      if($("#art_post_buttons").length){
        $("#art_post_buttons").appendTo($(".breadcrumbs"));
      }
      
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

