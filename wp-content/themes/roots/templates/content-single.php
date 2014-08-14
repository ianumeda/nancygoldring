<?php while (have_posts()) : the_post(); ?>
<div class="row">
  <div class="col-xs-12 col-sm-8 col-sm-push-2">
  <article <?php post_class(); ?>>
    <header>
		  <?php
		    if ( function_exists('custom_breadcrumb') && (is_front_page()!=true) ) {
          custom_breadcrumb();
		    } else {
          echo '<h1 class="entry-title">'.the_title().'</h1>';
		    }
		  ?>
    <div>
      <?php get_template_part('templates/entry-meta'); ?>
    </div>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
    <footer>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </footer>
  </article>
</div>
</div>
<?php endwhile; ?>
