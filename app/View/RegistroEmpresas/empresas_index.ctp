<?php $this->Html->addCrumb('Empresas','/empresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Registro de Empresas','/empresas/registroempresas',array('escape'=>false))?>
<?php $this->Html->addCrumb('Lista de empresas',false,array('escape'=>false))?>
<div class="row">
    <div class="col-md-12"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php echo $this->Html->link('<i class="fa fa-building-o"></i> Nueva empresa',array('controller'=>'registroempresas','action'=>'perfil'),array('class'=>'btn btn-primary','escape'=>false))?>
        <?php echo $this->Html->link('<i class="fa fa-print"></i> Imprimir lista',array('controller'=>'registroempresas','action'=>'imprimir',$filtro),array('class'=>'btn btn-default','escape'=>false))?>
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
                    <th><?php echo $this->Paginator->sort('nombre_empresa','Empresa <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th data-hide="phone,tablet"><?php echo $this->Paginator->sort('nit','NIT <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th data-hide="phone"><?php echo $this->Paginator->sort('primer_nombre','Contacto <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th data-hide="phone,tablet"><?php echo $this->Paginator->sort('giro','Giro <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th data-hide="phone,tablet">Direcci&oacute;n</th>
                    <th>Tel&eacute;fono</th>
                    <th data-hide="phone">Correo electr&oacute;nico</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $empresas as $empresa ):
                    ?>
                    <tr>
                        <td>
                            <div class="btn-group">
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="fa fa-cog"></span>
                              </button>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="/empresas/registroempresas/ver/<?php echo $empresa['Empresa']['id']?>">Ver</a></li>
                                <li><a href="/empresas/registroempresas/perfil/<?php echo $empresa['Empresa']['id']?>">Editar</a></li>
                                <li><?php echo $this->Html->link('Eliminar',array('controller'=>'registroempresas','action'=>'eliminar',$empresa['Empresa']['id']),array('escape'=>false),'¿Está seguro que desea eliminar el registro de la empresa? Esta acción no se puede deshacer.')?></li>
                              </ul>
                            </div>
                        </td>
                        <td><?php echo $empresa['Empresa']['nombre_empresa']?></td>
                        <td><?php echo $empresa['Empresa']['nit']?></td>
                        <td><a href="/admin/usuarios/ver/<?php echo $empresa['Persona']['id']?>"><?php echo $empresa['Persona']['primer_nombre'] . ' ' . $empresa['Persona']['primer_apellido']?></a></td>
                        <td><?php echo $empresa['Empresa']['giro']?></td>
                        <td><?php echo $empresa['Empresa']['direccion_final'] . '<br />' . $empresa['Municipio']['nombre_municipio'] . '<br />' . $empresa['Departamento']['nombre_departamento'];?></td>
                        <td><a href="tel:<?php echo $empresa['Empresa']['telefono']?>"><?php echo $empresa['Empresa']['telefono']?></a></td>
                        <td><a href="mailto:<?php echo $empresa['Empresa']['correo_electronico']?>" target="_blank"><?php echo $empresa['Empresa']['correo_electronico']?></a></td>
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
