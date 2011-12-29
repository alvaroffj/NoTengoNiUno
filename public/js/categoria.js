var validatorCat,
    $formCat;
$(document).ready(function() {
    $("table#tabla").tablesorter({
        sortList: [[0,0]],
        headers: { 
            1: { 
                sorter: false 
            }, 
            2: { 
                sorter: false 
            } 
        }
    });
    $formCat = $(".form-inline");
    $submitCat = $("#submit", $formCat);
    $('.edit').editable('/index.php/Categoria/mod', {
        indicator : 'Guardando...',
        tooltip : 'Click para editar',
        id : $(this).id,
        name : "nomCat"
    });
    validatorCat = $formCat.bind("invalid-form.validate",
        function() {
        }).validate({
        errorPlacement: function(error, element) {
        },
        submitHandler: function(form) {
//            form.submit();
            if(!$submitCat.hasClass("disabled")) {
                $.ajax({
                    url: form.action,
                    type: 'post',
                    dataType: 'json',
                    context: form,
                    data: {
                        idProyecto: $("#idProyecto option:selected", $formCat).val()
                        , categoria: $("#categoria", $formCat).val()
                        , format: 'json'
                    },
                    beforeSend: function() {
                        $submitCat.val("Guardando...").addClass("disabled");
                    },
                    complete: function(data) {
                        $submitCat.removeClass("disabled").val("Guardar");
                        form.reset();
                        var retornoPhp = $.parseJSON(data.responseText), 
                            fila;
                        fila = "<tr id='"+retornoPhp.res.idCategoria+"'>";
                        fila += "<td class='editable'><span class='edit' id='"+retornoPhp.res.idCategoria+"'>"+retornoPhp.res.categoria+"</span></td>";
                        fila += "<td><span class='positivo'>$ 0</span></td>";
                        fila += "<td><span class='negativo'>$ 0</span></td>";
                        fila += "<td><span class='positivo'>$ 0</span></td>";
                        fila += "</tr>";
                        $(fila).hide().appendTo("#tabla tbody").fadeIn();
                    }
                });
            }
            return false;
        },
        success: function(label) {
        }
    });
});