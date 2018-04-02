<?php $this->Html->addCrumb('Administraci&oacute;n','/admin',array('escape'=>false))?>
<?php $this->Html->addCrumb('Actividades econ&oacute;micas','/admin/actividades/',array('escape'=>false))?>
<?php $this->Html->addCrumb('Lista de actividades',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php echo $this->Html->link('<i class="fa fa-download"></i> Importar',array('controller'=>'actividades','action'=>'importar'),array('class'=>'btn btn-primary','escape'=>false))?>
        <?php echo $this->Html->link('<i class="fa fa-print"></i> Imprimir lista',array('controller'=>'actividades','action'=>'imprimir',$filtro),array('class'=>'btn btn-default','escape'=>false))?>
    </div>
    <div class="col-md-4 col-md-offset-4 hidden-xs">
        <div class="input-group hidden-xs">
          <input type="text" class="form-control" id="filtro" name="filtro" value="<?php echo $filtro?>" placeholder="buscar">
          <span class="input-group-btn">
            <button class="btn btn-default" id="btn_search" type="button"><i class="fa fa-search"></i></button>
          </span>
        </div><!-- /input-group -->
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-responsive footable">
            <thead>
                <tr>
                    <th width="10px;" align="center"><i class="fa fa-cogs"></i></th>
                    <th><?php echo $this->Paginator->sort('actividad_codigo','C&oacute;digo <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th><?php echo $this->Paginator->sort('actividad_nombre','Actividad econ&oacute;mica <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th data-hide="phone"><?php echo $this->Paginator->sort('subactividad','Subcategor&iacute;a <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th data-hide="phone,tablet"><?php echo $this->Paginator->sort('actividad_principal','Categor&iacute;a <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $actividades as $actividad ):
                    ?>
                    <tr>
                        <td></td>
                        <td><?php echo $actividad['ActividadesEconomica']['actividad_codigo']?></td>
                        <td><?php echo $actividad['ActividadesEconomica']['actividad_nombre']?></td>
                        <td><?php echo $actividad['ActividadesEconomica']['subactividad']?></td>
                        <td><?php echo $actividad['ActividadesEconomica']['actividad_principal']?></td>
                    </tr>
                    <?php
                endforeach;    
                ?>
            </tbody>
        </table>
    </div>
    <?php //print_r($personas)?>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Paginator->numbers(array('first' => '1','separator'=>'&nbsp;&nbsp;|&nbsp;&nbsp;'));?>
    </div>
</div>
