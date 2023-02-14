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
<script>
    var BASE_URL = '<?php echo base_url() ?>';
    var SITE_URL = '<?php echo site_url() ?>';
    $(document).ready(function () {
        var $loading = $('#loadingDiv').hide();
        $(document).ajaxStart(function () {
            $loading.show();
        }).ajaxStop(function () {
            $loading.hide();
        });
        $("form").on("submit", function () {
            $loading.show();
        });
        //for only nuneric
        $(document).on("input", ".only_numeric", function () {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
    });
</script>

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
                    <h3 class="text-white">Enter OTP</h3>
                </div>
                <?php if (validation_errors() != '') { ?>
                    <br>
                    <?php echo validation_errors(); ?>
                <?php } ?>
                <?php
                $message = $this->session->flashdata('response');
                $error_message = $this->session->flashdata('error_response');
                $success_message = $this->session->flashdata('success_response');
                if (isset($message) && $message != '') {
                    echo '<br><div class="bg-green" style="margin: 10px; padding: 10px" role="alert"><strong class="bg-font-green-soft font-lg">' . $message . '</strong></div>';
                }
                if (isset($error_message) && $error_message != '') {
                    echo '<br><div class="bg-red" style="margin: 10px; padding: 10px" role="alert"><strong class="bg-font-red-soft font-lg">' . $error_message . '</strong></div>';
                }
                if (isset($success_message) && $success_message != '') {
                    echo '<br><div class="bg-green" style="margin: 10px; padding: 10px" role="alert"><strong class="bg-font-green-soft font-lg">' . $success_message . '</strong></div>';
                }
                ?>
            </div>
            <div class="col-md-12">
                <div class="paf-banks-next">
                    <div class="bank-padding">
                        <form method="post" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Enter Number: <span class="requriedstar">*</span></label>
                                        <?php echo form_input('otp', set_value('otp'), array('class' => "form-control input-paf only_numeric", 'id' => 'otp', 'placeholder' => '#', 'minlength' => '6', 'maxlength' => '6', 'required' => '')) ?>
                                        <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"> &nbsp; </label><br/>
                                        <button type="submit" id="btn-submit" class="btn btn-primary">
                                            <i class="fa fa-check"></i> Submit
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <small><a href="<?php echo site_url('user/otp_resend/'.$user_id) ?>">Resend</a> OTP</small>
                                        <small class="pull-right"><a href="<?php echo site_url('login') ?>">Back to Login</a></small>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>