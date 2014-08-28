<?php while (have_posts()) : the_post(); ?>
<article id="art_post" <?php post_class(); ?>>
  <div class="md-overlay"></div>    
	<div class="entry-content">
		<div class="row">
      <div id="art_post_buttons">
        <?php if (ctype_space(get_the_content($post->ID)) || get_the_content($post->ID)!='') { ?>
          <a href="#" class="btn btn-xs post_content_modal collapsed" data-toggle="collapse" data-target="#post_content_modal">About</a>
        <?php } ?>
          <a class="btn btn-xs open_fullscreen_presentation" data-toggle="modal" href="#art_modal_fullscreen">
            <span class="glyphicon glyphicon-fullscreen"></span>
          </a>
      </div>
    </div>
    <?php if (ctype_space(get_the_content($post->ID)) || get_the_content($post->ID)!='') { ?>
    <div class="row">
      <div class="col-xs-12 col-sm-8 col-sm-push-2">
        <div id="post_content_modal" class="collapse">
				<?php the_content() ?>
        </div>
			</div>
		</div>
    <?php } ?>
	 <!-- FULLSCREEN MODAL CAROUSEL GALLERY --> 
	 
   	 <!-- Modal -->
   	 <div class="modal fade" id="art_modal_fullscreen" tabindex="-1" role="dialog" aria-labelledby="art_modal_fullscreenLabel" aria-hidden="true">
   	     <div class="modal-dialog">
   	         <div class="modal-content">
   	             <div class="modal-header">
 	                 <button type="button" class="close " data-dismiss="modal" aria-hidden="true">Close <span class="glyphicon glyphicon glyphicon-remove"></span></button>
 	                  <div class="modal-title">
                      <span class="site_title"><?php bloginfo('name') ?></span>
 	                    <span class="art_title"><?php the_title() ?></span>
                    </div>
   	             </div>
   	             <div class="modal-body">
   	                 <div id="goldring-modal-carousel" class="carousel slide" data-interval="0">
                      <!-- Indicators -->
                     <!-- Wrapper for slides -->
                     <div class="carousel-inner col-xs-12 col-sm-10 col-sm-push-1">
				   
      		      		<?php
      		   				$number = 0;
                    $modal_carousel_indicators='<ol class="carousel-indicators">';
                    $page_carousel_indicators='<ol class="carousel-indicators">';
                    $modal_carousel_items='';
                    $page_carousel_items='';
                    
            		    $images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) ); 
                		/* $images is now a object that contains all images (related to post id 1) and their information ordered like the gallery interface. */
        		        if ( $images ) { 
                      //looping through the images
                      foreach ( $images as $attachment_id => $attachment ) {
                        
                        $modal_carousel_indicators.='<li data-target="#goldring-modal-carousel" data-slide-to="'.$number.'" class="'. ($number==0 ? ' active' : '') .'"></li>';
                        // indicators for the page display with thumbnail images...
                        $page_carousel_indicators.='<li data-target="#GoldringCarousel" data-slide-to="'. $number .'" class="'. ($number==0 ? ' active' : '') .'">';
                        $thumbnail_image=wp_get_attachment_image_src( $attachment->ID, 'thumbnail' );
                    		$page_carousel_indicators.='<img src="'.$thumbnail_image[0] .'"/></li>';
                        

                        $modal_carousel_items.='<div class="item modal-item background-carousel'. ($number==0 ? ' active': '') .'">';
                        $large_image=wp_get_attachment_image_src( $attachment->ID, 'large' );
                        $modal_carousel_items.='<div class="background_image_container" style="background-image:url('. $large_image[0] .');"></div>';
                        $modal_carousel_items.='<div class="carousel-caption">';
                        $modal_carousel_items.='<p class="title">'. $attachment->post_title .'</p>';
                        $modal_carousel_items.='<p class="excerpt">'. $attachment->post_excerpt .'</p>';
        						    $modal_carousel_items.='<p class="content">'. $attachment->post_content .'</p></div></div>';


                        $page_carousel_items.='<div class="item modal-item background-carousel'. ($number==0 ? ' active': '') .'">';
                        $full_image=wp_get_attachment_image_src( $attachment->ID, 'full' );
                        $page_carousel_items.='<div data-target="#goldring-modal-carousel" data-slide-to="'.$number.'" class="background_image_container" style="background-image:url('. $full_image[0] .');"></div>';
                        $page_carousel_items.='<div class="carousel-caption">';
                        $page_carousel_items.='<p class="title">'. $attachment->post_title .'</p>';
                        $page_carousel_items.='<p class="excerpt">'. $attachment->post_excerpt .'</p>';
        						    $page_carousel_items.='<p class="content">'. $attachment->post_content .'</p></div></div>';

                        $number++;
      	              }
        			      }
         				    $modal_carousel_indicators.='</ol>';
                    $page_carousel_indicators.='</ol>';
                    echo $modal_carousel_items;
        						?>
					          
                   </div>
                   <!-- Controls --> 
                   <a class="left carousel-control" href="#goldring-modal-carousel" data-slide="prev">
               	     <span class="glyphicon glyphicon-chevron-left"></span>
               	   </a>
                 	 <a class="right carousel-control" href="#goldring-modal-carousel" data-slide="next">
               	     <span class="glyphicon glyphicon-chevron-right"></span>
               	   </a>

                   <?php echo $modal_carousel_indicators; ?>
                 </div>
               </div>
           <div class="modal-footer">
          </div>
       </div>
       <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
	 
	 <!-- /. FULLSCREEN MODAL CAROUSEL GALLERY -->  
	 
	 
	 
	 
	<div class="row">
		<div class="col-xs-12">
			
	 
	 <!-- POST CAROUSEL GALLERY -->  
	 
	 <div id="GoldringCarousel" class="carousel slide snazzy_thumbnails" data-ride="carousel" data-interval="20000">
     <!-- Wrapper for slides -->
     <div class="carousel-inner">
       <?php echo $page_carousel_items; ?>
     </div>
	   <!-- Indicators -->
     <?php echo $page_carousel_indicators; ?>
	 </div>

	   <!-- Controls -->
	   <a class="left carousel-control" href="#GoldringCarousel" role="button" data-slide="prev">
	     <span class="glyphicon glyphicon-chevron-left"></span>
	   </a>
	   <a class="right carousel-control" href="#GoldringCarousel" role="button" data-slide="next">
	     <span class="glyphicon glyphicon-chevron-right"></span>
	   </a>
	 </div>
	 
	 
 		</div>
 	</div>
	 <!-- /. POST CAROUSEL GALLERY --> 
		
  
    </div>
	<div>


	 
	 
	 
	 
	 
	 
	 
	</div>
    <footer>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>




