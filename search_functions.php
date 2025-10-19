<?php

function show_all_invest() {

    $invest = $_GET['invest'];

    $render = array();
    ob_start();


    if($invest) {
        $args = array(
            'post_type' => 'lokal',
            'post_status' => 'publish',
            'posts_per_page' => -1,        
            'tax_query' => array(
                'relation' => 'AND',
                   array(
                       'taxonomy' => 'inwestycja',
                       'field'    => 'id',
                       'terms'    =>  $invest,
                       ),
                   ),
            'meta_key' => 'name',
            'orderby' => 'meta_value',
            'order' => 'ASC',
        );
    } else {
        $args = array(
            'post_type' => 'lokal',
            'post_status' => 'publish',
            'posts_per_page' => -1,        
        );
    }

    

    $the_query = new WP_Query($args);
    $count = $the_query->found_posts;

    if ($the_query->have_posts()) :
        while ($the_query->have_posts()) : $the_query->the_post();

        get_template_part( 'template-parts/table', "single-row" );

        endwhile;
    wp_reset_postdata();
    endif;

    array_push($render, ob_get_contents());
    ob_end_clean();

    $is = array();
    $is['render'] = $render;
    $is['count'] = $count;

    echo json_encode($is);

    if ($_GET['ajax']) {
        die();
    }
}
add_action('wp_ajax_show_all_invest', 'show_all_invest');
add_action('wp_ajax_nopriv_show_all_invest', 'show_all_invest');


function search_invest() {

    $invest = $_GET['invest'];
    $rooms = $_GET['rooms'];
    $amount = $_GET['amount'];
    $status = $_GET['status'];
    $price = $_GET['price'];
    
    $amount1 = intval(substr($amount, 0, -8));
    $amount2 = intval(substr($amount, 5, -3));

    $price1 = intval(substr($price, 0, -8));
    $price2 = intval(substr($price, 8, -3));

    $render = array();
    ob_start();

    if($invest) {
        $args = array(
            'post_type' => 'lokal',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_key' => 'name',
            'orderby' => 'meta_value',
            'tax_query' => array(
                'relation' => 'AND',
                 array(
                     'taxonomy' => 'inwestycja',
                     'field'    => 'id',
                     'terms'    =>  $invest,
                     ),
                 ),
            'meta_key' => 'name',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query'	=> array(
                'relation'		=> 'AND',
                array(
                    'key'	  	=> 'rooms',
                    'value'	  	=> $rooms,
                    'compare' 	=> '=',
                ),
                array(
                    'key'	  	=> 'status',
                    'value'	  	=> $status,
                    'compare' 	=> '=',
                ),
                array(
                    'key'     => 'area',
                    'value'   => [$amount1, $amount2],
                    'compare' => 'BETWEEN',
                    'type'		=> 'NUMERIC',
                ),
                array(
                    'key'     => 'price',
                    'value'   => [$price1, $price2],
                    'compare' => 'BETWEEN',
                    'type'		=> 'NUMERIC',
                ),
            ),
        );
    } else {
        $args = array(
            'post_type' => 'lokal',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_key' => 'name',
            'orderby' => 'meta_value',
            'meta_query'	=> array(
                'relation'		=> 'AND',
                array(
                    'key'	  	=> 'rooms',
                    'value'	  	=> $rooms,
                    'compare' 	=> '=',
                ),
                array(
                    'key'	  	=> 'status',
                    'value'	  	=> $status,
                    'compare' 	=> '=',
                ),
                array(
                    'key'     => 'area',
                    'value'   => [$amount1, $amount2],
                    'compare' => 'BETWEEN',
                    'type'		=> 'NUMERIC',
                ),
                array(
                    'key'     => 'price',
                    'value'   => [$price1, $price2],
                    'compare' => 'BETWEEN',
                    'type'		=> 'NUMERIC',
                ),
            ),
        );
    }


    $the_query = new WP_Query($args);
    $count = $the_query->found_posts;

    if ($the_query->have_posts()) :
        while ($the_query->have_posts()) : $the_query->the_post();

        get_template_part( 'template-parts/table', "single-row" );

        endwhile;
    wp_reset_postdata();
    endif;

    //Show all
    $args2 = array(
        'post_type' => 'lokal',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'inwestycja',
                'field'    => 'id',
                'terms'    =>  $invest,
            ),
        ),
    );

    $the_query2 = new WP_Query($args2);
    $all = $the_query2->found_posts;

    array_push($render, ob_get_contents());
    ob_end_clean();

    $is = array();
    $is['render'] = $render;
    $is['count'] = $count;
    $is['all'] = $all;

    echo json_encode($is);

    if ($_GET['ajax']) {
        die();
    }
}
add_action('wp_ajax_search_invest', 'search_invest');
add_action('wp_ajax_nopriv_search_invest', 'search_invest');
?>