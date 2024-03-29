<?php

/**
 * This is the model base class for the table "credito_amortizacion".
 * DO NOT MODIFY THIS FILE! It is automatically generated by AweCrud.
 * If any changes are necessary, you must set or override the required
 * property or method in class "CreditoAmortizacion".
 *
 * Columns in table "credito_amortizacion" available as properties of the model,
 * followed by relations of table "credito_amortizacion" available as properties of the model.
 *
 * @property integer $id
 * @property integer $nro_cuota
 * @property string $fecha_pago
 * @property string $cuota
 * @property string $interes
 * @property string $amortizacion
 * @property string $mora
 * @property string $estado
 * @property string $saldo_contra
 * @property string $saldo_favor
 * @property integer $credito_id
 *
 * @property Credito $credito
 * @property CreditoDeposito[] $creditoDepositos
 */
abstract class BaseCreditoAmortizacion extends AweActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'credito_amortizacion';
    }

    public static function representingColumn() {
        return 'fecha_pago';
    }

    public function rules() {
        return array(
            array('nro_cuota, fecha_pago, cuota, interes, amortizacion, estado, credito_id', 'required'),
            array('nro_cuota, credito_id', 'numerical', 'integerOnly'=>true),
            array('cuota, interes, amortizacion, mora, saldo_contra, saldo_favor', 'length', 'max'=>10),
            array('estado', 'length', 'max'=>6),
            array('estado', 'in', 'range' => array('DEUDA','PAGADO')), // enum,
            array('mora, saldo_contra, saldo_favor', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, nro_cuota, fecha_pago, cuota, interes, amortizacion, mora, estado, saldo_contra, saldo_favor, credito_id', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
            'credito' => array(self::BELONGS_TO, 'Credito', 'credito_id'),
            'creditoDepositos' => array(self::HAS_MANY, 'CreditoDeposito', 'credito_amortizacion_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'id' => Yii::t('app', 'ID'),
                'nro_cuota' => Yii::t('app', 'Nro Cuota'),
                'fecha_pago' => Yii::t('app', 'Fecha Pago'),
                'cuota' => Yii::t('app', 'Cuota'),
                'interes' => Yii::t('app', 'Interes'),
                'amortizacion' => Yii::t('app', 'Amortizacion'),
                'mora' => Yii::t('app', 'Mora'),
                'estado' => Yii::t('app', 'Estado'),
                'saldo_contra' => Yii::t('app', 'Saldo Contra'),
                'saldo_favor' => Yii::t('app', 'Saldo Favor'),
                'credito_id' => Yii::t('app', 'Credito'),
                'credito' => null,
                'creditoDepositos' => null,
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('nro_cuota', $this->nro_cuota);
        $criteria->compare('fecha_pago', $this->fecha_pago, true);
        $criteria->compare('cuota', $this->cuota, true);
        $criteria->compare('interes', $this->interes, true);
        $criteria->compare('amortizacion', $this->amortizacion, true);
        $criteria->compare('mora', $this->mora, true);
        $criteria->compare('estado', $this->estado, true);
        $criteria->compare('saldo_contra', $this->saldo_contra, true);
        $criteria->compare('saldo_favor', $this->saldo_favor, true);
        $criteria->compare('credito_id', $this->credito_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array_merge(array(
        ), parent::behaviors());
    }
}