<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
  <div class="md-overlay"></div>    
	<div class="entry-content">
		<div class="row">
			<div class="col-xs-12">
        <h2 class="art_title"><?php the_title() ?></h2>
        <button type="button" class="btn btn-link art_about collapsed" data-toggle="collapse" data-target="#art_about">
          <span class="collapsed glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-minus"></span> About
        </button>

        <div id="art_about" class="collapse">
				<?php the_content() ?>
        </div>
			</div>
		</div>
   	   
	 <!-- FULLSCREEN MODAL CAROUSEL GALLERY --> 
	 
	<div class="row">
		<div class="col-xs-12">
	   	 <!-- Button trigger modal --> 
       <a class="open_fullscreen_presentation" data-toggle="modal" href="#art_modal_fullscreen" class="btn btn-default btn-xs">
	   		 <span class="glyphicon glyphicon-fullscreen"> fullscreen</span>
       </a>
		</div>
	</div> 
	 
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
   	                 <div id="goldring-modal-carousel" class="carousel slide" data-interval="30000">
                      <!-- Indicators -->
                     <!-- Wrapper for slides -->
                     <div class="carousel-inner">
				   
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
                    		$page_carousel_indicators.='<img src="'.wp_get_attachment_image_src( $attachment->ID, 'thumbnail' )[0] .'"/></li>';
                        

                        $modal_carousel_items.='<div class="item modal-item background-carousel'. ($number==0 ? ' active': '') .'">';
                        $modal_carousel_items.='<div class="background_image_container" style="background-image:url('. wp_get_attachment_image_src( $attachment->ID, 'large' )[0] .');"></div>';
                        $modal_carousel_items.='<div class="carousel-caption">';
                        $modal_carousel_items.='<p>'. $attachment->post_excerpt .'</p>';
        						    $modal_carousel_items.='<p>'. $attachment->post_content .'</p></div></div>';


                        $page_carousel_items.='<div class="item modal-item background-carousel'. ($number==0 ? ' active': '') .'">';
                        $page_carousel_items.='<div class="background_image_container" style="background-image:url('. wp_get_attachment_image_src( $attachment->ID, 'full' )[0] .');"></div>';
                        $page_carousel_items.='<div class="carousel-caption">';
                        $page_carousel_items.='<p>'. $attachment->post_excerpt .'</p>';
        						    $page_carousel_items.='<p>'. $attachment->post_content .'</p></div></div>';

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




