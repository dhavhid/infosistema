var validetta_obj = null;
$(document).ready(function(){
	// input masked elements
	$('input[data-inputmask="telefono"]').mask("9999-9999");
	// default validation
	validetta_obj = $('form').validetta({
		realTime : true,
		display: 'inline',
		onError: function(event){
			$('#mensajes_alerta').empty().append('<div class="alert alert-danger"><strong>Error:</strong> Existen errores en el formulario que desea enviar, por favor asegúrese de haber completado todos los campos obligatorios y haber digitado los datos correctamente.</div>');
			var body = $("html, body");
			body.animate({scrollTop:0}, '500', 'swing', function() {
				$(".alert-danger").delay(10000).fadeTo(1500, 0).slideUp(500, function(){
			        $(this).remove(); 
			    });
			});
		}
	});
	// automatically close alerts
	window.setTimeout(function() {
	    $(".alert-success,.alert-danger").fadeTo(1500, 0).slideUp(500, function(){
	        $(this).remove(); 
	    });
	}, 5000);
	$('.footable').footable();
	$('#btn_search').click(function(){
		var current_loc = window.document.location.href;
		if( $('#filtro') ){
			if( $('#filtro').val().length > 0 ){
				if( current_loc.indexOf('/index') != -1 ){
					var index_loc = current_loc.indexOf('/index');
					var cl = current_loc.substring(0,index_loc);
					window.document.location.href = cl + '/index/' + $('#filtro').val();
				}else{
					if( current_loc.substring(current_loc.length, (current_loc.length-1)) == '/' )
						window.document.location.href = window.location.href + 'index/' + $('#filtro').val();
					else
						window.document.location.href = window.location.href + '/index/' + $('#filtro').val();
				}	
			}else{
				var index_loc = current_loc.indexOf('/index');
				if( index_loc != -1 )
					window.document.location.href = current_loc.substring(0,index_loc);
				else
					window.document.location.href = window.location.href;
			}
		}
	});
	$('#filtro').keypress(function(ev) {
		var keycode = (ev.keyCode ? ev.keyCode : ev.which);
		if (keycode == '13') {
        	$('#btn_search').click();
        }
	});
});

function validar_file(oForm, exts, selector) {
	var _validFileExtensions = exts;
    var arrInputs = oForm.getElementsByTagName("input");
    if( selector == undefined || selector == null ){
    	selector = '#mensajes_alerta';
    } 
    for (var i = 0; i < arrInputs.length; i++) {
        var oInput = arrInputs[i];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }

                if (!blnValid) {
                    $(selector).append('<div class="alert alert-danger"><strong>Error:</strong> El archivo que est&aacute; tratando de adjuntar no es v&aacute;lido.</div>');
                    var body = $("html, body");
					body.animate({scrollTop:0}, '500', 'swing', function() {
						$(".alert-danger").delay(10000).fadeTo(1500, 0).slideUp(500, function(){
					        $(this).remove(); 
					    });
					});
                    return false;
                }
            }
        }
    }

    return true;
}

function getOptions( endpoint, obj, params, valor_vacio){
	$.ajax({
		"url":"/utilidades/"+endpoint+'/'+params+".json",
		"dataType": "json",
		"success": function(data,status,jqxhr){
			$(obj).empty();
			$(obj).append("<option value=''>"+valor_vacio+"</option>");
			if( data.length > 0 ){
				var content = '';
				$.each(data, function (i, item) {
					$(obj).append("<option value='"+item.id+"'>"+item.nombre+"</option>");
				});
			}//fin de data.length
		}// fin de success
	});
}
function setEditor(obj, params){
	var p = null;
	if( params == undefined || params == null ){
		p = {
	        height: 200,
	        toolbar: [
	            ['style', ['bold', 'italic', 'underline']],
	            ['para', ['ul', 'ol', 'paragraph']]
	        ]
	    }
	}else{
		p = params;
	}
	var e = $(obj).summernote(p);
    return e;
}
function isDate(txtDate)
{
    var currVal = txtDate;
    var today = new Date();
    if(currVal == '')
        return false;
    
    var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
    var dtArray = currVal.match(rxDatePattern); // is format OK?
    
    if (dtArray == null) 
        return false;
    
    //Checks for dd/mm/yyyy format.
    dtDay = dtArray[1];
    dtMonth= dtArray[3];
    dtYear = dtArray[5];        
    
    if (dtMonth < 1 || dtMonth > 12) 
        return false;
    else if (dtDay < 1 || dtDay> 31) 
        return false;
    else if(dtYear < today.getFullYear())
        return false
    else if( dtDay <= today.getDate() && dtMonth <= (today.getMonth()+1) && dtYear <= today.getFullYear() )
        return false
    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
        return false;
    else if (dtMonth == 2) 
    {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay> 29 || (dtDay ==29 && !isleap)) 
                return false;
    }
    return true;
}