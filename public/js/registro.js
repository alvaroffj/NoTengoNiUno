var $reg_wrapper,
    $resumen,
    $tabla;
    
function delTransaccion(id) {
    $.ajax({
        url: 'Transaccion/desactiva/',
        dataType: 'json',
        data: {
            id: id
            , format: 'json'
        },
        beforeSend: function() {
        },
        complete: function(data) {
            $("#"+id, $tabla).fadeOut();
            cargaTotales();
        }
    });
}

function cargaTransaccion(id) {
    $.ajax({
        url: 'Transaccion/carga/',
        dataType: 'json',
        data: {
            id: id
            , format: 'json'
        },
        beforeSend: function() {
            $("#submit", $formReg).val("Cargando...");
            $("#submit", $formReg).addClass("disabled");
            if(!$formRegWrap.hasClass("flotando")) {
                $("html:not(:animated),body:not(:animated)").animate({scrollTop: 0}, 500);
            }
            $formRegWrap.fadeIn();
        },
        complete: function(data) {
            var out = $.parseJSON(data.responseText);
            console.log(out);
            $("#montoRegistro", $formReg).val(out.reg.montoRegistro);
            $("#fechaRegistro", $formReg).val(out.reg.fechaRegistro);
            $("#descRegistro", $formReg).val(out.reg.descRegistro);
            $("#idUsuario", $formReg).val(out.reg.idUsuario);
            $("#idRegistro", $formReg).val(out.reg.idRegistro);
            $('#idCategoria option[value=' + out.reg.idCategoria + ']',$formReg).attr('selected', 'selected');
            $('#idTipoRegistro option[value=' + out.reg.idTipoRegistro + ']',$formReg).attr('selected', 'selected');
            $('#idProyecto option[value=' + out.reg.idProyecto + ']',$formReg).attr('selected', 'selected');
            $("#submit", $formReg).val("Guardar");
            $("#submit", $formReg).removeClass("disabled");
        }
    });
}

$(document).ready(function() {
    $reg_wrapper = $(".registro-wrapper");
    $resumen = $(".resumen");
    $tabla = $("#registro");
});