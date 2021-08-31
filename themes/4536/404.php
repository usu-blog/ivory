<?php get_header(); ?>

<div id="contents-wrapper" class="w-100 max-w-100 pa-4">
  <main id="main" class="w-100" role="main">
	<article>
	  <div class="post">
		<h1 id="h1" class="headline">ページが見つかりませんでした！</h1>
		<p>
		  <img src="<?php echo get_template_directory_uri(); ?>/img/404.png" alt="404" title="404" width="750" height="565" />
		</p>
	  </div>
	</article>
	</main>
</div>

<?php
get_sidebar();
get_footer();
?>
