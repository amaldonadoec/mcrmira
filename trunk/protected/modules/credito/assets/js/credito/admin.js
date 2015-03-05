var inputNumeroCheque, inputSocioId, inputSucursalId, inputAño, inputMes;
$(function () {
    initSelect();
});
function initSelect() {
    inputNumeroCheque = $("#Credito_numero_cheque");
    //select2
    inputNumeroCheque.select2({
        placeholder: "Seleccione un Número de Cheque",
        multiple: true,
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + "credito/credito/ajaxlistCreditos",
            type: "get",
            dataType: 'json',
            data: function (term, page) {
                return {
                    socio_ids: inputSocioId.val(),
                    search_value: term // search term
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });

    inputSocioId = $("#Credito_socio_id");
    //select2
    inputSocioId.select2({
        placeholder: "Seleccione un Socio",
        multiple: true,
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + "crm/persona/ajaxlistSocios",
            type: "get",
            dataType: 'json',
            data: function (term, page) {
                return {
                    search_value: term // search term
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });

    inputSucursalId = $("#Credito_sucursal_id");
    //select2
    inputSucursalId.select2({
        placeholder: "Seleccione una Sucursal",
        multiple: true,
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + "crm/sucursal/ajaxlistSucursales",
            type: "get",
            dataType: 'json',
            data: function (term, page) {
                return {
                    search_value: term // search term
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });

    inputSucursalId = $("#Credito_sucursal_id");
    //select2
    inputSucursalId.select2({
        placeholder: "Seleccione una Sucursal",
        multiple: true,
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + "crm/sucursal/ajaxlistSucursales",
            type: "get",
            dataType: 'json',
            data: function (term, page) {
                return {
                    search_value: term // search term
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });
    inputAño = $("#Credito_ano_creacion");
    inputAño.select2({
        placeholder: "Seleccione un año",
        multiple: true,
        data: [
//            {id: null, text: 'Todos'},
            {id: '2015', text: '2015'},
            {id: '2014', text: '2014'},
            {id: '2013', text: '2013'},
            {id: '2012', text: '2012'},
            {id: '2011', text: '2011'},
            {id: '2010', text: '2010'},
        ],
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        }
    });
    inputMes = $("#Credito_mes_creacion");
    inputMes.select2({
        placeholder: "Seleccione un mes",
        multiple: true,
        data: [
//            {id: null, text: 'Todos'},
            {id: '01', text: 'Enero'},
            {id: '02', text: 'Febero'},
            {id: '03', text: 'Marzo'},
            {id: '04', text: 'Abril'},
            {id: '05', text: 'Mayo'},
            {id: '06', text: 'Junio'},
            {id: '07', text: 'Julio'},
            {id: '08', text: 'Agosto'},
            {id: '09', text: 'Septiembre'},
            {id: '10', text: 'Octubre'},
            {id: '11', text: 'Noviembre'},
            {id: '12', text: 'Diciembre'},
        ],
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        }
    });
//    inputPersonaDiscapacidad = $("#Persona_discapacidad");
//    inputPersonaDiscapacidad.select2({
//        placeholder: "Seleccione un una",
//        multiple: false,
//        data: [{id: null, text: 'Todos'}, {id: 'SI', text: 'Si'}, {id: 'NO', text: 'No'}],
//        initSelection: function (element, callback) {
//            if ($(element).val()) {
//                var data = {id: element.val(), text: $(element).attr('selected-text')};
//                callback(data);
//            }
//        }
//    });
//    inputPersonaMadreSoltera = $('#Persona_madre_soltera');
//    inputPersonaMadreSoltera.bootstrapToggle({
//        on: 'SI',
//        off: 'NO',
//        onstyle: 'primary',
//        offstyle: 'warning'
//    });
    inputNumeroCheque.on("change", function (e) {
        updateGrid(getParamsSearch());
    });
    inputSocioId.on("change", function (e) {
        select2vacio('Credito_numero_cheque');
        updateGrid(getParamsSearch());
    });
    inputSucursalId.on("change", function (e) {
        updateGrid(getParamsSearch());
    });
    inputAño.on("change", function (e) {
        if ($('#s2id_Credito_ano_creacion > ul').children().length >= 3) {
            select2vacio('Credito_mes_creacion');
            $('#Credito_mes_creacion').attr('readOnly', 'readOnly');
        } else {
            $('#Credito_mes_creacion').attr('readOnly', false);
        }
        updateGrid(getParamsSearch());
    });
    inputMes.on("change", function (e) {
        updateGrid(getParamsSearch());
    });
//    inputPersonaEstadoCivil.on("change", function (e) {
//        updateGrid(getParamsSearch());
//
//    });
//    inputPersonaMadreSoltera.on("change", function (e) {
//        updateGrid(getParamsSearch());
//
//    });
//    inputPersonaSexo.on("change", function (e) {
//        updateGrid(getParamsSearch());
//
//    });
}
function updateGrid($params) {
    $.fn.yiiGridView.update("credito-grid", {
        type: 'GET',
        data: $params
    });
}
function getParamsSearch() {
    return {
        'Credito': {
            'numero_cheque': inputNumeroCheque.val(),
            'socio_id': inputSocioId.val(),
            'sucursal_id': inputSucursalId.val(),
            'ano_creacion': inputAño.val(),
            'mes_creacion': inputMes.val(),
        }
    };

}

function select2vacio(id) {
    $('#' + id).select2("val", "");
}

//function exporSocio(Formulario) {
//    if (!isEmptyGrid("#persona-grid")) //Cuando no este vacio
//    {
//        $(Formulario).attr('target', "blank");
//        $(Formulario).attr('action', baseUrl + 'crm/persona/exportarSocio');
//        $(Formulario).submit();
//    } else {
//        bootbox.alert('No hay datos para exportar');
//    }
//}