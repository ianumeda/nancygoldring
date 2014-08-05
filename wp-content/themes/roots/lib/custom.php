<?php
/**
 * Custom functions
 */

/**
 * Custom Breadcrumb
 */

function custom_breadcrumb() {
  if(!is_home()) {
    echo '<ol class="breadcrumb">';
    echo '<li><a href="'.get_option('home').'">Nancy Goldring</a></li>';
    if (is_single()) {
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
//     'show_ui'           => true,
//     'show_admin_column' => false,
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