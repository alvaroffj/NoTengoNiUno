var validator;
var $form;
$(document).ready(function() {
    $form = $(".form-inline");
    $('.edit').editable('/public/Categoria/mod', {
//        loadurl : '/public/Categoria/mod',
        indicator : 'Guardando...',
        tooltip : 'Click para editar...',
        id : $(this).id,
        name : "nomCat",
        width: 150,
        height: 15
    });
    validator = $form.bind("invalid-form.validate",
        function() {
//            $(".notification").html("<div>Debe completar todos lo campos requeridos</div>");
//            $(".notification").attr("class", "notification error png_bg");
        }).validate({
        errorPlacement: function(error, element) {
        },
        submitHandler: function(form) {
            form.submit();
        },
        success: function(label) {
        }
    });
});