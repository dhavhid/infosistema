<br />
<div class="row">
    <div class="col-md-3">
        <a href="javascript:window.history.back();" class="btn btn-default">
            <i class="fa fa-times"></i>
            Cerrar
        </a>
        <a href="javascript:window.print();" class="btn btn-primary">
            <i class="fa fa-print"></i>
            Imprimir
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h2>Lista de tickets</h2>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-responsive footable">
            <thead>
                <tr>
                    <th>Ficha de proyecto</th>
                    <th>Fecha de apertura</th>
                    <th>Fecha de cierre</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $tickets as $ticket ):
                    ?>
                    <tr>
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
</div>

