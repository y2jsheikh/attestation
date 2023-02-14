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
        p {
            font-size: 15px;
            font-family: Arial, sans-serif
        }

        .table td {
            padding: .35rem;
            vertical-align: top;
            border-bottom: 1px solid #dee2e6;
            border-top: none;
            font-size: 14px;
            font-family: Arial, sans-serif
        }

        .table th {
            padding: .35rem;
            vertical-align: top;
            border-bottom: none;
            border-top: none;
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
        <?php if ($result->application_submitted == 'N'){ ?>
        <button id="save-btn" style="float: right; margin-right: 1%;">Save Application</button> &nbsp;
        <button id="back-btn">Go Back</button>
        <?php }else{ ?>
        <button id="dashboard-btn">Go Back</button>
        <?php } ?>
    </div>
    <div class="dashboard-middle-content">
        <?php
            $attest_request_id = isset($result->id) && $result->id != '' ? $result->id : 0;
        ?>
        <div class="row" id="print-application">
            <div class="paf-banks-next">
                <br/>
                <div style="padding-left: 15px; padding-right: 15px; padding-top: 1%;">
                    <div>
                        <img style="width: 12%; float: left;"
                             src="<?php echo base_url('assets/images/govlogo.png') ?>">
                        <h4 style="width: 86%; float: right; padding-top: 1%;" class="text-center">Application Form
                            For Attestation of Documents From M/O National Health Services Regulations &
                            Coordination, Islamabad For Doctors, Nurses, Paramedics, Pharmacists, Homeopathics, Tabibs and
                            Physiotherapists Desiring to Proceed Abroad for Job</h4>
                    </div>
                    <div style="clear: both"></div>
                    <div>
                        <br/>
                        <div style="float: right">
                        <p style="text-decoration: underline;">Application No: <span style="font-style: italic"><?php echo $result->app_number ?></span></p>
                        </div>
                        <center style="margin-left: 190px;">
                            <img src="<?php echo site_url('attestation/call_barcode/'.$result->app_number) ?>" width="350"/>
                        </center>
                    </div>
                </div>
                <div class="col-md-12">
                    <h4 style="margin-top: 5%;"><u>Personal Information</u></h4><br/>
                    <div class="row">
                        <div style="width: 100%; padding-left: 15px; text-align: left;">
                            <table class="table" style="border: none">
                                <tr>
                                    <th width="30%">Name of Applicant</th>
                                    <td width="70%"><?php echo isset($result->user_name) && $result->user_name != '' ? $result->user_name : '-'; ?></td>
                                </tr>
                                <tr>
                                    <th>Father's Name</th>
                                    <td><?php echo isset($result->father_name) && $result->father_name != '' ? $result->father_name : '-'; ?></td>
                                </tr>
                                <tr>
                                    <th>Profession</th>
                                    <td><?php echo isset($result->occupation) && $result->occupation != '' ? $result->occupation : '-'; ?></td>
                                </tr>
                                <?php if (isset($result->add_occupation) && $result->add_occupation != ''){ ?>
                                <tr>
                                    <th>Additional Profession</th>
                                    <td><?php echo $result->add_occupation ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <th>Domicile</th>
                                    <td><?php echo isset($result->domicile) && $result->domicile != '' ? $result->domicile : '-'; ?></td>
                                </tr>
                                <tr>
                                    <th>CNIC/Passport</th>
                                    <td><?php echo isset($result->cnic) && $result->cnic != '' ? $result->cnic : '-'; ?></td>
                                </tr>
                                <tr>
                                    <th>E-mail</th>
                                    <td><?php echo isset($result->email) && $result->email != '' ? $result->email : '-'; ?></td>
                                </tr>
                                <tr>
                                    <th>Contact Number</th>
                                    <td><?php echo isset($result->contact_number) && $result->contact_number != '' ? $result->contact_number : '-'; ?></td>
                                </tr>
                                <tr>
                                    <th>Marital Status</th>
                                    <td><?php echo isset($result->marital_status) && $result->marital_status != '' ? $result->marital_status : '-'; ?></td>
                                </tr>
                                <tr>
                                    <th>Full Address in Pakistan</th>
                                    <td><?php echo isset($result->address) && $result->address != '' ? $result->address : '-'; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h4 style="margin-top: 5%;"><u>Academics</u></h4><br/>
                    <div class="row">
                        <div style="width: 100%; padding-left: 15px; text-align: left;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Area of degree/transcript received</th>
                                    <th style="text-align: center">Name of institute</th>
                                    <th style="text-align: center">Name of degree/transcript received</th>
                                    <th style="text-align: center">Degree Received Year</th>
                                </tr>
                                </thead>
                                <?php if (!empty($qualification) && count($qualification) > 0) { ?>
                                    <?php foreach ($qualification as $qualify) { ?>
                                        <tr>
                                            <td style="text-align: center"><?php echo isset($qualify->qualification_area) && $qualify->qualification_area != '' ? $qualify->qualification_area : ''; ?></td>
                                            <td style="text-align: center"><?php echo isset($qualify->institute) && $qualify->institute != '' ? $qualify->institute : ''; ?></td>
                                            <td style="text-align: center"><?php echo isset($qualify->qualification) && $qualify->qualification != '' ? $qualify->qualification : ''; ?></td>
                                            <td style="text-align: center"><?php echo isset($qualify->completion_year) && $qualify->completion_year != '' ? $qualify->completion_year : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </table>
                        </div>
                    </div>

                    <h4 style="margin-top: 5%;"><u>Employment Information</u></h4><br/>
                    <div class="row">
                        <div style="width: 100%; padding-left: 15px; text-align: left;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Served in</th>
                                    <th style="text-align: center">Designation</th>
                                    <th style="text-align: center">Institute</th>
                                    <th style="text-align: center">Duration</th>
                                </tr>
                                </thead>
                                <?php if (!empty($experience) && count($experience) > 0) { ?>
                                    <?php foreach ($experience as $exp) { ?>
                                        <tr>
                                            <td style="text-align: center"><?php echo isset($exp->emp_type) && $exp->emp_type != '' ? $exp->emp_type : ''; ?></td>
                                            <td style="text-align: center"><?php echo isset($exp->designation) && $exp->designation != '' ? $exp->designation : ''; ?></td>
                                            <td style="text-align: center"><?php echo isset($exp->institute) && $exp->institute != '' ? $exp->institute : ''; ?></td>
                                            <td style="text-align: center">
                                                <?php
                                                $duration = '';
                                                if (isset($exp->start_date) && $exp->start_date != '') {
                                                    $duration .= $exp->start_date;
                                                }
                                                if (isset($exp->is_currently_working) && $exp->is_currently_working == 'Y') {
                                                    $duration .= ' - Currently Working';
                                                }
                                                if ((isset($exp->is_currently_working) && $exp->is_currently_working == 'N') && (isset($exp->end_date) && $exp->end_date != '')) {
                                                    $duration .= ' - ' . $exp->end_date;
                                                }
                                                echo $duration;
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php }  ?>

                            </table>
                        </div>
                    </div>

                    <h4 style="margin-top: 5%;"><u>Overseas Employment Information</u></h4><br/>
                    <div class="row">
                        <div style="width: 100%; padding-left: 15px; text-align: left;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Name of Country</th>
                                    <th style="text-align: center">Name of institution</th>
                                    <th style="text-align: center">Position to be held</th>
                                    <th style="text-align: center">Tentative Date of Joining</th>
                                    <th style="text-align: center">Purpose</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($overseas_experience) && count($overseas_experience) > 0) { ?>
                                    <?php foreach ($overseas_experience as $overseas_exp) { ?>
                                        <tr>
                                            <td style="text-align: center"><?php echo isset($overseas_exp->country) && $overseas_exp->country != '' ? $overseas_exp->country : ''; ?></td>
                                            <td style="text-align: center"><?php echo isset($overseas_exp->institute) && $overseas_exp->institute != '' ? $overseas_exp->institute : ''; ?></td>
                                            <td style="text-align: center"><?php echo isset($overseas_exp->position) && $overseas_exp->position != '' ? $overseas_exp->position : ''; ?></td>
                                            <td style="text-align: center"><?php echo isset($overseas_exp->joining_date) && $overseas_exp->joining_date != '' ? $overseas_exp->joining_date : ''; ?></td>
                                            <td style="text-align: center"><?php echo isset($overseas_exp->purpose) && $overseas_exp->purpose != '' ? $overseas_exp->purpose : ''; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <h4 style="margin-top: 5%;"><u>Document to Attest</u></h4><br/>
                    <div class="row">
                        <div style="width: 100%; padding-left: 15px; text-align: left;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Document Type</th>
                                    <th style="text-align: center">Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($attest)) { ?>
                                    <?php foreach ($attest as $att) { ?>
                                        <tr>
                                            <td style="text-align: center"><?php echo $att['doc_type']; ?></td>
                                            <td style="text-align: center"><?php echo $att['qualification']; ?></td>
                                        </tr>
                                    <?php }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <h4 style="margin-top: 5%;"><u>Required Documents to Attach</u></h4><br/>
                    <div class="row">
                        <div style="width: 52%; padding-left: 15px; float: left;">
                            <!--<p><b>Application Form</b></p>-->
                            <p><b>Affidavit (Attested by Oath Commissioner/Notary Public)</b></p>
                            <p><b>Copy of Degree/Diploma from the faculty/board/university</b></p>

                            <?php if ($result->add_occupation_id == 1): ?>
                                <p><b>Copy of valid PMC Certificate</b></p>
                            <?php endif; ?>
                            <?php if ($result->occupation_id == 1): ?>
                                <p><b>Copy of valid PMC Certificate</b></p>
                            <?php endif; ?>

                            <?php if ($result->add_occupation_id == 2): ?>
                                <p><b>Copy of valid PNC Card</b></p>
                            <?php endif; ?>
                            <?php if ($result->occupation_id == 2): ?>
                                <p><b>Copy of valid PNC Card</b></p>
                            <?php endif; ?>

                            <?php if ($result->add_occupation_id == 4 || $result->add_occupation_id == 5 || $result->add_occupation_id == 6): ?>
                                <p><b>Copy of Council Registration Certificate (valid)</b></p>
                            <?php endif; ?>
                            <?php if ($result->occupation_id == 4 || $result->occupation_id == 5 || $result->occupation_id == 6): ?>
                                <p><b>Copy of Council Registration Certificate (valid)</b></p>
                            <?php endif; ?>

                            <?php /* if ($result->occupation_id == 1 || $result->add_occupation_id == 1): ?>
                                <p><b>Copy of valid PMC Certificate</b></p>
                            <?php elseif ($result->occupation_id == 2 || $result->add_occupation_id == 2): ?>
                                <p><b>Copy of valid PNC Card</b></p>
                            <?php elseif (($result->occupation_id == 4 || $result->occupation_id == 5 || $result->occupation_id == 6) OR ($result->add_occupation_id == 4 || $result->add_occupation_id == 5 || $result->add_occupation_id == 6)): ?>
                                <!--<p><b>Copy of valid PMDC card</b></p>-->
                                <p><b>Copy of Council Registration Certificate (valid)</b></p>
                            <?php endif; */ ?>

                            <p><b>Copy of CNIC (valid)</b></p>
                            <p><b>Copy of Passport (if available)</b></p>
                            <p><b>Copy of all documents/experience certificates submitted for attestation</b></p>
                            <p><b>Original Document(s) required to be attested are attached</b></p>
                        </div>
                        <div style="width: 48%; padding-left: 20%; float: right;">
                            <!--<p>--><?php // echo isset($result->is_application_form) && $result->is_application_form == 'Y' ? 'Yes' : 'No'; ?><!--</p>-->
                            <p><?php echo isset($result->is_affidavit_attested) && $result->is_affidavit_attested == 'Y' ? 'Yes' : 'No'; ?></p>
                            <p><?php echo isset($result->is_copy_of_degree) && $result->is_copy_of_degree == 'Y' ? 'Yes' : 'No'; ?></p>

                            <?php if ($result->add_occupation_id == 1): ?>
                                <p><?php echo isset($result->is_copy_of_pmc) && $result->is_copy_of_pmc == 'Y' ? 'Yes' : 'No'; ?></p>
                            <?php endif; ?>
                            <?php if ($result->occupation_id == 1): ?>
                                <p><?php echo isset($result->is_copy_of_pmc) && $result->is_copy_of_pmc == 'Y' ? 'Yes' : 'No'; ?></p>
                            <?php endif; ?>

                            <?php if ($result->add_occupation_id == 2): ?>
                                <p><?php echo isset($result->is_copy_of_pnc) && $result->is_copy_of_pnc == 'Y' ? 'Yes' : 'No'; ?></p>
                            <?php endif; ?>
                            <?php if ($result->occupation_id == 2): ?>
                                <p><?php echo isset($result->is_copy_of_pnc) && $result->is_copy_of_pnc == 'Y' ? 'Yes' : 'No'; ?></p>
                            <?php endif; ?>

                            <?php if ($result->add_occupation_id == 4 || $result->add_occupation_id == 5 || $result->add_occupation_id == 6): ?>
                                <p><?php echo isset($result->is_copy_of_crc) && $result->is_copy_of_crc == 'Y' ? 'Yes' : 'No'; ?></p>
                            <?php endif; ?>
                            <?php if ($result->occupation_id == 4 || $result->occupation_id == 5 || $result->occupation_id == 6): ?>
                                <p><?php echo isset($result->is_copy_of_crc) && $result->is_copy_of_crc == 'Y' ? 'Yes' : 'No'; ?></p>
                            <?php endif; ?>

                        <?php /* if ($result->occupation_id == 1 || $result->add_occupation_id == 1): ?>
                            <p><?php echo isset($result->is_copy_of_pmc) && $result->is_copy_of_pmc == 'Y' ? 'Yes' : 'No'; ?></p>
                        <?php elseif ($result->occupation_id == 2 || $result->add_occupation_id == 2): ?>
                            <p><?php echo isset($result->is_copy_of_pnc) && $result->is_copy_of_pnc == 'Y' ? 'Yes' : 'No'; ?></p>
                        <?php elseif (($result->occupation_id == 4 || $result->occupation_id == 5 || $result->occupation_id == 6) OR ($result->add_occupation_id == 4 || $result->add_occupation_id == 5 || $result->add_occupation_id == 6)): ?>
                            <!--<p>--><?php // echo isset($result->is_copy_of_pmdc) && $result->is_copy_of_pmdc == 'Y' ? 'Yes' : 'No'; ?><!--</p>-->
                            <p><?php echo isset($result->is_copy_of_crc) && $result->is_copy_of_crc == 'Y' ? 'Yes' : 'No'; ?></p>
                        <?php endif; */ ?>

                            <p><?php echo isset($result->is_copy_of_cnic) && $result->is_copy_of_cnic == 'Y' ? 'Yes' : 'No'; ?></p>
                            <p><?php echo isset($result->is_copy_of_passport) && $result->is_copy_of_passport == 'Y' ? 'Yes' : 'No'; ?></p>
                            <p><?php echo isset($result->is_copy_of_experience) && $result->is_copy_of_experience == 'Y' ? 'Yes' : 'No'; ?></p>
                            <p><?php echo isset($result->is_orignal_doc_attached) && $result->is_orignal_doc_attached == 'Y' ? 'Yes' : 'No'; ?></p>
                            <p></p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-1">
                            <h5 class="lead">Note:</h5>
                        </div>
                        <div class="col-md-11">
                            <p>1. All copies should be attested.</br>2. I have Read SOPs carefully before submission of
                                documents for attestation.</p>
                        </div>
                    </div>
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

    <?php if ($result->application_submitted == 'N'){ ?>
        $('#back-btn').on('click', function () {
        <?php if ($role_id == 2){ ?>
            window.location.replace(SITE_URL + "attestation/edit_request/<?php echo $attest_request_id ?>");
        <?php }else{ ?>
            window.location.replace(SITE_URL + "attestation");
        <?php } ?>
        });
        $('#save-btn').on('click', function () {
            window.location.replace(SITE_URL + "attestation/save_application/<?php echo $attest_request_id ?>");
        });
    <?php }else{ ?>
        $('#dashboard-btn').on('click', function () {
        <?php if ($role_id == 2){ ?>
            window.location.replace(SITE_URL + "attestation");
        <?php }else{ ?>
            window.location.replace(SITE_URL + "dashboard");
        <?php } ?>
        });
    <?php } ?>



    });
</script>

</body>
</html>