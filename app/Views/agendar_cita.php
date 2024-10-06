<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/locales-all.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css">
<link href="<?= base_url() ?>../../../assets/lib/SpinKit/spinkit.css" rel="stylesheet">

<div id="loader" class="modal fade show" style="display: none; padding-left: 0px; z-index: 999999999;">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="d-flex ht-300 pos-relative align-items-center">
            <div class="sk-chasing-dots">
                <div class="sk-child sk-dot1 bg-red-800"></div>
                <div class="sk-child sk-dot2 bg-green-800"></div>
            </div>
        </div>
    </div>
</div>

<section class="agendar-cita mg-b-220 mg-t-90">
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="text-center mt-5">Escoge el día y la hora que deseas</h3>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</section>

<div id="modal_cita" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-teal pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Agendar cita</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="pd-20">
                <form id="form_cita">
                    <div class="form-group">
                        <label class="form-control-label">Fecha y hora: </label>
                        <input id="fechaH" class="form-control" type="text" name="fecha" value="" placeholder="" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Comentarios: <span class="tx-danger"></span></label>
                        <textarea rows="3" id="comentarios" class="form-control" placeholder="Comentarios de la cita"></textarea>
                    </div>

                    <div class="form-group">
                        <input id="id_propiedad" class="form-control" type="hidden" name="propiedad">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button id="send_cita" type="button" class="btn btn-teal pd-x-20"><i class="fa fa-check-circle-o fa-lg mr-1" aria-hidden="true"></i>Aceptar</button>
                <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times-circle fa-lg mr-1" aria-hidden="true"></i>Cancelar</button>
            </div>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!--Modal alert -->
<div id="modal_alert" class="modal fade">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-teal pd-y-20 pd-x-25">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Agendar cita</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-lg">
                <div class="pd-80 pd-sm-80 form-layout form-layout-4">
                    <h6 style="text-align:center;">¿Deseas agendar esta cita?</h6>
                    <br>
                    <p style="color:red; text-align:center;">No se podrán deshacer las acciones una vez confirmada la cita</p>
                </div><!-- card -->
            </div>

            <div class="modal-footer">
                <button id="agendar_cita" type="button" class="btn btn-teal  pd-x-20"><i class="fa fa-check-circle-o mr-1" aria-hidden="true"></i>Aceptar</button>
                <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times-circle mr-1" aria-hidden="true"></i>Cancelar</button>
            </div>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<style>
    .fc-scrollgrid .fc-timegrid-slot:hover td {
  background-color: red;
}
</style>

<script>
    let id_propiedad = <?php echo json_encode($id_propiedad); ?>;
    let id_propietario = <?php echo json_encode($id_propietario); ?>;
    /*alert(id_propietario);*/
</script>



<script>
    get_fechas();
    calendario();
    

    function calendario(result) {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                locale: 'es',
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            selectable: true,
            dateClick: function (info) {
                var date = info.dateStr;
                var view = calendar.view.type;
                var hoy = calendar.getDate();
                var hoy2 = new Date(hoy).toLocaleString();

                var fecha = Date.parse(info.dateStr)
                var fecha2 = new Date(fecha).toLocaleString();

                date2 = new Date(hoy);
                year = date2.getFullYear();
                month = date2.getMonth()+1;
                dt = date2.getDate();

                if (dt < 10) {
                    dt = '0' + dt;
                }
                if (month < 10) {
                    month = '0' + month;
                }

                const actual = year+'-' + month + '-'+dt;
                
                if(info.dateStr > actual  ){
                    switch (view) {
                        case 'dayGridMonth':
                            calendar.changeView('timeGridDay', date);
                        break;
    
                        case 'timeGridWeek':
                            calendar.changeView('timeGridDay', date);
                        break;
    
                        case 'timeGridDay':
                            var fecha = Date.parse(info.dateStr)
                            var fecha2 = new Date(fecha).toLocaleString();
                            $('#fechaH').val(fecha2);
                            $("#id_propiedad").val(id_propiedad);
                            //alert(fecha2);
                            $('#modal_cita').modal();
                        break;
                    }
                } else{
                    Toastify({
                        text: "No se puede crear la cita",
                        duration: 5000,
                        className: "info",
                        avatar : "../../../../../assets/icons/advertencia.png",
                        style: {
                            background: "linear-gradient(to right, #0370b8, #0FB6FB)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },

                    }).showToast();
                }  
                
            },
        });
        calendar.setOption('locale', 'es');

        $.each(result, function (index, value) {
            calendar.addEvent({
                title: "OCUPADO",
                start: value.date_schedule,
                allDay: false,
                color: '#ff9f89'
    
            });
    
        });
        calendar.render();
    
    }

    function get_fechas() {
        //$('#loader').toggle();

        let propietario = {
            id_propietario: id_propietario,
        };

        var url_citas = `${BASE_URL}Mattes/Api/Arrendatario_api/Agendarcita_rest/get_fechas`;

        $.ajax({
            url: url_citas,
            type: "POST",
            data: JSON.stringify(propietario),
            dataType: 'json',
            success: function(result) {
                console.log(result);
                // $('#loader').toggle();
                calendario(result);
            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');

            }
        })
    }

    $("#send_cita").on("click", function() {
        $('#modaldemo2').modal('toggle');
        $('#modal_alert').modal('toggle');
    });

    $("#agendar_cita").on("click", function() {
        $('#loader').toggle();

        //let id_prop = id_propietario;
        let id_propiedad = $("#id_propiedad").val();
        let fecha = $('#fechaH').val();
        let observacion = $('#comentarios').val();

        var url_str = `${BASE_URL}Mattes/Api/Arrendatario_api/Agendarcita_rest`;

        let json = {
            id_propietario: id_propietario,
            id_propiedad: id_propiedad,
            fecha: fecha,
            observacion: observacion,
        };

        $.ajax({
            url: url_str,
            type: 'POST',
            data: JSON.stringify(json),
            dataType: 'json',
            success: function(data) {
                if (data.status == 200) {
                    Toastify({
                        text: data.messages.success,
                        duration: 3000,
                        className: "info",
                        // avatar: "../../assets/img/logop.png",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },

                    }).showToast();
                    $('#loader').toggle();
                    $('#modal_alert').modal('toggle');
                    $('#modal_cita').modal('toggle');
                    get_fechas();
                    setTimeout(function() { 
                        location.href = `${BASE_URL}mensajes`;
                    },2000);

                } else {
                    Toastify({
                        text: data.messages.success,
                        duration: 3000,
                        className: "info",
                        // avatar: "../../assets/img/logop.png",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },

                    }).showToast();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>