<?php

class CantonController extends AweController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';
    public $admin = true;

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
    public function actionCreate() {
        $model = new Canton;
        $this->performAjaxValidation($model, 'canton-form');

        if (isset($_POST['Canton'])) {
            $model->attributes = $_POST['Canton'];
            if ($model->save()) {
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model, 'canton-form');

        if (isset($_POST['Canton'])) {
            $model->attributes = $_POST['Canton'];
            if ($model->save()) {
                $this->redirect(array('admin'));
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
            $canton = $this->loadModel($id);
            $parroquias = $canton->parroquias;
            if (count($parroquias) == 0) {
                echo '<div class = "alert alert-success"><button data-dismiss = "alert" class = "close" type = "button">×</button>Borrado Exitosamente.</div>';
                $canton->delete();
            } else if (count($parroquias) >= 1) {
                echo '<div class = "alert alert-error"><button data-dismiss = "alert" class = "close" type = "button">×</button>Imposible eliminar el canton, varias parroquias dependen de ésta.</div>';
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Canton('search');
        $model->unsetAttributes(); // clear any default values
        
        if (isset($_GET['search'])) {
            $model->attributes = $this->assignParams($_GET['search']);
        }
        if (isset($_GET['Canton']))
            $model->attributes = $_GET['Canton'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAjaxGetCantonByProvincia() {
        if (Yii::app()->request->isAjaxRequest) {
//            die(var_dump($_POST));
            if (isset($_POST['provincia_id']) && $_POST['provincia_id'] > 0) {
                $data = Canton::model()->findAll(array(
                    "condition" => "provincia_id =:provincia_id ",
                    "order" => "nombre",
                    "params" => array(':provincia_id' => $_POST['provincia_id'],)
                ));
                if ($data) {
                    $data = CHtml::listData($data, 'id', 'nombre');
                    echo CHtml::tag('option', array('value' => 0, 'id' => 'p'), '- Cantones -', true);
                    foreach ($data as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                } else {
                    echo CHtml::tag('option', array('value' => 0), '- No existen opciones -', true);
                }
            } else {
                echo CHtml::tag('option', array('value' => 0, 'id' => 'p'), '- Seleccione una provincia -', true);
            }
        }
    }

    public function assignParams($params) {
        $result = array();
        if ($params['filters'][0] == 'all') {
            foreach (Canton::model()->searchParams() as $param) {
                $result[$param] = $params['value'];
            }
        } else {
            foreach ($params['filters'] as $param) {
                $result[$param] = $params['value'];
            }
        }
        return $result;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $modelClass = __CLASS__) {
        $model = Canton::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'canton-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    public function actionAjaxlistCantones($search_value = null) {
        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(Canton::model()->getListSelect2($search_value));
        }
    }


}
