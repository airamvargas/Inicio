
//Red unidad de negocio
getUnitBussines();
function getUnitBussines() {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/showUnitBussines`;
    var select = $(".unidad");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.length > 0) {
                select.append(`<option  value=""> SELECCIONA GRUPO </option>`);
                $(data).each(function (i, v) {
                    select.append(`<option title="${v.description}"  value="${v.id}"> ${v.name}</option>`);
                });
                $('#loader').toggle();

            }else{
                $('#loader').toggle();
                Swal.fire({
                    icon: 'error',
                    title: 'No se encontraron unidades de negocio',
                    //text: 'Agrege una unidad negocio',
                    html: '<a href="'+BASE_URL+'Catalogos/BusinessUnit">AGREGAR UNIDAD DE NEGOCIO</a>',
                    showConfirmButton: false,
                  });
            }
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
} 

//datos del datatable
var dataTable = $('#datatable').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/`,
        data: {},
        type: "post",
    },

    columns: [
        {
            data: 'id',

        },
        {
            data: 'unidad',

        },


        {
            data: 'name',

        },
        {
            data: 'description'
        },

        {
            data: 'start_time'
        },

        {
            data: 'end_time'
        },

        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<button  title="EDITAR" id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button title="ELIMINAR" id="' + data + '"  class="btn btn-danger delete solid pd-x-20 ml-1 btn-circle btn-sm"><i   class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
            }
        },


    ],

    "columnDefs": [
        {
          "targets": [ 0 ],
          "visible": false,
          "searchable": false
        }
      ], 

    order: [[0, 'desc']],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },
    responsive: true
});


//obtenemos los datospara editar campos
$(document).on('click', '.up', function () {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/readConsultorio`;
    let id = $(this).attr('id');
    $.ajax({
        url: url,
        data: { id: id },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (success) {
            // return index
            var keys = Object.keys(success[0]);
            keys.forEach(element => {
                console.log(element);
                $('#' + element).val(success[0][element]);
            });
            $('#loader').toggle();
            $('#updateModal').modal('show');
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });

});