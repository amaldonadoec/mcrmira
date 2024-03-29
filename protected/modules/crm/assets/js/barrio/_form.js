$(function() {

    $("#Barrio_provincia_id").change(function() {
        AjaxListaCantones("Barrio_provincia_id", "Barrio_canton_id");
    });
    $("#Barrio_canton_id").change(function() {
        AjaxListaParroquias("Barrio_canton_id", "Barrio_parroquia_id");
    });
});
function AjaxListaCantones(lista, lista_actualizar)
{
    $('#s2id_' + lista_actualizar + ' a span').html('');
    AjaxCargarListas(baseUrl + "crm/canton/ajaxGetCantonByProvincia",
            {provincia_id: $("#" + lista).val()}, function(data) {
        $("#" + lista_actualizar).html(data);
        $('#s2id_' + lista_actualizar + ' a span').html($("#" + lista_actualizar + " option[id='p']").html());
        $("#" + lista_actualizar).selectBox("refresh");

    });
}
function AjaxListaParroquias(lista, lista_actualizar)
{
    $('#s2id_' + lista_actualizar + ' a span').html('');
    AjaxCargarListas(baseUrl + "crm/parroquia/ajaxGetParroquiaByCanton",
            {canton_id: $("#" + lista).val()}, function(data) {
        $("#" + lista_actualizar).html(data);
        $('#s2id_' + lista_actualizar + ' a span').html($("#" + lista_actualizar + " option[id='p']").html());
        $("#" + lista_actualizar).selectBox("refresh");

    });
}
function AjaxCargarListas(url, data, callBack)
{
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(data) {
            callBack(data);
        }
    });
}