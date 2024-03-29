<?php
$ahorros = new Ahorro;
?>
<?php $validarDataPagos = $ahorros->de_socio($model->id)->de_tipo(Ahorro::TIPO_PRIMER_PAGO)->count() > 0 ?>
<?php if ($validarDataPagos): ?>
    <div class="widget red">
        <div class="widget-title">
            <h4><i class="icon-tasks"></i> Ahorro Primer Pago</h4>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>
                <!--<a href="javascript:;" class="icon-remove"></a>-->
            </span>
        </div>
        <div class="widget-body">

            <div class="row-fluid">
                <div style='overflow:auto'> 
                    <?php
                    $this->widget('ext.bootstrap.widgets.TbGridView', array(
                        'id' => 'pago-grid',
//                        'afterAjaxUpdate' => "function(id,data){AjaxActualizarActividades();}",
                        'type' => 'striped bordered hover advance',
                        'dataProvider' => $ahorros->de_socio($model->id)->de_tipo(Ahorro::TIPO_PRIMER_PAGO)->search(),
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
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{update}',
                                'buttons' => array(
                                    'update' => array(
                                        'label' => '<button class="btn btn-primary"><i class="icon-dollar"></i></button>',
                                        'options' => array('title' => 'Realizar deposito'),
                                        'url' => '"ahorro/ahorroDeposito/create?id_ahorro=".$data->id',
                                        'click' => 'function(e){e.preventDefault(); viewModalWidth($(this).attr("href"),function() {maskAttributes();});  return false; }',
                                        'imageUrl' => false,
                                        'visible' => '($data->estado=="PAGADO")?false:true',
                                    ),
                                ),
                            ),
                        ),
                    ));
                    echo '<br/>';
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>