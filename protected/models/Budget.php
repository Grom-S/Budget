<?php

/**
 * This is the model class for table "budget".
 *
 * The followings are the available columns in table 'budget':
 * @property string $id
 * @property string $transaction_type_id
 * @property string $currency_id
 * @property string $amount
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Currency $currency
 * @property TransactionType $transactionType
 * @property Category[] $categories
 */
class Budget extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Budget the static model class
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
		return 'budget';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transaction_type_id, currency_id, name', 'required'),
			array('transaction_type_id, currency_id, amount', 'length', 'max'=>10),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, transaction_type_id, currency_id, amount, name', 'safe', 'on'=>'search'),
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
			'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
			'transactionType' => array(self::BELONGS_TO, 'TransactionType', 'transaction_type_id'),
			'categories' => array(self::MANY_MANY, 'Category', 'budget_category(budget_id, category_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transaction_type_id' => 'Transaction Type',
			'currency_id' => 'Currency',
			'amount' => 'Amount',
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
		$criteria->compare('transaction_type_id',$this->transaction_type_id,true);
		$criteria->compare('currency_id',$this->currency_id,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function getPercentage($start_date, $end_date) {

        $budget_amount = $this->getAllowedAmount($start_date, $end_date);
        $spent_already = $this->spent($start_date, $end_date);

        return $spent_already * 100 / $budget_amount;
    }


    public function isIncomeType()
    {
        return (int)$this->transaction_type_id === TransactionType::INCOME_TYPE_ID;
    }

    public function isExpenseType()
    {
        return (int)$this->transaction_type_id === TransactionType::EXPENSE_TYPE_ID;
    }



    public function getAmountInDefaultCurrency()
    {
        return $this->amount * $this->currency->rate;
    }


    /**
     * Gets allowed budget amount for date interval
     *
     * @param DateTime $start_date
     * @param DateTime $end_date
     * @return float
     */
    public function getAllowedAmount(DateTime $start_date, DateTime $end_date)
    {
        $diff_in_days = $start_date->diff($end_date, true)->days + 1;

        return $this->getAmountInDefaultCurrency() * $diff_in_days;
    }


    // get how much spent in date interval
    public function spent(DateTime $start_date, DateTime $end_date)
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

        if (is_null($spent)) {
            $spent = 0;
        }

        return $spent;
    }

    // get how much left to spent already in date interval

    public function leftToSpent(DateTime $start_date, DateTime $end_date)
    {
        return $this->getAllowedAmount($start_date, $end_date) - $this->spent($start_date, $end_date);
    }


    // get calculate percentage of how much spent
}