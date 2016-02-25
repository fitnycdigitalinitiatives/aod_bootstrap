<?php echo $this->form('search-form', $options['form_attributes']); ?>
    <div class="input-group">
        <?php echo $this->formText('query', $filters['query'], array('class'=>'form-control', 'placeholder'=>'Search the collection')); ?>
        <span class="input-group-btn">
			<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search" aria-label="search"></span></button>
		</span>
    </div>
</form>
