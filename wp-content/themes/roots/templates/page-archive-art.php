

<div id="container" class="js-packery"
  data-packery-options='{ "itemSelector": ".item", "gutter": 10 }'>
	
		<?php $loop = new WP_Query( array( 'post_type' => 'art', 'posts_per_page' => -1 ) ); ?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
	<div class="item">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php the_excerpt(); ?>
	</div>
	
	<?php endwhile; wp_reset_query(); ?>
</div>