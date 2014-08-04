<?php
/** @var PersonaController $this */
/** @var Persona $model */
?>
<div class="row-fluid">
    <div class="span12">
        <h1 class="name-title"><i class="icon-user"></i> <?php echo $model->nombre_corto ?></h1>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <?php $this->renderPartial('portlets/_info', array('model' => $model)); ?>
    </div>

    <div class="span6">
        <?php $this->renderPartial('portlets/_pagos', array('model' => $model)); ?>
    </div>
</div>