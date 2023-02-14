$(document).ready(function () {
    $("form").attr("autocomplete", 'off');
    $(document).ajaxStart(function () {
        $(".loader").show();
        $("#loader").show();
    });
    $(document).ajaxStop(function () {
        $(".loader").hide();
        $("#loader").hide();
    });
    //for only alphabets
    $(document).on("input", ".only_alpha", function () {
        $(this).val($(this).val().replace(/[^A-Z a-z]/g, ''));
    });
    //for only number
    $(document).on("input", ".only_numeric", function () {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });

});