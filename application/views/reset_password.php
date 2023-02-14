<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('favicon.ico'); ?>"/>
    <title>Attestation | <?php echo $title; ?> </title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/css/style_new.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/components.css'); ?>" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/select2.full.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.mask.min.js'); ?>"></script>
    <!-- Datepicker Links -->
    <link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
    <!-- / Datepicker Links -->
    <style>
        .font-hg {
            font-size: 23px;
        }

        .font-lg {
            font-size: 18px;
        }

        .font-md {
            font-size: 14px;
        }

        .font-sm {
            font-size: 13px;
        }

        .font-xs {
            font-size: 11px;
        }

        .bg-red {
            background: #e7505a !important;
        }

        .bg-font-green-soft {
            color: #FFFFFF !important;
        }

        .bg-green {
            background: #32c5d2 !important;
            color: white;
        }

        .bg-font-red-soft {
            color: #FFFFFF !important;
        }

        .requriedstar {
            color: #ff2825 !important;
        }

        .makeRed {
            box-shadow: 1px 1px 2px #ffd2dc, 0 0 25px #ff2825, 0 0 5px white;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        /*Password Strength Checker Start*/
        /*
        .passwordInput{
            margin-top: 5%;
            text-align :center;
        }
        */
        .displayBadge {
            margin-top: 5%;
            display: none;
            text-align: center;
        }

        /*Password Strength Checker End*/
        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light nav-bg fixed-top" style="left: 0">
        <div class="sidebar-heading clearfix">
            <a href="<?php echo site_url()?>"><img src="<?php echo base_url('assets/images/logo.png')?>" width="75"></a>
        </div>
        <h3>Ministry Of National Health Services, Regulations and Coordination</h3>
    </nav>
    <div class="dashboard-middle-content margin-top-40">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header">
                    <h3 class="text-white">Reset Password</h3>
                </div>
                <?php if (validation_errors() != '') { ?>
                    <br>
                    <?php echo validation_errors(); ?>
                <?php } ?>
                <?php
                $message = $this->session->flashdata('response');
                if (isset($message) && $message != '') {
                    echo '<br><div class="bg-red" style="margin: 10px; padding: 10px" role="alert"><strong class="bg-font-green-soft font-lg">' . $message . '</strong></div>';
                }
                ?>
            </div>
            <div class="col-md-12">
                <div class="paf-banks-next">
                    <div class="bank-padding">
                        <form method="post" action="">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Password: <span
                                                    class="requriedstar">*</span></label>
                                        <?php // echo form_input('password', set_value('password'), array('class' => "form-control input-paf", 'id' => 'password', 'placeholder' => 'Password', 'required' => '')) ?>
                                        <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                                        <input type="password" id="PassEntry" name="password"
                                               class="form-control input-paf passwordInput"
                                               placeholder="Atleast 1 Capital and Small Alphabet, 1 Symbol, 1 Number" required/>
                                        <span id="StrengthDisp" class="badge displayBadge">Weak</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Confirm Password: <span
                                                    class="requriedstar">*</span></label>
                                        <?php // echo form_input('password', set_value('password'), array('class' => "form-control input-paf", 'id' => 'password', 'placeholder' => 'Password', 'required' => '')) ?>
                                        <input type="password" id="confirm_password" name="confirm_password"
                                               class="form-control input-paf" placeholder="Confirm Password" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions right">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" id="btn-submit" class="btn btn-primary">
                                    <i class="fa fa-check"></i> Change Password
                                </button>
                                <small class="pull-right"><a href="<?php echo site_url('login') ?>">Back to
                                        Login</a></small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        // Password Strength Checker Start
        // timeout before a callback is called

        let timeout;
        // traversing the DOM and getting the input and span using their IDs
        let password = document.getElementById('PassEntry');
        let strengthBadge = document.getElementById('StrengthDisp');
        // The strong and weak password Regex pattern checker
        let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})');
        let mediumPassword = new RegExp('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))');

        function StrengthChecker(PasswordParameter) {
            // We then change the badge's color and text based on the password strength
            if (strongPassword.test(PasswordParameter)) {
                strengthBadge.style.backgroundColor = "green";
                strengthBadge.style.color = "white";
                strengthBadge.textContent = 'Strong';

                $("#btn-submit").removeClass("disabled");
                $("#btn-submit").prop("disabled", false);

            } else if (mediumPassword.test(PasswordParameter)) {
                strengthBadge.style.backgroundColor = 'blue';
                strengthBadge.style.color = 'white';
                strengthBadge.textContent = 'Medium';

                $("#btn-submit").addClass("disabled");
                $("#btn-submit").prop("disabled", true);

            } else {
                strengthBadge.style.backgroundColor = 'red';
                strengthBadge.style.color = 'white';
                strengthBadge.textContent = 'Weak';

                $("#btn-submit").addClass("disabled");
                $("#btn-submit").prop("disabled", true);

            }
        }

        // Adding an input event listener when a user types to the  password input
        password.addEventListener("input", () => {
            //The badge is hidden by default, so we show it
            strengthBadge.style.display = 'block';
            clearTimeout(timeout);
            //We then call the StrengChecker function as a callback then pass the typed password to it
            timeout = setTimeout(() => StrengthChecker(password.value), 400);
            //Incase a user clears the text, the badge is hidden again
            if (password.value.length !== 0) {
                strengthBadge.style.display != 'block';
            } else {
                strengthBadge.style.display = 'none';
            }
        });
        // Password Strength Checker End

        $(document).on("click", "#btn-submit", function () {
            var password = $("#PassEntry").val();
            var confirm_password = $("#confirm_password").val();
            if ((password != '' && confirm_password != '') && (password != confirm_password)) {
            //    if ($("#password").val() != $("#confirm_password").val()) {
                alert("Please enter the same confirm password.");
                return false;
            }
        });
    });
</script>

</body>
</html>