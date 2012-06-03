<?php

Yii::import('bootstrap.widgets.BootProgress');


Class BudgetBar extends  BootProgress {


    /** @var Budget */
    public $model;

    public function init()
    {

        $start = new DateTime("2012-06-01 01:11:50");
        $end = new DateTime("2012-06-30 05:56:40");

        // set percentage of the bar
        $this->percent = $this->model->getPercentage($start, $end);

        // set color of the bar
        if ($this->model->isIncomeType()) {
            $this->type = self::TYPE_SUCCESS;
        }
        elseif ($this->model->isExpenseType()) {
            $this->type = self::TYPE_DANGER;
        }


        parent::init();
    }


    public function run()
    {
        parent::run();


        $start = new DateTime("2012-06-01 01:11:50");
        $end = new DateTime("2012-06-30 05:56:40");

        ?>
            <div class="legend">
                <span class="first value">0</span>
                <span class="last value"><?php echo round($this->model->getAllowedAmount($start, $end), 2) ?></span>
                <span class="spent value"><?php echo round($this->model->spent($start, $end)) ?></span>
                <span class="left value"><?php echo round($this->model->leftToSpent($start, $end)) ?></span>
            </div>

        <?php

    }


}