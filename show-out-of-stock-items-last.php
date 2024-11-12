<?php
function custom_product_query( $clauses, $query ) {
    global $wpdb;

    // Add join clause to filter out-of-stock products
    $clauses['join'] .= $wpdb->prepare(
        " LEFT JOIN {$wpdb->postmeta} AS out_of_stock_meta
          ON {$wpdb->posts}.ID = out_of_stock_meta.post_id
          AND out_of_stock_meta.meta_key = %s
          AND out_of_stock_meta.meta_value = %s",
        '_stock_status', 'outofstock'
    );

    // Modify the orderby clause to sort by stock status
    $clauses['orderby'] = "out_of_stock_meta.meta_value ASC, {$clauses['orderby']}";

    return $clauses;
}

add_filter( 'posts_clauses', 'custom_product_query', 10, 2 );
?>
