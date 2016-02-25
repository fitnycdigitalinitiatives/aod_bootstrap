<?php
    $pageTitle = __('Browse collections');
    echo head(array('title'=>$pageTitle,'bodyclass' => 'collections browse'));
?>

<h1><?php echo $pageTitle; ?> <span class="badge"><?php echo $total_results; ?></span></h1>
<hr>

<div class="browse-collections">
	<?php if ($total_results > 0): ?>
	<?php /* Drop-down sort isn't needed at the moment
	<div class="row">
		<div class="col-sm-12">
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
	*/ ?>

	<!-- Image Grid -->
	<div class="row" id="grid">
		<?php foreach (loop('collections') as $collection): ?>
		<div class="col-md-4 col-sm-6 item-thumb">
			<?php if ($collectionImage = record_image('collection', 'square_thumbnail', array('class' => 'img-responsive'))): ?>
			<?php echo link_to_items_browse($collectionImage . '<div class="caption"><h5>' . metadata('collection', array('Dublin Core', 'Title')) . '</h5></div>', array('collection' => metadata($collection, 'id')), array('class' => 'thumbnail')); ?>
			<?php endif; ?>
			<?php fire_plugin_hook('public_collections_browse_each', array('view' => $this, 'collection' => $collection)); ?>
		</div>
		<?php endforeach; ?>
	</div>
	<?php echo pagination_links(); ?>
	
	<?php else : ?>
	<p><?php echo 'No collections added, yet.'; ?></p>
	<?php endif; ?>
</div>
     

<?php fire_plugin_hook('public_collections_browse', array('collections'=> $collections, 'view' => $this)); ?>
<?php echo foot(); ?>
