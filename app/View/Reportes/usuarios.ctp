<?php $this->Html->addCrumb('Reportes','/reportes',array('escape'=>false))?>
<?php $this->Html->addCrumb('Usuarios','/reportes/usuarios/',array('escape'=>false))?>
<?php $this->Html->addCrumb('Lista de usuarios',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php echo $this->Html->link('<i class="fa fa-print"></i> Imprimir lista',array('controller'=>'/admin/usuarios','action'=>'imprimir',$filtro),array('class'=>'btn btn-default','escape'=>false))?>
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
                    <th data-hide="phone,tablet"><?php echo $this->Paginator->sort('usuario','Usuario <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th><?php echo $this->Paginator->sort('primer_nombre','Nombre <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th data-hide="phone"><?php echo $this->Paginator->sort('correo_electronico','Correo electr&oacute;nico <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $personas as $persona ):
                    ?>
                    <tr>
                        <td><a href="/admin/usuarios/ver/<?php echo $persona['Persona']['id']?>"><i class="fa fa-eye"></i></a></td>
                        <td><?php echo $persona['Usuario']['usuario']?></td>
                        <td><?php echo $persona['Persona']['primer_nombre'] . ' ' . $persona['Persona']['primer_apellido']?></td>
                        <td><a href="mailto:<?php echo $persona['Persona']['correo_electronico']?>" target="_blank"><?php echo $persona['Persona']['correo_electronico']?></a></td>
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
