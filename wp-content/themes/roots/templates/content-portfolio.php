<?php while (have_posts()) : the_post(); ?>
<?php
function get_image_within($id){
  // this returns a single image attachment id
  // always default on featured image otherwise...
  // if 'portfolio' (1) get child art posts or (2) get child portfolio posts,
  // if 'art' get first attachment
  if(get_post_type($id)=='attachment') {return $id;}
  if (has_post_thumbnail( $id ) ){
    return get_post_thumbnail_id( $id );
  }
  else
  {
    if(get_post_type($id)=='art'){
      // return the first attached image id
      $children = get_children( array( 'post_parent' => $id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
      foreach($children as $child){
        return $child;
      }
      // or return null if there is no attached image
      return null;
    }
    elseif(get_post_type($id)=='portfolio')
    {
      //search for associated art posts first and recursively run this function for an image
      $art_list=get_the_terms($id, 'art');
      if ( $art_list && !is_wp_error( $art_list ) ) {
        foreach($art_list as $art){
          // $image=get_image_within($art->term_id));
          if($image) return $image;
        }
      } else {
        // search id for porfolio children
        $children = get_children( array( 'post_parent' => $id, 'post_type' => 'portfolio', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
        foreach($children as $child){
          // $image=get_image_within($child);
          if($image) return $image;
        }
        return null;
      }
    }
  }
  return null;
}

function get_grid_item($id){
  // gets slides from art or portfolio posts
  // gets featured image or first attached image in art posts within the portfolio
  $grid_item='<div class="pack-item text-center">';

  $grid_item.='<div id="CurrentWorkCarousel'.$id.'" class="CurrentWorkCarousel carousel slide" data-ride="carousel" data-interval="4000">';
  $grid_item.='<div class="carousel-inner">';

  $p_children = get_children( array( 'post_parent' => $id, 'post_type' => 'portfolio', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
  $a_children =get_the_terms($id, 'art');
  $attachments = get_children( array( 'post_parent' => $id, 'post_type' => 'attachment', 'mime_type'=>'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
  $slides=array();

  if ( $a_children && !is_wp_error( $a_children ) ) {
    foreach($a_children as $art){
      $slides[]=$art->term_id;
    }
  }

  if ( count($p_children)>0 ) {
    foreach ( $children as $key => $value ) {
      $slides[]=$key;
    }
  }
  if(count($attachments)>0){
    foreach($attachments as $key => $value){
      $slides[]=$key;
    }
  }
    
  $number=-1;

  foreach($slides as $slide){
    $imageUrl = wp_get_attachment_image_src( get_image_within($slide), 'thumbnail' );
    if(!empty($imageUrl)){
      $number++;
      $grid_item.='<div class="carousel-item background-carousel item'.($number==0 ? ' active' : '').'">';
      $grid_item.='<div class="background_image_container">';
      $grid_item.='<img class="" src="'.$imageUrl[0].'"/>';
      $grid_item.='</div></div>';
    }
  }
  $grid_item.='</div>
               <a class="coverall_link" href="'.get_permalink($id).'"><span class="glyphicon glyphicon-chevron-right"></span></a>
             </div>
             <p class="title">'.get_the_title($id).'</p>
           </div>';
  return $grid_item;
}

?>
<article id="portfolio_post" <?php post_class(); ?>>
  <?php if (ctype_space(get_the_content($post->ID)) || get_the_content($post->ID)!='') { ?>
  <div id="art_post_buttons">
    <button type="button" class="btn btn-xs post_content_modal" >
      <a href="#" data-toggle="collapse" data-target="#post_content_modal">About</a>
    </button>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-push-2">
      <div id="post_content_modal" class="collapse">
  			<?php the_content() ?>
      </div>
		</div>
	</div>
  <?php } ?>
  <div id="container" class="js-packery" data-packery-options='{ "itemSelector":".pack-item" }'>
	
<?php 
    
  $art_list=get_the_terms($post->ID, 'art');
  $art_post_id_list=array();

  if ( $art_list && ! is_wp_error( $art_list ) ) {
    foreach ( $art_list as $art ) {
      array_push($art_post_id_list,$art->term_id);
    }
  }

  $portfolio_list=get_children( array( 'post_parent' => $post->ID, 'post_type' => 'portfolio', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
  foreach($portfolio_list as $key=>$value){
    array_push($art_post_id_list,$key);
  }
  
  // now sort them into alphabetical order by title...
  $ordered_posts = get_posts(array('include'=>$art_post_id_list, 'post_type'=>array('art','portfolio'), 'order'=>'ASC', 'orderby'=>'title'));
  
  foreach($ordered_posts as $art_post_id){
    echo get_grid_item($art_post_id->ID);
  }
?>
  </div>
</article>
<?php endwhile; ?>
