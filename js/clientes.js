var idClienteActual
function Eliminar(idCliente)
{
  var activo =0;
    resetAlert();
    alertify.confirm("Estas seguro que deseas eliminar el cliente?", function (e) {
        if (e) {
            $.ajax({
                    type: "POST",
                    url: "php/DAO/clienteDAO.php",
                    data: "accion=bajaLogicaCliente&activo="+activo+"&idCliente="+idCliente,
                    async: false,
                    dataType: "json",
                    success: function(datos) {
                            if(datos.msj=='success')
                            {
                               ObetnerAllClientes(1,"tblClientesActivos");
                               Notificacion('success','Cliente eliminado exitosamente','Mensaje');
                            }
                           else
                              Notificacion('error','Error al intentar eliminar cliente','Mensaje');
                        } 
                    });
        }
    });
     
}

function Editar(idCliente)
{
  idClienteActual=null;
    $.ajax({
    type: "POST",
    url: "php/DAO/clienteDAO.php",
    data: "accion=obtenerUnCliente&idCliente="+idCliente,
    async: false,
    dataType: "json",
    success: function(datos) {
      LimpiaTabla("tblVehiculosActivos");
        var data ='';
          if(datos.estatus == 1){
            $.each(datos.Vehiculo, function(i, item) {
                  data+='<tr>';
                  data+='<td>'+(i+1)+'</td>';
                  data+='<td>'+item.marca+'</td>';
                  data+='<td>'+item.modelo+'</td>';
                  data+='<td>'+item.ano+'</td>';
                  data+='<td>'+item.placas+'</td>';
                  data+='</tr>'
                });

           $("#bodyVehiculos").html(data);
           idClienteActual=datos.idCliente;
           $('#nombre').val(datos.nombreCompleto);
           $('#usuario').val(datos.usuario);
           $('#mail').val(datos.mail);
           $('#fechaAlta').val(datos.fechaAlta);

          InicializaTabla("tblVehiculosActivos");    
          $('#addCliente').modal({  keyboard: false,})
          $('#addCliente').modal('show', {backdrop: 'static', keyboard: false});
          }else
            Notificacion('info',datos.msj,'Mensaje');
    }
    });
}

function actualizarCliente()
{
  if($("#formCliente").valid())
  {

    $.ajax({
        type: "POST",
        url: "php/DAO/clienteDAO.php",
        data: "accion=actualizarCliente&"+$("#formCliente").serialize()+"&idCliente="+idClienteActual,
        async: false,
        dataType: "json",
        success: function(datos) {
                      if(datos.msj=='success')
                      {
                         ObetnerAllClientes(1,"tblClientesActivos");
                         Notificacion('success','Cliente actualizado exitosamente','Mensaje');
                      }
                     else
                        Notificacion('error','error al acutalizar el Cliente','Mensaje');
                      
                      $('#addCliente').modal('hide');
         }
    });
  }
    
}


function ObetnerAllClientes(activo,tabla)
{
   $.ajax({
    type: "POST",
    url: "php/DAO/clienteDAO.php",
    data: "accion=obtenerClientes&acitvo="+activo,
    async: false,
    dataType: "json",
    success: function(datos) {
 
             var data ='';
             LimpiaTabla(tabla);
                $.each(datos, function(i, item) {
                    data+='<tr>';
                    data+='<td>'+(i+1)+'</td>';
                    data+='<td>'+item.nombreCompleto+'</td>';
                    //data+='<td>'+item.usuario+'</td>';
                    data+='<td>'+item.mail+'</td>';
                    data+='<td>'+item.fechaAlta+'</td>';
                    data+='<td><div align="center"><a href="javascript:Editar('+item.idCliente+');"><i class="entypo-search right" style="font-size: 25px;"></i></a>';
                    data+='&nbsp;&nbsp;&nbsp;<a href="javascript:Eliminar('+item.idCliente+');"><i class="fa fa-trash-o right" style="font-size: 25px;"></i></a>';
                    data+='</div></td></tr>';
                  });
         
                $("#"+tabla).find('tbody').html(data);
              InicializaTabla(tabla);

    }
    });
}


function ActualizarTabActual()
{
    if($('.nav-tabs').find('.active').attr('aprobado')==0)
        ObetnerAllChoferes(0,"tblChoferesSinAprobar");
     else
        ObetnerAllChoferes(1,"tblChoferesAprobados");

}

function initFormulario()
{
$("#formCliente").validate({
    rules: {
        nombre: "required",
        mail: {
        required: true,
        email: true
      }
    },
    messages: {
      nombre: "Porfavor especifique un nombre",
      mail: {
        required: "Porfavor especifique un e-mail",
        email: "no es un correo valido"
      }
    }
  });

}

$( document ).ready(function() {

// initFormulario();
/* identicar  el tab actual
   $('.nav-tabs').bind('click', function (e) {
    if($(this).find('.active').attr('aprobado')==1)
      ObetnerAllChoferes(0,"tblChoferesSinAprobar");
     else
        ObetnerAllChoferes(1,"tblChoferesAprobados");
 });
 */
    $('#aprobado').on('switch-change', function (e, data) {
      Notificacion((data.value == true ? 'success' : 'warning'),'usuario '+(data.value == true ? 'Activado' : 'Descativado'),'Mensaje');
       // alert(data.value);
    });



  $('#btnGuardarCliente').click(function(e) {
      actualizarCliente();
  });
 

InicializaTabla("tblClientesActivos");
//InicializaTabla("tblChoferesAprobados");

ObetnerAllClientes(1,"tblClientesActivos");

});


