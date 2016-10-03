var idDptoActual
var idSucursal
function Eliminar(idDpto)
{
  var activo =0;
    resetAlert();
    alertify.confirm("Estas seguro que deseas eliminar el cliente?", function (e) {
        if (e) {
            $.ajax({
                    type: "POST",
                    url: "php/DAO/dptosDAO.php",
                    data: "accion=bajaLogicaDpto&activo="+activo+"&idDpto="+idDpto,
                    async: false,
                    dataType: "json",
                    success: function(datos) {
                            if(datos.msj=='success')
                            {
                               ObetnerAllDepartamentos();
                               Notificacion('success','Cliente eliminado exitosamente','Mensaje');
                            }
                           else
                              Notificacion('error','Error al intentar eliminar cliente','Mensaje');
                        } 
                    });
        }
    });
     
}

function Editar(idDpto,idSucu)
{

var validator = $( "#formDpto" ).validate();
validator.resetForm();

    idDptoActual=idDpto;
    idSucursal= idSucu;
    $.ajax({
    type: "POST",
    url: "php/DAO/dptosDAO.php",
    data: "accion=obtenerUnDpto&idDpto="+idDpto,
    async: false,
    dataType: "json",
    success: function(datos) {

          $('#dpto').val(datos.descripcion);
          $('#telefono').val(datos.telefono);   
          $('#btnGuardarDpto').css('display','none');
          $('#btnActualizarDpto').css('display','inline');
          $('#addDpto').modal({  keyboard: false,})
          $('#addDpto').modal('show', {backdrop: 'static', keyboard: false});
    }
    });
}

function guardarDpto(esActualizacion)
{
  if($("#formDpto").valid())
  {
    $.ajax({
        type: "POST",
        url: "php/DAO/dptosDAO.php",
        data: "accion="+(esActualizacion ? "actualizarDpto" : "guardar")+"&"+$("#formDpto").serialize()+"&idDpto="+idDptoActual,
        async: false,
        dataType: "json",
        success: function(datos) {
                      if(datos.msj=='success')
                      {
                         ObetnerAllDepartamentos()
                         Notificacion('success','Cliente actualizado exitosamente','Mensaje');
                      }
                     else
                        Notificacion('error','error al acutalizar el Cliente','Mensaje');
                      
                      $('#addDpto').modal('hide');
         }
    });
  }
    
}


function initFormulario()
{
$("#formDpto").validate({
    rules: {
        dpto: "required",
        telefono: {
        required: true,
        number: true
      }
    },
    messages: {
      dpto: "Porfavor especifique un departamento",
      telefono: {
                  required: "Porfavor especifique un telefono",
                  number: "el telefono solo puede tener digitos"
                }
    },

     highlight: function(element){
        $(element).closest('.form-group').addClass('validate-has-error');
        $(element).closest('.form-group').find('.error').addClass('validate-has-error');
      },
      
      unhighlight: function(element)
      {
        $(element).closest('.form-group').removeClass('validate-has-error');
        $(element).closest('.form-group').find('.error').removeClass('validate-has-error');
      },
      
  });

}


function ObetnerAllDepartamentos()
{
   $.ajax({
    type: "POST",
    url: "php/DAO/dptosDAO.php",
    data: "accion=obtenerDepartamentos",
    async: false,
    dataType: "json",
    success: function(datos) {
             LimpiaTabla("tblDptos");
             var data ='';
               $.each(datos, function(i, item) {
                  data+='<tr>';
                  data+='<td>'+(i+1)+'</td>';
                  data+='<td>'+item.descripcion+'</td>';
                  data+='<td>'+item.telefono+'</td>';
                  data+='<td>'+(item.desc_sucursal ===null ? 'Departamento sin asignar' : item.desc_sucursal)+'</td>';
                  data+='<td><div align="center"><a href="javascript:Editar('+item.idDpto+','+item.idSucursal+');"><i class="fa fa-edit right" style="font-size: 25px;"></i></a>';
                  data+='&nbsp;&nbsp;&nbsp;<a href="javascript:Eliminar('+item.idDpto+','+item.idSucursal+');"><i class="fa fa-trash-o right" style="font-size: 25px;"></i></a>';
                  data+='</div></td>';
                  data+='</tr>'
                });
               $("#bodyDpto").html(data);
               InicializaTabla("tblDptos");
    }
    });
}



$( document ).ready(function() {

  //initFormulario();

 $('#btnAddDpto').click(function(e) {
      Resetform("resetFrmDpto");
      $('#btnGuardarDpto').css('display','inline');
      $('#btnActualizarDpto').css('display','none');
      $('#resetFrmDpto').trigger('click');
      $('#addDpto').modal({  keyboard: false,})
      $('#addDpto').modal('show', {backdrop: 'static', keyboard: false});

  });


    $('#aprobado').on('switch-change', function (e, data) {
      Notificacion((data.value == true ? 'success' : 'warning'),'usuario '+(data.value == true ? 'Activado' : 'Descativado'),'Mensaje');
    });



  $('#btnGuardarDpto').click(function(e) {
      guardarDpto(false);
  });

  $('#btnActualizarDpto').click(function(e) {
      guardarDpto(true);
  });

//$("#cbClientes").select2();
//$("#cbVehiculos").select2();
//$("#cbVehiculos").parent().find('div').css('width','100%');

//$('#cbClientes').on('change', function (evt) {
//    ObtenerVehiculos($('#cbClientes').val());
//});

InicializaTabla("tblDptos");
ObetnerAllDepartamentos();



});


