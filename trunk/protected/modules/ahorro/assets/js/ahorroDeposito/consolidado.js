var inputPersonaId, inputPersonaCanton;
$(function () {
    inputPersonaId = $("#AhorroDeposito_socio_id");
    inputPersonaId.select2({
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

    //persona canton
    inputPersonaCanton = $("#AhorroDeposito_sucursal_comprobante_id");
    inputPersonaCanton.select2({
        placeholder: "Seleccione un canton",
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
    //chages
    inputPersonaId.on("change", function (e) {
        updateGrid(getParamsSearch());
    });
    inputPersonaCanton.on("change", function (e) {
        updateGrid(getParamsSearch());

    });

});

function updateGrid($params) {
    $.fn.yiiGridView.update("consolidado-grid", {
        type: 'GET',
        data: $params
    });
}
function getParamsSearch() {
    return {
        'AhorroDeposito': {
            'socio_id': inputPersonaId.val(),
            'sucursal_id': inputPersonaCanton.val()
        }
    };

}
