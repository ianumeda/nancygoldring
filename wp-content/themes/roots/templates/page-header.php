<div class="page-header">
<?php
// we are using the breadcrumbs as the title...
  if ( function_exists('custom_breadcrumb') && (is_front_page()!=true) ) {
    custom_breadcrumb();
  } else {
    echo '<h1 class="entry-title">'.the_title().'</h1>';
  }
?>
  <!-- <h1>
    <?php echo roots_title(); ?>
  </h1> -->
</div>
