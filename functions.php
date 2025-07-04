<?php
/**
 * Jifitness Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Jifitness_Theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function jifitness_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Jifitness Theme, use a find and replace
		* to change 'jifitness' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'jifitness', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'header' => esc_html__( 'Header Menu', 'jifitness' ),
			'footer-logo' => esc_html__( 'Footer Logo', 'jifitness' ),
			'footer-social-media' => esc_html__( 'Footer Social Media', 'jifitness' ),
			'footer-sitemap' => esc_html__( 'Footer Sitemap', 'jifitness' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'jifitness_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
			'header-text' => array( 'site-title', 'site-description' ),
			'unlink-homepage-logo' => false, 
		)
	);
}
add_action( 'after_setup_theme', 'jifitness_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function jifitness_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'jifitness_content_width', 640 );
}
add_action( 'after_setup_theme', 'jifitness_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function jifitness_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'jifitness' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'jifitness' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'jifitness_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function jifitness_scripts() {
	
	// Google Fonts：Zen Maru Gothic for headings, Roboto for body
	wp_enqueue_style(
		'jifitness-google-fonts',
		'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&family=Zen+Maru+Gothic:wght@400;500;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'jifitness-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'jifitness-style', 'rtl', 'replace' );

	wp_enqueue_script( 'jifitness-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Enqueue Swiper styles and scripts for homepage and team certificates
	wp_enqueue_style( 
		'swiper-style', 
		'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', 
		array(), 
		null 
	);

	wp_enqueue_script( 
		'swiper-script', 
		'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', 
		array(), 
		null, 
		true 
	);

	// Enqueue your custom swiper config JS
	wp_enqueue_script( 
		'jifitness-main', 
		get_template_directory_uri() . '/js/swiper.js', 
		array('swiper-script'), 
		null, 
		true 
	);

	// Enqueue AOS Animation
	wp_enqueue_style( 
		'aos-style', 
		'https://unpkg.com/aos@2.3.1/dist/aos.css', 
		array(), 
		null 
	);

	wp_enqueue_script( 
		'aos-script', 
		'https://unpkg.com/aos@2.3.1/dist/aos.js', 
		array(), 
		null, 
		true 
	);

	// Enqueue class-recommendation file and rest api
	if ( is_page(36) ) {
		
			 // 主JavaScript文件
			 wp_enqueue_script(
                'ji-recommendation-js',
                get_template_directory_uri() . '/js/recommendation.js',
                array('jquery'), // clare dependency on jquery
                filemtime(get_template_directory() . '/js/recommendation.js'),
                true
            );
            
            // 本地化脚本
            wp_localize_script(
                'ji-recommendation-js',
                'jiRecommendation', // 统一变量名
                array(
					'apiBaseUrl' => rest_url('ji/v1'),
					'nonce' => wp_create_nonce('wp_rest'),
					'translations' => [
						'selectCourseType' => '請選擇課程類型',
						'loadingError' => '加載失敗，請稍後再試',
					],
				)
            );
	}

	// Enqueue Google Maps API and map script
	if ( is_page('38') ) { // Page About ID
    $google_map_api_key = $_ENV['GOOGLE_MAP_API_KEY'] ?? '';
    if ( $google_map_api_key ) {
        wp_enqueue_script(
            'google-maps',
            'https://maps.googleapis.com/maps/api/js?key=' . esc_attr($google_map_api_key) . '&callback=initMap',
            array(),
            null,
            true
        );
        wp_enqueue_script(
            'ji-contact-map',
            get_template_directory_uri() . '/js/contact-map.js',
            array('google-maps'),
            null,
            true
        );
    	}
	}

	// Enqueue FAQ Accordion
	wp_enqueue_script( 'faq-script', get_template_directory_uri() . '/js/faq.js', array(), _S_VERSION, true );




}
add_action( 'wp_enqueue_scripts', 'jifitness_scripts' );


/**
 * 初始化推荐系统
 */
function ji_init_recommendation_system() {
    require_once get_template_directory() . '/inc/class-recommendation.php';
}
add_action('after_setup_theme', 'ji_init_recommendation_system');


// Remove the block editor from certain page
function jifitness_post_filter( $use_block_editor, $post ) {
    // Change the numbers of array to your Page ID
    $page_ids = array( 40,42,36,38,33,15,223 );
    if ( in_array( $post->ID, $page_ids ) ) {
		remove_post_type_support( 'page', 'editor' ); // remove page editor then only keep the title
        return false;
    } else {
        return $use_block_editor;
    }
}
add_filter( 'use_block_editor_for_post', 'jifitness_post_filter', 10, 2 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Implement the Custom Footer - Social Media feature.
 */
require get_template_directory() . '/inc/custom-footer.php';


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Change the excerpt more text
function ji_excerpt_more () {
    
	$more = '...';
	return $more;
    
}
add_filter('excerpt_more', 'ji_excerpt_more');

/**
* Custom Post Types & Taxonomies.
*/
require get_template_directory() . '/inc/cpt-taxonomy.php';


// function ji_register_custom_post_types() {
//     $args = array(
//         'public' => true,
//         'label'  => 'Testimonials'
//     );
//     register_post_type( 'ji-testimonials', $args );
// }
// add_action( 'init', 'ji_register_custom_post_types' );

// 在分類表單中加入欄位
function add_order_field_to_taxonomy($term) {
    $order = get_term_meta($term->term_id, 'order', true);
    ?>
    <tr class="form-field">
        <th scope="row"><label for="order">排序順序</label></th>
        <td>
            <select name="order" id="order">
                <?php for ($i = 1; $i <= 20; $i++) : ?>
                    <option value="<?php echo $i; ?>" <?php selected($order, $i); ?>><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
            <p class="description">選擇一個排序數字，數字越小越前面。</p>
        </td>
    </tr>
    <?php
}
add_action('ji-testimonials-order_edit_form_fields', 'add_order_field_to_taxonomy');

// 新增分類時顯示欄位（可選）
function add_order_field_to_taxonomy_create() {
    ?>
    <div class="form-field">
        <label for="order">排序順序</label>
        <select name="order" id="order">
            <?php for ($i = 1; $i <= 20; $i++) : ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
        <p class="description">選擇一個排序數字，數字越小越前面。</p>
    </div>
    <?php
}
add_action('ji-testimonials-order_add_form_fields', 'add_order_field_to_taxonomy_create');

function save_order_term_meta($term_id) {
    if (isset($_POST['order'])) {
        update_term_meta($term_id, 'order', intval($_POST['order']));
    }
}
add_action('edited_ji-testimonials-order', 'save_order_term_meta');
add_action('create_ji-testimonials-order', 'save_order_term_meta');

