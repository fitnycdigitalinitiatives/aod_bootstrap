<?php 
    echo head(array('title' => metadata('item', array('Dublin Core', 'Title')), 'bodyclass' => 'items show'));
?>
	<h1><?php echo metadata('item', array('Dublin Core', 'Title')); ?></h1>
    <div class="row">
        <div class="col-sm-12">
			<!-- Fire OpenSeadragon Separately from other plugins for placement -->
			<?php echo $this->openseadragon($item->Files); ?>
        </div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<?php if (metadata('item', array('Item Type Metadata', 'Palette'))): ?>
				<?php echo palette('item'); ?> 
			<?php endif; ?>
		</div>
		<div class="col-xs-6">
			<!-- Go to www.addthis.com/dashboard to customize your tools -->
			<div class="addthis_sharing_toolbox pull-right"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Item Information</h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<?php echo all_element_texts('item'); ?>   
							<!-- If the item belongs to a collection, the following creates a link to that collection. -->
							<?php if (metadata('item', 'Collection Name')): ?>
								<div id="collection" class="element">
									<h3><?php echo __('Collection'); ?></h3>
									<div class="element-text"><p><?php echo link_to_collection_for_item(); ?></p></div>
								</div>
							<?php endif; ?>
							
							<!-- The following prints a list of all tags associated with the item -->
							<?php if (metadata('item', 'has tags')): ?>
								<div id="item-tags" class="element">
									<h3><?php echo __('Tags'); ?></h3>
									<div class="element-text"><?php echo tag_string('item'); ?></div>
								</div>
							<?php endif;?>
							
							<!-- The following prints a citation for this item. -->
							<div id="item-citation" class="element">
								<h3><?php echo __('Citation'); ?></h3>
								<div class="element-text"><?php echo metadata('item', 'citation', array('no_escape' => true)); ?></div>
							</div>
							
							<div id="item-output-formats" class="element">
								<h3><?php echo __('Output Formats'); ?></h3>
								<div class="element-text"><?php echo output_format_list(); ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Related Items sidebar -->
		<?php echo related_items($item); ?>
	</div>
    <?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>
    <ul class="pager">
        <li class="previous"><?php echo link_to_previous_item_show(); ?></li>
        <li class="next"><?php echo link_to_next_item_show(); ?></li>
    </ul>

<?php echo foot(); ?>
