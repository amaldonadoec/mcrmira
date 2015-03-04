<?php

class AhorroDepositoController extends AweController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'..
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';
    public $admin = false;

    public function filters() {
        return array(
            array('CrugeAccessControlFilter'),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id_ahorro = null) {
        if (Yii::app()->request->isAjaxRequest) {// el deposito solo se lo puede hacer mediante un modal
            $result = array();
            $model = new AhorroDeposito;

            $model->ahorro_id = $id_ahorro;
            $modelAhorro = Ahorro::model()->findByPk($id_ahorro);
            $model->cod_comprobante_su = AhorroDeposito::model()->generarCodigoComprobante($model->ahorro->socio_id);
            $this->performAjaxValidation($model, 'ahorro-deposito-form');

            if (isset($_POST['AhorroDeposito'])) {
                $result['ahorro_id'] = $model->ahorro_id;
                $model->attributes = $_POST['AhorroDeposito'];

                if ($model->cantidad <= $modelAhorro->saldo_contra) {// saber si se supera la cantidad
                    $modelAhorro->saldo_contra = $modelAhorro->saldo_contra - $model->cantidad;
                    $modelAhorro->saldo_favor = $modelAhorro->saldo_favor + $model->cantidad;
                    $result['cantidadExtra'] = 0;
                } else {
                    $modelAhorro->saldo_contra = 0;
                    $modelAhorro->saldo_favor = $modelAhorro->cantidad;
                }
                $model->fecha_comprobante_entidad = Util::FormatDate($model->fecha_comprobante_entidad, 'Y-m-d H:i:s');

                $model->cod_comprobante_su = AhorroDeposito::model()->generarCodigoComprobante($model->ahorro->socio_id);
                $model->fecha_comprobante_su = Util::FechaActual();
                $result['enableButtonSave'] = true; // habilitado en boton para hacer depositos
                if ($model->save()) {
                    if ($modelAhorro->saldo_contra == 0) { // si el ahorro ya se pago en su totalidad
                        $modelAhorro->estado = Ahorro::ESTADO_PAGADO;
                        if ($modelAhorro->tipo == Ahorro::TIPO_PRIMER_PAGO) { //  si el ahorro  es tipo  primer pago y se pago en su totalidad; el socio debe pasar a aprobado  para registrarle ahorros obligatorio
                            Persona::model()->updateByPk($modelAhorro->socio->id, array(
                                'usuario_actualizacion_id' => Yii::app()->user->id,
                                'fecha_actualizacion' => Util::FechaActual(),
                                'aprobado' => 1
                                    )
                            );
                        }

                        $result['enableButtonSave'] = false; // deshabilitado en boton para hacer depositos
                    }
                    $result['success'] = $modelAhorro->save();
                }
                if (!$result['success']) { // cuando ocurre un problema al guardar en ahorro el deposito debe borrarse
                    $model->delete();
                    $result['message'] = "Error al registrar el deposito.";
                }
                echo json_encode($result);
                Yii::app()->end();
            }
            $this->renderPartial('_form_modal_deposito', array(
                'model' => $model,
                'modelAhorro' => $modelAhorro,
                    ), false, true);
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateDepositoAhorro() {
        if (Yii::app()->request->isAjaxRequest) {// el deposito solo se lo puede hacer mediante un modal
            $result = array();
            $model = new AhorroDeposito;
            $model->cod_comprobante_su = AhorroDeposito::model()->generarCodigoComprobante($model->socio_id);

            $this->performAjaxValidation($model, 'ahorro-deposito-form');
            if (isset($_POST['AhorroDeposito'])) {
                $model->attributes = $_POST['AhorroDeposito'];
                $model->socio_id = $_POST['AhorroDeposito']['socio_id'];
                $model->fecha_comprobante_entidad = Util::FormatDate($model->fecha_comprobante_entidad, 'Y-m-d H:i:s');
                $ahorroSocio = Ahorro::model()
                        ->findAll(
                        'socio_id=:socio_id AND estado=:estado AND tipo=:tipo ORDER BY fecha ASC', array(
                    ':socio_id' => $model->socio_id,
                    ':estado' => Ahorro::ESTADO_DEUDA,
                    ':tipo' => Ahorro::TIPO_OBLIGATORIO
                ));

                if ($model->save()) {
                    $result['success'] = true;
                    $fechaNext = null;
                    foreach ($ahorroSocio as $ahorro) {
                        if ($model->cantidad <= $ahorro->saldo_contra) {
                            $ahorro->saldo_contra = $ahorro->saldo_contra - $model->cantidad;
                            $ahorro->saldo_favor = $ahorro->saldo_favor + $model->cantidad;
                            if ($ahorro->save()) {
                                if ($ahorro->saldo_contra > 0) {
                                    $modelAhorroDetalle = new AhorroDetalle;
                                    $modelAhorroDetalle->ahorro_id = $ahorro->id;
                                    $modelAhorroDetalle->cantidad = $ahorro->saldo_contra;
                                    $modelAhorroDetalle->fecha = Util::FechaActual();
                                    $modelAhorroDetalle->usuario_creacion = Yii::app()->user->id;

                                    $modelAhorroDetalle->save();
                                }
                                $model->cantidad = $model->cantidad - $ahorro->saldo_favor;
                            }
                        } else {
                            $ahorro->saldo_favor = $ahorro->saldo_favor + $ahorro->saldo_contra;
                            $model->cantidad = $model->cantidad - $ahorro->saldo_contra;
                            $ahorro->saldo_contra = 0;
							$ahorro->estado = Ahorro::ESTADO_PAGADO;	
                            $ahorro->save();
                        }
                        $fechaNext = Util::FormatDate(date("d/m/Y", strtotime(Util::FormatDate($ahorro->fecha, 'm/d/Y') . " +1 month")), 'Y-m-d');
//                
                    }

                    while ($model->cantidad > 0) {
                        $modelAhorro = new Ahorro;
                        $modelAhorro->socio_id = $model->socio_id;
                        $modelAhorro->cantidad = Sucursal::model()->findByPk(Util::getSucursal())->valor_ahorro;
                        $modelAhorro->fecha = $fechaNext;                       
                        $modelAhorro->tipo = Ahorro::TIPO_OBLIGATORIO;
                        $modelAhorro->saldo_contra = $modelAhorro->cantidad - $model->cantidad;
                        $modelAhorro->saldo_favor = $modelAhorro->cantidad;		
						$modelAhorro->estado = $ahorro->saldo_contra > 0?Ahorro::ESTADO_DEUDA:Ahorro::ESTADO_PAGADO;						
                       
						 if ($modelAhorro->save()) {
                                if ($ahorro->saldo_contra > 0) {
                                    $modelAhorroDetalle = new AhorroDetalle;
                                    $modelAhorroDetalle->ahorro_id = $ahorro->id;
                                    $modelAhorroDetalle->cantidad = $ahorro->saldo_contra;
                                    $modelAhorroDetalle->fecha = Util::FechaActual();
                                    $modelAhorroDetalle->usuario_creacion = Yii::app()->user->id;

                                    $modelAhorroDetalle->save();
                                }
                                 $model->cantidad = $model->cantidad - $modelAhorro->cantidad;
                            }
                        $fechaNext = Util::FormatDate(date("d/m/Y", strtotime(Util::FormatDate($modelAhorro->fecha, 'm/d/Y') . " +1 month")), 'Y-m-d');
                      
                    }
                }


                echo json_encode($result);
                Yii::app()->end();
            }

            $this->renderPartial('_form_modal_deposito_ahorro', array(
                'model' => $model,
                    ), false, true);
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model, 'ahorro-deposito-form');

        if (isset($_POST['AhorroDeposito'])) {
            $model->attributes = $_POST['AhorroDeposito'];
            $model->fecha_comprobante_entidad = Yii::app()->dateFormatter->format("yyyy-MM-dd hh:mm:ss", $model->fecha_comprobante_entidad);
            $model->fecha_comprobante_su = Yii::app()->dateFormatter->format("yyyy-MM-dd hh:mm:ss", $model->fecha_comprobante_su);
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('AhorroDeposito');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AhorroDeposito('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['AhorroDeposito']))
            $model->attributes = $_GET['AhorroDeposito'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $modelClass = __CLASS__) {
        $model = AhorroDeposito::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ahorro-deposito-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
