<?php
/*
 * Plugin Name: Temps de lecture
 * Plugin URI: https://vincent-sureau.fr
 * Description: Ajoute un temps de lecture aux articles de votre site WordPress.
 * Version: 1.0.0
 * Author: Vincent Sureau
 * Author URI: https://vincent-sureau.fr
 * Text Domain: lecture
*/

function calcul_reading_time( $title, $id = null ) {
    // if not in the post page, nothing to do!
    if(!is_single()) {
        return $title;
    }
    // retrieve the current post
    $post = get_post();
    // retrieve the post content without html tags
    $content = strip_tags($post->post_content);
    // count the number of words in content
    $nb_words = str_word_count($content);

    // calcul the time needed to read the post
    // and round to the upper integer
    $time = ceil($nb_words / 183);

    // add the reading time in post title
    $title .= "<small> | $time minutes</small>";
    return $title;
}
add_filter( 'the_title', 'calcul_reading_time', 10, 2 );

// fire when display title in menu
function restore_menu_item_title( $title, $item ) {
    // remove filter to get the original post title
    remove_filter( 'the_title', 'calcul_reading_time', 10, 2 );
    // retrieve the original post title
    $title = get_the_title($item->object_id);
    // add the filter back
    add_filter( 'the_title', 'calcul_reading_time', 10, 2 );
    // return the title to display
    return $title;
}
add_filter( 'nav_menu_item_title', 'restore_menu_item_title', 10, 2 );

