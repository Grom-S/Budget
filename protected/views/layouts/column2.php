<?php $this->beginContent('//layouts/main'); ?>

<div class="row-fluid">

    <!-- content -->
    <div class="span9">
        <?php echo $content; ?>
    </div>

    <!-- sidebar -->
    <div class="span3">
        <div class="well">
            <?php $this->widget('bootstrap.widgets.BootMenu', array(
            'type'=>'list',
            'items'=>$this->menu,
        )); ?>
        </div>
    </div>

</div>


<?php $this->endContent(); ?>