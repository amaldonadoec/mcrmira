<?php

/**
 * This is the model base class for the table "cruge_user_sucursal".
 * DO NOT MODIFY THIS FILE! It is automatically generated by AweCrud.
 * If any changes are necessary, you must set or override the required
 * property or method in class "CrugeUserSucursal".
 *
 * Columns in table "cruge_user_sucursal" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $cruge_id
 * @property integer $sucursal_id
 *
 */
abstract class BaseCrugeUserSucursal extends AweActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'cruge_user_sucursal';
    }

    public static function representingColumn() {
        return array(
            'cruge_id',
            'sucursal_id',
        );
    }

    public function rules() {
        return array(
            array('cruge_id, sucursal_id', 'required'),
            array('cruge_id, sucursal_id', 'numerical', 'integerOnly'=>true),
            array('cruge_id, sucursal_id', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'cruge_id' => Yii::t('app', 'Cruge'),
                'sucursal_id' => Yii::t('app', 'Sucursal'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('cruge_id', $this->cruge_id);
        $criteria->compare('sucursal_id', $this->sucursal_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array_merge(array(
        ), parent::behaviors());
    }
}