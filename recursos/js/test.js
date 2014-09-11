$(document).ready(function() {
	var base_url = 'http://localhost/test/index.php/';
	var base_url_upload = 'http://localhost/test/uploads/';
    
    //Configuracion Datepicker
    $("#fecha_nac").datepicker({
				yearRange: "-40:+0",
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd-mm-yy'
	});
    
    //formatear el rut
    $('#rut').Rut();
    
    //Metodo para validar si ya existe un rut
    $.validator.addMethod("existe_rut", function(value, element) {
			var response = false;
			jQuery.ajax({
				url: base_url + 'home/existe_rut/' + $('#rut').val(),
				dataType: 'json',
				success: function(data, status) {
					response = data.status === "error" ? false : true
				},
				async: false
			});
			return response;
	}, "RUT ya ingresado");
    
    //Metodo para validar si ya existe un correo
    $.validator.addMethod("existe_mail", function(value, element) {
			var response = false;
			jQuery.ajax({
				url: base_url + 'home/existe_mail/' + $('#email').val(),
				dataType: 'json',
				success: function(data, status) {
					response = data.status === "error" ? false : true
				},
				async: false
			});
			return response;
	}, "Correo ya ingresado");
    
    //metodo personalizado para jquery.validate rut chileno
    $.validator.addMethod("rut", function(value, element) {
			return this.optional(element) || $.Rut.validar(value);
		}, 'RUT incorrecto');
        
	//metodo personalizado para jquery.validate fecha formato chileno
	$.validator.addMethod("chileanDate", function(value, element) {
	    	return value.match(/^\d{1,2}\-\d{1,2}\-\d{4}$/);
		}, "Porfavor ingrese el formato dd-mm-yyyy");
        
        
    //metodo personalizado para jquery.validate para aceptar solamente letras
	$.validator.addMethod("letras", function(value, element) {
			return value.match(/^[a-zA-Z]+$/);
		}, "Ingrese solo letras");
        
    
    //Validacion formulario
    $("#form_registro").validate({
        
        rules: {
				rut: {
					required: true,
                    rut: true,
                    existe_rut: true
				},
				nombre: {
					required: true,
                    letras: true
				},
                apellidos: {
					required: true,
                    letras: true
				},
                email: {
					required: true,
                    email: true
				},
				fecha_nac: {
					required: true,
                    chileanDate: true
				},
                fono: {
                    required: true,
                    number: true
                }
			},
			//mensajes personalizados par las validaciones 
			messages: {
				rut: {
					required: "Este campo es obligatorio"
				},
				nombre: {
					required: "Este campo es obligatorio"
				},
                apellidos: {
					required: "Este campo es obligatorio"
				},
                email: {
					required: "Este campo es obligatorio",
                    email: "Ingrese un mail valido"
				},
				fecha_nac: {
					required: "Este campo es obligatorio"
				},
                fono: {
                    required: "Este campo es obligatorio",
                    number: "Ingrese solamente numeros"
                }
			},

			submitHandler: function() {
			   
               $.ajaxFileUpload({
					url: base_url + 'home/ingresar_usuario',
					secureuri: false,
					fileElementId: 'userfile',
					dataType: 'json',
					//este plugin NO soporta serialize() para capturar los datos del form
					data: {
						'rut': $('#rut').val(),
						'nombre': $('#nombre').val(),
						'apellidos': $('#apellidos').val(),
						'email': $('#email').val(),
                        'fecha_nac': $('#fecha_nac').val(),
                        'fono': $('#fono').val()
					},
					success: function(data, status) {
					   
						if (data.status != 'error') {
							document.location = base_url + 'home/ficha_usuario/'+$('#rut').val();
						}else{
						    alert(data.msg);
						}
					}
				});
				return false;
               
			}
        
    });
});