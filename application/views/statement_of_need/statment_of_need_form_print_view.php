<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/select2.min.css'); ?>" rel="stylesheet">

<div class="container">
    <div class="row" id="print-btn-div">
        <div class="col-md-6">
            <button id="back-btn" class="float-left">Go Back</button>
        </div>
        <div class="col-md-6">
            <button id="print-btn" class="float-right">Print</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php if (validation_errors() != '') { ?>
                <br>
                <?php echo validation_errors(); ?>
            <?php } ?>
            <?php
            $message = $this->session->flashdata('response');
            if (isset($message) && $message != '') {
                echo '<br><div class="bg-red" style="margin: 10px; padding: 10px" role="alert">
                        <strong class="bg-font-red-soft font-lg">' . $message . '</strong></div>';
            }
            $success_message = $this->session->flashdata('success_response');
            if (isset($success_message) && $success_message != '') {
                echo '<br><div class="bg-green" style="margin: 10px; padding: 10px" role="alert">
                        <strong class="bg-font-green-soft font-lg">' . $success_message . '</strong></div>';
            }
            ?>
        </div>
        <div class="col-md-12">
            <div class="paf-banks-next">
                <div class="bank-padding">
                    <div class="row" id="print-application">
                        <div class="col-md-12 mt-5 mb-5">
                            <h3 class="text-center"><?php echo $result->fullname ?>'s Statement of Need</h3><br/>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">USMLE/ECFMG ID Number: </label>
                                <label class="form-control input-paf"><?php echo $result->ecfmg_no ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">PMC Registered: </label><br/>
                                <label>
                                <?php
                                    if ($result->is_pmc_reg == 'N'){
                                ?>
                                        <label class="form-control input-paf">No</label>
                                <?php
                                    }else{
                                ?>
                                        <label class="form-control input-paf">Yes</label>
                                <?php
                                    }
                                ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4" style="display: <?php echo $result->is_pmc_reg == 'Y' ? 'block' : 'none'; ?>;">
                            <label class="control-label">PMC Number: </label>
                            <label class="form-control input-paf"><?php echo $result->pmc_no ?> </label>
                        </div>
                        <div class="col-md-4" style="display: <?php echo $result->is_pmc_reg == 'N' ? 'block' : 'none'; ?>;">
                            <label class="control-label">I <?php echo $result->fullname ?> S/O, D/O <?php echo $result->father_name ?> Resident of <?php echo $result->address ?>, do hereby undertake and declare that, I will obtain PMC License and get my qualification registered within a year of completing of training.</label>
                        </div>

                        <div class="col-md-12">
                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="image-upload">
                                    <label for="contract_letter">
                                        <?php if ($result->contract_letter != ''){ ?>
                                            <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                        <?php }else{ ?>
                                            No Attachment Found
                                        <?php } ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="image-upload">
                                    <label for="ecfmg_certificate">
                                        <?php if ($result->ecfmg_certificate != ''){ ?>
                                            <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                        <?php }else{ ?>
                                            No Attachment Found
                                        <?php } ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="image-upload">
                                    <label for="cnic_copy">
                                        <?php if ($result->cnic_copy != ''){ ?>
                                            <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                        <?php }else{ ?>
                                            No Attachment Found
                                        <?php } ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="image-upload">
                                    <label for="other_file">
                                        <?php if ($result->other_file != ''){ ?>
                                            <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                        <?php }else{ ?>
                                            No Attachment Found
                                        <?php } ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-12">
                            <hr/>
                            <h4 class="text-muted">Basic Information</h4>
                            <br/>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Name of Applicant: <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf"><?php echo $result->fullname ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Father's Name: <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf"><?php echo $result->father_name ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Cell Phone: <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf"><?php echo $result->contact_number ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Email Address: </label>
                                <label class="form-control input-paf"><?php echo $result->email ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">CNIC/Passport #: <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf"><?php echo $result->cnic ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Present Address: <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf"><?php echo $result->address ?></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr/>
                            <h4 class="text-muted">Education / Qualification Information</h4>
                            <br/>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Graduation: <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf"><?php echo $result->qualification ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Graduation Degree was received: <span class="requriedstar">*</span> (<small class="text-muted">Institute</small>)</label>
                                <label class="form-control input-paf"><?php echo $result->institute ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Post Graduation: (<small class="text-muted">Optional</small>)</label>
                                <label class="form-control input-paf"><?php echo $result->post_qualification ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Year of Passing: <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf"><?php echo $result->pass_year ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Are you a serving government employee? </label><br/>
                                <label class="form-control input-paf"><?php echo $result->is_gov_employee == 'N' ? 'No' : 'Yes'; ?></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="clearfix"></div>
                            <hr/>
                            <h4 class="text-muted">Overseas Training Information</h4>
                            <br/>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Speciality Area: <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf"><?php echo $result->speciality ?></label>
                                <small class="text-muted">According to offer letter/as per contract</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Commencing Date: <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf"><?php echo $result->training_start_date ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Duration (in Years): <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf"><?php echo $result->years ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Institute in which overseas training is sought: <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf"><?php echo $result->training_institute ?></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr/>
                            <h4 class="text-muted">In Case Statement of Exceptional Need</h4>
                            <br/>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Special Need: <?php echo $result->is_special_need == 'Y' ? 'Yes' : 'No'; ?></label>
                                <label class="form-control input-paf" style="display: <?php echo $result->is_special_need == 'Y' ? 'block' : 'none'; ?>;"><?php echo $result->special_need_remarks ?></label>
                            </div>
                        </div>
                    </div>

                    <hr/>
                    <form name="form_approval" method="post" action="">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-muted">Form Approval</h4><br/>
                            </div>
                            <div class="col-md-2">
                                <label><input type="checkbox" id="status" name="status" checked /> Accepted</label>
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id ?>" />
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                            </div>
                            <div class="col-md-6" id="signatory-div">
                                <div class="form-group">
                                    <?php echo $signatory_select ?>
                                    <input type="hidden" id="signatory" name="signatory" />
                                </div>
                            </div>
                            <div class="col-md-6" id="remarks-div" style="display: none;">
                                <div class="form-group">
                                    <input type="text" placeholder="Remarks" id="ministry_comment" name="ministry_comment" class="form-control input-paf" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-info float-right"><i class="fa fa-check"></i>Submit</button>
                            </div>
                            <div class="col-md-12"><br/></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.print.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/select2.full.min.js'); ?>"></script>
<script>
    var SITE_URL = '<?php echo site_url() ?>';
    $(document).ready(function () {
        $(".select2").select2();
        $('#print-btn').on('click', function () {
            $.print("#print-application");
        });
        $('#back-btn').on('click', function () {
            window.location.replace(SITE_URL + "statement/receive");
        });
        $(document).on("change", "#signatory_id", function () {
            var signatory = $("#signatory_id option:selected").text();
            $("#signatory").val(signatory);
        });
        $('#status').change(function() {
            if (this.checked) {
                $("#signatory-div").show();
                $("#remarks-div").hide();
                $("#signatory_id").prop('required', true);
                $("#ministry_comment").prop('required', false);
                $("#ministry_comment").val('');
            } else {
                $("#remarks-div").show();
                $("#signatory-div").hide();
                $("#ministry_comment").prop('required', true);
                $("#signatory_id").prop('required', false);
                $("#signatory_id").val('').change();
            }
        });

    });
</script>