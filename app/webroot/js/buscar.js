$(document).ready(function(){
    $('.avanzada').toggle();
    $('#btn_avanzada').click(function(){
        $('.avanzada').slideToggle('slow');
    });
    $('#btn_buscar').click(function(){
        $(this).html('<i class="fa fa-spinner fa-spin"></i> Buscando ...');
        $('.resultados').html('<div class="col-md-2 col-md-offset-5" style="text-align:center;"><img src="/img/spin_80x80.gif" width="80"><br />Buscando ... </div>');
        $(this).attr('disabled','disabled');
        $('.avanzada').slideUp('slow');
        // serialize
        var tiposervicio = $('#tiposervicio:checked').map(function (_, el) {
            return $(el).val();
        }).get();
        var areas = $('#areas:checked').map(function (_, el) {
            return $(el).val();
        }).get();
        var laboratorios = $('#laboratorios:checked').map(function (_, el) {
            return $(el).val();
        }).get();
        var sectores = $('#sectores:checked').map(function (_, el) {
            return $(el).val();
        }).get();
        var subcategorias = $('#subcategorias:checked').map(function (_, el) {
            return $(el).val();
        }).get();
        var departamentos = $('#departamentos:checked').map(function (_, el) {
            return $(el).val();
        }).get();
        var tipoempresa = $('#tipoempresa:checked').map(function (_, el) {
            return $(el).val();
        }).get();
        /*console.log(tiposervicio);
        console.log(areas);
        console.log(laboratorios);
        console.log(sectores);
        console.log(subcategorias);
        console.log(departamentos);*/
        var params = {
            "filtro": $('#filtro').val(),
            "tipo_servicio": tiposervicio,
            "tipo_empresa": tipoempresa,
            "areas": areas,
            "laboratorios": laboratorios,
            "sectores": sectores,
            "subcategorias": subcategorias,
            "departamentos": departamentos,
            "ticket_id": $('#MensajeTicketId').val() || "0"
        };
        $.ajax({
            "url":"/busquedas/buscar.json",
            "data": params,
            "type": "POST",
            "dataType": "json",
            "success": function(data,status,jqxhr){
                //console.log(data);
                popularResultados(data);
            }// fin de success
        });
    });
});

function popularResultados( data ){
	
	var domUl = $('<ul>',{"class":"fa-ul"});
	
	if( data.length > 0 ){
        $.each(data, function (i, item) {
        	
        	var servicio = item.ServicioTecnologico;
        	var empresa = item.Empresa || null;
        	var ver_servicio = $('<a>',{"href":"/empresas/servicios/ver/"+servicio.id+'/0',"target":"_blank","class":"various fancybox.iframe"});
			if( empresa != null){
	        	var ver_empresa = $('<a>',{"href":"/empresas/registroempresas/ver/"+empresa.id+'/0',"target":"_blank","class":"various fancybox.iframe"});
	        	var c_electronico = $('<a>',{"href":"mailto:"+empresa.correo_electronico});
	        	var n_telefono = $('<a>',{"href":"tel:"+empresa.telefono});
	        }
        	
        	var li = $('<li>',{"class":"servicio"});
        	li.append( $('<i>',{"class":"fa-li fa fa-thumb-tack text-primary"}) );
        	li.append( ver_servicio.append($('<strong>').html(servicio.nombre_servicio)) );
        	li.append( $('<p>').append(servicio.descripcion_servicio) );
        	li.append( $('<p>').html('<em>Pasos para proveer el servicio tecnol&oacute;gico:</em> ' + servicio.pasos_servicio) );
        	li.append( $('<span>').html('<em>Precio:</em> ' + '$ ' + $.number(servicio.precio_servicio,2) ) );
        	if( empresa != null ){
	        	li.append( $('<span>').html('<br /><em>Empresa:</em> ').append(ver_empresa.html(empresa.nombre_empresa)) );
	        	li.append( $('<span>').html('<br /><em>Giro de la empresa:</em> ' + empresa.giro) );
	        	li.append( $('<span>').html('<br /><em>Tel&eacute;fono:</em> ').append(n_telefono.html(empresa.telefono)) );
	        	li.append( $('<span>').html('<br /><em>Correo electr&oacute;nico:</em> ').append(c_electronico.html(empresa.correo_electronico)) );
			}	
			if( !isNaN($('#MensajeTicketId').val()) ){// crear boton para sugerir servicio tecnologico
				var button = $('<button>',{"class":"btn btn-info"}).html('Sugerir este servicio tecnol&oacute;gico').click(function(){
					
					$.ajax({
			            "url":"/tickets/servicio_agregado.json",
			            "data": {"servicio_id":servicio.id,"ticket_id":$('#MensajeTicketId').val()},
			            "type": "POST",
			            "dataType": "json",
			            "success": function(data,status,jqxhr){
			            	console.log(data);
			                if(data.n_servicios == '0'){
				                $('#area_mensaje').html('');
								editor.code('');
								$('#MensajesServicioServicioId').val( servicio.id );
								$('div#nombre_servicio').empty().html('<strong>' + servicio.nombre_servicio + '</strong>');	
								$('#myModal').modal('show');
			                }else{
				                if( confirm('El servicio tecnológico ya fue sugerido en este ticket. Está seguro que desea sugerirlo nuevamente?') ){
					                $('#area_mensaje').html('');
									editor.code('');
									$('#MensajesServicioServicioId').val( servicio.id );
									$('div#nombre_servicio').empty().html('<strong>' + servicio.nombre_servicio + '</strong>');
									$('#myModal').modal('show');
				                }
			                }// fin de n_servicios
			            }// fin de success
			        });
			        
					// fin de click de boton sugerir servicio
				});
				li.append(
					$('<p>').append( button )	
				);	
			}
			
			domUl.append(li);
        });
    }//fin de data.length
    else{
    	var li = $('<li>');
    	li.append( $('<h5>',{"class":"text-info"}).html('<i class="fa fa-frown-o"></i> &rarr; No se encontraron resultados.') );
    	domUl.append(li);
    }
    var div12 = $('<div>',{"class":"col-md-12"});
    div12.append(domUl);
    $('.resultados').empty().append(div12);
    $('#btn_buscar').html('<i class="fa fa-search"></i> Buscar').removeAttr('disabled');
    $(".various").fancybox({
		fitToView	: true,
		width		: '95%',
		height		: '90%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
}