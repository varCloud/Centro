
function ObetnerAllUsuarios()
{
   $.ajax({
    type: "POST",
    url: "php/DAO/usuarioDAO.php",
    data: "accion=obtenerUsuarios&idSucursal="+($("#idSucursal").val() == '0' ? 'null' :$("#idSucursal").val() )+"&idRol="+$("#idRol").val(),
    async: false,
    dataType: "json",
    success: function(datos) {
           var data ='';
		   LimpiaTabla("tblUsuarios");
		   if(datos != null)
		   {
				  $.each(datos, function(i, item) {
					  data+='<tr>';
					  data+='<td>'+(i+1)+'</td>';
					  data+='<td>'+item.nombreCompleto+'</td>';
					  data+='<td>'+item.usuario+'</td>';
					  data+='<td>'+item.sucursal+'</td>';  
					  data+='<td>'+item.rol+'</td>'; 					  
					  data+='<td><div align="center"><a href="javascript:Editar('+item.idUsuario+');"><i class="fa fa-edit right" style="font-size: 25px;"></i></a>';
					  data+='&nbsp;&nbsp;&nbsp;<a href="javascript:Eliminar('+item.idUsuario+');"><i class="fa fa-trash-o right" style="font-size: 25px;"></i></a>';
					  data+='</div></td></tr>';
					});
		   
				  $("#tblUsuarios").find('tbody').html(data);
				   InicializaTabla("tblUsuarios");
		   }else
				 InicializaTabla("tblUsuarios");
    }
    });
}

function Eliminar(idUsuario)
{
  var activo =0;
    resetAlert();
    alertify.confirm("Estas seguro que deseas eliminar el usuario?", function (e) {
        if (e) {
            $.ajax({
                    type: "POST",
                    url: "php/DAO/usuarioDAO.php",
                    data: "accion=EliminarUsuario&idUsuario="+idUsuario,
                    async: false,
                    dataType: "json",
                    success: function(datos) {
                            if(datos.msj=='success')
                            {
							  ObetnerAllUsuarios();
                               Notificacion('success','Usuario eliminado exitosamente','Mensaje');
                            }
                           else
                              Notificacion('error','Error al intentar eliminar el usuario','Mensaje');
                        } 
                    });
        }
    });
     
}

function Editar(idUsuarioEditar)
{
	$("#idUsuarioEditar").val(idUsuarioEditar);
	$.ajax({
    type: "POST",
    url: "php/DAO/usuarioDAO.php",
    data: "accion=obtenerUnUsuario&idUsuario="+idUsuarioEditar,
    async: false,
    dataType: "json",
    success: function(datos) {
		
		Resetform("resetUs");
		$("#idUsuarioEditar").val(datos.idUsuario);
		$("#nombre").val(datos.nombreCompleto);
		$("#usuario").val(datos.usuario);
		$("#contra").val(datos.contrasena);
		$('#cbSucursal').val(datos.idSucursal);
		$('#cbSucursal').trigger('change');
		$('#cbRoles').val(datos.idRol);
		$('#cbRoles').trigger('change');
		$('#addUsuario').modal({  keyboard: false,})
		$('#addUsuario').modal('show', {backdrop: 'static', keyboard: false});
		
        }
    });	
}

function ObetnerAllRoles()
{
   $.ajax({
    type: "POST",
    url: "php/DAO/usuarioDAO.php",
    data: "accion=obtenerRoles&idUsuario="+$("#idUsuario").val(),
    async: false,
    dataType: "json",
    success: function(datos) {
             var data ='<option value=""></option>';
             data +='<optgroup label="Roles">';
                $.each(datos, function(i, item) {
                    data+='<option value='+item.idRol+'>'+item.descripcion+'</option>';
                  });
              data+='</optgroup>';

          $("#cbRoles").html(data);
          //$("#cbRoles").parent().find('div').css('width','100%');
    }
    });
}

function ObetnerAllSucursales()
{
   $.ajax({
    type: "POST",
    url: "php/DAO/usuarioDAO.php",
    data: "accion=obtenerSucursales&idUsuario="+$("#idUsuario").val(),
    async: false,
    dataType: "json",
    success: function(datos) {

			 var data ='<option value=""></option>';
             data +='<optgroup label="Seleccione una Sucursal">';
                $.each(datos, function(i, item) {
                    data+='<option value='+item.idSucursal+'>'+item.descripcion+'</option>';
                  });
              data+='</optgroup>';

          $("#cbSucursal").html(data);
	     //$("#cbRoles").parent().find('div').css('width','100%');
    }
    });
}

function guardarUS()
{
 if($("#frmUs").valid())
  {
	   $.ajax({
		type: "POST",
		url: "php/DAO/usuarioDAO.php",
		data: "accion=guardarUsuario&"+$("#frmUs").serialize(),
		async: false,
		dataType: "json",
		success: function(datos) {
			   if(datos.msj=='success')
                {
				   ObetnerAllUsuarios();
				   Notificacion('success','Usuario agregado exitosamente','Mensaje');
                }
                  else
					Notificacion('error','Error al intentar guardar al usuario','Mensaje');

			 $('#addUsuario').modal('hide');
		}
		});
  }
}

function initFormulario()
{
  $("#frmUs").validate({
      ignore: [], 
      rules: {
          cbRoles: {required: true,},
          contra: {required: true,},
          cbSucursal: {required: true,},
          usuario: {required: true,},
          nombre: {required: true,},
      },
      messages: {
        cbRoles: "Porfavor especifique un rol",
        contra: "Porfavor especifique una contraseña",
        cbSucursal: "Porfavor especifique una sucursal",
        usuario: "Porfavor especifique un usuario",
        nombre: "Porfavor especifique una nombre",

      },

       highlight: function(element){
          $(element).closest('.form-group').addClass('validate-has-error');
          $(element).closest('.form-group').find('label .error').addClass('validate-has-error');
         
        },
        
        unhighlight: function(element)
        {
          $(element).closest('.form-group').removeClass('validate-has-error');
          $(element).closest('.form-group').find('label .error').removeClass('validate-has-error');
        },

        errorPlacement: function(error, element) {
           $(error).addClass('validate-has-error');
            error.insertAfter(element);
        }

    });
}

$( document ).ready(function() {
	initFormulario();
 
    $('#aprobado').on('switch-change', function (e, data) {
      Notificacion((data.value == true ? 'success' : 'warning'),'usuario '+(data.value == true ? 'Activado' : 'Descativado'),'Mensaje');
    });

	
$('.select2').on('click', function (evt) {
	$(this).parent().find('.error').css('display','none');
});



  $('#btnAddUsuario').click(function(e) {
      Resetform("resetUs");
      $('#addUsuario').modal({  keyboard: false,})
      $('#addUsuario').modal('show', {backdrop: 'static', keyboard: false});
  });
  
  $('#btnGuardarUs').click(function(e) {
      guardarUS();
  });
 

InicializaTabla("tblUsuarios");
ObetnerAllUsuarios();
ObetnerAllRoles();
ObetnerAllSucursales();

});
