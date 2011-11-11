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
    if($resumen) {
        $.ajax({
            url: 'Transaccion/carga-Totales/',
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
}

function limpiaTransaccion() {
    validatorReg.resetForm();
    validatorReg.currentForm.reset();
    $('#idTipoRegistro option[index=0]',$formReg).attr('selected', 'selected');
    $('#idCategoria option[index=0]',$formReg).attr('selected', 'selected');
    $("#idRegistro", $formReg).val("");
}

$(document).ready(function() {
    $resumen = $(".resumen");
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
    //                        alert($("#montoRegistro", $form).val());
                            $("#submit", $formReg).val("Guardando...").addClass("disabled");
                        },
                        complete: function(data) {
                            $("#submit", $formReg).removeClass("disabled").val("Guardar");
    //                        $(".notification").html("<div>La transaccion fue guardada correctamente</div>");
    //                        $(".notification").attr("class", "notification success png_bg");
                            form.reset();
                            var retornoPhp = $.parseJSON(data.responseText);
                            console.log(retornoPhp);
                            cargaTotales();
                            $tabla = $("#registro");
                            if($tabla) {
                                if(save) {
                                    $tabla.fadeIn();
                                    var clas,
                                        trClass,
                                        fila,
                                        pri = $tabla.find(".primero");
                                        
                                    if(retornoPhp.res.idTipoRegistro == 1) trClass = "positivo";
                                    else trClass = "negativo";
                                    fila = "<tr id='" + retornoPhp.res.idRegistro + "'>";
                                    fila += "<td align='center'>" + retornoPhp.res.fechaRegistro + "</td>";
                                    fila += "<td align='center'>" + retornoPhp.res.nomCategoria + "</td><td>" + retornoPhp.res.descRegistro + "</td>";
                                    fila += "<td><span class='" + trClass + "'>$ " + $().number_format(retornoPhp.res.montoRegistro, {numberOfDecimals:0, decimalSeparator: '', thousandSeparator: '.'}) + "</span></td>";
                                    fila += "<td align='center'>";
                                    fila += "<a href='#' onClick='cargaTransaccion(\"" + retornoPhp.res.idRegistro + "\"); return false;'><img src='/img/edit.png' alt='Editar' title='Editar' border='0' width=20/></a>";
                                    fila += "<a href='#' onClick='delTransaccion(\"" + retornoPhp.res.idRegistro + "\"); return false;'><img src='/img/delete.png' alt='Eliminar' title='Eliminar' border='0' width=20/></a>";
                                    fila += "</td>";
                                    fila += "</tr>";
                                    if(pri.length>0) {
                                        if(pri.hasClass("par")) clas = "impar";
                                        else clas = "par";
                                        pri.removeClass("primero");
                                        $(fila).hide().insertBefore(pri).addClass("primero").addClass(clas).fadeIn();
                                    } else {
                                        var tb = $tabla.find("tbody");
                                        $(fila).hide().appendTo(tb).addClass("primero").addClass("impar").fadeIn();
                                    }
                                } else {
                                    if(retornoPhp.res.idTipoRegistro == 1) trClass = "positivo";
                                    else trClass = "negativo";
                                    fila = "<td align='center'>" + retornoPhp.res.fechaRegistro + "</td>";
                                    fila += "<td align='center'>" + retornoPhp.res.nomCategoria + "</td><td>" + retornoPhp.res.descRegistro + "</td>";
                                    fila += "<td><span class='" + trClass + "'>$ " + $().number_format(retornoPhp.res.montoRegistro, {numberOfDecimals:0, decimalSeparator: '', thousandSeparator: '.'}) + "</span></td>";
                                    fila += "<td align='center'>";
                                    fila += "<a href='#' onClick=\"cargaTransaccion('" + id + "'); return false;\"><img src='img/edit.png' alt='Editar' title='Editar' border='0' width=20/></a>";
                                    fila += "<a href='#' onClick=\"delTransaccion('" + id + "'); return false;\"><img src='img/delete.png' alt='Eliminar' title='Eliminar' border='0' width=20/></a>";
                                    fila += "</td>";
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
        nFotos = 20, 
        fotoHoy = d.getDate()%nFotos;
        
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