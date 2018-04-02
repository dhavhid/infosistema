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
        <h2><?php echo $ticket['Ticket']['ficha_proyecto']?></h2>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-5">
        Empresa solicitante: <br /><strong><?php echo $empresa['Empresa']['nombre_empresa']?></strong>
    </div>
    <div class="col-md-3">
        Estado: <br /><strong><?php echo $estados[$ticket['Ticket']['estado']]?></strong>
    </div>
    <div class="col-md-2">
        Prioridad: <br /><strong><?php echo ucwords($ticket['Ticket']['prioridad'])?></strong>
    </div>
    <div class="col-md-2">
        Fecha de apertura: <br /><strong><?php echo date('d-m-Y',strtotime($ticket['Ticket']['fecha_apertura']))?></strong>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-5">
        Monto acordado: <br /><strong><?php echo $this->Number->currency($ticket['Ticket']['monto_acordado'],'USD')?></strong>
    </div>
    <div class="col-md-3">
        Monto final: <br /><strong><?php echo $this->Number->currency($ticket['Ticket']['monto_final'],'USD')?></strong>
    </div>
    <div class="col-md-2">
        Fecha de cierre: <br /><strong><?php echo ( !empty($ticket['Ticket']['fecha_cierre']) && ($ticket['Ticket']['estado'] != 'abierto' || $ticket['Ticket']['estado'] == 'en espera' ) )? date('d-m-Y',strtotime($ticket['Ticket']['fecha_cierre'])) : '&mdash;';?></strong>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-5">
        Tiene Financiamiento: <br /><strong><?php echo ($ticket['Ticket']['financiamiento'] == 1)? 'Si':'No';?></strong>
    </div>
    <div class="col-md-7">
        Observaciones: <br /><strong><?php echo $ticket['Ticket']['observaciones_financiamiento']?></strong>
    </div>
</div>
<br />
<div class="row">
	<div class="col-md-12 servicioseleccionado"></div>
</div>
<hr />
<div class="row">
    <div class="col-md-12" id="mensajes">
        <?php 
        foreach( $mensajes as $mensaje ):
            $timeago = $this->Time->timeAgoInWords(strtotime($mensaje['Mensaje']['fecha_mensaje']));
            $timeago = str_replace(
                array('ago','years','year','months','month','days','day','hours','hour','minutes','minute','seconds','second','just now'), 
                array('','a&ntilde;os','a&ntilde;o','meses','mes','d&iacute;as','d&iacute;a','horas','hora','minutos','minuto','segundos','segundo','un momento'), 
                $timeago);
            ?>
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class=" pull-left fa fa-comments-o <?php echo ( $_COOKIE['Infosistema']['usuario'] == $mensaje['Usuario']['usuario'] )? '' : 'text-primary' ;?>"></i>
                        <strong class="<?php echo ( $_COOKIE['Infosistema']['usuario'] == $mensaje['Usuario']['usuario'] )? '' : 'text-primary' ;?>"><?php echo $mensaje['Persona']['primer_nombre'] . ' ' . $mensaje['Persona']['primer_apellido'] ?></strong> <small class="<?php echo ( $_COOKIE['Infosistema']['usuario'] == $mensaje['Usuario']['usuario'] )? '' : 'text-primary' ;?>">dijo</small><br />
                        <em class="<?php echo ( $_COOKIE['Infosistema']['usuario'] == $mensaje['Usuario']['usuario'] )? '' : 'text-primary' ;?>">hace <?php echo $timeago?></em>
                    </div>
                    <div class="panel-body"><?php echo $mensaje['Mensaje']['mensaje']?></div>   
                    <!-- Lista de adjuntos si existen -->
                    <?php if( is_array($mensaje['MensajesAdjunto']) && count($mensaje['MensajesAdjunto']) > 0 ){?>
                    <ul class="list-group">
                        <?php
                            foreach($mensaje['MensajesAdjunto'] as $adjunto){
                                ?>
                                <li class="list-group-item">
                                    <?php echo $this->Html->link('<i class="fa fa-download"></i> '.$adjunto['nombre_archivo'],array('controller'=>'tickets','action'=>'descargarArchivo',$mensaje['Mensaje']['id'],$adjunto['nombre_archivo']),array('escape'=>false))?>
                                    <small>(<?php echo $this->Number->toReadableSize($adjunto['tamano_archivo'])?>)</small>
                                </li>
                                <?php
                            }
                        ?>
                    </ul> 
                    <?php }?>
                    <?php if( is_array($mensaje['MensajesServicio']) && count($mensaje['MensajesServicio']) > 0 ){?>
		            	<ul class="list-group">
		            		<?php
								foreach( $mensaje['MensajesServicio'] as $servicio ){
									$seleccionado = ($servicio['servicio_seleccionado'] == 1)? 'list-group-item-info' : 'list-group-item-warning' ;
									?>
									<li class="list-group-item <?php echo $seleccionado?>">
										<?php if( $servicio['servicio_seleccionado'] == 0 && ($ticket['Ticket']['estado'] == 'abierto' || $ticket['Ticket']['estado'] == 'en espera') ):
											echo '<i class="fa fa-square-o"></i>';
										endif;
										if( $servicio['servicio_seleccionado'] == 1 ):
											echo '<i class="fa fa-check-square-o pull-right"></i>';
											$servicio_seleccionado = $servicio['ServicioTecnologico']['nombre_servicio'];
											$servicio_seleccionado_id = $servicio['ServicioTecnologico']['id'];
										endif;
										?>
										<?php echo $this->Html->link($servicio['ServicioTecnologico']['nombre_servicio'],array('controller'=>'empresas/servicios','action'=>'ver',$servicio['ServicioTecnologico']['id']),array('escape'=>false))?>
									</li>	
									<?php
								}                    		
		            		?>
		            	</ul>
                <?php }?>
                </div>   
            <?php
        endforeach;
        ?>
    </div>
</div>
<script type="text/javascript">
	<?php
	if( isset($servicio_seleccionado) && isset($servicio_seleccionado_id) )
		echo "var servicio_nombre = '{$servicio_seleccionado}'; var servicio_id = '{$servicio_seleccionado_id}';";
	else echo "var servicio_id = undefined;";
	?>
    $(document).ready(function(){
	    if( !isNaN(servicio_id) ){
        	$('.servicioseleccionado').html('Servicio tecnol&oacute;gico seleccionado: <br />');
			$('.servicioseleccionado').append( $('<a>',{"href":"/empresas/servicios/ver/"+servicio_id}).html(servicio_nombre) );
		}
    });
</script>