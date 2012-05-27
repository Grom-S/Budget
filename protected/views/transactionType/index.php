<?php
$this->breadcrumbs=array(
	'Transaction Types',
);

$this->menu=array(
	array('label'=>'Create TransactionType','url'=>array('create')),
	array('label'=>'Manage TransactionType','url'=>array('admin')),
);
?>

<h1>Transaction Types</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
