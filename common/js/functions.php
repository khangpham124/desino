<?php

//login logo
function custom_login_logo() {
        echo '<style type="text/css">h1 a { width:172px !important; height:49px !important; background: url('.get_bloginfo('template_directory').'/images/logo.png) 50% 50% no-repeat !important; }</style>';
}

add_action('login_head', 'custom_login_logo');
add_theme_support('post-thumbnails');

add_image_size('productBanner', 880,550, true);
add_image_size('thumbStore', 640,426, true);
add_image_size('thumbCollection', 900,600, true);
add_image_size('thumbBlog', 900,600, true);
add_image_size('thumbPro', 350,468, true);

//timthumb

define('THEME_DIR', get_template_directory_uri());
/* Timthumb CropCropimg */
function thumbCrop($img='', $w=false, $h=false, $zc=1){
    if($h)
        $h = "&amp;h=$h";
    else
        $h = "";
        
    if($w)
        $w = "&amp;w=$w";
    else
        $w = "";
    $img = str_replace(get_bloginfo('url'), '', $img);
    $image_url = THEME_DIR . "/timthumb/timthumb.php?src=" . $img . $h . $w ;
    return $image_url;

}
$image_cache = THEME_DIR . "/php/cache/";


// 管理画面サイドバーメニュー非表示
function remove_menus () {
    if (!current_user_can('level_9')) { //level9以下のユーザーの場合メニューをunsetする
    global $menu;
    var_dump($menu);
    unset($menu[2]);//ダッシュボード
    unset($menu[4]);//メニューの線1
    unset($menu[5]);//投稿
    unset($menu[15]);//リンク
    unset($menu[20]);//ページ
    unset($menu[25]);//コメント
    unset($menu[59]);//メニューの線2
    unset($menu[60]);//テーマ
    unset($menu[65]);//プラグイン
    unset($menu[70]);//プロフィール
    unset($menu[75]);//ツール
    unset($menu[80]);//設定
    unset($menu[90]);//メニューの線3
    }
}
add_action('admin_menu', 'remove_menus');

function custom_admin_footer() {
    echo 'Desino website';
}
add_filter('admin_footer_text', 'custom_admin_footer');

/* term drop down function */
function todo_restrict_manage_posts() {
    global $typenow;
    $args=array( 'public' => true, '_builtin' => false );
    $post_types = get_post_types($args);
    if ( in_array($typenow, $post_types) ) {
    $filters = get_object_taxonomies($typenow);
        foreach ($filters as $tax_slug) {
            $tax_obj = get_taxonomy($tax_slug);
            wp_dropdown_categories(array(
                'show_option_all' => __('Category'),
                'taxonomy' => $tax_slug,
                'name' => $tax_obj->name,
                'orderby' => 'term_order',
                'selected' => $_GET[$tax_obj->query_var],
                'hierarchical' => $tax_obj->hierarchical,
                'show_count' => false,
                'hide_empty' => true
            ));
        }
    }
}
function todo_convert_restrict($query) {
    global $pagenow;
    global $typenow;
    if ($pagenow=='edit.php') {
        $filters = get_object_taxonomies($typenow);
        foreach ($filters as $tax_slug) {
            $var = &$query->query_vars[$tax_slug];
            if ( isset($var) ) {
                $term = get_term_by('id',$var,$tax_slug);
                $var = $term->slug;
            }
        }
    }
    return $query;
}
add_action( 'restrict_manage_posts', 'todo_restrict_manage_posts' );
add_filter('parse_query','todo_convert_restrict');
/* term drop down function end*/

//for archives
global $my_archives_post_type;
add_filter( 'getarchives_where', 'my_getarchives_where', 10, 2 );
function my_getarchives_where( $where, $r ) {
  global $my_archives_post_type;
  if ( isset($r['post_type']) ) {
    $my_archives_post_type = $r['post_type'];
    $where = str_replace( '\'post\'', '\'' . $r['post_type'] . '\'', $where );
  } else {
    $my_archives_post_type = '';
  }
  return $where;
}
add_filter( 'get_archives_link', 'my_get_archives_link' );
function my_get_archives_link( $link_html ) {
  global $my_archives_post_type;
  if ( '' != $my_archives_post_type )
    $add_link .= '?post_type=' . $my_archives_post_type;
	$link_html = preg_replace("/href=\'(.+)\'\s/","href='$1".$add_link."'",$link_html);

  return $link_html;
}

// // paging
// $option_posts_per_page = get_option( 'posts_per_page' );
// add_action( 'init', 'my_modify_posts_per_page', 0);
// function my_modify_posts_per_page() {
//     add_filter( 'option_posts_per_page', 'my_option_posts_per_page' );
// }


// Custom post

//sample
add_action('init', 'my_custom_product');
function my_custom_product()
{
  $labels = array(
    'name' => _x('product', 'post type general name'),
    'singular_name' => _x('product', 'post type singular name'),
    'add_new' => _x('add product', 'news'),
    'add_new_item' => __('add product item'),
    'edit_item' => __('edit product'),
    'new_item' => __('new item'),
    'view_item' => __('view item'),
    'search_staff' => __('product'),
    'not_found' =>  __('not found'),
    'not_found_in_trash' => __('not found in trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array('title','editor','excerpt','thumbnail'),
    'has_archive' => true,
    'menu_icon'   => 'dashicons-products',
  );
  register_post_type('product',$args);
}

// make taxonomy
add_action ('init','create_productcat_taxonomy','0');
function create_productcat_taxonomy () {
	$taxonomylabels = array(
	'name' => _x('productcat','post type general name'),
	'singular_name' => _x('productcat','post type singular name'),
	'search_items' => __('productcat'),
	'all_items' => __('productcat'),
	'parent_item' => __( 'Parent Cat' ),
	'parent_item_colon' => __( 'Parent Cat:' ),
	'edit_item' => __('edit category'),
	'add_new_item' => __('add new Category'),
	'menu_name' => __( 'categories' ),
	);
	$args = array(
	'labels' => $taxonomylabels,
	'hierarchical' => true,
	'has_archive' => true,
	'show_ui' => true,
	'query_var' => true,
  'rewrite'      => array('slug' => 'catagories', 'with_front' => false)
	);
	register_taxonomy('productcat','product',$args);
}

add_action ('init','create_brandcat_taxonomy','0');
function create_brandcat_taxonomy () {
	$taxonomylabels = array(
	'name' => _x('brandcat','post type general name'),
	'singular_name' => _x('brandcat','post type singular name'),
	'search_items' => __('brandcat'),
	'all_items' => __('brandcat'),
	'parent_item' => __( 'Parent Cat' ),
	'parent_item_colon' => __( 'Parent Cat:' ),
	'edit_item' => __('edit category'),
	'add_new_item' => __('add new Category'),
	'menu_name' => __( 'Brand' ),
	);
	$args = array(
	'labels' => $taxonomylabels,
	'hierarchical' => true,
	'has_archive' => true,
	'show_ui' => true,
	 'query_var' => true,
	 'rewrite' => array( 'slug' => 'brandcat' )
	);
	register_taxonomy('brandcat','product',$args);
}


add_action('init', 'my_custom_blog');
function my_custom_blog()
{
  $labels = array(
    'name' => _x('blog', 'post type general name'),
    'singular_name' => _x('blog', 'post type singular name'),
    'add_new' => _x('add blog', 'news'),
    'add_new_item' => __('add blog item'),
    'edit_item' => __('edit blog'),
    'new_item' => __('new item'),
    'view_item' => __('view item'),
    'search_staff' => __('product'),
    'not_found' =>  __('not found'),
    'not_found_in_trash' => __('not found in trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
	'taxonomies' => array('post_tag'),
    'menu_position' => 5,
    'supports' => array('title','editor','excerpt','thumbnail'),
    'has_archive' => true,
    'menu_icon'   => 'dashicons-welcome-write-blog',
  );
  register_post_type('blog',$args);
}


add_action('init', 'my_custom_collection');
function my_custom_collection()
{
  $labels = array(
    'name' => _x('collection', 'post type general name'),
    'singular_name' => _x('collection', 'post type singular name'),
    'add_new' => _x('add collection', 'news'),
    'add_new_item' => __('add collection item'),
    'edit_item' => __('edit collection'),
    'new_item' => __('new item'),
    'view_item' => __('view item'),
    'search_staff' => __('product'),
    'not_found' =>  __('not found'),
    'not_found_in_trash' => __('not found in trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array('title','editor','excerpt','thumbnail'),
    'has_archive' => true,
    'menu_icon'   => 'dashicons-format-gallery',
  );
  register_post_type('collection',$args);
}

add_action('init', 'my_custom_recruit');
function my_custom_recruit()
{
  $labels = array(
    'name' => _x('recruit', 'post type general name'),
    'singular_name' => _x('recruit', 'post type singular name'),
    'add_new' => _x('add recruit', 'news'),
    'add_new_item' => __('add recruit item'),
    'edit_item' => __('edit recruit'),
    'new_item' => __('new item'),
    'view_item' => __('view item'),
    'search_staff' => __('product'),
    'not_found' =>  __('not found'),
    'not_found_in_trash' => __('not found in trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array('title','editor','excerpt'),
    'has_archive' => true,
    'menu_icon'   => 'dashicons-businessman',
  );
  register_post_type('recruit',$args);
}

function get_id_youtube($link) {
	parse_str( parse_url( $link, PHP_URL_QUERY ), $vars );
	return $vars['v'];
}


add_action('init', 'my_custom_getorder');
function my_custom_getorder()
{
  $labels = array(
    'name' => _x('Order', 'post type general name'),
    'singular_name' => _x('Order', 'post type singular name'),
    'add_new' => _x('add Order', 'news'),
    'add_new_item' => __('add Order'),
    'edit_item' => __('edit Order'),
    'new_item' => __('new item'),
    'view_item' => __('view item'),
    'not_found' =>  __('not found'),
    'not_found_in_trash' => __('not found'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array('title','thumbnail'),
    'has_archive' => true,
    'menu_icon' => 'dashicons-media-spreadsheet',
  );
register_post_type('getorder',$args);
}

add_action('init', 'my_custom_customer');
function my_custom_customer()
{
  $labels = array(
    'name' => _x('Customer', 'post type general name'),
    'singular_name' => _x('Customer', 'post type singular name'),
    'add_new' => _x('add Customer', 'news'),
    'add_new_item' => __('add Customer'),
    'edit_item' => __('edit Customer'),
    'new_item' => __('new item'),
    'view_item' => __('view item'),
    'not_found' =>  __('not found'),
    'not_found_in_trash' => __('not found'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array('title','thumbnail'),
    'has_archive' => true,
    'menu_icon' => 'dashicons-media-spreadsheet',
  );
register_post_type('customer',$args);
}

add_action( 'admin_menu', 'add_orders_menu_bubble' );
function add_orders_menu_bubble() {
  global $menu;
  $orderStatus = get_posts(array(
    'post_type' => 'getorder',
    'posts_per_page' => -1,
    'meta_query' => array(
      array(
        'key' => 'cf_order_status',
        'value' => 'in progress',
        'compare' => '=',
      )
    ),
  ));
  if ( count($orderStatus) ) {
    foreach ( $menu as $key => $value ) {
      if ( $menu[$key][2] == 'edit.php?post_type=getorder' ) {
        $menu[$key][0] .= ' <span class="update-plugins count-1"><span class="plugin-count">' . count($orderStatus) . '</span></span>';
        return;
      }
    }
  }
}

$colorStatusArr = array(
  'in progress' =>array('color'=>'#ffa300','icon'=>'dashicons-clipboard'),
  'cancel' =>array('color'=>'#ff0c0c','icon'=>'dashicons-no'),
  'done' =>array('color'=>'#009222','icon'=>'dashicons-yes'),
);

// CUSTOMER ORDER
add_filter( 'manage_edit-getorder_columns', 'my_edit_getorder_columns' ) ;
function my_edit_getorder_columns( $columns ) {
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Title' ),
    'cf_first_name' => __( 'Customer Name' ),
    'cf_phone' => __( 'Phone Number' ),
    'cf_order_status' => __( 'Order Status' ),
    'date' => __( 'Date' ),

  );
  return $columns;
}

add_action( 'manage_getorder_posts_custom_column', 'my_manage_getorder_columns', 10, 2 );
function my_manage_getorder_columns( $column, $post_id ) {
  global $post, $colorStatusArr;
  switch( $column ) {
    case 'cf_order_status':
      $orderStatus = get_field('cf_order_status');
      $field_key = "field_5c6119d2d81e7";
      $field = get_field_object($field_key);
      if(isset($orderStatus)) {
        echo '<span style="color: '.$colorStatusArr[$orderStatus]['color'].'"><i class="dashicons '.$colorStatusArr[$orderStatus]['icon'].'"></i> '.$field['choices'][$orderStatus].'</span>';
      }
    break;
  
    case 'cf_first_name':
      $cus_name = get_field('cf_first_name');
      $field_key = "field_5c6115b9d81da";
      $field = get_field_object($field_key);
      if(isset($cus_name)) {
        echo $field['value'];
      }
    break;

    case 'cf_phone':
      $cus_name = get_field('cf_phone');
      $field_key = "field_5c611612d81e1";
      $field = get_field_object($field_key);
      if(isset($cus_name)) {
        echo $field['value'];
      }
    break;
  }
  return;
}