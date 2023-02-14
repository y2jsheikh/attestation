$(document).ready(function () {
    $(".select2").select2(), $(".mobile_no").mask("0000-0000000"), $(".year_mask").mask("0000"), $(".cnic").mask("0000000000000"), $(".ecfmg_mask").mask("0-000-000-0"), $(".datepicker").datepicker({ dateFormat: "mm/dd/yy" });
    var e = $("#loadingDiv").hide();
    $(document)
        .ajaxStart(function () {
            e.show();
        })
        .ajaxStop(function () {
            e.hide();
        }),
        $("form").on("submit", function () {
            e.show();
        }),
        $(document).on("input", ".only_alpha", function () {
            $(this).val(
                $(this)
                    .val()
                    .replace(/[^A-Z a-z]/g, "")
            );
        }),
        $(document).on("input", ".only_numeric", function () {
            $(this).val(
                $(this)
                    .val()
                    .replace(/[^0-9]/g, "")
            );
        }),
        $(document).on("input", ".only_numeric_decimal", function () {
            $(this).val(
                $(this)
                    .val()
                    .replace(/[^\d.]/g, "")
            );
        }),
        $("input#username").on({
            keydown: function (e) {
                if (32 === e.which) return !1;
            },
            change: function () {
                this.value = this.value.replace(/\s/g, "");
            },
        }),
        $(document).on("click", 'input[type="submit"], button[type="submit"]', function () {
            $("input, select").each(function () {
                var e = $(this),
                    n = e.val();
                "required" == e.attr("required") ? 0 == n.length && e.addClass("makeRed") : e.removeClass("makeRed");
            });
        }),
        /*
        $(document).on("keyup", "#answer_num", function () {
            var e = $("#num_1").val(),
                n = $("#num_2").val();
            return parseInt(e) + parseInt(n) != $(this).val()
                ? ($("#answer_num").addClass("makeRed"), $(".btn-login-cc").addClass("disabled"), $(".btn-login-cc").prop("disabled", !0), !1)
                : ($("#answer_num").removeClass("makeRed"), $(".btn-login-cc").removeClass("disabled"), $(".btn-login-cc").prop("disabled", !1), !1);
        }),
        */
        $(document).on("click", "#btn_login_cc", function () {
            var e = $("#num_1").val(),
                n = $("#num_2").val();
            /*
            $("input, select").each(function () {
                var e = $(this),
                    n = e.val();
                e.removeClass("makeRed"), 0 == n.length && e.addClass("makeRed");
            });
            */
            if ($("#answer_num").val() != '') {
                if (parseInt(e) + parseInt(n) != $("#answer_num").val()) {
                    $('#answerModal').modal({backdrop: 'static', keyboard: false});
                    return false;
                }
            }

        }),
        $("input,select").focus(function () {
            $(this).removeClass("makeRed");
        });
});
