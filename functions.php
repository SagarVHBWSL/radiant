<?php
/**
 * Title: Function
 *
 * Description: Defines theme specific functions including actions and filters.
 *
 * Please do not edit this file. This file is part of the Cyber Chimps Framework and all modifications
 * should be made in a child theme.
 *
 * @category CyberChimps Framework
 * @package  Framework
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v3.0 (or later)
 * @link     http://www.cyberchimps.com/
 */

// Load text domain.
function cyberchimps_text_domain() {
	load_theme_textdomain( 'radiant', get_template_directory() . '/inc/languages' );
}
add_action( 'after_setup_theme', 'cyberchimps_text_domain' );

// Load Core
require_once( get_template_directory() . '/cyberchimps/init.php' );
require( get_template_directory() . '/inc/admin-about.php' );

// Set the content width based on the theme's design and stylesheet.
if ( !isset( $content_width ) ) {
	$content_width = 640;
} /* pixels */

// Define site info
function cyberchimps_add_site_info() {
	?>
	<p>&copy; Company Name</p>
<?php
}

add_action( 'cyberchimps_site_info', 'cyberchimps_add_site_info' );


if ( !function_exists( 'cyberchimps_comment' ) ) :

// Template for comments and pingbacks.
// Used as a callback by wp_list_comments() for displaying the comments.
	function cyberchimps_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				?>
				<li class="post pingback">
				<p><?php _e( 'Pingback:', 'radiant' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'radiant' ), ' ' ); ?></p>
				<?php
				break;
			default :
				?>
					<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment hreview">
						<footer>
							<div class="comment-author reviewer vcard">
								<?php echo get_avatar( $comment, 40 ); ?>
								<?php printf( '%s <span class="says">' . __( 'says:', 'radiant' ) . '</span>', sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
							</div>
							<!-- .comment-author .vcard -->
							<?php if ( $comment->comment_approved == '0' ) : ?>
								<em><?php _e( 'Your comment is awaiting moderation.', 'radiant' ); ?></em>
								<br/>
							<?php endif; ?>

							<div class="comment-meta commentmetadata">
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="dtreviewed">
									<time pubdate datetime="<?php comment_time( 'c' ); ?>">
										<?php
										/* translators: 1: date, 2: time */
										printf( __( '%1$s at %2$s', 'radiant' ), get_comment_date(), get_comment_time() ); ?>
									</time>
								</a>
								<?php edit_comment_link( __( '(Edit)', 'radiant' ), ' ' );
								?>
							</div>
							<!-- .comment-meta .commentmetadata -->
						</footer>

						<div class="comment-content"><?php comment_text(); ?></div>

						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div>
						<!-- .reply -->
					</article><!-- #comment-## -->

				<?php
				break;
		endswitch;
	}
endif; // ends check for cyberchimps_comment()

// set up next and previous post links for lite themes only
function cyberchimps_next_previous_posts() {
	if ( get_next_posts_link() || get_previous_posts_link() ): ?>
		<div class="more-content">
			<div class="row-fluid">
				<div class="span6 previous-post">
					<?php previous_posts_link(); ?>
				</div>
				<div class="span6 next-post">
					<?php next_posts_link(); ?>
				</div>
			</div>
		</div>
	<?php
	endif;
}

add_action( 'cyberchimps_after_content', 'cyberchimps_next_previous_posts' );

// core options customization Names and URL's
//Pro or Free
function cyberchimps_theme_check() {
	$level = 'free';

	return $level;
}

//Theme Name
function cyberchimps_options_theme_name() {
	$text = 'Radiant';

	return $text;
}

//Theme Pro Name
function cyberchimps_upgrade_bar_pro_title() {
	$text = 'Radiant Pro';

	return $text;
}

//Upgrade link
function cyberchimps_upgrade_bar_pro_link() {
	$url = 'http://cyberchimps.com/store/radiant-pro';

	return $url;
}

//Doc's URL
function cyberchimps_options_documentation_url() {
	$url = 'http://cyberchimps.com/guides/c/';

	return $url;
}

// Support Forum URL
function cyberchimps_options_support_forum() {
	$url = 'http://cyberchimps.com/forum/free/radiant/';

	return $url;
}

add_filter( 'cyberchimps_current_theme_name', 'cyberchimps_options_theme_name', 1 );
add_filter( 'cyberchimps_upgrade_pro_title', 'cyberchimps_upgrade_bar_pro_title' );
add_filter( 'cyberchimps_upgrade_link', 'cyberchimps_upgrade_bar_pro_link' );
add_filter( 'cyberchimps_documentation', 'cyberchimps_options_documentation_url' );
add_filter( 'cyberchimps_support_forum', 'cyberchimps_options_support_forum' );

// Help Section
function cyberchimps_options_help_header() {
	$text = 'Radiant';

	return $text;
}

function cyberchimps_options_help_sub_header() {
	$text = __( 'CyberChimps Responsive WordPress Theme', 'radiant' );

	return $text;
}

add_filter( 'cyberchimps_help_heading', 'cyberchimps_options_help_header' );
add_filter( 'cyberchimps_help_sub_heading', 'cyberchimps_options_help_sub_header' );

// Branding images and defaults

// Banner default
function cyberchimps_banner_default() {
	$url = '/images/branding/banner.jpg';

	return $url;
}

add_filter( 'cyberchimps_banner_img', 'cyberchimps_banner_default' );

//theme specific skin options in array. Must always include option default
function cyberchimps_skin_color_options( $options ) {
	// Get path of image
	$imagepath = get_template_directory_uri() . '/inc/css/skins/images/';

	$options = array(
		'default' => $imagepath . 'default.png'
	);

	return $options;
}

add_filter( 'cyberchimps_skin_color', 'cyberchimps_skin_color_options' );

// theme specific background images
function cyberchimps_background_image( $options ) {
	$imagepath = get_template_directory_uri() . '/cyberchimps/lib/images/';
	$options   = array(
		'none'  => $imagepath . 'backgrounds/thumbs/none.png',
		'noise' => $imagepath . 'backgrounds/thumbs/noise.png',
		'blue'  => $imagepath . 'backgrounds/thumbs/blue.png',
		'dark'  => $imagepath . 'backgrounds/thumbs/dark.png',
		'space' => $imagepath . 'backgrounds/thumbs/space.png'
	);

	return $options;
}

add_filter( 'cyberchimps_background_image', 'cyberchimps_background_image' );

// theme specific typography options
function cyberchimps_typography_sizes( $sizes ) {
	$sizes = array( '8', '9', '10', '12', '14', '16', '20' );

	return $sizes;
}

function cyberchimps_typography_faces( $faces ) {
	$faces = array(
		'Arial, Helvetica, sans-serif'                     => 'Arial',
		'Arial Black, Gadget, sans-serif'                  => 'Arial Black',
		'Comic Sans MS, cursive'                           => 'Comic Sans MS',
		'Courier New, monospace'                           => 'Courier New',
		'Georgia, serif'                                   => 'Georgia',
		'Impact, Charcoal, sans-serif'                     => 'Impact',
		'Lucida Console, Monaco, monospace'                => 'Lucida Console',
		'Lucida Sans Unicode, Lucida Grande, sans-serif'   => 'Lucida Sans Unicode',
		'Palatino Linotype, Book Antiqua, Palatino, serif' => 'Palatino Linotype',
		'Tahoma, Geneva, sans-serif'                       => 'Tahoma',
		'Times New Roman, Times, serif'                    => 'Times New Roman',
		'Trebuchet MS, sans-serif'                         => 'Trebuchet MS',
		'Verdana, Geneva, sans-serif'                      => 'Verdana',
		'Symbol'                                           => 'Symbol',
		'Webdings'                                         => 'Webdings',
		'Wingdings, Zapf Dingbats'                         => 'Wingdings',
		'MS Sans Serif, Geneva, sans-serif'                => 'MS Sans Serif',
		'MS Serif, New York, serif'                        => 'MS Serif',
		'Arimo, Arial, sans-serif'                         => 'Arimo',
		'Spinnaker, sans-serif'                            => 'Spinnaker',
		'Great Vibes, cursive'							   => 'Great Vibes',
	);

	return $faces;
}

function cyberchimps_typography_styles( $styles ) {
	$styles = array( 'normal' => 'Normal', 'bold' => 'Bold' );

	return $styles;
}

function cyberchimps_typography_defaults() {
	$default = array(
		'size'  => '14px',
		'face'  => 'Georgia, serif',
		'style' => 'normal'
	);

	return $default;
}

function cyberchimps_typography_heading_defaults() {
	$default = array(
		'face'  => 'Great Vibes, cursive',
	);

	return $default;
}

add_filter( 'cyberchimps_typography_sizes', 'cyberchimps_typography_sizes' );
add_filter( 'cyberchimps_typography_faces', 'cyberchimps_typography_faces' );
add_filter( 'cyberchimps_typography_styles', 'cyberchimps_typography_styles' );
add_filter( 'cyberchimps_typography_defaults', 'cyberchimps_typography_defaults' );
add_filter( 'cyberchimps_typography_heading_defaults', 'cyberchimps_typography_heading_defaults' );

function cyberchimps_blog_draganddrop_defaults() {
	$options = array(
		'slider_lite'    => __( 'Slider Lite', 'radiant' ),
		'boxes_lite'     => __( 'Boxes', 'radiant' ),
		'portfolio_lite' => __( 'Portfolio Lite', 'radiant' ),
		'blog_post_page' => __( 'Post Page', 'radiant' ),
	);

	return $options;
}

add_filter( 'cyberchimps_elements_draganddrop_defaults', 'cyberchimps_blog_draganddrop_defaults' );

// Customize social icons.
function cyberchimps_social_icon_options( $options ) {
	$options['default'] = get_template_directory_uri() . '/images/social/default.png';

	return $options;
}
add_filter( 'cyberchimps_social_icon_options', 'cyberchimps_social_icon_options' );

function cyberchimps_radiant_upgrade_bar(){
	$upgrade_link = apply_filters( 'cyberchimps_upgrade_link', 'http://cyberchimps.com' );
	$pro_title = apply_filters( 'cyberchimps_upgrade_pro_title', 'CyberChimps Pro' );
?>
	<br>
	<div class="upgrade-callout">
		<p><img src="<?php echo get_template_directory_uri(); ?>/cyberchimps/options/lib/images/chimp.png" alt="CyberChimps"/>
			<?php printf(
				__( 'Welcome to Radiant! Get 30%% off on %1$s using Coupon Code <span style="color:red">RADIANT30</span>', 'radiant' ),
				'<a href="' . $upgrade_link . '" target="_blank" title="' . $pro_title . '">' . $pro_title . '</a> '
			); ?>
		</p>

	<div class="social-container">
			<div class="social">
				<a href="https://twitter.com/cyberchimps" class="twitter-follow-button" data-show-count="false" data-size="small">Follow @cyberchimps</a>
				<script>!function (d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (!d.getElementById(id)) {
							js = d.createElement(s);
							js.id = id;
							js.src = "//platform.twitter.com/widgets.js";
							fjs.parentNode.insertBefore(js, fjs);
						}
					}(document, "script", "twitter-wjs");</script>
			</div>
			<div class="social">
				<iframe
					src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fcyberchimps.com%2F&amp;send=false&amp;layout=button_count&amp;width=200&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21"
					scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:21px;" allowTransparency="true"></iframe>
			</div>
		</div>

	</div>
<h4 class="notice notice-info is-dismissible" style="margin-top:15px;">
<p>
<?php
	$utm_link="https://cyberchimps.com/free-download-50-stock-images-use-please/?utm_source=radiant";
 	$utm_text="FREE - Download CyberChimps' Pack of 50 High-Resolution Stock Images Now";
	printf('<a href="' . $utm_link . '" target="_blank" style="font-size:18px;">' . $utm_text . '</a> ');
?>
</p>
</h4>

<?php
}

add_action('admin_init','remove_upgrade_bar');
function remove_upgrade_bar(){
remove_action( 'cyberchimps_options_before_container', 'cyberchimps_upgrade_bar');
}

if( cyberchimps_theme_check() == 'free' ) {
	add_action( 'cyberchimps_options_before_container', 'cyberchimps_radiant_upgrade_bar' );
}

// enabling theme support for title tag
function radiant_title_setup()
{
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'radiant_title_setup' );

function fine_customize_edit_links( $wp_customize ) {


   $wp_customize->selective_refresh->add_partial( 'blogname', array(
'selector' => '.site-title a'
) );

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.top-head-description'
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[custom_logo]', array(
		'selector' => '#logo'
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[theme_backgrounds]', array(
		'selector' => '#social'
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[searchbar]', array(
		'selector' => '#navigation #searchform'
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[footer_show_toggle]', array(
		'selector' => '#footer_wrapper'
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[footer_copyright_text]', array(
		'selector' => '#copyright'
	) );

	$wp_customize->selective_refresh->add_partial( 'nav_menu_locations[primary]', array(
		'selector' => '#navigation .nav'
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[blog_title]', array(
		'selector' => '.page-title'
	) );

}
add_action( 'customize_register', 'fine_customize_edit_links' );
add_theme_support( 'customize-selective-refresh-widgets' );

add_action( 'admin_notices', 'fine_rating_notice' );
function fine_rating_notice()
{
	$admin_check_screen = get_admin_page_title();

	if( !class_exists('SlideDeckPlugin') )
	{

	$slug = 'slidedeck';
	 if ( $admin_check_screen == 'Manage Themes' || $admin_check_screen == 'Theme Options Page' )
	{
		?>
		<div class="notice notice-info is-dismissible" style="margin-top:15px;">
		<p>
		 <a href="<?php echo wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ), 'install-plugin_' . $slug ); ?>">Install the SlideDeck Lite plugin</a>
		</p>
		</div>
		<?php
	}
	}

	if( !class_exists('WPForms') )
	{

	$slug = 'wpforms-lite';
	 if ( $admin_check_screen == 'Manage Themes' || $admin_check_screen == 'Theme Options Page' )
	{
		?>
		<div class="notice notice-info is-dismissible" style="margin-top:15px;">
		<p>
		 <a href="<?php echo wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ), 'install-plugin_' . $slug ); ?>">Install the WP Forms Lite plugin</a>
		</p>
		</div>
		<?php
	}
	}

	if ( $admin_check_screen == 'Manage Themes' || $admin_check_screen == 'Theme Options Page' )
	{
	?>
		<div class="notice notice-success is-dismissible">
				<b><p>Liked this theme? <a href="https://wordpress.org/support/theme/radiant/reviews/#new-post" target="_blank">Leave us</a> a ***** rating. Thank you! </p></b>
		</div>
		<?php
	}

}
