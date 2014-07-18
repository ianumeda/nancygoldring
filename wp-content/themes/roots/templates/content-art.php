<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    
	<div class="entry-content">
   	   
	 <!-- FULLSCREEN MODAL CAROUSEL GALLERY -->  
	 <!-- Button trigger modal --> <a data-toggle="modal" href="#myModal" class="btn btn-default btn-xs">
		 <span class="glyphicon glyphicon-fullscreen"> fullscreen</span></a>

   	 <!-- Modal -->
   	 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   	     <div class="modal-dialog">
   	         <div class="modal-content">
   	             <div class="modal-header">
   	                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
   	                  <h4 class="modal-title"><?php the_title() ?></h4>

   	             </div>
   	             <div class="modal-body">
   	                 <div id="goldring-modal-carousel" class="carousel slide">
   	                     <!-- Indicators -->
   	                     <ol class="carousel-indicators">
   	                         <li data-target="#goldring-modal-carousel" data-slide-to="0" class="active"></li>
   	                         <li data-target="#goldring-modal-carousel" data-slide-to="1"></li>
   	                         <li data-target="#goldring-modal-carousel" data-slide-to="2"></li>
   	                     </ol>
   	                     <!-- Wrapper for slides -->
   	                     <div class="carousel-inner">
							 
   				 	   		<?php
   				 	   		        $images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) ); 
   				 	   		/* $images is now a object that contains all images (related to post id 1) and their information ordered like the gallery interface. */
   				 	   		        if ( $images ) { 

   				 	   		                //looping through the images
   				 	   		                foreach ( $images as $attachment_id => $attachment ) {
   				 	   		                ?>

   				 	   		                <?php /* Outputs the image like this: <img src="" alt="" title="" width="" height="" /> */  ?>							
   												<div class="item modal-item">
   				 	   									
													
													<?php
													$imageUrl = wp_get_attachment_image_src( $attachment->ID, 'full' );

													echo '<img class="img-responsive" src="'; echo $imageUrl[0]; echo '"/> ';
													?>
   					   	                             <div class="carousel-caption">
     				 								        <p>Caption <?php echo $attachment->post_excerpt; ?></p>
     				 								        <p>Description <?php echo $attachment->post_content; ?></p>
   					   	                             </div>
   												</div>
				 								        
       
   				 	   		                <?php
   				 	   		                }
   				 	   		        }
   				 	   				?>         
   	                     </div>
   	                     <!-- Controls --> <a class="left carousel-control" href="#goldring-modal-carousel" data-slide="prev">
   	     <span class="icon-prev"></span>
   	   </a>
   	  <a class="right carousel-control" href="#goldring-modal-carousel" data-slide="next">
   	     <span class="icon-next"></span>
   	   </a>

   	                 </div>
   	             </div>
   	             <div class="modal-footer">
   	                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   	             </div>
   	         </div>
   	         <!-- /.modal-content -->
   	     </div>
   	     <!-- /.modal-dialog -->
   	 </div>
   	 <!-- /.modal -->
	 
	 <!-- /. FULLSCREEN MODAL CAROUSEL GALLERY -->  
		
      <?php the_content(); ?>
    </div>
	<div>


	 
	 
	 
	 
	 
	 
	 
	</div>
    <footer>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>




