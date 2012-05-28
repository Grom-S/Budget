<?php
/** @var $form BootActiveForm */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id' => 'transaction-form',
    'enableAjaxValidation' => false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->dropDownListRow($model, 'transaction_type_id',
    CHtml::listData(TransactionType::model()->findAll(), 'id', 'name'),
    array('options' => array(2 => array('selected' => 'selected')))); ?>

<?php echo $form->dropDownListRow($model, 'account_id', CHtml::listData(Account::model()->findAll(), 'id', 'name')); ?>

<?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData(Category::model()->findAll(), 'id', 'name')); ?>

<?php echo $form->dropDownListRow($model, 'currency_id', CHtml::listData(Currency::model()->findAll(), 'id', 'name')); ?>

<?php echo $form->textFieldRow($model, 'amount', array('class' => 'span5', 'maxlength' => 10)); ?>

<?php echo $form->labelEx($model, 'date'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array('model' => $model, 'attribute' => 'date', 'htmlOptions' => array('value' => date('m/d/Y')))); ?>
<?php echo $form->error($model, 'date'); ?>

<?php echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => $model->isNewRecord ? 'Create' : 'Save',
)); ?>
</div>

<?php $this->endWidget(); ?>
