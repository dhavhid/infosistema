<?php $this->Html->addCrumb('Reportes','/reportes',array('escape'=>false))?>
<?php $this->Html->addCrumb('Servicios Tecnol&oacute;gicos','/reportes/servicios',array('escape'=>false))?>
<?php $this->Html->addCrumb('Lista de servicios tecnol&oacute;gicos',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php echo $this->Html->link('<i class="fa fa-print"></i> Imprimir lista',array('controller'=>'/empresas/servicios','action'=>'imprimir',$filtro),array('class'=>'btn btn-default','escape'=>false))?>
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
                    <th><?php echo $this->Paginator->sort('nombre_servicio','Servicio Tecnol&oacute;gico <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th data-hide="phone,tablet"><?php echo $this->Paginator->sort('nombre_empresa','Empresa <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th data-hide="phone"><?php echo $this->Paginator->sort('precio_servicio','Precio <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $servicios as $servicio ):
                    ?>
                    <tr>
                        <td><a href="/empresas/servicios/ver/<?php echo $servicio['ServicioTecnologico']['id']?>"><i class="fa fa-eye"></i></a></td>
                        <td><?php echo $servicio['ServicioTecnologico']['nombre_servicio']?></td>
                        <td><?php echo $servicio['Empresa']['nombre_empresa']?></td>
                        <td><?php echo $this->Number->currency($servicio['ServicioTecnologico']['precio_servicio'], 'USD')?></td>
                    </tr>
                    <?php
                endforeach;    
                ?>
            </tbody>
        </table>
    </div>
    <?php //print_r($empresas)?>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Paginator->numbers(array('first' => '1','separator'=>'&nbsp;&nbsp;|&nbsp;&nbsp;'));?>
    </div>
</div>
