
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
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Edit Statement of Need</h3><hr/>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">USMLE/ECFMG ID Number: </label>
                                <?php
                                if ($result->ecfmg_no != '') {
                                ?>
                                <label class="form-control input-paf" readonly><?php echo $result->ecfmg_no ?></label>
                                <input type="hidden" name="ecfmg_no" value="<?php echo $result->ecfmg_no ?>" />
                                <?php
                                } else {
                                ?>
                                <?php echo form_input('ecfmg_no', set_value('ecfmg_no', $result->ecfmg_no), array('class' => "form-control input-paf ecfmg_mask", 'id' => 'ecfmg_no', 'minlength' => 11, 'maxlength' => 11, 'placeholder' => '#')) ?>
                                <?php
                                }
                                ?>
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $result->user_id ?>" />
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">PMDC Registered: </label><br/>
                                <?php
                                if ($result->pmc_no != '') {
                                ?>
                                    Yes
                                    <input type="hidden" name="is_pmc_reg" value="Y" />
                                <?php
                                } else {
                                ?>
                                    <label><input name="is_pmc_reg" type="radio" value="Y" <?php echo $result->is_pmc_reg == 'Y' ? 'checked' : ''; ?> /> Yes</label> &nbsp;
                                    <label><input name="is_pmc_reg" type="radio" value="N" <?php echo $result->is_pmc_reg == 'N' ? 'checked' : ''; ?> /> No</label>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4" id="pmc_no_div" style="display: <?php echo $result->is_pmc_reg == 'Y' ? 'block' : 'none'; ?>;">
                            <label class="control-label">PMDC Number: </label>
                            <?php
                            if ($result->pmc_no != '') {
                            ?>
                                <label class="form-control input-paf" readonly><?php echo $result->pmc_no ?></label>
                                <input type="hidden" name="pmc_no" value="<?php echo $result->pmc_no ?>" />
                            <?php
                            } else {
                            ?>
                            <?php echo form_input('pmc_no', set_value('pmc_no', $result->pmc_no), array('class' => "form-control input-paf", 'id' => 'pmc_no', 'placeholder' => '#')) ?>
                            <?php
                            }
                            ?>
                        </div>

                        <?php if ($role_id == 2){ ?>
                        <div class="col-md-12">
                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id ?>" />
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                                <div class="image-upload">
                                    <label for="contract_letter">
                                        <?php if ($result->contract_letter != ''){ ?>
                                            <a href="<?php echo base_url('uploads/statment_of_need/letters/'.$result->contract_letter) ?>" target="_blank">
                                                <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                            </a>
                                        <?php }else{ ?>
                                            <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                        <?php } ?>
                                        <img id="contract_letter" width="50" />
                                    </label><br/>
                                    <input id="contract_letter"
                                           name="contract_letter"
                                           size="200000"
                                           type="file"
                                           <?php echo $result->contract_letter == '' ? 'required' : ''; ?> />
                                </div>
                                <br>
                                <span id="contract_letter_error" style="color: red;"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="image-upload">
                                    <label for="ecfmg_certificate">
                                        <?php if ($result->ecfmg_certificate != ''){ ?>
                                            <a href="<?php echo base_url('uploads/statment_of_need/letters/'.$result->ecfmg_certificate) ?>" target="_blank">
                                                <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                            </a>
                                        <?php }else{ ?>
                                            <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                        <?php } ?>
                                        <img id="ecfmg_certificate" width="50" />
                                    </label><br/>
                                    <input id="ecfmg_certificate"
                                           name="ecfmg_certificate"
                                           size="200000"
                                           type="file"
                                        <?php echo $result->ecfmg_certificate == '' ? 'required' : ''; ?> />
                                </div>
                                <br>
                                <span id="ecfmg_certificate_error" style="color: red;"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="image-upload">
                                    <label for="cnic_copy">
                                        <?php if ($result->cnic_copy != ''){ ?>
                                            <a href="<?php echo base_url('uploads/statment_of_need/letters/'.$result->cnic_copy) ?>" target="_blank">
                                                <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                            </a>
                                        <?php }else{ ?>
                                            <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                        <?php } ?>
                                        <img id="cnic_copy" width="50" />
                                    </label><br/>
                                    <input id="cnic_copy"
                                           name="cnic_copy"
                                           size="200000"
                                           type="file"
                                        <?php echo $result->cnic_copy == '' ? 'required' : ''; ?> />
                                </div>
                                <br>
                                <span id="cnic_copy_error" style="color: red;"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="image-upload">
                                    <label for="other_file">
                                        <?php if ($result->other_file != ''){ ?>
                                            <a href="<?php echo base_url('uploads/statment_of_need/letters/'.$result->other_file) ?>" target="_blank">
                                                <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                            </a>
                                        <?php }else{ ?>
                                            <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                        <?php } ?>
                                        <img id="other_file" width="50" />
                                    </label><br/>
                                    <input id="other_file"
                                           name="other_file"
                                           size="200000"
                                           type="file" />
                                </div>
                                <br>
                                <span id="other_file_error" style="color: red;"></span>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="col-md-12">
                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-12">
                            <hr/>
                            <h4>Basic Information</h4>
                            <br/>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Name of Applicant: <span class="requriedstar">*</span></label>
                                <?php echo form_input('fullname', set_value('fullname', $result->fullname), array('class' => "form-control input-paf", 'id' => 'fullname', 'placeholder' => 'Name', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Father's Name: <span class="requriedstar">*</span></label>
                                <?php echo form_input('father_name', set_value('father_name', $result->father_name), array('class' => "form-control input-paf", 'id' => 'father_name', 'placeholder' => 'Name', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Cell Phone: <span class="requriedstar">*</span></label>
                                <?php echo form_input('contact_number', set_value('contact_number', $result->contact_number), array('class' => "form-control input-paf mobile_no", 'id' => 'contact_number', 'placeholder' => '#', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Email Address: </label>
                                <label class="form-control input-paf" readonly><?php echo $result->email ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">CNIC/Passport #: <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf" readonly><?php echo $result->cnic ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Present Address: <span class="requriedstar">*</span></label>
                                <?php echo form_input('address', set_value('address', $result->address), array('class' => "form-control input-paf", 'id' => 'address', 'placeholder' => 'Address', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr/>
                            <h4>Education / Qualification Information</h4>
                            <br/>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Graduation: <span class="requriedstar">*</span></label>
                                <?php echo form_input('qualification', set_value('qualification', $result->qualification), array('class' => "form-control input-paf", 'id' => 'qualification', 'placeholder' => 'Degree', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Institute where Graduation Degree was received: <span class="requriedstar">*</span></label>
                                <?php echo form_input('institute', set_value('institute', $result->institute), array('class' => "form-control input-paf", 'id' => 'institute', 'placeholder' => 'Institute', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Post Graduation: (<small class="text-muted">Optional</small>)</label>
                                <?php echo form_input('post_qualification', set_value('post_qualification', $result->post_qualification), array('class' => "form-control input-paf", 'id' => 'post_qualification', 'placeholder' => 'Post Graduation')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Year of Passing: <span class="requriedstar">*</span></label>
                                <?php echo form_input('pass_year', set_value('pass_year', $result->pass_year), array('class' => "form-control input-paf", 'id' => 'pass_year',  'min' => "1970",  'max' => date('Y'), 'placeholder' => 'Year', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Are you a serving government employee? </label><br/>
                                <label><input type="radio" name="is_gov_employee" value="Y" <?php echo $result->is_gov_employee == 'Y' ? 'checked' : ''; ?> /> Yes</label> &nbsp;
                                <label><input type="radio" name="is_gov_employee" value="N" <?php echo $result->is_gov_employee == 'N' ? 'checked' : ''; ?> /> No</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="clearfix"></div>
                            <hr/>
                            <h4>Overseas Training Information</h4>
                            <br/>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Post-Grad Training: </label>
                                <select name="post_grad_training" id="post_grad_training" class="form-control select2">
                                    <option value="residency" <?php echo $result->post_grad_training == 'residency' ? 'selected' : ''; ?>>Residency</option>
                                    <option value="fellowship" <?php echo $result->post_grad_training == 'fellowship' ? 'selected' : ''; ?>>Fellowship</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Speciality Area: <span class="requriedstar">*</span> (<small class="text-muted">According to offer letter/as per contract</small>)</label>
                                <?php echo form_input('speciality', set_value('speciality', $result->speciality), array('class' => "form-control input-paf", 'id' => 'speciality', 'placeholder' => 'Speciality', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Commencing Date: <span class="requriedstar">*</span></label>
                                <?php echo form_input('training_start_date', set_value('training_start_date', $result->training_start_date), array('class' => "form-control input-paf datepicker", 'id' => 'training_start_date', 'placeholder' => 'MM/DD/YYYY', 'readonly' => true, 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Duration (in Years): <span class="requriedstar">*</span></label>
                                <?php echo form_number('years', set_value('years', $result->years), array('class' => "form-control input-paf", 'id' => 'years', 'placeholder' => '#', 'maxlength' => 2, 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Institute in which overseas training is sought: <span class="requriedstar">*</span></label>
                                <?php echo form_input('training_institute', set_value('training_institute', $result->training_institute), array('class' => "form-control input-paf", 'id' => 'training_institute', 'placeholder' => 'Institute', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr/>
                            <h4 class="text-muted">In Case Statement of Exceptional Need</h4>
                            <br/>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><input name="is_special_need" id="is_special_need" <?php echo $result->is_special_need == 'Y' ? 'checked' : ''; ?> type="checkbox" /> Exceptional Need </label>
                                <textarea name="special_need_remarks"
                                          id="special_need_remarks"
                                          class="form-control input-paf"
                                          placeholder="Brief Why You Need Statement of Exceptional Need (Give Reason)"
                                          maxlength="300"
                                          style="display: <?php echo $result->is_special_need == 'Y' ? 'block' : 'none'; ?>;"><?php echo $result->special_need_remarks ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr/>
                            <h4 class="text-muted">Remarks/Feedback</h4>
                            <br/>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="user_comment"
                                          id="user_comment"
                                          class="form-control input-paf"
                                          placeholder="Some Remarks/Feedback"
                                          maxlength="300"><?php echo $result->user_comment ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions right">
                        <a href="<?php echo $role_id == 4 ? site_url('statement') : site_url('dashboard'); ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> Go Back</a>
                        <button type="submit" id="submit_btn" class="btn btn-primary pull-right">
                            <i class="fa fa-check"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var CorrectContractLetter = true;
    var CorrectECFMGCertificate = true;
    var CorrectCnicCopy = true;

    $(document).ready(function () {
        $('input[type=radio][name=is_pmc_reg]').change(function() {
            if (this.value == 'Y') {
                $("#pmc_no_div").show();
                $("#pmc_no").prop('required', true);
            } else if (this.value == 'N') {
                $("#pmc_no_div").hide();
                $("#pmc_no").prop('required', false);
                $("#pmc_no").val('');
            }
        });
        $('#is_special_need').change(function() {
            if (this.checked) {
                $("#special_need_remarks").show();
                $("#special_need_remarks").prop('required', true);
            } else {
                $("#special_need_remarks").hide();
                $("#special_need_remarks").prop('required', false);
                $("#special_need_remarks").val('');
            }
        });
    });

    $('input[id="contract_lettersss"]').change(function() {
        fname = this.files[0].name;
        var extension = fname.substr((fname.lastIndexOf('.') + 1));
        //alert(extension);

        if (extension != "pdf" && extension != "PDF") {
            $("#contract_letter_error").html("File Type not allowed.<br> (Allowed: pdf)");
            CorrectContractLetter = false;
            return false;
        } else {
            $("#contract_letter_error").html("");
        }
        /*
        fileSize = this.files[0].size;
        limitCheck = fileSize / 1024;
        if (limitCheck > 1024) {
            $("#contract_letter_error").html("Your File exceed limit (1Mb)");
            CorrectContractLetter = false;
            return false;
        } else {
            $("#contract_letter_error").html("");
            CorrectContractLetter = true;
        }
        */
    });

    $('input[id="ecfmg_certificatesss"]').change(function() {
        fname = this.files[0].name;
        var extension = fname.substr((fname.lastIndexOf('.') + 1));
        //alert(extension);

        if (extension != "jpg" && extension != "jpeg" && extension != "png" && extension != "JPG" && extension != "JPEG" && extension != "PNG") {
            $("#ecfmg_certificate_error").html("File Type not allowed.<br> (Allowed: jpg|jpeg|gif|png)");
            CorrectECFMGCertificate = false;
            return false;
        } else {
            $("#ecfmg_certificate_error").html("");
        }
        fileSize = this.files[0].size;
        limitCheck = fileSize / 1024;
        if (limitCheck > 1024) {
            $("#ecfmg_certificate_error").html("Your File exceed limit (1Mb)");
            CorrectECFMGCertificate = false;
            return false;
        } else {
            $("#ecfmg_certificate_error").html("");
            CorrectECFMGCertificate = true;
        }
    });

    $('input[id="cnic_copysss"]').change(function() {
        fname = this.files[0].name;
        var extension = fname.substr((fname.lastIndexOf('.') + 1));
        //alert(extension);

        if (extension != "jpg" && extension != "jpeg" && extension != "png" && extension != "JPG" && extension != "JPEG" && extension != "PNG") {
            $("#cnic_copy_error").html("File Type not allowed.<br> (Allowed: jpg|jpeg|gif|png)");
            CorrectCnicCopy = false;
            return false;
        } else {
            $("#cnic_copy_error").html("");
        }
        fileSize = this.files[0].size;
        limitCheck = fileSize / 1024;
        if (limitCheck > 1024) {
            $("#cnic_copy_error").html("Your File exceed limit (1Mb)");
            CorrectCnicCopy = false;
            return false;
        } else {
            $("#cnic_copy_error").html("");
            CorrectCnicCopy = true;
        }
    });

    $(document).on("click", "#submit_btn", function(){
//    $("#submit_btn").on("click",function(){
        if(CorrectContractLetter == true){
        } else {
            alert("Please Upload Correct Attachment File...");
            return false;
        }
    });
</script>