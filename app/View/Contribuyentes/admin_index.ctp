<?php $this->Html->addCrumb('Administraci&oacute;n','/admin',array('escape'=>false))?>
<?php $this->Html->addCrumb('Contribuyentes','/admin/contribuyentes/',array('escape'=>false))?>
<?php $this->Html->addCrumb('Lista de contribuyentes',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php echo $this->Html->link('<i class="fa fa-download"></i> Importar',array('controller'=>'contribuyentes','action'=>'importar'),array('class'=>'btn btn-primary','escape'=>false))?>
        <?php echo $this->Html->link('<i class="fa fa-print"></i> Imprimir lista',array('controller'=>'contribuyentes','action'=>'imprimir',$filtro),array('class'=>'btn btn-default','escape'=>false))?>
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
                    <th><?php echo $this->Paginator->sort('nit','NIT <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th><?php echo $this->Paginator->sort('contribuyente_nombre','Contribuyente <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $contribuyentes as $contribuyente ):
                    ?>
                    <tr>
                        <td><?php echo $contribuyente['Contribuyente']['nit']?></td>
                        <td><?php echo $contribuyente['Contribuyente']['contribuyente_nombre']?></td>
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
