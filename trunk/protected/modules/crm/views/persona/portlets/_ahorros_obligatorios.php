<?php
$ahorros = new Ahorro;
?>

<div class="widget green">
    <div class="widget-title">
        <h4><i class="icon-tasks"></i> Ahorros</h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--<a href="javascript:;" class="icon-remove"></a>-->
        </span>
    </div>
    <div class="widget-body">
        <div class="row-fluid">

            <?php $validarDataPagos = $ahorros->de_socio($model->id)->de_tipo(Ahorro::TIPO_OBLIGATORIO)->count() > 0 ?>
            <?php
            $this->widget(
                'bootstrap.widgets.TbButton', array(
                    'id' => 'add-Cobranza',
                    'label' => $validarDataPagos ? 'Agregar Ahorro' : '<h3 >Agregar Ahorro</h3>',
                    'encodeLabel' => false,
                    'icon' => $validarDataPagos ? 'plus-sign' : 'dollar',
                    'htmlOptions' => array(
                        'onClick' => 'js:viewModal("ahorro/ahorro/ajaxCreate/socio_id/' . $model->id . '",function(){'
                            . 'maskAttributes();},false)',
                        'class' => $validarDataPagos ? '' : 'empty-portlet',
                    ),
                )
            );
            ?>
            <?php if ($validarDataPagos): ?>
                <div style='overflow:auto'>

                    <?php
                    $dP = $ahorros->de_socio($model->id)->de_tipo(Ahorro::TIPO_OBLIGATORIO)->search();
                    $dP->pagination = false;
                    $this->widget('ext.bootstrap.widgets.TbGridView', array(
                        'id' => 'pago-grid',
                        'type' => 'striped bordered hover advance condensed',
                        'template' => '{summary}{items}{pager}',
                        'dataProvider' => $dP,
                        'columns' => array(
                            array(
                                'header' => 'Fecha',
                                'name' => 'fecha',
                                'value' => 'Util::FormatDate($data->fecha,"d/m/Y")',
                                'type' => 'raw',
                            ),
                            array(
                                'header' => 'Cantidad',
                                'name' => 'cantidad',
                                'value' => '$data->cantidad',
                                'type' => 'raw',
                            ),
                            array(
                                'header' => 'Pagado',
                                'name' => 'saldo_favor',
                                'value' => '$data->saldo_favor',
                                'type' => 'raw',
                            ),
                            array(
                                'header' => 'Por pagar',
                                'name' => 'saldo_contra',
                                'value' => '$data->saldo_contra',
                                'type' => 'raw',
                            ),
                            array(
                                'header' => 'Razón',
                                'name' => 'tipo',
                                'value' => '$data->tipo',
                                'type' => 'raw',
                            ),
                            'estado',
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{update}',
                                'buttons' => array(
                                    'update' => array(
                                        'label' => '<button class="btn btn-primary"><i class="icon-dollar"></i></button>',
                                        'options' => array('title' => 'Realizar deposito'),
                                        'url' => '"ahorro/ahorroDeposito/create?id_ahorro=".$data->id',
                                        'click' => 'function(e){e.preventDefault(); viewModalWidth($(this).attr("href"),function() {maskAttributes();}); return false;}',
                                        'imageUrl' => false,
                                        'visible' => '(($data->saldo_contra==0)||($data->estado=="PAGADO"))?false:true',
                                    ),
                                ),
                            ),
                        ),
                    ));
                    echo '<br/>';
                    ?>

                </div>
            <?php endif; ?>


        </div>
    </div>
</div>