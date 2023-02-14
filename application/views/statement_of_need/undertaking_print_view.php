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
        <?php if ($role_id == 2){ ?>
            <?php if ($result->user_application_submitted == 'N'){ ?>
                <button id="submit-btn" style="float: right; margin-right: 1%; display: none;">Submit</button> &nbsp;
                <button id="edit-btn">Edit</button>
            <?php } ?>
        <?php } ?>
        <?php // if ($role_id == 4){ ?>
            <button id="back-btn">Go Back</button>
        <?php // } ?>
    </div>
    <div class="dashboard-middle-content">
        <div class="row" id="print-application">
            <!--<div class="paf-banks-next">-->
            <div class="">
                <br/>
                <div style="padding-left: 15px; padding-right: 15px; padding-top: 1%; padding-bottom: 10%;">
                    <div>
                        <img style="width: 12%; float: left;"
                             src="<?php echo base_url('assets/images/govlogo.png') ?>">
                        <h3 class="text-center">Government of Pakistan
                        <span style="width: 86%; float: right; font-size: 23px;" class="text-center">
                            Ministry of National Health Services, Regulations & Coordination<br/>Attestation Section
                        </span>
                        </h3>
                    </div>
                </div>
                <div class="container-fluid">
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
                    <h4 class="mt-5"><u><?php echo $heading ?> Undertaking</u></h4><br/>
                    <div class="row">
                        <div class="col-md-12">
                        <?php /* if ($result->pmc_no == ''){ ?>
                        <p>
                            I, <?php echo $result->fullname ?> S/O, D/O <?php echo $result->father_name ?> Resident of <?php echo $result->address != '' ? $result->address : 'Not Mentioned' ?>, do hereby undertake and declare that, I will obtain PMC License and get my qualification registered within a year of completion of training.
                        </p>
                        <?php }else{ ?>
                        <p>
                            I, <?php echo $result->fullname ?> S/O, D/O <?php echo $result->father_name ?> Resident of <?php echo $result->address != '' ? $result->address : 'Not Mentioned' ?>, do hereby solemnly affirm and declare as under:
                        </p>
                        <?php } */ ?>
                        <p>
                            I, <?php echo $result->fullname ?> <?php echo $result->gender == 'Female' ? 'D/O' : 'S/O' ?> <?php echo $result->father_name ?> Resident of <?php echo $result->address != '' ? $result->address : 'Not Mentioned' ?>, do hereby solemnly affirm and declare as under:
                        </p>
                        <p>
                            a) This statement for obtaining the <?php echo $result->is_special_need == 'Y' ? 'Statement of  Exceptional Need' : 'Statement of Need' ?> from Ministry of National Health Services, Regulations and Coordination, Islamabad.<br/>
                            b) That I am the citizen of Pakistan by birth and applying the <?php echo $result->is_special_need == 'Y' ? 'Statement of  Exceptional Need' : 'Statement of Need' ?> for training in <?php echo $result->speciality ?> at <?php echo $result->institute ?> .<br/>
                            c) That I have passed <?php echo $result->qualification ?> from <?php echo $result->institute ?> in the year <?php echo $result->pass_year ?> .<br/>
                            <!--d) That I intend to undergo post-graduate / residency / fellowship training in the field of <?php /*echo $result->speciality */?> for <?php /*echo $result->years */?> years and upon completion of training in the United States and intends to enter the practice of medicine in the specialty for which training is being sought.<br/>-->
                            d) That I intend to undergo <?php echo $result->post_grad_training ?> training in the field of <?php echo $result->speciality ?> for <?php echo $result->years ?> years and upon completion of training in the United States I will return back to my country (Pakistan) and intends to enter the practice of medicine in the speciality for which training is being sought.<br/>
                            <!--e) That my above statement is true and correct to the best of my knowledge and belief and nothing has been concealed therein.<br/>-->
                        </p>
                        </div>
                    </div>

                    <?php if ($role_id == 2 && $result->user_application_submitted == 'N'){ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <p><b><label><input type="checkbox" id="check_stat" /> My above statement is true and correct to the best of my knowledge and belief and nothing has been concealed therein.</label></b></p>
                        </div>
                    </div>
                    <?php } ?>

                    <!--
                    <div class="row">
                        <div class="col-md-1">
                            <h5 class="lead">Note:</h5>
                        </div>
                        <div class="col-md-11">
                            <p>The above mentioned information / attached documents are correct / true and nothing has been concealed there-from.</p>
                        </div>
                    </div>
                    -->

                    <br>
                    <div class="row" style="display: none;">
                        <div class="col-md-4">
                            <p>
                                Signature: _____________________
                            </p>
                            <p>
                                Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                                        style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo date(' d M Y') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            </p>
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

        $('#check_stat').change(function() {
            if (this.checked) {
                $("#submit-btn").show();
            } else {
                $("#submit-btn").hide();
            }
        });

        <?php // if ($result->application_submitted == 'N'){ ?>
        $('#edit-btn').on('click', function () {
            window.location.replace(SITE_URL + "statement/edit_request/<?php echo $statement_id ?>");
        });
        <?php // }else{ ?>

        <?php if ($role_id == 4){ ?>
        $('#back-btn').on('click', function () {
            window.location.replace(SITE_URL + "statement");
        });
        <?php }else{ ?>
        $('#back-btn').on('click', function () {
            window.location.replace(SITE_URL + "dashboard");
        });
        $('#submit-btn').on('click', function () {
            window.location.replace(SITE_URL + "statement/statement_of_need_user_fields_print_view/<?php echo $statement_id ?>");
        });
        <?php } ?>

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