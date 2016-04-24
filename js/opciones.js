(function(yourcode) {
    yourcode(window.jQuery, window, document);

}(function($, window, document) {
    $(function() {
        $.ajax({
            url: 'controller.php',
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'select',
                codigo_menu: $('#codigo_menu').val()
            },
            success: function(response) {
                $('#optionsTable').bootstrapTable({
                    data: response,
                    classes: 'table table-bordered table-responsive table-condensed table-hover',
                    search: true,
                    detailView: true,
                    detailFormatter: detailFormatter,
                    columns: [{
                        field: 'codigo_opcion',
                        title: 'ID'
                    }, {
                        field: 'nombre',
                        title: 'Nombre'
                    }]
                });
            }
        }).done(function (response) {

        });
        $('#optionsTable').on('expand-row.bs.table', function (e, index, row, $detail) {
//                $detail.html('Detalle de fila: ' + row.codigo_opcion + ' ' + row.nombre);
//             $('#optionsTable').bootstrapTable('collapseAllRows',true);
//             $('#optionsTable').bootstrapTable('expandRow',index);
            console.log($detail.html());
            var filas = $('#optionsTable tbody tr').length;
            var filasReales = filas - 1;
            for(var i = 0; i < ($('#optionsTable tbody tr').length -1);i++){
                if (i != index){
                    $('#optionsTable').bootstrapTable('collapseRow',i);
                }
            }
            cargarTablaArchivos(row.codigo_opcion).done(function (response) {
                if(response.length != 0){
                    $('#files_container').html('No se encontraron archivos para esta opcion.' + index);
                }else{
                    $('#files_container').empty();
                    var $tablaArchivos = $('<table id="tabla_archivos"></table>');
                    $('#files_container').html('<table id="tabla_archivos"></table>');
                    $('#tabla_archivos').bootstrapTable({
                        // data: response,
                        classes: 'table table-bordered table-responsive table-condensed table-hover',
                        columns: [{
                            field: 'codigo_archivo',
                            title: 'ID'
                        }, {
                            field: 'nombre',
                            title: 'Nombre'
                        }],
                        data: [{
                            codigo_archivo : 1,
                            nombre : "archivo.txt"
                        }]
                    });
                }
            });
            cargarTablaVideos(row.codigo_opcion).done(function (response) {
                if(response.length == 0){
                    $('#videos_container').html('No se encontraron videos para esta opcion');
                }else{
                    $('#videos_container').empty();
                    $('#videos_container').html('<table id="tabla_videos"></table>');
                    $('#tabla_videos').bootstrapTable({
                        data: response,
                        classes: 'table table-bordered table-responsive table-condensed table-hover',
                        columns: [{
                            field: 'codigo_video',
                            title: 'ID'
                        }, {
                            field: 'nombre',
                            title: 'Nombre'
                        }]
                    });
                }
            });
        });
        $('#optionsTable').on('click-row.bs.table', function (e, row, $element) {
            $.ajax({
                url: 'controller.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'select_option',
                    codigo_opcion: row.codigo_opcion,
                    codigo_menu: $('#codigo_menu').val()
                },
                beforeSend: function () {
//                        $detail.html('Cargando datos...');
                },
                success: function(response) {
                    var datos = JSON.parse(JSON.stringify(response));
                    console.log(JSON.stringify(response));
                    console.log(datos[0].nombre);


                }
            }).done(function (response) {

            });
        });
    });
    function cargarTablaArchivos(codigo_opcion) {
        return $.ajax({
            url: 'controller.php',
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'select_option_files',
                codigo_opcion: codigo_opcion
            },
            beforeSend: function () {
                $('#files_container p').html('Cargando listado de archivos...');
            }
        });
    }
    function cargarTablaVideos(codigo_opcion) {
        return $.ajax({
            url: 'controller.php',
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'select_option_videos',
                codigo_opcion: codigo_opcion
            },
            beforeSend: function () {
                $('#videos_container p').html('Cargando listado de videos...');
            }
        });
    }
    function detailFormatter(index, row) {
        var html = [];
        html.push(
            '<div class="col-lg-12 col-md-12 container">'+
            '<ul class="nav nav-tabs">'+
            '<li><a data-toggle="tab" href="#files">Archivos</a></li>'+
            '<li><a data-toggle="tab" href="#videos">Videos</a></li>'+
            '</ul>'+
            '<div class="tab-content">'+
            '<div id="files" class="tab-pane fade in active">'+
            '<h3>Archivos</h3>'+
            '<div  id="files_container"><p></p></div>'+
            '</div>'+
            '<div id="videos" class="tab-pane fade">'+
            '<h3>Videos</h3>'+
            '<div  id="videos_container"><p></p></div>'+
            '</div>'+
            '</div>'+
            '</div>'
        );


        return html.join('');
    }
}));