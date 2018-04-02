<?php $this->Html->addCrumb('Reportes','/reportes',array('escape'=>false))?>
<?php $this->Html->addCrumb('Tickets','/tickets',array('escape'=>false))?>
<?php $this->Html->addCrumb('Lista de tickets','/tickets',array('escape'=>false))?>
<div class="row">
    <div class="col-md-12"><?php echo $this->Session->flash()?></div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php echo $this->Html->link('<i class="fa fa-print"></i> Imprimir lista',array('controller'=>'tickets','action'=>'imprimir',$filtro),array('class'=>'btn btn-default','escape'=>false))?>
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
                    <th><?php echo $this->Paginator->sort('ficha_proyecto','Ficha de proyecto <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th><?php echo $this->Paginator->sort('fecha_apertura','Fecha de apertura <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th data-hide="tablet"><?php echo $this->Paginator->sort('fecha_cierre','Fecha de cierre <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th data-hide="phone,tablet"><?php echo $this->Paginator->sort('estado','Estado <i class="pull-right fa fa-unsorted"></i>',array('escape'=>false))?></th>
                    <th data-hide="phone,tablet">Prioridad</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $tickets as $ticket ):
                    ?>
                    <tr>
                        <td><a href="/tickets/imprimir_ticket/<?php echo $ticket['Ticket']['id']?>"><i class="fa fa-eye"></i></a></td>
                        <td><?php echo $ticket['Ticket']['ficha_proyecto']?></td>
                        <td><?php echo date('d-m-Y',strtotime($ticket['Ticket']['fecha_apertura']))?></td>
                        <td><?php echo (!empty($ticket['Ticket']['fecha_cierre']) && ($ticket['Ticket']['estado'] != 'abierto' && $ticket['Ticket']['estado'] != 'en espera'))? date('d-m-Y',strtotime($ticket['Ticket']['fecha_cierre'])) : '&mdash;' ;?></td>
                        <td><?php echo $estados[$ticket['Ticket']['estado']]?></td>
                        <td><?php echo ucwords($ticket['Ticket']['prioridad'])?></td>
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
