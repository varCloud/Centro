

$( document ).ready(function() {

/*     $('#btnAddSucu').click(function() {
        alert();
        $("#addSucu").modal('show', {backdrop: 'static'});
    });*/


            var $table1 = jQuery('#tblDptos');
            // Initialize DataTable
            $table1.DataTable({
                "aLengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "bStateSave": true,
                 "language": {
                        "lengthMenu": "Muestra _MENU_ registros por pagina",
                        "zeroRecords": "No existen registros",
                        "info": "Pagina _PAGE_ de _PAGES_",
                        "infoEmpty": "No existe informacion para mostrar",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        "search":         "Buscar:",
                        "paginate": {
                                        "first":      "First",
                                        "last":       "Last",
                                        "next":       "Siguiente",
                                        "previous":   "Anterior"
                                    },
                    },
                    "bDestroy": true,
            
            });

});


