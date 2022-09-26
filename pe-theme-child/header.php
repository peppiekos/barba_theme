<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package PE_Theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<!-- font CDN here or preload fonts from local theme -->	
	<!-- Example pre load: <link rel="preload" href="/wp-content/themes/pe-theme-child/scss/fonts/kalam.bold.woff2" as="font" crossorigin="anonymous" />	-->
	<link href="https://api.fontshare.com/v2/css?f[]=chillax@1&display=swap" rel="stylesheet">
	<link href="https://api.fontshare.com/v2/css?f[]=satoshi@1&display=swap" rel="stylesheet">	
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php get_template_part('template-parts/navigation'); ?>


	
