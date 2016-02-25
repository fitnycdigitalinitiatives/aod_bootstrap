<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ( $description = option('description')): ?>
        <meta name="description" content="<?php echo $description; ?>" />
    <?php endif; ?>

    <!-- Will build the page <title> -->
    <?php
        $titleParts[] = metadata('exhibit_page', 'title') . ' &middot; ' . metadata('exhibit', 'title');
        $titleParts[] = option('site_title');
    ?>
    <title><?php echo implode(' &middot; ', $titleParts); ?></title>
    <?php echo auto_discovery_link_tags(); ?>

    <!-- Will fire plugins that need to include their own files in <head> -->
    <?php fire_plugin_hook('public_head', array('view'=>$this)); ?>


    <!-- Need to add custom and third-party CSS files? Include them here -->
    <?php
        queue_css_file('lib/bootstrap.min');
        queue_css_file('style');
		queue_css_file('exhibit-cover');
        echo head_css();
    ?>

    <!-- Need more JavaScript files? Include them here -->
    <?php
        queue_js_file('lib/bootstrap.min');
        queue_js_file('globals');
        echo head_js();
    ?>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5661dc9df1aebb59" async="async"></script>
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php echo body_tag(array('class' => 'exhibits show')); ?>
    <?php fire_plugin_hook('public_body', array('view'=>$this)); ?>
	<div class="site-wrapper">

		<div class="site-wrapper-inner">

			<div class="cover-container">

				<div class="masthead clearfix">
					<header role="banner">
						<!-- Fixed navbar -->
						<nav class="navbar navbar-inverse navbar-static-top">
							<div class="container">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
									<a class="navbar-brand" href="/">
										<?php echo '<img src="' . img('fit_sparc.png') . '" alt="Brand">'; ?>
									</a>
								</div>
								<div id="navbar" class="navbar-collapse collapse">
									<?php echo public_nav_main_bootstrap(); ?>
									<?php echo search_form(array('show_advanced' => false, 'form_attributes' => array('class' => 'navbar-form navbar-right', 'role' => 'search'))); ?>
								</div><!--/.nav-collapse -->
							</div>
						</nav>					
					</header>
				</div>

				<div class="inner cover">
					<main id="content" role="main">
						<div class="container">
							<?php fire_plugin_hook('public_content_top', array('view'=>$this)); ?>

							<?php exhibit_builder_render_exhibit_page(); ?>
							
						</div>
					</main>
				</div>

				<div class="mastfoot">
					<footer role="contentinfo">
						<nav class="navbar navbar-inverse navbar-static-bottom">
							<div class="container">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sub-navbar" aria-expanded="false" aria-controls="navbar">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
									<?php echo exhibit_builder_link_to_exhibit($exhibit, null, array('class' => 'navbar-brand')); ?>
								</div>
								<div id="sub-navbar" class="navbar-collapse collapse">
									<?php echo exhibit_builder_page_tree($exhibit, $exhibit_page); ?>
								</div><!--/.nav-collapse -->
							</div>
						</nav>	
						<?php fire_plugin_hook('public_footer', array('view' => $this)); ?>
					</footer>
				</div>

			</div>

		</div>

	</div>
</body>
</html>
