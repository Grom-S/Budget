<?php
$this->breadcrumbs=array(
	'Transactions',
);

$this->menu=array(
	array('label'=>'Create Transaction','url'=>array('create')),
	array('label'=>'Manage Transaction','url'=>array('admin')),
);
?>

<h1>Transactions</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
