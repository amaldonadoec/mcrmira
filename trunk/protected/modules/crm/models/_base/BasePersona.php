<?php

/**
 * This is the model base class for the table "persona".
 * DO NOT MODIFY THIS FILE! It is automatically generated by AweCrud.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Persona".
 *
 * Columns in table "persona" available as properties of the model,
 * followed by relations of table "persona" available as properties of the model.
 *
 * @property integer $id
 * @property string $primer_nombre
 * @property string $segundo_nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $cedula
 * @property string $ruc
 * @property string $telefono
 * @property string $celular
 * @property string $email
 * @property string $descripcion
 * @property string $tipo
 * @property string $estado
 * @property string $fecha_creacion
 * @property string $fecha_actualizacion
 * @property integer $usuario_creacion_id
 * @property integer $usuario_actualizacion_id
 * @property integer $aprobado
 * @property integer $sucursal_id
 * @property integer $persona_etapa_id
 * @property integer $direccion_domicilio_id
 * @property integer $direccion_negocio_id
 * @property string $sexo
 * @property string $fecha_nacimiento
 * @property integer $carga_familiar
 * @property string $discapacidad
 * @property string $estado_civil
 * @property integer $actividad_economica_id
 *
 * @property Direccion $direccionDomicilio
 * @property Direccion $direccionNegocio
 * @property Sucursal $sucursal
 * @property ActividadEconomica $actividadEconomica
 * @property PersonaEtapa $personaEtapa
 */
abstract class BasePersona extends AweActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'persona';
    }

    public static function representingColumn() {
        return 'primer_nombre';
    }

    public function rules() {
        return array(
            array('primer_nombre, apellido_paterno, cedula, usuario_creacion_id, sucursal_id, persona_etapa_id, sexo, fecha_nacimiento, carga_familiar, discapacidad, estado_civil, actividad_economica_id', 'required'),
            array('usuario_creacion_id, usuario_actualizacion_id, aprobado, sucursal_id, persona_etapa_id, direccion_domicilio_id, direccion_negocio_id, carga_familiar, actividad_economica_id', 'numerical', 'integerOnly'=>true),
            array('email', 'email'),
            array('primer_nombre, segundo_nombre, cedula', 'length', 'max'=>20),
            array('apellido_paterno, apellido_materno', 'length', 'max'=>30),
            array('ruc', 'length', 'max'=>13),
            array('telefono, celular', 'length', 'max'=>24),
            array('email', 'length', 'max'=>255),
            array('tipo', 'length', 'max'=>7),
            array('estado', 'length', 'max'=>8),
            array('sexo', 'length', 'max'=>1),
            array('discapacidad', 'length', 'max'=>2),
            array('estado_civil', 'length', 'max'=>10),
            array('descripcion, fecha_actualizacion', 'safe'),
            array('tipo', 'in', 'range' => array('CLIENTE','GARANTE')), // enum,
            array('estado', 'in', 'range' => array('ACTIVO','INACTIVO')), // enum,
            array('sexo', 'in', 'range' => array('M','F')), // enum,
            array('discapacidad', 'in', 'range' => array('SI','NO')), // enum,
            array('estado_civil', 'in', 'range' => array('SOLTERO','CASADO','DIVORCIADO','VIUDO')), // enum,
            array('segundo_nombre, apellido_materno, ruc, telefono, celular, email, descripcion, tipo, estado, fecha_actualizacion, usuario_actualizacion_id, aprobado, direccion_domicilio_id, direccion_negocio_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, primer_nombre, segundo_nombre, apellido_paterno, apellido_materno, cedula, ruc, telefono, celular, email, descripcion, tipo, estado, fecha_creacion, fecha_actualizacion, usuario_creacion_id, usuario_actualizacion_id, aprobado, sucursal_id, persona_etapa_id, direccion_domicilio_id, direccion_negocio_id, sexo, fecha_nacimiento, carga_familiar, discapacidad, estado_civil, actividad_economica_id', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
            'direccionDomicilio' => array(self::BELONGS_TO, 'Direccion', 'direccion_domicilio_id'),
            'direccionNegocio' => array(self::BELONGS_TO, 'Direccion', 'direccion_negocio_id'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursal', 'sucursal_id'),
            'actividadEconomica' => array(self::BELONGS_TO, 'ActividadEconomica', 'actividad_economica_id'),
            'personaEtapa' => array(self::BELONGS_TO, 'PersonaEtapa', 'persona_etapa_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'id' => Yii::t('app', 'ID'),
                'primer_nombre' => Yii::t('app', 'Primer Nombre'),
                'segundo_nombre' => Yii::t('app', 'Segundo Nombre'),
                'apellido_paterno' => Yii::t('app', 'Apellido Paterno'),
                'apellido_materno' => Yii::t('app', 'Apellido Materno'),
                'cedula' => Yii::t('app', 'Cedula'),
                'ruc' => Yii::t('app', 'Ruc'),
                'telefono' => Yii::t('app', 'Telefono'),
                'celular' => Yii::t('app', 'Celular'),
                'email' => Yii::t('app', 'Email'),
                'descripcion' => Yii::t('app', 'Descripcion'),
                'tipo' => Yii::t('app', 'Tipo'),
                'estado' => Yii::t('app', 'Estado'),
                'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
                'fecha_actualizacion' => Yii::t('app', 'Fecha Actualizacion'),
                'usuario_creacion_id' => Yii::t('app', 'Usuario Creacion'),
                'usuario_actualizacion_id' => Yii::t('app', 'Usuario Actualizacion'),
                'aprobado' => Yii::t('app', 'Aprobado'),
                'sucursal_id' => Yii::t('app', 'Sucursal'),
                'persona_etapa_id' => Yii::t('app', 'Persona Etapa'),
                'direccion_domicilio_id' => Yii::t('app', 'Direccion Domicilio'),
                'direccion_negocio_id' => Yii::t('app', 'Direccion Negocio'),
                'sexo' => Yii::t('app', 'Sexo'),
                'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
                'carga_familiar' => Yii::t('app', 'Carga Familiar'),
                'discapacidad' => Yii::t('app', 'Discapacidad'),
                'estado_civil' => Yii::t('app', 'Estado Civil'),
                'actividad_economica_id' => Yii::t('app', 'Actividad Economica'),
                'direccionDomicilio' => null,
                'direccionNegocio' => null,
                'sucursal' => null,
                'actividadEconomica' => null,
                'personaEtapa' => null,
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('primer_nombre', $this->primer_nombre, true);
        $criteria->compare('segundo_nombre', $this->segundo_nombre, true);
        $criteria->compare('apellido_paterno', $this->apellido_paterno, true);
        $criteria->compare('apellido_materno', $this->apellido_materno, true);
        $criteria->compare('cedula', $this->cedula, true);
        $criteria->compare('ruc', $this->ruc, true);
        $criteria->compare('telefono', $this->telefono, true);
        $criteria->compare('celular', $this->celular, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('tipo', $this->tipo, true);
        $criteria->compare('estado', $this->estado, true);
        $criteria->compare('fecha_creacion', $this->fecha_creacion, true);
        $criteria->compare('fecha_actualizacion', $this->fecha_actualizacion, true);
        $criteria->compare('usuario_creacion_id', $this->usuario_creacion_id);
        $criteria->compare('usuario_actualizacion_id', $this->usuario_actualizacion_id);
        $criteria->compare('aprobado', $this->aprobado);
        $criteria->compare('sucursal_id', $this->sucursal_id);
        $criteria->compare('persona_etapa_id', $this->persona_etapa_id);
        $criteria->compare('direccion_domicilio_id', $this->direccion_domicilio_id);
        $criteria->compare('direccion_negocio_id', $this->direccion_negocio_id);
        $criteria->compare('sexo', $this->sexo, true);
        $criteria->compare('fecha_nacimiento', $this->fecha_nacimiento, true);
        $criteria->compare('carga_familiar', $this->carga_familiar);
        $criteria->compare('discapacidad', $this->discapacidad, true);
        $criteria->compare('estado_civil', $this->estado_civil, true);
        $criteria->compare('actividad_economica_id', $this->actividad_economica_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array_merge(array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'fecha_creacion',
                'updateAttribute' => 'fecha_actualizacion',
                'timestampExpression' => new CDbExpression('NOW()'),
            )
        ), parent::behaviors());
    }
}