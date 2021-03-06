<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Gragas
 */

get_header();
?>

<div id="primary" class="content-area mt-25">
	<main id="main" class="site-main">

		<section id="seciton-404" class="section error-page-section error-404 not-found">
			<div class="container">
				<div class="row">
					<div class="col-12 order-md-last">
						<img src="<?php echo get_stylesheet_directory_uri() . '/assets/dist/images/img-404.png'; ?>" alt="404" class="img-fluid">
					</div>
					<div class="col-12">
						<header class="page-header">
							<h3 class="page-title">Ups! Halaman tidak dapat ditemukan.</h3>
						</header><!-- .page-header -->

						<div class="page-content">
							<p>Sepertinya link yang Anda cari tidak bisa kami temukan.</p>
							<a href="<?php echo home_url('/'); ?>" class="btn btn-primary">Kembali ke Halaman Utama</a>
						</div><!-- .page-content -->
					</div>
				</div>
			</div>
			<section>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
