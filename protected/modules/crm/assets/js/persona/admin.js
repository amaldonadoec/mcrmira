$(function () {
        select2vacio("s2id_Persona_direccion_domicilio_id");
    initSelect();
});
function initSelect(){
    //select2
    $("#Persona_id").select2({
        placeholder: "Seleccione un Socio",
        initSelection: function(element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + "crm/persona/ajaxlistSocios",
            type: "get",
            dataType: 'json',
            data: function(term, page) {
                return {
                    search_value: term // search term
                };
            },
            results: function(data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });
    $("#Persona_canton_ids").select2({
        placeholder: "Seleccione un cantón",
        multiple: true,
        initSelection: function(element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + "crm/canton/ajaxlistCantones",
            type: "get",
            dataType: 'json',
            data: function(term, page) {
                return {
                    search_value: term // search term
                };
            },
            results: function(data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });
    $("#Persona_sexo").select2({
        placeholder: "Seleccione un género",
        multiple: false,
        data:[{id:null,text:'Ambos'},{id:'F',text:'Mujeres'},{id:'M',text:'Hombres'}],
        initSelection: function(element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        }
    });
    $("#Persona_estado_civil").select2({
        placeholder: "Seleccione un estado civil",
        multiple: false,
        data:[{id:null,text:'Todos'},{id:'SOLTERO',text:'Soltero'},{id:'CASADO',text:'Casado'},{id:'DIVORCIADO',text:'Divorsiado'},{id:'VIUDO',text:'Viudo'}],
        initSelection: function(element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        }
    });
    $("#Persona_discapacidad").select2({
        placeholder: "Seleccione un una",
        multiple: false,
        data:[{id:null,text:'Todos'},{id:'SI',text:'Si'},{id:'NO',text:'No'}],
        initSelection: function(element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        }
    });
    $('#Persona_madre_soltera').bootstrapToggle({
        on: 'SI',
        off: 'NO',
        onstyle:'primary',
        offstyle:'warning',
    });
}
function select2vacio(id) {
    $('#' + id).select2("val", "");
    $('#' + id).select2("val", "0");
}
function select2validar(event, id) {
    var seleccionados = $('#' + id).select2("val");
    if (seleccionados.length == 0)
    {
        $('#' + id).select2("val", "0");
    }
    else if ($.inArray("0", seleccionados) != -1 && seleccionados.length > 1)
    {
        seleccionados.splice($.inArray("0", seleccionados), 1);
        $('#' + id).select2("val", seleccionados);
    }

    if (event.added)
    {
        if (event.added.id == 0)
        {
            select2vacio(id);
        }
    }
}
function btnStatus(btn_id, loading, accion) {
    var botonSubmit = $(btn_id);
    if (loading == true) {
        $(botonSubmit).attr("disabled", true);
        $(botonSubmit).html('<i class="icon-loading"></i> Espere...');
        $(botonSubmit).attr("disabled", true);
        $(botonSubmit).attr("onclick", false);
    } else {
        $(botonSubmit).attr("disabled", false);
        $(botonSubmit).attr("disabled", false);
        $(botonSubmit).attr("onclick", accion);
    }
}
function generarGridAdminPersonas(Formulario) {
//capturar en la variable accion el modod e click()
    var accion = $('#buttonbuscar').attr('onclick');
    //poner valores automaticamente de indice 0 no existen valores solo en provincia y ciudad
    if (!$("#Persona_direccion_domicilio_id").val()) {
        $("#Persona_direccion_domicilio_id").val("0");
//        $("#Contacto_ciudad").val("0");
    }
    ms = $('#Persona_madre_soltera').is(':checked') ? 1 : 0;
    //window.console.log(ms);
    //recoger los valores si todos son 0000 esque los valores no han sidos escogidos
    var condicion = 0 + $('#Persona_direccion_domicilio_id').val() + $('#Persona_sexo').val() + $('#Persona_estado_civil').val() + $('#Persona_discapacidad').val() + ms;
//    window.console.log(condicion);
//    window.console.log(condicion != '000000');
    if (condicion !== '000000') {
        btnStatus('#buttonbuscar', true);
        $.fn.yiiGridView.update("persona-grid", {
            type: 'GET',
            data: $(Formulario).serialize(),
            complete: function (jqXHR, status) {
                if (status === 'success') {
                    //quitar el oculto el boton quitar filtros
                    $('#buttonquitar').removeClass('hidden');
                    //al boton buscar dar el nombre de buscar por espere...
                    $('#buttonbuscar').html('<i class="icon-search"></i> Buscar');
                    //cambiar los anuncios del boton buscar
                    btnStatus('#buttonbuscar', false, accion);
                }
            }
        });
    } else {
        generarGridAdminPersonasTodos(Formulario)
    }
}
function generarGridAdminPersonasTodos(Formulario) {
    var accion = $('#buttonquitar').attr('onclick');
    btnStatus('#buttonquitar', true);
    //resetar los campos en indice en 0
    //$("#Persona_sexo").select2("val", "");
    //$("#Persona_estado_civil").val("0");
    //$("#Persona_discapacidad").val("0")
    //$("#s2id_Persona_direccion_domicilio_id").select2("val", "0");
    //$('#Persona_madre_soltera').removeAttr('checked');
    $(Formulario).trigger("reset");

    $.fn.yiiGridView.update("persona-grid", {
        type: 'GET',
        data: $(Formulario).serialize(),
        complete: function (jqXHR, status) {
            if (status == 'success') {
                //oculat el boton quitar filtros
                $('#buttonquitar').addClass('hidden');
                //cambiar valores del boton quitar filtros
                btnStatus('#buttonquitar', false, accion);
                //poner el nombre de espere... por quitar filtros
                $('#buttonquitar').html('<i class="icon-refresh"></i> Quitar Filtros');
            }
        }
    });
}

function exporCont(Formulario) {

    $(Formulario).attr('target', "blank");
    $(Formulario).attr('action', baseUrl + 'crm/persona/exportExcel');
    $('.truulo-search').clone().appendTo(Formulario);
    //window.console.log($(Formulario).attr('action'));
    $(Formulario).submit();
    $(Formulario + ' >.truulo-search').remove();
}