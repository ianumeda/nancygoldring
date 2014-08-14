<?php
/**
 * Custom functions
 */

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
  global $post; 
  if(!is_home()) {
    echo '<div class="breadcrumbs"><ol class="breadcrumb">';
    // echo '<li><a href="'.get_option('home').'">Nancy Goldring</a></li>';
    if ( is_singular( array( 'portfolio' ) ) ) {
      $ancestors=get_ancestors($post->ID, 'portfolio');
      if(count($ancestors)>0){
        foreach($ancestors as $anscestor){
          echo '<li><a href="'.get_permalink($anscestor).'">'.get_the_title($anscestor).'</a></li>';
        }
      }
      echo '<li class="portfolio">';
      the_title();
      echo '</li>';
    } elseif ( is_singular( array( 'art' ) ) ) {
      $portfolios=get_arts_shows($post->ID);
      if($portfolios){
        $portfolio=$portfolios[0];
        $ancestors=get_ancestors($portfolio, 'portfolio');
        if(count($ancestors)>0){
          foreach($ancestors as $anscestor){
            echo '<li><a href="'.get_permalink($anscestor).'">'.get_the_title($anscestor).'</a></li>';
          }
        }
      }
      echo '<li class="portfolio"><a href="'.get_permalink($portfolio).'">'.get_the_title($portfolio).'</a></li>';
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
    echo '</ol></div>';
  }
}

/**
 * MORE
 */