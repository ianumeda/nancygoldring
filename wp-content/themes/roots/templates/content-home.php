<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    
	<div class="entry-content">

<?php 
$query = new WP_Query( array( 'post_type' => 'page', 'post_parent' => $post->ID, 'posts_per_page' => '999' ,'order' =>'ASC' ) ); 
if ( $query->have_posts() ) {
?>
<div id="feature_box" class="row">
  <div id="feature_carousel" class="carousel carousel slide col-md-12" data-interval="20000">
    <!-- Wrapper for slides -->
    <div class="carousel-inner">

<?php	
$slide_counter=0;
$indicators='<!-- Indicators --><ol class="carousel-indicators hidden-md hidden-lg">';
while ( $query->have_posts() ) { 
  $indicators.='<li data-target="#feature_carousel" data-slide-to="'.$slide_counter.'" class="carousel-indicator '.($slide_counter==0 ? "active" : "").'"></li>';
  $query->the_post(); 
	if (has_post_thumbnail( $post->ID ) ){
  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
  $imgurl=$image[0];
  } else $imgurl="";

?>      

      <div class="item<?php if($slide_counter==0) echo " active"; ?>">
        <img class="img-responsive" src="<?php echo $imgurl; ?>" alt="<?php echo $post->ID; ?>">
        <div class="carousel-caption ">
          <div class="carousel-item-title visible-xs"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?> </a></div>
          <div class="hidden-xs"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_content($post->ID); ?></a></div>
          <span class="read_more_link"><a href="<?php echo get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-arrow-right"></span></a></span>
        </div>
        <div class="carousel_bottom">&nbsp;</div>
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
  </div>
<?php echo $indicators; ?>
</div>
<?php } else { ?>
	<div class="alert alert-danger">Content not found.</div>
<?php } wp_reset_postdata(); ?>
		
  </div>


	 
	 
	 
	 
	 
  </article>
<?php endwhile; ?>




