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
	 
	 $("#tblCalendario tbody tr").each(function (index) 
	{
			 var check =  $(this).find("td:eq(" +0+ ")").find('div').find('input[type=checkbox]');
			 $(check).iCheck('uncheck');
			 var tipoCalendario = $(this).find("td:eq(" +2+ ")").find('select');
			 var selectBox = $(tipoCalendario).data("selectBox-selectBoxIt");
			 selectBox.selectOption(1);
			 var rangoMin = $(this).find("td:eq(" + 3+ ")").find('div').find('input[type=text]');
			 var rangoMax = $(this).find("td:eq(" + 4+ ")").find('div').find('input[type=text]');
			 $(rangoMin).val('9:00');
			 $(rangoMax).val('9:00');
				 //$(rangoMin).data("timepicker").setTime(datos[index].horaMinOfi);
				 //$(rangoMax).data("timepicker").setTime(datos[index].horaMaxOfi);
			 
			 /*var rangoMin = $(this).find("td:eq(" + 3+ ")").find('div').find('input[type=text]');
			 var rangoMax = $(this).find("td:eq(" + 4+ ")").find('div').find('input[type=text]');
			 $(rangoMin).val(datos[index].horaMin);
			 $(rangoMax).val(datos[index].horaMax); */
		 

	});

	
}

function StyleTabla(tipoHorario)
{


    if(exisreHorarioOfician() >0 && tipoHorario ==HorarioOficina){
         $("#sizeAddSucu").css('width', '60%');
         if(tabAcutal == Avanzado)
         {
            $("#headerMin").css('display','');
            $("#headerMax").css('display','');
        }else
        {
            $("#headerMinTipico").css('display','');
            $("#headerMaxTipico").css('display','');
        }
    }else
    {
        if(exisreHorarioOfician() == 0 && tipoHorario ==HorarioCorrido)
        {
            $("#sizeAddSucu").css('width','600px');
            if(tabAcutal == Avanzado){
                $("#headerMin").css('display','none');
                $("#headerMax").css('display','none');
             }else
             {
                 $("#headerMinTipico").css('display','none');
                 $("#headerMaxTipico").css('display','none');
             }
        }
    }
    
}

function exisreHorarioOfician()
{
    existe=0;
    var nombreTabla ='';
    if(tabAcutal == Avanzado)
        nombreTabla = 'tblCalendario';
    else
        nombreTabla = 'tblCalendarioTipico';

     $("#"+nombreTabla+" tbody tr").each(function (index) 
        {
            if($(this).find("td:eq(" + 5 + ")").length > 0)
            {
                    existe++;
            }
        });
     return existe;
}

function CrearObj()
{
     cal.calendario=[];
    $("#tblCalendario tbody tr").each(function (index) 
        {
            var dia_desc,dia,horaMin,horaMax,tipoHorario,horaMinOfi,horaMaxOfi;
            horaMinOfi=0;
            horaMaxOfi=0;
            var check;
            check=$(this).find("td:eq(" +0+ ")").find('div').find('input[type=checkbox]');
            if($(check).val() === 'true')
            {
                $(this).children("td").each(function (index2) 
                {
                   
                    switch (index2) 
                    {
                        case 0: 
                             dia = index+1//$(this).text();
                             break;
                        case 1: 
                            dia_desc = $(this).text();
                                break;
                        case 2: 
                                tipoHorario = $(this).find('select').val();
                                break;
                        case 3: 
                                horaMin = $(this).find('div').find('input[type=text]').val();
                                break;
                        case 4: 
                                horaMax = $(this).find('div').find('input[type=text]').val();
                                break;
                        case 5: 
                                horaMinOfi = $(this).find('div').find('input[type=text]').val();
                                break;
                        case 6: 
                                horaMaxOfi = $(this).find('div').find('input[type=text]').val();
                                break;
                    }
                   // $(this).css("background-color", "#ECF8E0");
                });
                 cal.calendario.push({ 
                    "dia" : dia,
                    "tipoHorario":tipoHorario,
                    "horaMin"  :horaMin,
                    "horaMax"  : horaMax,
                    "horaMinOfi"  :horaMinOfi,
                    "horaMaxOfi"  : horaMaxOfi                
                });
             }
            // alert(" "+dia +" "+ tipoHorario+ " "+horaMin+" " +horaMax);
       });        
}

function Editar(idSucursal)
{
    $.ajax({
    type: "POST",
    url: "php/DAO/sucuDAO.php",
    data: "accion=obtenerUnaSucursal&idSucursal="+idSucursal,
    async: false,
    dataType: "json",
    success: function(datos) {
           var data ='';
					  limpiarForm();
                      EliminaTD();
                     $('#sucursal').val(datos[0].descripcion);
                     $("#timepoEntreCitas").val(datos[0].tiempoEntreCitas);
                     $("#lon").val(datos[0].lon),
                     $("#lati").val(datos[0].lati),
                     $("#colonia").val(datos[0].colonia),
                     $("#telefono").val(datos[0].telefono),
                     $("#calle").val(datos[0].colonia),
                     $("#timepoEntreCitas").val(datos[0].tiempoEntreCitas),
					 $("#direccion").val(datos[0].direccion),
                     $("#tblCalendario tbody tr").each(function (index) 
                        {
                          if(typeof(datos[index]) != "undefined" )
                              {
                                 var check =  $(this).find("td:eq(" +0+ ")").find('div').find('input[type=checkbox]');

                                 $(check).iCheck('check');
                                 var tipoCalendario = $(this).find("td:eq(" +2+ ")").find('select');
                                 var  selectBox = $(tipoCalendario).data("selectBox-selectBoxIt");
                                 selectBox.selectOption( datos[index].idTipoHorario );
                                 if( datos[index].idTipoHorario == HorarioOficina )
                                 {
                                     var rangoMin = $(this).find("td:eq(" + 5+ ")").find('div').find('input[type=text]');
                                     var rangoMax = $(this).find("td:eq(" + 6+ ")").find('div').find('input[type=text]');
                                     $(rangoMin).val(datos[index].horaMinOfi);
                                     $(rangoMax).val(datos[index].horaMaxOfi);
                                     //$(rangoMin).data("timepicker").setTime(datos[index].horaMinOfi);
                                     //$(rangoMax).data("timepicker").setTime(datos[index].horaMaxOfi);
                                 }
                                 var rangoMin = $(this).find("td:eq(" + 3+ ")").find('div').find('input[type=text]');
                                 var rangoMax = $(this).find("td:eq(" + 4+ ")").find('div').find('input[type=text]');
                                 $(rangoMin).val(datos[index].horaMin);
                                 $(rangoMax).val(datos[index].horaMax);
                             }

                        });
               // });
            $("#idSucu").val(idSucursal);
            $('#btnActualizar').css('display','');
            $('#btnGuardar').css('display','none');
            $('#addSucu').modal({  keyboard: false,});
            $('#addSucu').modal('show', {backdrop: 'static'});
    }
    });
}

function Eliminar(idSucursal)
{
    resetAlert();
    alertify.confirm("Esta usted seguro que deseas eliminar la sucursal?", function (e) {
        if (e) {
            $.ajax({
                    type: "POST",
                    url: "php/DAO/sucuDAO.php",
                    data: "accion=eliminarSucursal&idSucursal="+idSucursal,
                    async: false,
                    dataType: "json",
                    success: function(datos) {
                            if(datos.msj=='success')
                            {
                               ObetnerAllSucursales();
                               Notificacion('success','Sucursal eliminada exitosamente','Mensaje');
                            }
                           else
                              Notificacion('error','Error al intentar eliminar la sucursal','Mensaje');
                        } 
                    });
        }
    });
     
}

function ObetnerAllSucursales()
{
	var disabled = '';
		if($("#idRol").val() == '2')
			disabled ='style="display:none"';
		
   $.ajax({
    type: "POST",
    url: "php/DAO/sucuDAO.php",
    data: "accion=obtenerSucursales&idSucursal="+($("#idSucursal").val() == '0' ? 'null' :$("#idSucursal").val()),
    async: false,
    dataType: "json",
    success: function(datos) {
           var data ='';
           LimpiaTabla("tblSucursales");
		   if(datos != null)
		   {
              $.each(datos, function(i, item) {
                  data+='<tr>';
                  data+='<td>'+(i+1)+'</td>';
                  data+='<td>'+item.descripcion+'</td>';
                  data+='<td>'+item.folio+'</td>';
                  data+='<td>'+item.tiempoEntreCitas+'</td>';
                  data+='<td><div align="center"><a href="javascript:Editar('+item.idSucursal+');"><i class="fa fa-edit right" style="font-size: 25px;"></i></a>';
                  data+='&nbsp;&nbsp;&nbsp; <a href="javascript:addDpto('+item.idSucursal+');"><i class="fa fa-plus-square right" style="font-size: 25px;"></i></a>';
                 // data+='&nbsp;&nbsp;&nbsp<button '+disabled+' class="btn btn-success '+disabled+' " onclick="Eliminar('+item.idSucursal+')"  type="button" id="btnEliminarAgencia">';
				 // data+='  <i class="fa fa-trash-o"  style="font-size: 25px;"></i>';
				 // data+='</button>'	;
				  data+='&nbsp;&nbsp;&nbsp;<a '+disabled+' href="javascript:Eliminar('+item.idSucursal+');"><i class="fa fa-trash-o right" style="font-size: 25px;"></i></a>';
                data+='</div></td></tr>';
                });

              $("#bodySucu").html(data);
               InicializaTabla("tblSucursales");
		   }else
			     InicializaTabla("tblSucursales");
    }
    });
}

function addDpto(idSucursal)
{
    sucursalActual=idSucursal;
    $.ajax({
    type: "POST",
    url: "php/DAO/dptosDAO.php",
    data: "accion=obtenerDptosXsucursal&idSucursal="+idSucursal,
    async: false,
    dataType: "json",
    success: function(datos) {
             var data ='';
			 var disbled = '';
               $.each(datos, function(i, item) {
				   if(item.idDpto == "1")
						disbled = 'disabled';
				   else 
					   disbled = '';
                  data+='<div class="row">';
                  data+=  '<div class="col-md-6">';
                  data+=    '<div class="form-group">';
                  data+=      '<input type="checkbox"'+ (item.activo=='1' ? 'checked' :'')  +' value="" '+disbled+' class="icheck-2 dptos" id="'+item.idDpto+'" style="position: absolute; opacity: 0;">';
                  data+=      '<label for="'+item.idDpto+'"> &nbsp;&nbsp;'+item.descripcion+'</label>';
                  data+=      '<input type="hidden" name="dptos[]" id="dptos'+i+'"  value="'+item.idDpto+'" />'
                  data+=      '<input type="hidden" class="valores" name="valor[]" id="dptos_'+i+'"  value="'+(item.activo=='1' ? true : false)+'" />'
                  data+=      '<input type="hidden" name="descDpto[]" id="dptos_'+i+'"  value="'+item.descripcion+'" />'
                  data+=   '</div>';
                  data+= '</div>';
                  data+='</div>';
                });
               $("#formAddDpto").html(data);

               $('input.dptos').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                });

               $('input.dptos').on('ifUnchecked', function(event){
                $(this).parent().parent().find('.valores').val(false);
                 $(this).val(false);
              });

              $('input.dptos').on('ifChecked', function(event){
                 //alert($(this).parent().parent().find('.valores').html());
                 $(this).parent().parent().find('.valores').val(true);
                 $(this).val(true);
              });

    }
    });
    $('#addDpto').modal('show', {backdrop: 'static'});
}

function Guardar(esActualizacion,idSucursal)
{

  $('tbody.files tr').each(function(i, e) {
    //according to @Brandon's comment it's now p.name
    var name = $(e).find('td').find('span.preview').find('a').attr('title'); 
    var size = $(e).find('td').find('p.name').find('a').attr('title');
    var imagen = $(e).find('td').find('span.preview').find('a').attr('href');  
    alert(name +" "+size+" "+imagen);    //etc.
});

LimpiarTablaFiles();

 alert(JSON.stringify(myFile));
  if($("#formSucursal").valid())
  {
	    var count = Object.keys(cal.calendario).length;
	   	if(count > 0)
	   	{
  			  geocoder.geocode({ 'address': $("#direccion").val() }, function (results, status) {
  				if (status == google.maps.GeocoderStatus.OK) {
  					 $("#lat").val(results[0].geometry.location.lat());
  					 $("#lng").val(results[0].geometry.location.lng());
  					 $.ajax({
  					  type: "POST",
  					  url: "php/DAO/sucuDAO.php",
  					  data: "calendario="+JSON.stringify(cal.calendario)+"&accion=guardar",
  					  async: false,
  					  dataType: "json",
  					  success: function(datos) {
  						  $('#addSucu').modal('hide');
  						  Notificacion('success',"Sucursal Guardada Exitosamente",'Mensaje');
  						  ObetnerAllSucursales();

  					  }
  				  });
  				}else
  					 Notificacion('error',"La direccion de la agencia no es valida ",'Mensaje');
  			});
      }
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
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'fu/server/php/index.php'
    });
}

/*ESTE ES PARA SELECIONAR TODOS LOS COMBOS DE UNA TABALA
function selectUnSelect(select)
{
         $("#tblCalendario tbody tr").each(function (index) 
        {
            if(select)
            {
                $(this).find("td:eq(" + 0 + ")").find('div').addClass('checked');
            }
            else
            {
                $(this).find("td:eq(" + 0 + ")").find('div').removeClass('checked');
            }
        });
}
*/

function EliminaTD()
{
       $("#tblCalendario tbody tr").each(function (index) 
        {
            $(this).find("td:eq(" +6+ ")").remove();
            $(this).find("td:eq(" +5+ ")").remove();
            var tipoCalendario = $(this).find("td:eq(" +2+ ")").find('select');
            var  selectBox = $(tipoCalendario).data("selectBox-selectBoxIt");
            selectBox.selectOption(0);
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


/*Es para identificar  a cual de los tab se le esta dando click
 $('.nav-tabs').bind('click', function (e) {

    if($(this).find('.active').text()== Tipico)
        tabAcutal = Avanzado;
    else
        tabAcutal = Tipico;
        if(exisreHorarioOfician() >0);
              $("#sizeAddSucu").css('width', '60%');
 });*/

$('.timepicker').click( function(e) {
      $(this).parent().removeClass('validate-has-error');
});

$('#btnAddSucu').click( function(e) {
	limpiarForm();
    EliminaTD();
    $('#btnActualizar').css('display','none');
    $('#btnGuardar').css('display','');
    $('#addSucu').modal({  keyboard: false,});
    $('#addSucu').modal('show', {backdrop: 'static'});

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

        $( ".selectboxit" ).change(function() {
            $(this).parent().removeClass('validate-has-error');
            if($( this ).val()== HorarioOficina){

                $( this ).parent().parent().append('<td>'+
                            '<div class="form-group" style="margin-bottom: 4px">'+
                            '<input type="text" class="form-control timepicker horarioOficina" data-template="dropdown" data-show-seconds="false"'+ 
                            'data-default-time="11:25 AM" data-show-meridian="false" data-minute-step="5"  />'+
                            '</div>'+
                            '<div class="form-group" style="margin-bottom: 4px">'+
                            '</td>'+
                            '<td>'+
                            '<div class="form-group" style="margin-bottom: 4px">'+
                            '<input type="text" class="form-control timepicker horarioOficina" data-template="dropdown" data-show-seconds="false"'+
                            'data-default-time="11:25 AM" data-show-meridian="false" data-minute-step="5"  />'+ 
                            '</div>'+
                            '</td>');

                  $( this ).parent().parent().find("td:eq(" + 6 + ")").find('input').timepicker();
                  $( this ).parent().parent().find("td:eq(" + 5 + ")").find('input').timepicker();
            
            }else
            {
                  $( this ).parent().parent().find("td:eq(" + 6 + ")").remove();
                  $( this ).parent().parent().find("td:eq(" + 5 + ")").remove();
            }
            StyleTabla($( this ).val());
        });


    ObetnerAllSucursales();

});

/*
function updateiCheckSkinandStyle() {
    var skin = $(".icheck-skins a.current").data('color-class'),
        style = $("#icheck-style").val();
    var cb_class = 'icheckbox_' + style + (skin.length ? ("-" + skin) : ''),
        rd_class = 'iradio_' + style + (skin.length ? ("-" + skin) : '');
    if (style == 'futurico' || style == 'polaris') {
        cb_class = cb_class.replace('-' + skin, '');
        rd_class = rd_class.replace('-' + skin, '');
    }
    $('input.icheck-2').iCheck('destroy');
    $('input.icheck-2').iCheck({
        checkboxClass: cb_class,
        radioClass: rd_class
    });
}

*/