<?php
    $pageTitle = __('Browse Items');
    echo head(array('title'=>$pageTitle,'bodyclass' => 'items browse'));
?>

	<h1><?php echo $pageTitle;; ?> <?php echo item_search_filters_bootstrap(); ?> <span class="badge"><?php echo $total_results; ?></span></h1>
	
	<div class="browse-items">
	<?php if ($total_results > 0): ?>
		
		<div class="row">
			<div class="col-sm-6">
				<?php echo public_nav_items_bootstrap(); ?>  
			</div>
			<div class="col-sm-6">
				<div class="dropdown pull-right">
					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						Sort by:
						<span class="caret"></span>
					</button>
					<?php
						$sortLinks[__('Title')] = 'Dublin Core,Title';
						$sortLinks[__('Creator')] = 'Dublin Core,Creator';
						$sortLinks[__('Date Added')] = 'added';
						?>
					<?php echo browse_sort_links_bootstrap($sortLinks); ?>
				</div>
			</div>
		</div>

		<hr>

		<!-- Image Grid -->
		<div class="row" id="grid">
			<?php foreach (loop('items') as $item): ?>
			<div class="col-lg-3 col-md-4 col-xs-6 item-thumb">
				<?php if (metadata('item', 'has thumbnail')): ?>
				<?php echo link_to_item(item_image('square_thumbnail', array('class' => 'img-responsive')) . '<div class="caption"><h5>' . metadata('item', array('Dublin Core', 'Title')) . '</h5></div>', array('class' => 'thumbnail')); ?>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
		<?php echo pagination_links(); ?>
	<?php else : ?>
		<p>Your search returned no results. Please try another keyword. Or try our <a href="/items/search">Advanced Search</a>.</p>
	<?php endif; ?>
	</div>

	<?php fire_plugin_hook('public_items_browse', array('items'=>$items, 'view' => $this)); ?>
<?php echo foot(); ?>
	