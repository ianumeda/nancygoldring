

<div id="container" class="js-packery"
  data-packery-options='{ "itemSelector": ".item" }'>
	
		<?php $loop = new WP_Query( array( 'post_type' => 'art', 'posts_per_page' => -1 ) ); ?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
		
		<?php $image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src($image_id,'medium', true);
				?>
		<div class="item" style="background: url(<?php echo $image_url[0]; ?> ) !important;">
		
		<h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	</div>
	
	<?php endwhile; wp_reset_query(); ?>
</div>



