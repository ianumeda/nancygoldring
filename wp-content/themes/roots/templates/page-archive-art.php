				 <?php 
				 // Featured POEM args
				 $args = array(
				 	'numberposts' => -1,
				 	'post_type' => 'art',
				 );
 
				 // get results
				 $the_query = new WP_Query( $args );
 
				 // The Loop
				 ?>
				 <?php if( $the_query->have_posts() ): ?>
				 	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				 		<h6>
				 		  <a href="<?php the_permalink(); ?>"><?php the_field('work-author'); ?>, <em><?php the_title(); ?></em></a>
				 		</h6>
				 	<?php endwhile; ?>
				 <?php endif; ?>
 
				 <?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>	