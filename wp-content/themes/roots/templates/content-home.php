<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    
	<div class="entry-content">

<?php 
$query = new WP_Query( array( 'post_type' => 'page', 'post_parent' => $post->ID, 'posts_per_page' => '999' ,'orderby' =>'menu_order' ) ); 
if ( $query->have_posts() ) {
?>
<div class="row">
  <div id="feature_carousel" class="carousel carousel slide col-md-12" data-interval="5000">
    <!-- Wrapper for slides -->
    <div class="carousel-inner">

<?php	
$slide_counter=0;
$indicators='<!-- Indicators --><ol class="carousel-indicators">';
while ( $query->have_posts() ) { 
  $indicators.='<li data-target="#feature_carousel" data-slide-to="'.$slide_counter.'" class="carousel-indicator '.($slide_counter==0 ? "active" : "").'"></li>';
  $query->the_post(); 
	if (has_post_thumbnail( $post->ID ) ){
  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
  $imgurl=$image[0];
  } else $imgurl="";

?>      
    <div class="item background-carousel<?php if($slide_counter==0) echo " active"; ?>">
      <div class="background_image_container" style="height:50%; min-height:360px;">
        <img src="<?php echo $imgurl; ?>">
      </div>
      <!-- <img class="img-responsive" src="<?php echo $imgurl; ?>" alt="<?php echo $post->ID; ?>"> -->
      <div class="carousel-caption ">
        <div class="carousel-item-title visible-xs"><?php echo get_the_title($post->ID); ?></div>
        <div class="hidden-xs"><?php echo get_the_content($post->ID); ?></div>
      </div>
      <a class="coverall_link" href="<?php echo get_permalink($post->ID); ?>"> <span class="glyphicon glyphicon-chevron-right"></span></a>
    </div>

<?php 
  $slide_counter++;
}
$indicators.='</ol>'; 
?>

    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#feature_carousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#feature_carousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
<?php echo $indicators; ?>
  </div>
</div>
<?php } else { ?>
	<div class="alert alert-danger">Content not found.</div>
<?php } wp_reset_postdata(); ?>
		
  </div>


	 
	 
	 
	 
	 
  </article>
<?php endwhile; ?>




