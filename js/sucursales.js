var HorarioOficina = 2;
var HorarioCorrido = 1;
var selectAll=false;
var Tipico ='Tipico';
var Avanzado='Avanzado';
var tabAcutal='Avanzado';
var cal = {calendario: []};
var esActualizacion = false;
var sucursalActual;
var geocoder = new google.maps.Geocoder();

function limpiarForm(){
	
	$(".form-group").removeClass('validate-has-error'); 
	$(".form-group").find('.validate-has-error').css('display','none');
	
	 $('#sucursal').val('');
	 $('#telefono').val('');
	 $('#direccion').val('');
	 
}



function Editar(idProyecto)
{
    $.ajax({
            type: "POST",
            url: "php/DAO/centrosDAO.php",
            data: "accion=obtenerProyectos&idProyecto="+idProyecto,
            async: false,
            dataType: "json",
            success: function(datos) {
                   var data ='';
        					  limpiarForm();
                             $('#titulo').val(datos[0].descripcion);
                             $("#direccion").val(datos[0].tiempoEntreCitas);
                             $("#lon").val(datos[0].lon),
                             $("#lati").val(datos[0].lati),
                             $("#descripcion").val(datos[0].descripcion),
                             $("#face").val(datos[0].urlFacebook),
                             $("#google").val(datos[0].colonia),
                             $("#inst").val(datos[0].tiempoEntreCitas),
                             alert(JSON.stringify(datos[0].files));
                    $('#fileupload').fileupload('option', 'done').call('#fileupload', $.Event('done'), {result: datos[0].files});
                    $('#addProyecto').modal({  keyboard: false,});
                    $('#addProyecto').modal('show', {backdrop: 'static'});

            }
    });
}

function Eliminar(idProyecto)
{
    resetAlert();
    alertify.confirm("Esta usted seguro que deseas eliminar el Proyecto ?", function (e) {
        if (e) {
            $.ajax({
                    type: "POST",
                    url: "php/DAO/centrosDAO.php",
                    data: "accion=eliminarProyecto&idProyecto="+idProyecto,
                    async: false,
                    dataType: "json",
                    success: function(datos) {
                            if(datos.msj=='ok')
                            {
                               ObetnerProyectos(null);
                               Notificacion('success','Proyecto eliminado exitosamente','Mensaje');
                            }
                           else
                              Notificacion('error','Espere un momento y vuelva a intentarlo ','Mensaje');
                        } 
                    });
        }
    });
     
}

function ObetnerProyectos(idProyecto)
{
	var disabled = '';

		
   $.ajax({
    type: "POST",
    url: "php/DAO/centrosDAO.php",
    data: "accion=obtenerProyectos&idProyecto="+idProyecto,
    async: false,
    dataType: "json",
    success: function(datos) {
           var data ='';
           LimpiaTabla("tblProyectos");
    		   if(datos != null)
    		   {
                  $.each(datos, function(i, item) {
                      data+='<tr>';
                      data+='<td>'+(i+1)+'</td>';
                      data+='<td>'+item.titulo+'</td>';
                      data+='<td>'+item.descripcion+'</td>';
                      data+='<td>'+item.direccion+'</td>';
                      data+='<td>'+item.urlImagenPrincipal+'</td>';
                      data+='<td><div align="center">';
                      data+='   <button '+disabled+' class="btn btn-blue '+disabled+' " onclick="Editar('+item.idProyecto+')"  type="button" id="btnEditServicio">';
                      data+='     <i class="fa fa-edit right" style="font-size: 20px;"></i>';
                      data+='   </button>';
                      data+='   &nbsp;&nbsp;&nbsp;'; 
                      data+='   <button  class="btn btn-black " onclick="obtenerCoordenadasChofer('+item.idProyecto+')"  type="button" id="btnEditServicio">';
                      data+='     <i class="fa fa-map-marker right" style="font-size: 20px;"></i>';
                      data+='   </button>';
                      data+='   &nbsp;&nbsp;&nbsp;';
                      data+=    '<button '+disabled+' class="btn btn-red '+disabled+' " onclick="Eliminar('+item.idProyecto+')"  type="button" id="btnEditServicio">';
                      data+='     <i class="fa fa-trash-o right "  style="font-size: 20px;"></i>';
                      data+='   </button>' ;
                      data+='</div></td></tr>';
                    });

                  $("#bodyProy").html(data);
                   InicializaTabla("tblProyectos");
    		   }else
    			     InicializaTabla("tblProyectos");
    }
    });
}

function Guardar(esActualizacion,idSucursal)
{
  cal.proyectos=[];

  $('tbody.files tr').each(function(i, e) {
    var name = $(e).find('td').find('span.preview').find('a').attr('title'); 
    var size = $(e).find('td').find('span.size').text();
    var url = $(e).find('td').find('span.preview').find('a').attr('href');  
    var thumbnailUrl = $(e).find('td').find('span.preview').find('a').find('img ').attr('src');  
    var deleteUrl = $(e).find('td').find('button').attr('data-url');

    cal.proyectos.push({ 
              "name" : name,
              "size":size,
              "url"  :url,
              "thumbnailUrl": thumbnailUrl,
              "deleteUrl"  :deleteUrl,
              "deleteType" : "DELETE"                
          });
    });




  if($("#formProyecto").valid())
  {
	    var count = Object.keys(cal.proyectos).length;
	   	if(count > 0)
	   	{
  			  geocoder.geocode({ 'address': $("#direccion").val() }, function (results, status) {
  				if (status == google.maps.GeocoderStatus.OK) {
  					 $("#lat").val(results[0].geometry.location.lat());
  					 $("#lng").val(results[0].geometry.location.lng());
  					 $.ajax({
  					  type: "POST",
  					  url: "php/DAO/centrosDAO.php",
  					  data: "urlImagen=tyhrthtyh&imgProyecto="+JSON.stringify(cal.proyectos)+"&accion=guardar&"+$("#formProyecto").serialize(),
  					  async: false,
  					  dataType: "json",
  					  success: function(datos) {
  						  $('#addSucu').modal('hide');
  						  Notificacion('success',"Sucursal Guardada Exitosamente",'Mensaje');
  						  ObetnerProyectos();
                LimpiarTablaFiles();
  					  }
  				  });
  				}else
  					 Notificacion('error',"La direccion de la agencia no es valida ",'Mensaje');
  			});
      }else
           Notificacion('error','Necesitar agregar imagenes al proyecto','Mensaje');
  }
}

function validaRangos(fila)
{ 
    var bandera = 0;
         $("#tblCalendario tbody tr").each(function (index) 
        {
           var check =  $(this).find("td:eq(" +0+ ")").find('div').find('input[type=checkbox]');

           if($(check).val()==='true'){

                  var tipoCalendario = $(this).find("td:eq(" +2+ ")").find('select');
                  var rangoMin = $(this).find("td:eq(" + 3+ ")").find('div').find('input[type=text]');
                  var rangoMax = $(this).find("td:eq(" + 4+ ")").find('div').find('input[type=text]');
                  //var fecha1 = new Date('1/1/1990 '+$(rangoMin).data("timepicker").getTime());
                  //var fecha2 = new Date('1/1/1990 '+$(rangoMax).data("timepicker").getTime());
                  var fecha1 = new Date('1/1/1990 '+$(rangoMin).val());
                  var fecha2 = new Date('1/1/1990 '+$(rangoMax).val());
                  if(fecha1 >= fecha2)
                  {
                       $(this).find("td:eq(" + 4+ ")").find('div').addClass('validate-has-error');
                       $(rangoMin).attr('aria-invalid','true');
                       bandera ++;
                  }
                  
                  if($(tipoCalendario).val()==2)
                  {
                      //alert($(tipoCalendario).val());
                      rangoMin = $(this).find("td:eq(" + 5+ ")").find('div').find('input[type=text]');
                      rangoMax = $(this).find("td:eq(" + 6+ ")").find('div').find('input[type=text]');
                      fecha1 = new Date('1/1/1990 '+$(rangoMin).val());
                      fecha2 = new Date('1/1/1990 '+$(rangoMax).val());
                      if(fecha1 >= fecha2) {
                           $(this).find("td:eq(" + 6+ ")").find('div').addClass('validate-has-error');
                           $(rangoMin).attr('aria-invalid','true');
                           bandera ++;
                       }
                  }
              }
          });
       

         if(bandera !=0)
        {
            Notificacion('error',' No coinciden algunos rangos ','Mensaje');
            return false;
        }
        return true;
}

function Asignar()
{
     $.ajax({
          type: "POST",
          url: "php/DAO/sucuDAO.php",
          data: "accion=asignarDpto&idSucursal="+sucursalActual+"&"+$("#formAddDpto").serialize(),
          async: false,
          dataType: "json",
          success: function(datos) {

              $('#addDpto').modal('hide');
              Notificacion('success',"Departamentos asignados exitosamente",'Mensaje');
              ObetnerAllSucursales();
          }
      });

}

function LimpiarTablaFiles()
{
   $(".template-download").remove();
   
   $('#fileupload').fileupload({
        url: 'fu/server/php/index.php'
    });
}





$( document ).ready(function() {


google.maps.event.addDomListener(window, 'load', function () {
		 new google.maps.places.SearchBox(document.getElementById('direccion'));
		directionsDisplay = new google.maps.DirectionsRenderer({ 'draggable': true });
	});
		
$('input.icheck-2').iCheck({
    checkboxClass: 'icheckbox_square-blue',

});

$('input.icheck-2').on('ifChecked', function(event){
   $(this).val(true);
});

$('input.icheck-2').on('ifUnchecked', function(event){
   $(this).val(false);
});


$('#btnAddProyecto').click( function(e) {
    $('#btnActualizar').css('display','none');
    $('#btnGuardar').css('display','');
    $('#addProyecto').modal({  keyboard: false,});
    $('#addProyecto').modal('show', {backdrop: 'static'});

});

$('#btnActualizar').click( function(e) {
    Guardar(true);
});

$('#btnGuardar').click( function(e) {
    Guardar(false);
});


$('#btnAsignarDpto').click( function(e) {
   Asignar();
});



$('#btnCheckAll').click( function(e) {
        e.preventDefault(); 
        if(selectAll==false)
        {
            selectAll=true;
            $('.icheck-11').attr('checked','true');
            selectUnSelect(true);
             $('#btnCheckAll').find('i').removeClass('glyphicon glyphicon-check');
            $('#btnCheckAll').find('i').addClass('glyphicon glyphicon-unchecked');

        }else
        {
            selectAll=false;
            $('.icheck-11').attr('checked','false');
            selectUnSelect(false);
            $('#btnCheckAll').find('i').removeClass('glyphicon glyphicon-unchecked');
            $('#btnCheckAll').find('i').addClass('glyphicon glyphicon-check');
        }

        return false; 
});

        $("#headerMinTipico").css('display','none');
        $("#headerMaxTipico").css('display','none');
        $("#headerMin").css('display','none');
        $("#headerMax").css('display','none');

          $('input.icheck-11').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-yellow'
        });

InicializaTabla("tblProyectos");
ObetnerProyectos(null);
});


