$(document).ready(function () {
    $(".select2").select2();
    $(".mobile_no").mask('0000-0000000');
    $(".year_mask").mask('0000');
    $(".cnic").mask('0000000000000');
    $(".datepicker").datepicker({dateFormat: 'mm/dd/yy'});
    var $loading = $('#loadingDiv').hide();
    $(document).ajaxStart(function () {
        $loading.show();
    }).ajaxStop(function () {
        $loading.hide();
    });
    $("form").on("submit", function () {
        $loading.show();
    });
    $(document).on("input", ".only_alpha", function () {
        $(this).val($(this).val().replace(/[^A-Z a-z]/g, ''));
    });
    $(document).on("input", ".only_numeric", function () {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
    $(document).on("input", ".only_numeric_decimal", function () {
        $(this).val($(this).val().replace(/[^\d.]/g, ''));
    });
    $("input#username").on({
        keydown: function (e) {
            if (e.which === 32)
                return false;
        },
        change: function () {
            this.value = this.value.replace(/\s/g, "");
        }
    });
    $(document).on('click', 'input[type="submit"], button[type="submit"]', function(){
        $("input, select").each( function(){
            var $this = $(this);
            var value = $this.val();
            if ($this.attr('required') == 'required') {
                if (value.length == 0){
                    $this.addClass("makeRed");
                }
            } else {
                $this.removeClass("makeRed");
            }
        });
    });
    $(document).on("keyup", "#answer_num", function () {
        var num_1 = $("#num_1").val();
        var num_2 = $("#num_2").val();
        var answer = parseInt(num_1) + parseInt(num_2);
        var result = $(this).val();
        if (answer != result) {
            $("#answer_num").addClass("makeRed");
            $(".btn-login-cc").addClass("disabled");
            $(".btn-login-cc").prop("disabled", true);
            return false;
        }else{
            $("#answer_num").removeClass("makeRed");
            $(".btn-login-cc").removeClass("disabled");
            $(".btn-login-cc").prop("disabled", false);
            return false;
        }
    });
    $(document).on('click', '#btn_login_cc', function(){
        $("input, select").each( function(){
            var $this = $(this);
            var value = $this.val();
            $this.removeClass("makeRed");
            if (value.length == 0){
                $this.addClass("makeRed");
            }
        });
    });
    $("input,select").focus(function(){
        $(this).removeClass("makeRed");
    })
});