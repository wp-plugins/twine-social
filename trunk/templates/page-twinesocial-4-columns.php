<?php 
/*
 * Template Name: TwineSocial Layout (Full Width)
 * 
 */
get_header();

while ( have_posts() ) : the_post();

    the_content();

endwhile;

get_footer();
?>
