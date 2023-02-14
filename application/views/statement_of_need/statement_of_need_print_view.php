<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('favicon.ico'); ?>"/>
    <title>Attestation | <?php echo $title; ?> </title>
    <!-- CSS Links -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
    <!-- / Script Links -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <style>
        p{
            font-size: x-large;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <?php
        $message = $this->session->flashdata('success_response');
        if (isset($message) && $message != '') {
        ?>
            <div id="savedAsDraftModal" class="modal fade" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-confirm">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center" style="background: #218838; color: white;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body text-center">
                            <h4>Success!</h4>
                            <p><?php echo $message ?></p>
                            <button class="btn btn-success" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $('#savedAsDraftModal').modal({backdrop: 'static', keyboard: false});
            </script>
        <?php
        }
        ?>
    </div>
    <div id="print-btn-div">
        <button id="print-btn" style="float: right;">Print Application</button>
        <?php if ($role_id == 4){ ?>
            <?php if ($result->application_submitted == 'N'){ ?>
                <button id="save-btn" style="float: right; margin-right: 1%;">Save Application</button> &nbsp;
                <button id="edit-btn">Edit</button>
            <?php } ?>
        <?php } ?>
        <button id="back-btn">Go Back</button>
    </div>
    <div class="dashboard-middle-content">
        <div class="row" id="print-application">
            <!--<div class="paf-banks-next">-->
            <br/>
            <div style="padding-left: 15px; padding-right: 15px; padding-top: 1%; padding-bottom: 3%;">
                <div style="margin-left: 4%;">
                    <img style="width: 17%; float: left;"
                         src="<?php echo base_url('assets/images/govlogo.png') ?>">
                    <h3 class="text-center" style="padding-top: 3%;"><strong>Government of Pakistan
                        <span style="width: 83%; float: right; font-size: 23px;" class="text-center">
                            Ministry of National Health Services, Regulations & Coordination<br/>Attestation Section
                        </span></strong>
                    </h3>
                </div>
            </div>
            <div class="container">
                <!--<div style="clear: both;"></div>-->
                <div style="padding-left: 15px; padding-right: 15px;">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><strong>No. F11-1/2013-NHS R&C/NOC</strong></h5>
                        </div>
                        <div class="col-md-6">
                            <h5 class="pull-right"><strong>Serial Number: 20/<?php echo date('Y'); ?><br/>Islamabad, <?php echo date('F d, Y', time()); ?></strong></h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mt-2 col-md-12">
                        <?php
                        $heading = "Statement of Need";
                        $need = "a need";
                        if ($result->is_special_need == 'Y'){
                            $heading = "Statement of Exceptional Need";
                            $need = "an exceptional need";
                        }else{
                            $heading = "Statement of Need";
                            $need = "a need";
                        }
                        ?>
                        <h4 class="text-center"><strong><u><?php echo $heading ?></u></strong></h4><br/><br/>

                        <div class="col-md-12">
                            <p><b>USMLE/ECFMG ID Number: <?php echo $result->ecfmg_no ?></b></p>
                            <p><b>Name of Applicant for Visa: <?php echo $result->fullname ?></b></p>
                            <p>
                                There currently exists in Pakistan <?php echo $need ?> for qualified medical practitioners in the
                                speciality of <?php echo $result->speciality ?>. <?php echo ucfirst($result->fullname) ?> has filed a written
                                assurance with the government of this country that <?php echo $result->gender == 'Female' ? 'she' : 'he'; ?> will return to this country
                                upon completion of training in the United States and intends to enter the practice of
                                medicine in the speciality for which training is being sought.
                            </p>
                            <br/>
                            <p>
                                This letter is valid for above said medical education program.
                            </p>
                            <br/>
                        </div>
                        <div class="col-md-12" style="margin-top: 5%;">
                            <p class="pull-right">(<?php echo $result->signatory != '' ? $result->signatory : 'Dr. Nusrat Haider'; ?>)<br/><?php echo $result->signatory_designation != '' ? $result->signatory_designation : 'Assistant Director'; ?><br/><?php echo $result->signatory_department != '' ? $result->signatory_department : ''; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.print.js'); ?>"></script>
<script>
    var SITE_URL = '<?php echo site_url() ?>';
    $(document).ready(function () {
    /*
        $(document).on("click", "#print-btn", function () {
            window.print();
        });
    */
        $('#print-btn').on('click', function () {
            $.print("#print-application");
        });

        <?php // if ($result->application_submitted == 'N'){ ?>
        $('#edit-btn').on('click', function () {
            window.location.replace(SITE_URL + "statement/edit_request/<?php echo $statement_id ?>");
        });
        $('#save-btn').on('click', function () {
            if (confirm("Are you sure you want to save! This action is irreversible.") == true) {
                window.location.replace(SITE_URL + "statement/save_application/<?php echo $statement_id ?>");
            //    return true;
            } else {
                return false;
            }
        //    window.location.replace(SITE_URL + "statement/save_application/<?php echo $statement_id ?>");
        });
        <?php // }else{ ?>
        $('#back-btn').on('click', function () {
            window.location.replace(SITE_URL + "statement");
        });
        <?php // } ?>

    });

    /*
    function savePrompt() {
        if (confirm("Are you sure you want to save! This action is irreversible.") == true) {
            return true;
        } else {
            return false;
        }
    }
    */
    
</script>

</body>
</html>