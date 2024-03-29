<?php
Util::tsRegisterAssetJs('_form.js');

/** @var PersonaController $this */
/** @var Persona $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'persona-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,
        'afterValidate' => 'js:function(form, data, hasError){ $("#contenedor1 > div :not(.error)").addClass("success");$("#contenedor2 > div :not(.error)").addClass("success");return true;}'
    ),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i> <?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . Persona::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">

        <?php echo $form->textFieldRow($model, 'primer_nombre', array('maxlength' => 20, 'class' => 'span6')) ?>

        <?php echo $form->textFieldRow($model, 'segundo_nombre', array('maxlength' => 20, 'class' => 'span6')) ?>

        <?php echo $form->textFieldRow($model, 'apellido_paterno', array('maxlength' => 30, 'class' => 'span6')) ?>

        <?php echo $form->textFieldRow($model, 'apellido_materno', array('maxlength' => 30, 'class' => 'span6')) ?>

        <?php
//        echo $form->radioButtonListRow(
//                $model, 'tipo_identificacion', array('C' => 'Cédula', 'P' => 'Pasaporte',), array('labelOptions' => array('style' => 'display:inline-block'),
//            'separator' => "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;")
//        );
        ?>

        <?php // echo $form->textFieldRow($model, 'cedula', array('class' => 'span4', 'disabled' => $model->isNewRecord ? true : false)) ?>
        <?php echo $form->textFieldRow($model, 'cedula', array('class' => 'span4 numeric')) ?>

        <?php echo $form->textFieldRow($model, 'ruc', array('maxlength' => 13, 'class' => 'span4')) ?>



        <div class="control-group">
            <?php echo $form->labelEx($model, 'actividad_economica_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <div class="inline span12" >
                    <?php
                    $actividades_eco = ActividadEconomica::model()->activos()->findAll();


                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
//                        'asDropDownList' => false,

                        'model' => $model,
                        'attribute' => 'actividad_economica_id',
                        'data' => CHtml::listData($actividades_eco, 'id', 'nombre'),
                        'options' => array(
//                    'tags' => array('clever', 'is', 'better', 'clevertech'),
                            'placeholder' => '-- Seleccione --',
//                    'width' => '40%',
//                    'tokenSeparators' => array(',', ' ')
                        )
                            )
                    );
//                    
                    ?>
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbButton', array(
//            'label' => 'Add',
                        'id' => 'nuevaSucursal',
                        'icon' => 'plus',
//            'type' => 'primary',
                        'htmlOptions' => array(
                            'data-html' => true,
                            'data-title' => '<i class="icon-dollar"></i> Agregar Actividad<button type="button" class="close" onclick="$(&quot;#nuevaSucursal&quot;).popover(&quot;hide&quot;)" >&times;',
                            'data-placement' => 'left',
                            'data-content' =>
                            $this->renderPartial("crm.views.persona.popovers._formActividadEconomicaCreate", array("model" => new ActividadEconomica), true, false),
//                     true si el resultado de la representación debe ser devuelto en vez de ser mostrado a los usuarios finales.
//                    flase si el resultado renderizado debe posprocesarlo usando processOutput .
                            'data-toggle' => 'popover'
                        ),
                            )
                    );
                    ?>
                </div>

<!--                <span class="input-group-addon btn">
                    <a  href="#" id="popover2" class="pop" entidad="actividad_economica_id" data-original-title="" title=""><i class="fa fa-plus"></i></a>
                </span>-->
                <?php echo $form->error($model, 'actividad_economica_id') ?> 
            </div>                                           
        </div>

        <?php
        $actividades_eco = ActividadEconomica::model()->activos()->findAll();

        echo $form->dropDownListRow($model, 'tipo', array('-- selecione --', 'NUEVO' => 'NUEVO', 'FUNDADOR' => 'FUNDADOR'), array('placeholder' => null)
        );
        ?>

        <?php echo $form->textFieldRow($model, 'telefono', array('maxlength' => 24, 'class' => 'span4')) ?>

        <?php echo $form->textFieldRow($model, 'celular', array('maxlength' => 24, 'class' => 'span4')) ?>

        <?php echo $form->textFieldRow($model, 'email', array('maxlength' => 255, 'class' => 'span4')) ?>

        <?php echo $form->textFieldRow($model, 'carga_familiar', array('maxlength' => 3, 'class' => 'span4')) ?>

        <?php
        echo $form->radioButtonListRow(
                $model, 'discapacidad', array('SI' => 'SI', 'NO' => 'NO',), array('labelOptions' => array('style' => 'display:inline-block'),
            'separator' => "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;")
        );
        ?>
        <?php
        echo $form->datepickerRow(
                $model, 'fecha_nacimiento', array(
            'options' => array(
                'language' => 'es',
                'format' => 'dd/mm/yyyy',
                'autoclose' => true,
                'startView' => 2,
                'orientation' => 'bottom right',
            ),
            'htmlOptions' => array(
                'readonly' => 'readonly',
                'style' => 'cursor:pointer;'
            )
                )
        );
        ?>
        <?php
        echo $form->datepickerRow(
                $model, 'fecha_creacion', array(
            'options' => array(
                'language' => 'es',
                'format' => 'dd/mm/yyyy',
                'autoclose' => true,
                'endDate' => 'today',
//                'startView' => 2,
                'orientation' => 'bottom right',
            ),
            'htmlOptions' => array(
                'readonly' => 'readonly',
                'style' => 'cursor:pointer;'
            )
                )
        );
        ?>


        <?php
        echo $form->radioButtonListRow(
                $model, 'estado_civil', array('SOLTERO' => 'Soltero', 'CASADO' => 'Casado', 'DIVORCIADO' => 'Divorciado', 'VIUDO' => 'Viudo',), array('labelOptions' => array('style' => 'display:inline-block'),
            'separator' => "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;")
        );
        ?>

        <?php
        echo $form->radioButtonListRow(
                $model, 'sexo', array('M' => 'Masculino', 'F' => 'Femenino',), array('labelOptions' => array('style' => 'display:inline-block'),
            'separator' => "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;")
        );
        ?>

        <?php // echo $form->textFieldRow($model, 'usuario_creacion_id')                ?>

        <?php // echo $form->textFieldRow($model, 'usuario_actualizacion_id')                 ?>


        <?php // echo $form->textFieldRow($model, 'aprobado')                 ?>
        <?php
//        $sucursales = Sucursal::model()->activos()->findAll();
//        if (!empty($sucursales)) {
//            $sucursales = array(null => '-- Seleccione --') + CHtml::listData($sucursales, 'id', 'nombre');
//        } else {
//            $sucursales = array(null => '-- Ninguno --');
//        }
        ?>

        <!--        --><?php //echo $form->dropDownListRow($model, 'sucursal_id', $sucursales, array('class' => 'span4',))                                                                                                                ?>
        <!--inicio direccion 1-->
        <?php
        if ($modelDireccion1->isNewRecord) {
            $lista_provincia1 = CHtml::listData(Provincia::model()->findAll(), 'id', 'nombre');
            $lista_canton1 = null;
            $lista_parroquia1 = null;
            $lista_barrio1 = null;
        } else {
            $lista_provincia1 = CHtml::listData(Provincia::model()->findAll(), 'id', 'nombre');
            $lista_canton1 = null;
            $lista_parroquia1 = null;
            $lista_barrio1 = null;
            if ($modelDireccion1->parroquia_id) {
                $modelDireccion1->provincia_id = $modelDireccion1->parroquia->canton->provincia->id;
                $modelDireccion1->canton_id = $modelDireccion1->parroquia->canton->id;
                $lista_canton1 = CHtml::listData(Canton::model()->findAll(array(
                                    "condition" => "provincia_id =:provincia_id ",
                                    "order" => "nombre",
                                    "params" => array(':provincia_id' => $modelDireccion1->parroquia->canton->provincia->id,)
                                )), 'id', 'nombre');
                $lista_parroquia1 = CHtml::listData(Parroquia::model()->findAll(
                                        array(
                                            "condition" => "canton_id =:canton_id",
                                            "order" => "nombre",
                                            "params" => array(':canton_id' => $modelDireccion1->parroquia->canton->id,)
                                )), 'id', 'nombre');
                $lista_barrio1 = CHtml::listData(Barrio::model()->findAll(
                                        array(
                                            "condition" => "parroquia_id =:parroquia_id",
                                            "order" => "nombre",
                                            "params" => array(':parroquia_id' => $modelDireccion1->parroquia_id,)
                                )), 'id', 'nombre');
            }
        }
        ?>
        <div id="contenedor1">
            <div class="control-group ">
                <label class="control-label"><?php echo $form->labelEx($model, 'direccion_domicilio_id') ?></label>
                <div class="controls">
                    <?php echo $form->textField($modelDireccion1, 'calle_1', array('name' => 'Direccion1[calle_1]', 'maxlength' => 128, 'class' => 'span10', 'placeholder' => 'Calle Principal')) ?>  
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <?php echo $form->textField($modelDireccion1, 'calle_2', array('name' => 'Direccion1[calle_2]', 'maxlength' => 128, 'class' => 'span10', 'placeholder' => 'Calle Secundaria')) ?>  
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <?php echo $form->textField($modelDireccion1, 'numero', array('name' => 'Direccion1[numero]', 'maxlength' => 20, 'class' => 'span10', 'placeholder' => 'Número')) ?>  
                </div>
            </div>
            <div class="controls controls-row ">
                <div class=" control-group span5">
                    <?php
//                            var_dump($modelDireccion1);
                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'name' => 'Direccion1[provincia_id]',
                        'model' => $modelDireccion1,
                        'data' => $lista_provincia1,
                        'val' => $modelDireccion1->provincia_id,
                        'options' => array(
                            'placeholder' => '-- Provincia --',
                            'width' => '100%',
                        )
                            )
                    );
                    ?>
                    <?php echo $form->error($modelDireccion1, 'provincia_id'); ?>
                </div>
                <div class=" control-group span5">
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'name' => 'Direccion1[canton_id]',
                        'model' => $modelDireccion1,
                        'data' => $lista_canton1,
                        'val' => $modelDireccion1->canton_id,
                        'options' => array(
                            'placeholder' => '-- Canton --',
                            'width' => '100%',
                        )
                            )
                    );
//                        
                    ?>

                    <?php echo $form->error($modelDireccion1, 'canton_id'); ?>
                </div>
            </div>
            <div class="controls controls-row">
                <div class="control-group span5 row-fluid">
                    <!--<div class="span10">-->
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'name' => 'Direccion1[parroquia_id]',
                        'model' => $modelDireccion1,
                        'data' => $lista_parroquia1,
                        'val' => $modelDireccion1->parroquia_id,
                        'options' => array(
                            'placeholder' => '-- Parroquia --',
                            'width' => '77%',
                        )
                            )
                    );
                    ?>
                    &nbsp;
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbButton', array(
//            'label' => 'Add',
                        'id' => 'newParroquiaDomicilio',
                        'icon' => 'plus',
//            'type' => 'primary',
                        'htmlOptions' => array(
                            'data-html' => true,
                            'data-title' => '<i class="icon-map-marker"></i> Agregar Parroquia<button type="button" class="close" onclick="$(&quot;#newParroquiaDomicilio&quot;).popover(&quot;hide&quot;)" >&times;',
                            'data-placement' => 'left',
                            'data-content' =>
                            $this->renderPartial("crm.views.persona.popovers._formParroquiaCreate", array("model" => new Parroquia, 'buttomId' => 'newParroquiaDomicilio', 'control' => 'Direccion1_parroquia_id', 'nro' => 1), true, false),
//                     true si el resultado de la representación debe ser devuelto en vez de ser mostrado a los usuarios finales.
//                    flase si el resultado renderizado debe posprocesarlo usando processOutput .
                            'data-toggle' => 'popover'
                        ),
                            )
                    );
                    ?>

                    <?php echo $form->error($modelDireccion1, 'parroquia_id'); ?>
                </div>
                <div class="control-group  success span5">
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'name' => 'Direccion1[barrio_id]',
                        'model' => $modelDireccion1,
                        'data' => $lista_barrio1,
                        'val' => $modelDireccion1->barrio_id,
                        'options' => array(
                            'placeholder' => '-- Barrio --',
                            'width' => '100%',
                        )
                            )
                    );
                    ?>
                    <?php echo $form->error($modelDireccion1, 'barrio_id'); ?>
                </div>
            </div>
            <!--</div>-->
            <div class="control-group" >
                <div class="controls controls-row">
                    <div class="control-group span8">
                        <?php echo $form->textArea($modelDireccion1, 'referencia', array('name' => 'Direccion1[referencia]', 'class' => 'span12', 'placeholder' => 'Referencia')) ?>

                    </div>
                </div>
            </div>
        </div>
        <!--fin direccion 1-->
        <!--//inicio direccion 2-->
        <?php
        if ($modelDireccion2->isNewRecord) {
            $lista_provincia2 = CHtml::listData(Provincia::model()->findAll(), 'id', 'nombre');
            $lista_canton2 = null;
            $lista_parroquia2 = null;
            $lista_barrio2 = null;
        } else {
            $lista_provincia2 = CHtml::listData(Provincia::model()->findAll(), 'id', 'nombre');
            $lista_canton2 = null;
            $lista_parroquia2 = null;
            $lista_barrio2 = null;
            if ($modelDireccion2->parroquia_id) {
                $modelDireccion2->provincia_id = $modelDireccion2->parroquia->canton->provincia->id;
                $modelDireccion2->canton_id = $modelDireccion2->parroquia->canton->id;
                $lista_canton2 = CHtml::listData(Canton::model()->findAll(array(
                                    "condition" => "provincia_id =:provincia_id ",
                                    "order" => "nombre",
                                    "params" => array(':provincia_id' => $modelDireccion2->parroquia->canton->provincia->id,)
                                )), 'id', 'nombre');
                $lista_parroquia2 = CHtml::listData(Parroquia::model()->findAll(
                                        array(
                                            "condition" => "canton_id =:canton_id",
                                            "order" => "nombre",
                                            "params" => array(':canton_id' => $modelDireccion2->parroquia->canton->id,)
                                )), 'id', 'nombre');
                $lista_barrio2 = CHtml::listData(Barrio::model()->findAll(
                                        array(
                                            "condition" => "parroquia_id =:parroquia_id",
                                            "order" => "nombre",
                                            "params" => array(':parroquia_id' => $modelDireccion2->parroquia_id,)
                                )), 'id', 'nombre');
            }
        }
        ?>

        <div id="contenedor2">
            <div class="control-group ">
                <label class="control-label"><?php echo $form->labelEx($model, 'direccion_negocio_id') ?></label>
                <div class="controls">
                    <?php echo $form->textField($modelDireccion2, 'calle_1', array('name' => 'Direccion2[calle_1]', 'maxlength' => 128, 'class' => 'span10', 'placeholder' => 'Calle Principal')) ?>  
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <?php echo $form->textField($modelDireccion2, 'calle_2', array('name' => 'Direccion2[calle_2]', 'maxlength' => 128, 'class' => 'span10', 'placeholder' => 'Calle Secundaria')) ?>  
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <?php echo $form->textField($modelDireccion2, 'numero', array('name' => 'Direccion2[numero]', 'maxlength' => 20, 'class' => 'span10', 'placeholder' => 'Número')) ?>  
                </div>
            </div>
            <div class="controls controls-row">
                <div class=" control-group span5">
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'name' => 'Direccion2[provincia_id]',
                        'model' => $modelDireccion2,
                        'data' => $lista_provincia2,
                        'val' => $modelDireccion2->provincia_id,
                        'options' => array(
                            'placeholder' => '-- Provincia --',
                            'width' => '100%',
                        )
                            )
                    );
                    ?>
                    <?php echo $form->error($modelDireccion2, 'provincia_id'); ?>
                </div>
                <div class=" control-group span5">
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'name' => 'Direccion2[canton_id]',
                        'model' => $modelDireccion2,
                        'data' => $lista_canton2,
                        'val' => $modelDireccion2->canton_id,
                        'options' => array(
                            'placeholder' => '-- Canton --',
                            'width' => '100%',
                        )
                            )
                    );
//                        
                    ?>
                    <?php echo $form->error($modelDireccion2, 'canton_id'); ?>
                </div>
            </div>
            <div class="controls controls-row">
                <div class="control-group span5">
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'name' => 'Direccion2[parroquia_id]',
                        'model' => $modelDireccion2,
                        'data' => $lista_parroquia2,
                        'val' => $modelDireccion2->parroquia_id,
                        'options' => array(
                            'placeholder' => '-- Parroquia --',
                            'width' => '77%',
                        )
                            )
                    );
                    ?>
                    &nbsp;

                    <?php
                    $parroquiaPopover = new Parroquia;
                    if ($model->isNewRecord) {
                        $parroquiaPopover->canton_id = $modelDireccion2->canton_id;
                        $parroquiaPopover->provincia_id = $modelDireccion2->provincia_id;
                    }

                    $this->widget(
                            'bootstrap.widgets.TbButton', array(
//            'label' => 'Add',
                        'id' => 'newParroquiaNegocio',
                        'icon' => 'plus',
//            'type' => 'primary',
                        'htmlOptions' => array(
                            'data-html' => true,
                            'data-title' => '<i class="icon-map-marker"></i> Agregar Actividad<button type="button" class="close" onclick="$(&quot;#newParroquiaNegocio&quot;).popover(&quot;hide&quot;)" >&times;',
                            'data-placement' => 'left',
                            'data-content' =>
                            $this->renderPartial("crm.views.persona.popovers._formParroquiaCreate", array("model" => $parroquiaPopover, 'buttomId' => 'newParroquiaNegocio', 'control' => 'Direccion2_parroquia_id', 'nro' => 2), true, false),
//                     true si el resultado de la representación debe ser devuelto en vez de ser mostrado a los usuarios finales.
//                    flase si el resultado renderizado debe posprocesarlo usando processOutput .
                            'data-toggle' => 'popover'
                        ),
                            )
                    );
                    ?>
                    <?php echo $form->error($modelDireccion2, 'parroquia_id'); ?>
                </div>
                <div class="control-group  success span5">
                    <?php
                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'name' => 'Direccion2[barrio_id]',
                        'model' => $modelDireccion2,
                        'data' => $lista_barrio2,
                        'val' => $modelDireccion2->barrio_id,
                        'options' => array(
                            'placeholder' => '-- Barrio --',
                            'width' => '100%',
                        )
                            )
                    );
                    ?>
                    <?php echo $form->error($modelDireccion2, 'barrio_id'); ?>
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <div class="control-group span8">
                        <?php echo $form->textArea($modelDireccion2, 'referencia', array('name' => 'Direccion2[referencia]', 'class' => 'span12', 'placeholder' => 'Referencia')) ?>

                    </div>
                </div>
            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'descripcion', array('rows' => 3, 'cols' => 50, 'class' => 'span8')) ?>
    </div>              
    <div class="form-actions">
        <div class="form-actions-float">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'success',
                'label' => $model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
            ));
            ?>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'label' => Yii::t('AweCrud.app', 'Cancel'),
                'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
            ));
            ?>
        </div>
    </div>
</div>
</div>
<?php $this->endWidget(); ?>
