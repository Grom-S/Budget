<?php
/** @var $data Budget */
?>

<div class="view budget-bar">

    <?php echo $data->name ?>

    <?php $this->widget('BudgetBar', array(
//        'type' => 'danger', // '', 'info', 'success' or 'danger'
//        'percent' => $data->getPercentage(), // the progress
        'model' => $data
    )); ?>


</div>