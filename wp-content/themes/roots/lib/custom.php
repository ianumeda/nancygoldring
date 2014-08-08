<?php
/**
 * Custom functions
 */

function get_reverse_linked_posts_of_type(){ 
  // $custom_terms = get_terms('portfolio');

  // foreach($custom_terms as $custom_term) {
    
    wp_reset_query();
    $args = array('post_type' => 'portfolio',
        'tax_query' => array(
            array(
                'field' => 'slug',
                'terms' => $post->name,
            ),
        ),
     );

     echo "<foo>searching for ".$post->name." in portfolios</foo>";
     $posts = get_posts($args);
     if($posts){
        return '<li>'.$posts[0]->name.'</li>';
     }
  // }
}
function get_shows_art($showID){
  // returns an array of post id's of artwork associated with showID
  $art_list=get_the_terms($showID, 'art');
  if ( $art_list && ! is_wp_error( $art_list ) ) { 
    $art_post_id_list=array();
  	foreach ( $art_list as $art ) {
      array_push($art_post_id_list,$art->term_id);
    }
    return $art_post_id_list;
  } else return null;
}
function get_arts_shows($artID){ 
  $art_post=get_post($artID);
  $arts_show_postID_list=array();
  // $all_art=get_posts( array('post_type'=>'piece', 'posts_per_page'=>-1) );
  $all_shows=get_posts( array('post_type'=>'portfolio', 'posts_per_page'=>-1) );
  foreach($all_shows as $this_show){
    $this_shows_art=get_shows_art($this_show->ID);
    foreach($this_shows_art as $this_shows_artID){
      $this_shows_art_post=get_post($this_shows_artID);
      if($this_shows_art_post->post_name == $art_post->post_name){
        $arts_show_postID_list[]=$this_show->ID;
      }
    }
  }
  return $arts_show_postID_list;
}
/**
 * Custom Breadcrumb
 */

function custom_breadcrumb() {
  if(!is_home()) {
    echo '<ol class="breadcrumb">';
    echo '<li><a href="'.get_option('home').'">Nancy Goldring</a></li>';
    if ( is_singular( array( 'portfolio' ) ) ) {
      echo '<li class="portfolio">';
      the_title();
      echo '</li>';
    } elseif ( is_singular( array( 'art' ) ) ) {
      $ports=get_arts_shows($post->ID);
      echo '<li class="portfolio"><a href="'.get_permalink($ports[0]).'">'.get_the_title($ports[0]).'</a></li>';
      echo '<li class="art">';
      the_title();
      echo '</li>';
    } elseif (is_single()) {
      echo '<li>';
      the_category(', ');
      echo '</li>';
      if (is_single()) {
        echo '<li>';
        the_title();
        echo '</li>';
      }
    } elseif (is_category()) {
      echo '<li>';
      single_cat_title();
      echo '</li>';
    } elseif (is_page() && (!is_front_page())) {
      echo '<li>';
      the_title();
      echo '</li>';
    } elseif (is_tag()) {
      echo '<li>Tag: ';
      single_tag_title();
      echo '</li>';
    } elseif (is_day()) {
      echo'<li>Archive for ';
      the_time('F jS, Y');
      echo'</li>';
    } elseif (is_month()) {
      echo'<li>Archive for ';
      the_time('F, Y');
      echo'</li>';
    } elseif (is_year()) {
      echo'<li>Archive for ';
      the_time('Y');
      echo'</li>';
    } elseif (is_author()) {
      echo'<li>Author Archives';
      echo'</li>';
    } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
      echo '<li>Blog Archives';
      echo'</li>';
    } elseif (is_search()) {
      echo'<li>Search Results';
      echo'</li>';
    } 
    echo '</ol>';
  }
}

//
// add_action( 'init', 'create_current_artwork_taxonomy', 0 );
//
// // create two taxonomies, genres and writers for the post type "book"
// function create_current_artwork_taxonomy() {
//   // Add new taxonomy, make it hierarchical (like categories)
//   $labels = array(
//     'name'              => _x( 'Current Work', 'taxonomy general name' ),
//     'singular_name'     => _x( 'Current Work', 'taxonomy singular name' ),
//     'search_items'      => __( 'Search Current Work' ),
//     'all_items'         => __( 'All Current Work' ),
//     'edit_item'         => __( 'Edit Current Work' ),
//     'update_item'       => __( 'Update Current Work' ),
//     'add_new_item'      => __( 'Add New Current Work' ),
//     'new_item_name'     => __( 'New Current Work' ),
//     'menu_name'         => __( 'Current Artwork' ),
//   );
//
//   $args = array(
//     'hierarchical'      => false,
//     'labels'            => $labels,
//     'portfolio_ui'           => true,
//     'portfolio_admin_column' => false,
//     'query_var'         => true,
//     'rewrite'           => false,
//   );
//
//   register_taxonomy( 'current_work', array( 'art' ), $args );
//
//
// }


/**
 * MORE
 */