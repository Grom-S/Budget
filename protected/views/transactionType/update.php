<?php
$this->breadcrumbs=array(
	'Transaction Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionType','url'=>array('index')),
	array('label'=>'Create TransactionType','url'=>array('create')),
	array('label'=>'View TransactionType','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TransactionType','url'=>array('admin')),
);
?>

<h1>Update TransactionType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>