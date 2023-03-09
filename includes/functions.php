<?php

defined('ABSPATH') || die();

add_action('wp_ajax_woomentor_ajax_search', 'woomentor_ajax_search');
add_action('wp_ajax_nopriv_woomentor_ajax_search', 'woomentor_ajax_search');

function woomentor_arr_to_string_with_quotes($arrs) {
    $str = '';
    foreach($arrs as $arr) {
        $str .= "'$arr',";
    }
    return substr($str, 0, -1);
}
function get_category_by_product_id( $product_id ) {
    $terms = function_exists("wc_get_product_category_list") ?  wc_get_product_category_list($product_id) : '';
    return $terms;
}
function woomentor_check_exist_in_array($fields, $search_in) {
    $str = '';
    foreach($fields as $key) {
        if( array_key_exists($key, $search_in) ) {
            $str .= $search_in[$key]. ',';
        } 
    }
    if( in_array('product_categories', $fields) || in_array('product_tags', $fields) ) {
        $str .= 'terms.name,terms.slug,';
    }
    return substr($str, 0,-1);
}

function woomentor_ajax_search() {
    // if( ! wp_verify_nonce( $_POST['searchNonce'], 'woomentor_ajax_search_nonce' ) ) {
    //     wp_send_json_error();
    //     wp_die();
    // }

    // $containerClass = isset( $_POST['containerClass'] ) ? sanitize_text_field( wp_unslash( $_POST['containerClass'] ) ) : 'woomentor_ajax_search_masonry_layoutone';
    // $image_size = isset( $_POST['thumbnailSize'] ) ? sanitize_text_field( wp_unslash( $_POST['thumbnailSize'] ) ) : 'woocommerce_thumbnail';

    // $noResultText = isset( $_POST['noResultText'] ) ? sanitize_text_field( wp_unslash( $_POST['noResultText'] ) ) : '';
    // $linkTarget = isset( $_POST['linkTarget'] ) ? sanitize_text_field( wp_unslash( $_POST['linkTarget'] ) ) : '';
    // // Search Term
    $search_term        = isset( $_POST['searchTerm'] ) ? sanitize_text_field( wp_unslash( $_POST['searchTerm'] ) ) : '';

    wp_send_json([
        'search_term'  => $search_term,
    ]);
    // // Search In
    // $search_in = isset( $_POST['searchIn'] )? sanitize_text_field( wp_unslash( $_POST['searchIn'] ) ) : '';
    // $search_in_arr = explode('|', $search_in);
    // // Display fields
    // $display = isset( $_POST['display'] )? sanitize_text_field( wp_unslash( $_POST['display'] ) ) : '';
    // $display = explode('|', $display);
    // // Order By
    // $orderby = isset( $_POST['orderBy'] ) ? sanitize_text_field( wp_unslash( $_POST['orderBy'] ) ) : '';
    // $order = isset( $_POST['order'] ) ? sanitize_text_field( wp_unslash( $_POST['order'] ) ) : 'DESC';
    // $search_limit = isset( $_POST['search_limit'] ) ? sanitize_text_field( wp_unslash( $_POST['search_limit'] ) ) : '10';
    // $categoryStatus = isset( $_POST['categoryStatus'] ) ? sanitize_text_field( wp_unslash( $_POST['categoryStatus'] ) ) : 'off';
    // $selectedCategory = isset( $_POST['selectedCategory'] ) ? sanitize_text_field( wp_unslash( $_POST['selectedCategory'] ) ) : 'all';
    // $categoryIds = isset( $_POST['categoryIds'] ) ? sanitize_text_field( wp_unslash( $_POST['categoryIds'] ) ) : '';
    
    // $current_category = isset( $_POST['currentCategory'] ) ? sanitize_text_field( wp_unslash( $_POST['currentCategory'] ) ) : 'off';



    // $search_items = array('product.ID', 'product.post_title', 'product.post_name', 'product.post_excerpt', 'product_data.sku','product_data.onsale', 'product_data.stock_status');
    // $allowed_search_fields = array(
    //     'title' => 'product.post_title, product.post_name',
    //     'content' => 'product.post_content',
    //     'excerpt' => 'product.post_excerpt',
    //     'sku' => 'product_data.sku',
    //     'on_sale' => 'product_data.onsale',
    //     'stock_status' => 'product_data.stock_status',
    //     // 'product_categories' => 'terms.name terms.slug'
    // );
    // $search_in = woomentor_check_exist_in_array($search_in_arr, $allowed_search_fields);
    // $display_fields_query = "product.ID,";
    // $display_fields_query .= woomentor_check_exist_in_array($display, $allowed_search_fields);
    // $category_fields = array('product_cat', 'product_tag');
    // $post_types = array('product', 'product_variation');
    // $post_status = array('publish');

    // $post_type_str = woomentor_arr_to_string_with_quotes($post_types);

    // global $wpdb;

    // $query = sprintf('select product.ID,product.post_parent ');
    // $query .= sprintf('from %1$sposts as product left join %1$swc_product_meta_lookup as product_data on product.ID=product_data.product_id left join %1$sterm_relationships as relation on product.ID=relation.object_id left join %1$sterm_taxonomy as taxo on relation.term_taxonomy_id=taxo.term_taxonomy_id left join %1$sterms terms on terms.term_id=taxo.term_id ', $wpdb->prefix);
    // $query .= sprintf('where product.post_type in (%1$s) ', $post_type_str);
    // $query .= "and product.post_status='publish' ";

    // if('off' == $current_category){
    //     if( 'all' != $selectedCategory && 'off' != $categoryStatus) {
    //         $query .= sprintf('and terms.term_id="%1$s" ', esc_sql($selectedCategory));
    //     }elseif( 'all' == $selectedCategory && '' != $categoryIds) {
    //         $categoryIds = explode(',', esc_sql($categoryIds));
    //         $categoryIds = "'" . implode("','",$categoryIds) . "'";
    //         $query .= sprintf('and terms.term_id in (%1$s) ', $categoryIds);
    //     }
    // }elseif('on' == $current_category) {
    //     $categoryIds = explode(',', esc_sql($categoryIds));
    //     $categoryIds = "'" . implode("','",$categoryIds) . "'";
    //     $query .= sprintf('and terms.term_id in (%1$s) ', $categoryIds);
    // }


    // if((!in_array('custom_taxonomies', $search_in_arr))) {
    //     $category_fields_str = woomentor_arr_to_string_with_quotes($category_fields);
    //     $query .= sprintf('and (taxo.taxonomy in (%1$s) ', $category_fields_str);
        
    //     if(in_array('attributes', $search_in_arr)){
    //         $query .= "or taxo.taxonomy like '%pa_%'";
    //     }
    //     $query .= ') ';
    // }

    
    // $query .= sprintf('and concat(%1$s) ', esc_sql($search_in));

    // $query .= "like '%" . esc_sql($search_term) ."%' ";
    
    // $query .= sprintf('group by product.ID order by product.%3$s %1$s limit %2$s;', esc_sql($order), esc_sql(absint($search_limit)), esc_sql($orderby));
    // $results = $wpdb->get_results($query, OBJECT);



    // $late_query = array_filter($display, function($item) {
    //     $will_check_late = array('thumbnail', 'category', 'rating_count', 'product_price');
    //     return in_array($item, $will_check_late);
    // });


    // // -- We need - id, thumbnail image,title,price,excerpt,category, rating count
    // // -- Search In - title, content, excerpt, product categories, product tags, custom taxonomies, attributes, sku
    // // -- Order By - date, modified date, title, slug, id
    // // -- Order - asc, desc --
    // // -- Search Result Number Limit - 10 --
    // $result_html = '';
    // // $result_arr = [];
    // if( 0 == count($results) ):
    //     $result_html .= sprintf('<div class="woomentor_ajax_search_result "><div class="woomentor_ajax_search_items %1$s"><p class="woomentor_no_result">%2$s</p></div></div', $containerClass, $noResultText);
    // endif;
    // if( count($results) > 0 ) :
    //     $result_ids = array_column($results, 'ID');
    //     $parent_ids = [];
    //     $gutter_item = 'woomentor_ajax_search_masonry_layoutthree' == $containerClass ? '<div class="woomentor_search_item_masonry"><div class="gutter-sizer"></div>' : '';
    //     $result_html .= sprintf('<div class="woomentor_ajax_search_items %1$s grid">%2$s', $containerClass, $gutter_item);

    //     foreach ($result_ids as $key) :
    //         $ID = intval($key);
    //         $parent_id = wp_get_post_parent_id( $ID );
    //         if( $parent_id ):
    //             if( in_array( $parent_id, $result_ids ) ):
    //                 continue;
    //             endif;
    //             $ID = $parent ? intval( $parent_id ) : $ID;
    //         endif;

    //         $_product = wc_get_product($ID);
            
    //         $thumbnail = (in_array('thumbnail', $display) && has_post_thumbnail($ID)) ? sprintf('<div class="woomentor_ajax_search_img">%1$s</div>', get_the_post_thumbnail($ID, $image_size)) : '';
    //         $excerpt = in_array('excerpt', $display) ? sprintf('<p class="woomentor_ajax_search_item_des">%1$s</p>', get_the_excerpt($ID) ) : '';
    //         // $category = wc_get_product_category_list($ID);
    //         $permalink = get_permalink($ID);
    //         $title = in_array('title', $display) ? sprintf('<p class="woomentor_ajax_search_title">%1$s</p>',$_product->get_title() ) : '';

    //         $price_html = in_array('product_price', $display) ? $_product->get_price_html() : '';
    //         $stock_status = $_product->get_stock_status();
    //         $is_on_sale = (in_array('on_sale', $display) && '1' == $_product->is_on_sale()) ? '<div class="woomentor_ajax_search_onsale_withprice">Sale</div>' : '';

    //         $rating_count = (in_array('rating_count', $display) && $_product->get_rating_count() > 0) ? sprintf('<div class="woomentor_ajax_search_item_ratting_count"><span>(%1$s)</span></div>', $_product->get_rating_count() ) : '';

    //         $is_featured = $_product->is_featured();
    //         $product_rating = in_array('star_rating', $display) ? wc_get_rating_html($_product->get_average_rating(), $_product->get_rating_count()) : '';
    //         $product_avg_rating_count = in_array('star_rating', $display) ? '<div class="woomentor_product_ratting"><div class="star-rating"><span style="width:0%">'.esc_html__('Rated', 'et_builder').' <strong class="rating">'.esc_html__('0', 'et_builder').'</strong> '.esc_html__('out of 5', 'et_builder').'</span>'.$product_rating.'</div></div>' : '';

    //         $rating_div = ('' != $product_rating && '' != $rating_count) ? sprintf('<div class="woomentor_ajax_search_item_ratting_count_combined">
    //             <div class="woomentor_ajax_search_item_ratting">
    //                 %1$s
    //             </div>
    //             %2$s
    //         </div>',$product_avg_rating_count, $rating_count) : '';

    //         $result_html .= sprintf('
    //         <div class="woomentor_ajax_search_single_item_wrapper grid-item">
    //         <div class="woomentor_ajax_search_wrapper_inner">
    //           <a href="%1$s" class="woomentor_ajax_search_item_link" target="%8$s">
    //             %2$s
                
    //             <div class="woomentor_ajax_search_content_wrapper">
    //                 %3$s
    //                 %4$s
                  
    
    //               <div class="woomentor_ajax_search_pricewithsalecombined">
    //                 %5$s
    //                 %6$s
    //                 </div>
                    
    //                 %7$s
    //             </div>
    //           </a>
    //         </div>
    //       </div>',
    //       $permalink,
    //       $thumbnail,
    //         $title,
    //         $rating_div,
    //         $price_html,
    //         $is_on_sale,
    //         $excerpt,
    //         $linkTarget
    //     );


    //     endforeach;

    //     $result_html .= 'woomentor_ajax_search_masonry_layoutthree' == $containerClass ? '</div>' : '';
    //     $result_html .= '</div>';
    // endif;

    // wp_send_json(array(
    //     // 'query' => $query,
    //     // 'display' => $display,
    //     // 'category_status' => $categoryStatus,
    //     // 'categoryIds' => $categoryIds,
    //     // 'current_category' => $current_category,
    //     // 'selectedCategory' =>$selectedCategory,
    //     'result_html' => $result_html,
    // ));
    // wp_die();
}