var $formReg,
    $formRegWrap,
    validatorReg;

function output(txt) {
    $("#output").find("#texto").html("<pre>"+txt+"<pre>");
}

function addTransaccion() {
    $formRegWrap.fadeIn();
    limpiaTransaccion();
}

function cargaTotales() {
    if($proyecto) {
        $.ajax({
            url: '/Transaccion/carga-Totales/',
            dataType: 'json',
            data: {
                format: 'json'
            },
            beforeSend: function() {
            },
            complete: function(data) {
                console.log(data);
            }
        });
    }
}

function updateProyecto(data) {
    $proyecto.html("Proyecto " + data.nombre + ": $" + $().number_format(data.balance, {numberOfDecimals:0, decimalSeparator: '', thousandSeparator: '.'}))
            .attr("title", "$" + $().number_format(data.ingresos, {numberOfDecimals:0, decimalSeparator: '', thousandSeparator: '.'}) + " - $" + $().number_format(data.egresos, {numberOfDecimals:0, decimalSeparator: '', thousandSeparator: '.'}) + " = $" + $().number_format(data.balance, {numberOfDecimals:0, decimalSeparator: '', thousandSeparator: '.'}));
}

function getFila(data) {
    var trClass, fila;
    if(data.idTipoRegistro == 1) trClass = "positivo";
    else trClass = "negativo";
    fila = "<tr id='" + data.idRegistro + "'>";
    fila += "<td align='center'>" + data.fechaRegistro + "</td>";
    fila += "<td align='center'>" + data.nomCategoria + "</td><td>" + data.descRegistro + "</td>";
    fila += "<td><span class='" + trClass + "'>$ " + $().number_format(data.montoRegistro, {numberOfDecimals:0, decimalSeparator: '', thousandSeparator: '.'}) + "</span></td>";
    fila += "<td class='actionCol'>";
    fila += "<a href='#' onClick='cargaTransaccion(\"" + data.idRegistro + "\"); return false;'><img src='/img/edit.png' alt='Editar' title='Editar' border='0' width=20 style='margin:0;'/></a>";
    fila += "<a href='#' onClick='delTransaccion(\"" + data.idRegistro + "\"); return false;'><img src='/img/delete.png' alt='Eliminar' title='Eliminar' border='0' width=20 style='margin:0;'/></a>";
    fila += "</td>";
    fila += "</tr>";
    
    return fila;
}

function limpiaTransaccion() {
    validatorReg.resetForm();
    validatorReg.currentForm.reset();
    $('#idTipoRegistro option[index=0]',$formReg).attr('selected', 'selected');
    $('#idCategoria option[index=0]',$formReg).attr('selected', 'selected');
    $("#idRegistro", $formReg).val("");
}

$(document).ready(function() {
    $proyecto = $("#proyecto");
    $formRegWrap = $("#formReg");
    $formReg = $(".form", $formRegWrap);
    if($formReg.length>0) {
        $formRegWrap.find(".btnIco").removeClass("popup").addClass("popdown");
        $formRegWrap.find("h2").addClass("dragable");
        $("[type=hidden]", $formReg).parent().hide();
        $("#fechaRegistro", $formReg).datepicker({
            'dateFormat': 'yy-mm-dd'
        });
        $formRegWrap.draggable({
            handle:'h2',
            opacity: 0.8
        });
        $(".btnIco", $formRegWrap).bind("click", function(){$formRegWrap.fadeOut();});
        
        validatorReg = $formReg.bind("invalid-form.validate",
            function() {
                $(".notification").html("<div>Debe completar todos lo campos requeridos</div>");
                $(".notification").attr("class", "notification error png_bg");
            }).validate({
            errorPlacement: function(error, element) {
            },
            submitHandler: function(form) {
                var save;
                if($("#idRegistro", $formReg).val()=='') save = true;
                else {
                    save = false;
                    var id = $("#idRegistro", $formReg).val();
                }
                if(!$("#submit").hasClass("disabled")) {
                    $.ajax({
                        url: form.action,
                        type: 'post',
                        dataType: 'json',
                        context: form,
                        data: {
                            idProyecto: $("#idProyecto option:selected", $formReg).val()
                            , idTipoRegistro: $("#idTipoRegistro option:selected", $formReg).val()
                            , idCategoria: $("#idCategoria option:selected", $formReg).val()
                            , idUsuario: $("#idUsuario", $formReg).val()
                            , montoRegistro: $("#montoRegistro", $formReg).val()
                            , fechaRegistro: $("#fechaRegistro", $formReg).val()
                            , descRegistro: $("#descRegistro", $formReg).val()
                            , idRegistro: $("#idRegistro", $formReg).val()
                            , format: 'json'
                        },
                        beforeSend: function() {
                            $("#submit", $formReg).val("Guardando...").addClass("disabled");
                        },
                        success: function(data) {
                            $("#submit", $formReg).removeClass("disabled").val("Guardar");
                            form.reset();
                            var retornoPhp = data;
                            console.log(data);
                            updateProyecto(data.pro);
                            $tabla = $("#registro");
                            if($tabla) {
                                fila = getFila(retornoPhp.res);
                                if(save) {
                                    $tabla.fadeIn();
                                    var fila,
                                        pri = $tabla.find(".primero");
                                    
                                    if(pri.length>0) {
                                        $(fila).hide().insertBefore(pri).addClass("primero").fadeIn();
                                        pri.removeClass("primero");
                                    } else {
                                        var tb = $tabla.find("tbody");
                                        $(fila).hide().appendTo(tb).fadeIn();
                                    }
                                } else {
                                    $("#" + id).html(fila);
                                }
                            }
                        }
                    });
                }
                return false;
            },
            success: function(label) {
            }
        });
    }
});

$(function($){
    var d = new Date(), 
        nFotos = 25, 
        fotoHoy = d.getDate()%nFotos + 1;
   $(".tooltip").twipsy({
        'live': true,
        'placement': 'below',
        'offset': 5
    });     
    $.supersized({
        start_slide : 0,
        vertical_center : 1,
        horizontal_center : 1,
        min_width : 1000,
        min_height : 700,
        fit_portrait : 1,
        fit_landscape : 0,
        image_protect :	1,
        slides : [{
            image : '/background/'+fotoHoy+'.jpg'
        }]
    });
});