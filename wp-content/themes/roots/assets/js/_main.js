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
        if($("#goldring-modal-carousel .carousel-inner .item").first().innerHeight() === 0 || !iteration){
          $("#goldring-modal-carousel").css({"opacity":"0"});
          setTimeout(function(){init_fullscreen_modal(iteration+1);},500);
          console.log("item height === 0, "+iteration);
        } else  {
          // vertically_center_element( $("#goldring-modal-carousel") , $('.modal-header').innerHeight() );
          $("#goldring-modal-carousel").css({"opacity":"0"});
          make_background_carousel_fit($("#goldring-modal-carousel"));
          $("#goldring-modal-carousel").css({"opacity":"1" , "transition":"opacity .5s ease"});
          console.log("item height === 0, "+iteration);
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
      $('#post_content_modal .close').on('click', function(){
        $("#post_content_modal").collapse('hide');
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
          adjustment=$(this).next('.carousel-caption').height() ? $(this).next('.carousel-caption').height() : 0;
          // $(this).height($(this).parent().height()-adjustment); // this sets the height of the image div to the max height of the container
          
          if($(this).attr('loaded')!==1) {
            $(this).children("img").first().one("load", function() {
              $(this).parent().attr("loaded",1);
              size_carousel_images_appropriately($(this).parent());
            }).each(function() {
              if(this.complete) {$(this).load();}
            });
          } else {
            size_carousel_images_appropriately($(this));
          }
        });
      }
      
      function set_carousel_container_to_window_size(el){
        // this function is for the art post carousels to size the container to that of the viewport.
        var viewportWidth = $(window).width();
        var viewportHeight = $(window).height();
        viewportHeight=viewportHeight*0.5;
        el.find('.carousel-inner').css('height',viewportHeight+"px");
        el.find('.carousel-inner .item').each(function(){
          $(this).css('height',viewportHeight+"px");
        });
      }
      function size_carousel_images_appropriately(el){
        //expects el to be .item.background_image_container
        var test_img=new Image();
        
        var img = el.children("img").first();
        test_img.src=img.attr('src');
        var parent_h=el.parent().height();
        var parent_w=el.parent().width();
        adjustment=el.next('.carousel-caption').outerHeight() ? el.next('.carousel-caption').outerHeight() : 0;
        console.log('adjustment='+adjustment);
        var space_for_captions=adjustment;
        console.log(parent_h+"/"+parent_w, test_img.height+"/"+test_img.width);
        if( parent_h/parent_w < test_img.height/test_img.width ){
          // image is a taller rectangle than the window
          img.css({'margin':"0px auto",'height':(parent_h-space_for_captions)+"px",'width':'auto'});
          console.log("img is taller than window. ");
        } else {
          // image is a fatter rectangle than the window
          img.css({'margin-top':"0px", 'margin-left':"auto",'margin-right':"auto",'width':"100%",'height':'auto'});
          img_y=(parent_h-img.innerHeight()-space_for_captions)/2;
          img.css('margin-top', img_y+"px");
          console.log("img is fatter than window. ");
        }
        if( el.parent().attr('style') ){
          el.parent().removeAttr('style'); // unhack!
        }
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
        if($(".CurrentWorkCarousel").length > 0) {make_background_carousel_fit($(".CurrentWorkCarousel"));}
        
        if($('#feature_carousel').length) { set_carousel_container_to_window_size($('#feature_carousel')); }
        vertically_center_element( $("#goldring-modal-carousel") , $('.modal-header').innerHeight() );
        if($('#goldring-modal-carousel').length) { make_background_carousel_fit($('#goldring-modal-carousel')); }
        if($('#GoldringCarousel').length) {
          set_carousel_container_to_window_size($('#GoldringCarousel'));
          make_background_carousel_fit($('#GoldringCarousel'));
          // vertically_center_element( $("#GoldringCarousel") , 100 );
        }
        if($("#feature_carousel").length>0) {
          make_background_carousel_fit($("#feature_carousel"));
          vertically_center_element( $("#feature_carousel"), $('main').offset().top );
        }
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
      // $(".CurrentWorkCarousel .carousel-inner .item").each(function(){ size_carousel_images_appropriately( $(this) ); });
      // vertically_center_element( $("#feature_carousel"), $('main').offset().top );
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
      $('#feature_carousel').carousel({
        interval: 5000
      });
    }
  },
  // About us page, note the change from about-us to about_us.
  contact: {
    init: function() {
      // JavaScript to be fired on the contact page
      function vertically_center_element(e, offset_h){
        if(!e.length) {return false;}
        else {
          if(isNaN(offset_h)) {
            offset_h=0;
          }
          var foo=(document.documentElement.clientHeight-e.innerHeight()-offset_h)/2;
          e.css({"position":"relative", "margin-top":(foo>0 ? foo : 0)+"px"});
        }
      }
      contact_content=$("main").children("p").first();
      main_offset=$("main").offset();
      vertically_center_element( contact_content, 300 );
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

