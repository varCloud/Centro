var idChoferActual

function Eliminar(idChofer)
{
	resetAlert();
    alertify.confirm("Estas seguro que deseas eliminar el chofer ?", function (e) {
        if (e) {
				$.ajax({
					type: "POST",
					url: "php/DAO/choferesDAO.php",
					data: "accion=eliminarChofer&idChofer="+idChofer,
					async: false,
					dataType: "json",
					success: function(datos) {
								  if(datos.msj=='success')
								  {
									 ActualizarTabActual();
									 Notificacion('success','Chofer actualizado exitosamente','Mensaje');
								  }
								 else
									Notificacion('error','error al acutalizar el chofer','Mensaje');
								  $('#addChofer').modal('hide');
					}

				  });
		}
	});
}

function Editar(idChofer)
{
  idChoferActual=null;
    $.ajax({
    type: "POST",
    url: "php/DAO/choferesDAO.php",
    data: "accion=obtenerUnChofer&idChofer="+idChofer,
    async: false,
    dataType: "json",
    success: function(datos) {
            $.each(datos, function(i, item) {
                   $('#usuario').val(item.usuario);
                   $('#telefono').val(item.telefono);
                   $('#placas').val(item.usuario);
                   $('#tipoUnidad').val(item.usuario);
                   $('#itemG1').val(item.urlFotoPoliza);
                   $('#itemG2').val(item.urlFotoLicencia);
                   $('#itemG3').val(item.urlFotoAuto);
                   $('#itemG4').val(item.urlFotoUsuario);
                   $('#itemG1').find('img').attr('src',item.urlFotoPoliza);
                   $('#itemG2').find('img').attr('src',item.urlFotoLicencia);
                   $('#itemG3').find('img').attr('src',item.urlFotoAuto);
                   $('#itemG4').find('img').attr('src',item.urlFotoUsuario);  
                   $('#itemG1').attr('href',item.urlFotoPoliza);
                   $('#itemG2').attr('href',item.urlFotoLicencia);
                   $('#itemG3').attr('href',item.urlFotoAuto);
                   $('#itemG4').attr('href',item.urlFotoUsuario); 				   
                   $('#aprobado').bootstrapSwitch('setState',(item.aprobado == 0 ? false : true));
                   idChoferActual=idChofer;
                });      

          $('#addChofer').modal({  keyboard: false,})
          $('#addChofer').modal('show', {backdrop: 'static', keyboard: false});
          $(".slide").nivoLightbox();
    }
    });
}

function actualizarChofer()
{
    $.ajax({
    type: "POST",
    url: "php/DAO/choferesDAO.php",
    data: "accion=actualizarChofer&aprobado="+$('#aprobado').bootstrapSwitch('status')+"&idChofer="+idChoferActual,
    async: false,
    dataType: "json",
    success: function(datos) {
                  if(datos.msj=='success')
                  {
                     ActualizarTabActual();
                     Notificacion('success','Chofer actualizado exitosamente','Mensaje');
                  }
                 else
                    Notificacion('error','error al acutalizar el chofer','Mensaje');
                  $('#addChofer').modal('hide');
    }

  });
}

function ObetnerAllChoferes(aprobado,tabla)
{
   $.ajax({
    type: "POST",
    url: "php/DAO/choferesDAO.php",
    data: "accion=obtenerChoferes&aprobado="+aprobado,
    async: false,
    dataType: "json",
    success: function(datos) {
           var data ='';
           LimpiaTabla(tabla);
              $.each(datos, function(i, item) {
                  data+='<tr>';
                  data+='<td>'+(i+1)+'</td>';
                  data+='<td>'+item.usuario+'</td>';
                  data+='<td>'+item.telefono+'</td>';
                  data+='<td>'+item.placas+'</td>';
                  data+='<td>';
                  data+='      <div class="gallery-item">';
                  data+='          <a href="'+item.urlFotoPoliza+'"  title="Poliza"  data-lightbox-gallery="G'+item.idChofer+'" class="image" >';
                  data+='               <img src="'+item.urlFotoPoliza+'" class="img-rounded"  style="height: 70px; max-width: 100%; width: 100%;" />'; 
                  data+='                   <span class="hover-zoom"></span>'; 
                  data+='           </a>';
                  data+='      </div>';
                  data+='</td>';
                  data+='<td>';
                  data+='      <div class="gallery-item">';
                  data+='          <a href="'+item.urlFotoLicencia+'" data-lightbox-gallery="G'+item.idChofer+'" class="image" title="Licencia">';
                  data+='               <img src="'+item.urlFotoLicencia+'" class="img-rounded" style="height: 70px; max-width: 100%; width: 100%;" />'; 
                  data+='                   <span class="hover-zoom"></span> <span class="title">Licencia</span>'; 
                  data+='           </a>';
                  data+='      </div>';
                  data+='</td>';
                  data+='<td>';
                  data+='      <div class="gallery-item ">';
                  data+='          <a href="'+item.urlFotoAuto+'" data-lightbox-gallery="G'+item.idChofer+'" class="image" title="Automovil">';
                  data+='               <img src="'+item.urlFotoAuto+'" class="img-rounded" style="height: 70px; max-width: 100%; width: 100%;" />'; 
                  data+='                   <span class="hover-zoom"></span> <span class="title">Automovil</span>'; 
                  data+='           </a>';
                  data+='      </div>';
                  data+='</td>';
                  data+='<td>';
                  data+='      <div class="gallery-item ">';
                  data+='          <a href="'+item.urlFotoUsuario+'" data-lightbox-gallery="G'+item.idChofer+'"" class="image" style="height: 70px; max-width: 100%; width: 100%;" title="Poliza">';
                  data+='               <img src="'+item.urlFotoUsuario+'" class="img-rounded" />'; 
                  data+='                   <span class="hover-zoom"></span> <span class="title">Usuario</span>'; 
                  data+='           </a>';
                  data+='      </div>';
                  data+='</td>';                                                      
                  data+='<td><div align="center"><a href="javascript:Editar('+item.idChofer+');"><i class="fa fa-edit right" style="font-size: 25px;"></i></a>';
                  data+='&nbsp;&nbsp;&nbsp;<a href="javascript:Eliminar('+item.idChofer+');"><i class="fa fa-trash-o right" style="font-size: 25px;"></i></a>';
                  data+='</div></td></tr>';
                });
       
              $("#"+tabla).find('tbody').html(data);
               InicializaTabla(tabla);
              $(".gallery-item .image").nivoLightbox();
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



$( document ).ready(function() {

   $('.nav-tabs').bind('click', function (e) {
    if($(this).find('.active').attr('aprobado')==1)
      ObetnerAllChoferes(0,"tblChoferesSinAprobar");
     else
        ObetnerAllChoferes(1,"tblChoferesAprobados");
 });
 
    $('#aprobado').on('switch-change', function (e, data) {
      
      Notificacion((data.value == true ? 'success' : 'warning'),'usuario '+(data.value == true ? 'Activado' : 'Descativado'),'Mensaje');
       // alert(data.value);
    });



  $('#btnGuardarCho').click(function(e) {
      actualizarChofer();
  });
 

InicializaTabla("tblChoferesSinAprobar");
InicializaTabla("tblChoferesAprobados");

ObetnerAllChoferes(1,"tblChoferesAprobados");

});


