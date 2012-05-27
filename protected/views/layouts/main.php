<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/css/style.css">
</head>
<body>
<div class="container">

    <?php $this->widget('bootstrap.widgets.BootNavbar', array(
    'fixed'=>false,
    'brand'=>'Budget',
    'brandUrl'=>'#',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.BootMenu',
            'items'=>array(
                array('label'=>'Home', 'url'=>array('site/index'), 'active'=>true),
                array('label'=>'Transactions', 'url'=>array('transaction/admin')),
                array('label'=>'Accounts', 'url'=>array('account/admin')),
                array('label'=>'Categories', 'url'=>array('category/admin')),
                array('label'=>'Budget', 'url'=>array('budget/index')),
            ),
        ),
    ),
)); ?>


	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

</div>
</body>
</html>

