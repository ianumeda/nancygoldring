<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <div class="col-lg-8 col-lg-push-2 col-sm-10 col-sm-push-1">
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
    <footer>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </footer>
  </div>
  </article>
<?php endwhile; ?>
