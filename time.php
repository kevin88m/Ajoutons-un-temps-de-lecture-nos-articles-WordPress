<?php
/*
Plugin Name:time
Plugin URI: https://mon-siteweb.com/
Description: Time
Author: Mancelle
Version: 1.0
Author URI: http://mon-siteweb.com/
*/




function capitaine_reading_time( $post_id, $post, $update )  {

	if( ! $update ) { return; }
	if( wp_is_post_revision( $post_id ) ) { return; }
	if( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) { return; }
	if( $post->post_type != 'post' ) { return; }

	// Calculer le temps de lecture
	$word_count = str_word_count( strip_tags( $post->post_content ) );

	// On prend comme base 250 mots par minute
	$minutes = ceil( $word_count / 250 );
	
	// On sauvegarde la meta
	update_post_meta( $post_id, 'time', $minutes );
}
add_action( 'save_post', 'capitaine_reading_time', 10, 3 );


function affichage ($content){
    global $id;
    if((is_single() || is_home()) && in_the_loop() && is_main_query() ) {
        $time = get_post_meta( $id, 'time', true );
        $content .= " | Lecture : " . $time . " minutes";
    }
   return $content;
};
add_filter( 'the_title', 'affichage', 10, 2 );

