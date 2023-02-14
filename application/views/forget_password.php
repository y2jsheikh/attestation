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
    <script src="<?php echo base_url('assets/js/jquery.mask.min.js'); ?>"></script>
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
        <h3>Ministry of National Health Services, Regulations & Coordination Islamabad</h3>
    </nav>
    <div class="dashboard-middle-content margin-top-40">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header">
                    <h3 class="text-white">Forgot Password</h3>
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
                                        <!--<label class="control-label">Email: <span class="requriedstar">*</span></label>-->
                                        <label class="control-label">CNIC/Passport No.: <span class="requriedstar">*</span></label>
                                        <?php // echo form_email('email', set_value('email'), array('class' => "form-control input-paf", 'id' => 'email', 'placeholder' => 'Enter Your Email ID', 'required' => '')) ?>
                                        <?php echo form_input('cnic', set_value('cnic'), array('class' => "form-control input-paf", 'id' => 'cnic', 'placeholder' => '#', 'maxlength' => '13', 'required' => '')) ?>
                                        <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions right">
                                <button type="submit" id="btn-submit" class="btn btn-primary">
                                    <i class="fa fa-check"></i> Submit
                                </button>
                                <small class="pull-right">
                                    <a href="<?php echo site_url('login') ?>">Back to Login</a>
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="passwordEmailModal" class="modal fade" aria-hidden="true">
                <div class="modal-dialog modal-confirm">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center" style="background: #218838; color: white;">
                            <button type="button" class="close" id="closing" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body text-center">
                            <h4>Password Change Request Generated!</h4>
                            <p>A Change Password Email has been sent. Please check your email provided against this CNIC for further processing. In case of any queries, please contact 0519245692 or Email at attestation@nhsrc.gov.pk</p>
                            <button type="button" id="closing_2" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check"></i> Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function () {
        var baseurl = '<?php echo site_url(); ?>';
    <?php if ($redirect_flag == 1){ ?>
        $('#passwordEmailModal').modal({backdrop: 'static', keyboard: false});
        $(document).on("click", "#closing, #closing_2", function () {
            location.assign(baseurl);
        });
    <?php } ?>

    });
</script>
</body>
</html>