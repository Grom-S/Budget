<?php

/**
 * This is the model class for table "transaction".
 *
 * The followings are the available columns in table 'transaction':
 * @property string $id
 * @property string $transaction_type_id
 * @property string $account_id
 * @property string $category_id
 * @property string $client_id
 * @property string $currency_id
 * @property string $amount
 * @property string $date
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Account $account
 * @property Category $category
 * @property Client $client
 * @property Currency $currency
 * @property TransactionType $transactionType
 *
 * @method Transaction expenses()
 * @method Transaction incomes()
 */
class Transaction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Transaction the static model class
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
		return 'transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transaction_type_id, account_id, currency_id, amount, date', 'required'),
			array('transaction_type_id, account_id, category_id, client_id, currency_id, amount', 'length', 'max'=>10),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, transaction_type_id, account_id, category_id, client_id, currency_id, amount, date, description', 'safe', 'on'=>'search'),
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
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
			'transactionType' => array(self::BELONGS_TO, 'TransactionType', 'transaction_type_id'),
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
			'account_id' => 'Account',
			'category_id' => 'Category',
			'client_id' => 'Client',
			'currency_id' => 'Currency',
			'amount' => 'Amount',
			'date' => 'Date',
			'description' => 'Description',
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
		$criteria->compare('account_id',$this->account_id,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('client_id',$this->client_id,true);
		$criteria->compare('currency_id',$this->currency_id,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('description',$this->description,true);

        $criteria->with = array('category');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    protected function beforeSave()
    {
        $this->date = date('Y-m-d', strtotime($this->date));
        return parent::beforeSave();
    }


    public function scopes()
    {
        return array(
            'expenses' => array(
                'condition' => 'transaction_type_id='. TransactionType::EXPENSE_TYPE_ID,
            ),
            'incomes' => array(
                'condition' => 'transaction_type_id='. TransactionType::INCOME_TYPE_ID,
            ),
        );
    }

    public function isExpense()
    {
        return (int)$this->transaction_type_id === TransactionType::EXPENSE_TYPE_ID;
    }

    public function isIncome()
    {
        return (int)$this->transaction_type_id === TransactionType::INCOME_TYPE_ID;
    }

}