<?php
$this->breadcrumbs=array(
	'Budgets'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Budget','url'=>array('index')),
	array('label'=>'Create Budget','url'=>array('create')),
	array('label'=>'View Budget','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Budget','url'=>array('admin')),
);
?>

<h1>Update Budget <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>