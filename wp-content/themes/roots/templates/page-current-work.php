

<div id="container" class="js-packery" data-packery-options='{ "itemSelector": ".pack-item" }'>
	
		<?php $loop = new WP_Query( array( 'post_type' => 'art', 'posts_per_page' => -1 ) ); ?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
		
		
		<div class="pack-item text-center">
			
			 <!-- POST CAROUSEL GALLERY -->  
	 
			 <div id="CurrentWorkCarousel<?php the_id() ?>" class="CurrentWorkCarousel carousel slide" data-ride="carousel" data-interval="<?php echo round(rand(8000000,16000000)/1000); ?>">
		 
			   <!-- Wrapper for slides -->
			   <div class="carousel-inner">
		   		<?php
 		        $images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) ); 
		   		/* $images is now a object that contains all images (related to post id 1) and their information ordered like the gallery interface. */
		   		        if ( $images ) { 
 		                //looping through the images
                    $number=-1;
 		                foreach ( $images as $attachment_id => $attachment ) {
                      $number++;
 		                ?>

									<div class="carousel-item item<?php echo ($number==0 ? ' active' : ''); ?>">
   									
								
										<?php
										$imageUrl = wp_get_attachment_image_src( $attachment->ID, 'medium' );

										echo '<img class="img-responsive" src="'; echo $imageUrl[0]; echo '"/> ';
										?>
									</div>
							        

		   		                <?php
		   		                }
		   		        }
		   				?>
			     </div>

			   </div>

</div>
			 <!-- /. POST CAROUSEL GALLERY -->
			
			
			
	
	<?php endwhile; wp_reset_query(); ?>
</div>



