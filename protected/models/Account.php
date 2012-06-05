<?php

/**
 * This is the model class for table "account".
 *
 * The followings are the available columns in table 'account':
 * @property string $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Transaction[] $transactions
 */
class Account extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Account the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'transactions' => array(self::HAS_MANY, 'Transaction', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function getAmount()
    {
        $sql = "
            SELECT
              SUM(t.amount * c.rate)

            FROM budget b
            JOIN budget_category bc
              ON b.id = bc.budget_id
            JOIN `transaction` t
              ON bc.category_id = t.category_id
            JOIN currency c
              ON t.currency_id = c.id

            WHERE b.id = :budget_id
              AND t.transaction_type_id = :transaction_type_id
              AND t.date BETWEEN :start_date AND :end_date
        ";


        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->params = array(
            ':budget_id'           => $this->id,
            ':transaction_type_id' => $this->transaction_type_id,
            ':start_date'          => $start_date->format('Y-m-d'),
            ':end_date'            => $end_date->format('Y-m-d'),
        );

        $spent = $cmd->queryScalar();
    }


    function getTotal($type = TransactionType::EXPENSE_TYPE_ID)
    {

        $sql = "
            SELECT SUM(t.amount * c.rate)
            FROM `transaction` t
            JOIN currency c ON c.id = t.currency_id
            WHERE account_id = :account_id
            AND transaction_type_id = :transaction_type_id
        ";

        $cmd = Yii::app()->db->createCommand($sql);

        $cmd->params = array(
            ':account_id'          => $this->id,
            ':transaction_type_id' => $type,
        );

        return $cmd->queryScalar();
    }


    public function getCurrentValue()
    {
        $initial_value = $this->getTotal(TransactionType::INITIAL_TYPE_ID);
        $income        = $this->getTotal(TransactionType::INCOME_TYPE_ID);
        $expenses      = $this->getTotal(TransactionType::EXPENSE_TYPE_ID);

        return $initial_value + $income - $expenses;
    }


}