<?php
$this->breadcrumbs=array(
	'Transactions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Transaction','url'=>array('index')),
	array('label'=>'Create Transaction','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('transaction-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Transactions</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php //echo CVarDumper::dump($model->search()) ?>


<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'transaction-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        'date',
        'amount',
        'category.name',
        'description',
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
		),
	),
)); ?>
