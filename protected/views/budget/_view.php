<?php
/** @var $data Budget */
?>

<div class="view budget-bar">


    <?php echo $data->name ?>

    <?php $this->widget('bootstrap.widgets.BootProgress', array(
        'type' => 'danger', // '', 'info', 'success' or 'danger'
        'percent' => $data->getPercentage(), // the progress
        'striped' => false,
        'animated' => false,
    )); ?>

    <div class="legend">
        <span class="first value">0</span>
        <span class="last value"><?php echo round(($data->amount / 3) * 2) ?></span>
        <span class="spent value"><?php echo round($data->spentAlready()) ?></span>
        <span class="left value"><?php echo round(($data->amount / 3) * 2 - $data->spentAlready()) ?></span>
    </div>



</div>