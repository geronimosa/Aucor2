<?php
/**
 * Template Name: Front Page Embedded Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 * @var int $user_id
 */
get_header(); ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">
                    <?php get_template_part( 'content', 'main' ); ?>
                    <?php
                    $file = get_template_directory() . '/embedded.php';
                    echo $file;
                        include_once 'embedded.php';
                    ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>
