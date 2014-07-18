<?php while (have_posts()) : the_post(); ?>

<?php
$query = new WP_Query( array( 'post_type' => 'page', 'post_parent' => '2', 'posts_per_page' => '-1','order' =>'ASC' ) ); 
if ( $query->have_posts() ) {
  $i=0;
  $feature_buttons='<div id="feature_buttons" class="row hidden-xs hidden-sm">';
?>
<div id="feature_box" class="row">
  <div id="feature_carousel" class="carousel carousel slide col-md-12" data-interval="20000">
    <!-- Indicators -->
    <ol class="carousel-indicators hidden-md hidden-lg">
      <li data-target="#feature_carousel" data-slide-to="0" class="carousel-indicator active"></li>
      <li data-target="#feature_carousel" data-slide-to="1" class="carousel-indicator"></li>
      <li data-target="#feature_carousel" data-slide-to="2" class="carousel-indicator"></li>
      <li data-target="#feature_carousel" data-slide-to="3" class="carousel-indicator"></li>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">

<?php	
while ( $query->have_posts() ) { 
  $query->the_post(); 
	if (has_post_thumbnail( $post->ID ) ){
  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
  $imgurl=$image[0];
  } else $imgurl="";

?>      

      <div class="item <?php if($i==0) echo " active"; ?>">
        <img src="<?php echo $imgurl; ?>);">
        <div class="carousel-caption ">
          <div class="carousel-item-title visible-xs"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?> </a></div>
          <div class="hidden-xs"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_content($post->ID); ?></a></div>
          <span class="read_more_link"><a href="<?php echo get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-arrow-right"></span></a></span>
        </div>
        <div class="carousel_bottom">&nbsp;</div>
      </div>

    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#feature_carousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#feature_carousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
  </div>
</div>
<?php } else { ?>
	<div class="alert alert-danger">Carousel content not found.</div>
<?php } wp_reset_postdata(); ?>
  

<?php endwhile; ?>
