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

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-page-section error-404 not-found">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-12 col-lg-6 order-sm-last">
							<img src="<?php echo get_stylesheet_directory_uri() . '/assets/dist/images/img-404.png';?>" alt="404" class="img-fluid">
						</div>
						<div class="col-12 col-lg-6">
							<header class="page-header">
								<h3 class="page-title">Ups! Halaman tidak dapat ditemukan.</h3>
							</header><!-- .page-header -->

							<div class="page-content">
								<p>Sepertinya link yang Anda cari tidak bisa kami temukan.</p>
								<a href="<?php echo home_url('/');?>" class="btn btn-primary">Kembali ke Halaman Utama</a>
							</div><!-- .page-content -->
						</div>
					</div>
				</div>
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
