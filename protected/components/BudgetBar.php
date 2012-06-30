<?php

Yii::import('bootstrap.widgets.BootProgress');


Class BudgetBar extends  BootProgress {


    /** @var Budget */
    public $model;

    public function init()
    {

        $start = new DateTime($this->model->date_from);
        $end = new DateTime($this->model->date_to);

        // set percentage of the bar
        $this->percent = $this->model->getPercentage($start, $end);

        // set color of the bar
//        if ($this->model->isIncomeType()) {
//            $this->type = self::TYPE_SUCCESS;
//        }
//        elseif ($this->model->isExpenseType()) {
//            $this->type = self::TYPE_DANGER;
//        }

        $idealPercentage = $this->model->getIdealPercentage($start, $end);

        if ($this->percent > $idealPercentage) {
            $this->type = self::TYPE_DANGER;
        }
        else {
            $this->type = self::TYPE_SUCCESS;
        }


        parent::init();
    }


    public function run()
    {
//        parent::run();

        $start = new DateTime($this->model->date_from);
        $end = new DateTime($this->model->date_to);

        echo CHtml::openTag('div', $this->htmlOptions);
        echo '<div class="bar" style="width: '.$this->percent.'%;"></div>';
        echo '<div class="ideal-value" style="width: '.$this->model->getIdealPercentage($start, $end).'%" title="'.round($this->model->getIdealValue($start, $end), 2).'">&nbsp;</div>';
        echo '</div>';



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