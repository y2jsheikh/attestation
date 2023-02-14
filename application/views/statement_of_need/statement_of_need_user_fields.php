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
                <button id="save-btn" style="float: right; margin-right: 1%; display: none;">Save Application</button> &nbsp;
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
                        <h3 class="text-center">Application Form
                        <span style="width: 88%; float: right; font-size: 23px;" class="text-center">
                            Ministry of National Health Services, Regulations & Coordination<br/>Attestation Section
                        </span>
                        </h3>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <?php /* if ($result->pmc_no == ''){ ?>
                        <p>
                            I, <?php echo $result->fullname ?> S/O, D/O <?php echo $result->father_name ?> Resident of <?php echo $result->address != '' ? $result->address : 'Not Mentioned' ?>, do hereby undertake and declare that, I will obtain PMC License and get my qualification registered within a year of completion of training.
                        </p>
                        <?php }else{ ?>
                        <p>
                            I, <?php echo $result->fullname ?> S/O, D/O <?php echo $result->father_name ?> Resident of <?php echo $result->address != '' ? $result->address : 'Not Mentioned' ?>, do hereby solemnly affirm and declare as under:
                        </p>
                        <?php } */ ?>
                        <ol type="1">
                            <li>Name of Applicant: <u><b><?php echo $result->fullname ?></b></u></li>
                            <li>CNIC No: <u><b><?php echo $result->cnic ?></b></u></li>
                            <li>Email Address: <u><b><?php echo $result->email ?></b></u></li>
                            <li>Cell Phone: <u><b><?php echo $result->contact_number ?></b></u></li>
                            <li>Present Address: <u><b><?php echo $result->address ?></b></u></li>
                            <li>Education Qualification: <u><b><?php echo $result->qualification ?></b></u></li>
                            <li>USMLE/ECFMG ID Number: <u><b><?php echo $result->ecfmg_no ?></b></u></li>
                            <li>PMC registration number: <u><b><?php echo $result->pmc_no ?></b></u></li>
                            <li>Are you a serving government employee? <u><b><?php echo $result->is_gov_employee == 'Y' ? 'Yes' : 'No'; ?></b></u></li>
                            <li>Speciality area for which overseas training is sought: <u><b><?php echo $result->speciality ?></b></u></li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php /* nhsrc website format ?>
                            <p>
                                11.	Undertaken that after the training abroad I shall return to Pakistan and serve: - <br/>
                                I, <u><b><?php echo $result->fullname ?></b></u> <?php echo $result->gender == 'Female' ? 'D/O': 'S/O'; ?>, <u><b><?php echo $result->father_name ?></b></u> Resident of <u><b><?php echo $result->address ?></b></u>, do hereby solemnly affirm and declare as under: <br/>
                                a)	This statement for obtaining the Statement of <?php echo $result->is_special_need == 'Y' ? 'Exceptional' : ''; ?> from Ministry of National Health Services, Regulations and Coordination, Islamabad. <br/>
                                b)	That I am the citizen of Pakistan by birth and applying the Statement of <?php echo $result->is_special_need == 'Y' ? 'Exceptional' : ''; ?> Need for training in <u><b><?php echo $result->speciality ?></b></u> at <u><b><?php echo $result->training_institute ?></b></u> <br/>
                                c)	That I have passed <?php echo $result->qualification ?> from <u><b><?php echo $result->institute ?></b></u> in the year <u><b><?php echo $result->pass_year ?></b></u> <br/>
                                d)	That I intend to undergo <?php echo $result->post_grad_training ?> training in the field of <u><b><?php echo $result->speciality ?></b></u> for <u><b><?php echo $result->years ?></b></u> years and will return back to my country. <br/>
                                e)	That my above statement is true and correct to the best of my knowledge and belief and nothing has been concealed therein.
                            </p>
                            <?php */ ?>
                            <p>
                                11. a) This statement for obtaining the <?php echo $result->is_special_need == 'Y' ? 'Statement of  Exceptional Need' : 'Statement of Need' ?> from Ministry of National Health Services, Regulations and Coordination, Islamabad.<br/>
                                b) That I am the citizen of Pakistan by birth and applying the <?php echo $result->is_special_need == 'Y' ? 'Statement of  Exceptional Need' : 'Statement of Need' ?> for training in <?php echo $result->speciality ?> at <?php echo $result->institute ?> .<br/>
                                c) That I have passed <?php echo $result->qualification ?> from <?php echo $result->institute ?> in the year <?php echo $result->pass_year ?> .<br/>
                                d) That I intend to undergo <?php echo $result->post_grad_training ?> training in the field of <?php echo $result->speciality ?> for <?php echo $result->years ?> years and upon completion of training in the United States I will return back to my country (Pakistan) and intends to enter the practice of medicine in the speciality for which training is being sought.<br/>
                            </p>
                        </div>
                    </div>
                    <?php /* ?>
                    <div class="row">
                        <div class="col-md-12">
                            <p>12.	The above mentioned information / attached documents are correct / true and nothing has been concealed there-from.</p>
                        </div>
                    </div>
                    <?php */ ?>
                    <?php if ($role_id == 2 && $result->user_application_submitted == 'N'){ ?>
                        <div class="row">
                            <div class="col-md-12">
                                <p><b><label><input type="checkbox" id="check_stat" /> The above mentioned information / attached documents are correct / true and nothing has been concealed there-from.</label></b></p>
                            </div>
                        </div>
                    <?php } ?>
                    <br/>
                    <div class="row" style="display: none;">
                        <div class="col-md-4">
                            <p>
                                Signature: ____________________________
                            </p>
                            <p>
                                Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo date(' d M Y') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
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
                $("#save-btn").show();
            } else {
                $("#save-btn").hide();
            }
        });

        <?php // if ($result->application_submitted == 'N'){ ?>

        $('#save-btn').on('click', function () {
            if (confirm("Are you sure you want to save! Please make sure the data you've entered is accurate up to your knowledge. You can edit in case any change is required. This action is irreversible.") == true) {
                window.location.replace(SITE_URL + "statement/user_save_application/<?php echo $statement_id ?>");
            //    return true;
            } else {
                return false;
            }
        //    window.location.replace(SITE_URL + "statement/user_save_application/<?php echo $statement_id ?>");
        });

        <?php // }else{ ?>

        $('#back-btn').on('click', function () {
            <?php if ($role_id == 4){ ?>
                <?php if ($result->status == 'pending'){ ?>
                window.location.replace(SITE_URL + "statement/receive");
                <?php } else { ?>
                window.location.replace(SITE_URL + "statement");
                <?php } ?>
            <?php }elseif ($role_id == 2 && $result->user_application_submitted == 'N'){ ?>
            window.location.replace(SITE_URL + "statement/statement_of_need_undertaking/<?php echo $statement_id ?>");
            <?php }elseif ($role_id == 2 && $result->user_application_submitted == 'Y'){ ?>
            window.location.replace(SITE_URL + "dashboard");
            <?php } ?>
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