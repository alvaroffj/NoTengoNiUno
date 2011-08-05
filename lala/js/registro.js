var $form_wrappper;
var $reg_wrapper;
var $form;
var validator;
var $resumen;
var $tabla;
function delTransaccion(id) {
    $.ajax({
        url: 'http://notengoniuno.gpsline.cl/index.php/Registro/desactiva/',
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

function cargaTotales() {
    $.ajax({
        url: 'http://notengoniuno.gpsline.cl/index.php/Registro/carga-Totales/',
        dataType: 'html',
        data: {
            format: 'html'
        },
        beforeSend: function() {
        },
        complete: function(data) {
            $resumen.html(data.responseText);
        }
    });
}


function cargaTransaccion(id) {
    $.ajax({
        url: 'http://notengoniuno.gpsline.cl/index.php/Registro/carga/',
        dataType: 'json',
        data: {
            id: id
            , format: 'json'
        },
        beforeSend: function() {
            $("#submit", $form).val("Cargando...");
            $("#submit", $form).addClass("working");
            if(!$form_wrapper.hasClass("flotando")) {
                $("html:not(:animated),body:not(:animated)").animate({scrollTop: 0}, 500);
            }
            $form_wrapper.fadeIn();
        },
        complete: function(data) {
            var out = $.parseJSON(data.responseText);
            $("#montoRegistro", $form).val(out.reg.montoRegistro);
            $("#fechaRegistro", $form).val(out.reg.fechaRegistro);
            $("#descRegistro", $form).val(out.reg.descRegistro);
            $("#idUsuario", $form).val(out.reg.idUsuario);
            $("#idRegistro", $form).val(out.reg.idRegistro);
            $('#idCategoria option[value=' + out.reg.idCategoria + ']',$form).attr('selected', 'selected');
            $('#idTipoRegistro option[value=' + out.reg.idTipoRegistro + ']',$form).attr('selected', 'selected');
            $("#submit", $form).val("Guardar");
            $("#submit", $form).removeClass("working");
        }
    });
}

function addTransaccion() {
    $form_wrapper.fadeIn();
    limpiaTransaccion();
}

function limpiaTransaccion() {
    validator.resetForm();
    validator.currentForm.reset();
    $('#idTipoRegistro option[index=0]',$form).attr('selected', 'selected');
    $('#idCategoria option[index=0]',$form).attr('selected', 'selected');
    $("#idRegistro", $form).val("");
}
var $lala;
$(document).ready(function() {
    $form_wrapper = $("#form-wrapper");
    $reg_wrapper = $(".registro-wrapper");
    $form = $(".form", $form_wrapper);
    $resumen = $(".resumen");
    $tabla = $(".registro");
    $("#fechaRegistro", $form).datepicker({
        'dateFormat': 'yy-mm-dd'
    });
    
    $form_wrapper.find(".btn").removeClass("popup");
    $form_wrapper.find(".btn").addClass("popdown");
    $form_wrapper.find("h2").addClass("dragable");
    $form_wrapper.draggable({
        handle:'h2',
        opacity: 0.8
    });
    $(".btn", $form_wrapper).bind("click", function(){$form_wrapper.fadeOut();});

//    var depagify = function() {
//        $('.paginacion a:last').depagify({
//            container:  '.registro',
////            filter:     '.post',
////            trigger:    '#footer',
//            request:    function(options) {
//                $('.paginacion', options.container).remove();
//            },
//            effect:     function() {
//                $(this).fadeIn('slow');
//            }
//        });
////    };

    validator = $form.bind("invalid-form.validate",
        function() {
            $(".notification").html("<div>Debe completar todos lo campos requeridos</div>");
            $(".notification").attr("class", "notification error png_bg");
        }).validate({
        errorPlacement: function(error, element) {
        },
        submitHandler: function(form) {
            var save;
            if($("#idRegistro", $form).val()=='') save = true;
            else {
                save = false;
                var id = $("#idRegistro", $form).val();
            }
            if(!$("#submit").hasClass("working")) {
                $.ajax({
                    url: form.action,
                    type: 'post',
                    dataType: 'json',
                    context: form,
                    data: {
                        idTipoRegistro: $("#idTipoRegistro option:selected", $form).val()
                        , idCategoria: $("#idCategoria option:selected", $form).val()
                        , idUsuario: $("#idUsuario", $form).val()
                        , montoRegistro: $("#montoRegistro", $form).val()
                        , fechaRegistro: $("#fechaRegistro", $form).val()
                        , descRegistro: $("#descRegistro", $form).val()
                        , idRegistro: $("#idRegistro", $form).val()
                        , format: 'json'
                    },
                    beforeSend: function() {
//                        alert($("#montoRegistro", $form).val());
                        $("#submit").val("Guardando...");
                        $("#submit").addClass("working");
                    },
                    complete: function(data) {
                        $("#submit").removeClass("working");
                        $("#submit").val("Guardar");
                        $(".notification").html("<div>La transaccion fue guardada correctamente</div>");
                        $(".notification").attr("class", "notification success png_bg");
                        form.reset();
//                        var retornoPhp = $.parseJSON(data.responseText);
                        var retornoPhp = data;
                        lala = data.responseText;
                        lele = retornoPhp;
                        cargaTotales();
                        if(save) {
                            var clas;
                            var trClass;
                            var fila;
//                            alert("-1: "+data.responseText);
                            $tabla = $(".registro");
                            var pri = $tabla.find(".primero");
//                            alert("0: "+retornoPhp.res.idTipoRegistro);
                            if(retornoPhp.res.idTipoRegistro == 1) trClass = "positivo";
                            else trClass = "negativo";
//                            alert("1");
                            fila = "<tr id='" + retornoPhp.res.idRegistro + "'>";
                            fila += "<td align='center'>" + retornoPhp.res.fechaRegistro + "</td>";
                            fila += "<td align='center'>" + retornoPhp.res.idCategoria + "</td><td>" + retornoPhp.res.descRegistro + "</td>";
                            fila += "<td><span class='" + trClass + "'>$ " + $().number_format(retornoPhp.res.montoRegistro, {numberOfDecimals:0, decimalSeparator: '', thousandSeparator: '.'}) + "</span></td>";
                            fila += "<td align='center'>";
                            fila += "<a href='#' onClick='cargaTransaccion(\"" + retornoPhp.res.idRegistro + "\"); return false;'><img src='/public/img/edit.png' alt='Editar' title='Editar' border='0' /></a>";
                            fila += "<a href='#' onClick='delTransaccion(\"" + retornoPhp.res.idRegistro + "\"); return false;'><img src='/public/img/delete.png' alt='Eliminar' title='Eliminar' border='0' /></a>";
                            fila += "</td>";
                            fila += "</tr>";
//                            alert("2");
                            if(pri.length>0) {
                                if(pri.hasClass("par")) clas = "impar";
                                else clas = "par";
                                pri.removeClass("primero");
                                $(fila).hide().insertBefore(pri).addClass("primero").addClass(clas).fadeIn();
                            } else {
                                var tb = $tabla.find("tbody");
                                $(fila).hide().appendTo(tb).addClass("primero").addClass("impar").fadeIn();
                            }
//                            alert("guardo:"+fila);
                        } else {
                            if(retornoPhp.res.idTipoRegistro == 1) trClass = "positivo";
                            else trClass = "negativo";
//                            fila = "<tr id='" + out.res.idRegistro + "'>";
                            fila = "<td align='center'>" + retornoPhp.res.fechaRegistro + "</td>";
                            fila += "<td align='center'>" + retornoPhp.res.idCategoria + "</td><td>" + retornoPhp.res.descRegistro + "</td>";
                            fila += "<td><span class='" + trClass + "'>$ " + $().number_format(retornoPhp.res.montoRegistro, {numberOfDecimals:0, decimalSeparator: '', thousandSeparator: '.'}) + "</span></td>";
                            fila += "<td align='center'>";
                            fila += "<a href='#' onClick=\"cargaTransaccion('" + id + "'); return false;\"><img src='img/edit.png' alt='Editar' title='Editar' border='0' /></a>";
                            fila += "<a href='#' onClick=\"delTransaccion('" + id + "'); return false;\"><img src='img/delete.png' alt='Eliminar' title='Eliminar' border='0' /></a>";
                            fila += "</td>";
//                            fila += "</tr>";
                            $("#" + id).html(fila);
                        }
                    }
                });
            }
            return false;
        },
        success: function(label) {
        }
    });
});