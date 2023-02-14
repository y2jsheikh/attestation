<style>
    /*
    .image-upload>input {
        display: none;
    }
    */
    .highlighted{
        background: red;
        box-shadow: #ff3546 3px 3px 3px 3px;
        color: white;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <?php /* if ($role_id == 2){ ?>
        <ul class="nav nav-tabs nav-fill" style="border: none;">
            <li class="nav-item">
                <a class="nav-link active" href="javascript:void(0)">Basic Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('qualification') ?>">Qualification</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('experience') ?>">Experience</a>
            </li>
            <!--
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
            -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('experience/overseas') ?>">Overseas Employment Information</a>
            </li>
        </ul>
        <?php } */ ?>
        <?php if ($role_id == 2){ ?>
            <br class="d-block d-sm-none"/>
            <br class="d-block d-sm-none"/>
            <nav class="nav nav-pills nav-fill" style="border: none;">
                <a class="nav-item nav-link active" href="javascript:void(0)">Basic Information</a>
                <a class="nav-item nav-link <?php echo isset($result->address) && $result->address !='' ? '' : 'disabled'; ?>" href="<?php echo site_url('qualification') ?>">Qualification</a>
                <a class="nav-item nav-link" href="<?php echo site_url('experience') ?>">Experience</a>
                <!--<a class="nav-item nav-link disabled" href="#">Disabled</a>-->
                <a class="nav-item nav-link <?php echo $is_qualification_entered == 'Y' ? '' : 'disabled'; ?>" href="<?php echo site_url('experience/overseas') ?>">Overseas Employment Information</a>
            </nav>
        <?php } ?>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <!--<br/>-->
                                <!--<label class="control-label">Picture: </label>-->
                                <!--<input class="btn btn-sm btn-default" size="200000" type="file" id="picture" name="picture" />-->
                                <div class="image-upload">
                                    <label for="picture">
                                    <?php if ($result->picture != ''){ ?>
                                        <img src="<?php echo base_url('uploads/user_image/'.$result->picture) ?>" width="50" />
                                    <?php }else{ ?>
                                        <img src="<?php echo base_url('assets/images/blank_user.png') ?>" width="50" />
                                    <?php } ?>
                                    <img id="profile_image" width="50" />
                                    </label><br/>
                                    <input id="picture"
                                           onchange="loadImageFile(event)"
                                           name="picture"
                                           size="200000"
                                           type="file" <?php if ($result->picture == ''){echo "required";} ?> />
                                </div>
                                <br>
                                <span id="picture_error" style="color: red;"></span>
                            </div>
                        </div>
                        <?php if ($role_id == 1){ ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">User Type: </label>
                                <label class="form-control input-paf"><?php echo $result->role_name ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">OTP: </label>
                                <label class="form-control input-paf"><?php echo $result->otp ?></label>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Username: <span class="requriedstar">*</span></label>
                                <?php echo form_input('username', set_value('username', $result->username), array('class' => "form-control input-paf", 'id' => 'username', 'placeholder' => 'Username', 'required' => '', 'readonly' => '')) ?>
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id ?>" />
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                                <input type="hidden" name="is_son" id="is_son" value="N" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Name: <span class="requriedstar">*</span></label>
                                <?php echo form_input('fullname', set_value('fullname', $result->fullname), array('class' => "form-control input-paf", 'id' => 'fullname', 'placeholder' => 'Full Name', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Father Name: <span class="requriedstar">*</span></label>
                                <?php echo form_input('father_name', set_value('father_name', $result->father_name), array('class' => "form-control input-paf", 'id' => 'father_name', 'placeholder' => 'Father Name', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Domicile: </label>
                                <?php echo form_input('domicile', set_value('domicile', $result->domicile), array('class' => "form-control input-paf", 'id' => 'domicile', 'placeholder' => 'Domicile')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Date of Birth: <span class="requriedstar">*</span></label>
                                <?php echo form_input('dob', set_value('dob', $result->dob), array('class' => "form-control input-paf datepicker", 'id' => 'dob', 'placeholder' => 'MM/DD/YYYY', 'readonly' => '', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Email: <span class="requriedstar">*</span></label>
                                <input type="email" id="email" name="email" value="<?php echo $result->email ?>" class="form-control input-paf" placeholder="Email ID" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Contact No: <span class="requriedstar">*</span></label>
                                <?php echo form_input('contact_number', set_value('contact_number', $result->contact_number), array('class' => "form-control input-paf mobile_no", 'id' => 'contact_number', 'placeholder' => '0000-0000000', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">CNIC/Passport No.: <span class="requriedstar">*</span></label>
                                <?php if ($role_id == 1){ ?>
                                    <?php echo form_input('cnic', set_value('cnic', $result->cnic), array('class' => "form-control input-paf", 'id' => 'cnic', 'placeholder' => '#', 'maxlength' => '13')) ?>
                                <?php }else{ ?>
                                    <?php echo form_input('cnic', set_value('cnic', $result->cnic), array('class' => "form-control input-paf", 'id' => 'cnic', 'placeholder' => '#', 'maxlength' => '13', 'readonly' => '')) ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Gender: <span class="requriedstar">*</span></label>
                                <select class="select2 form-control input-paf" id="gender" name="gender" required>
                                    <option value="" <?php echo $result->gender == '' ? 'selected' : ''; ?>>Select Gender</option>
                                    <option value="Male" <?php echo $result->gender == 'Male' ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo $result->gender == 'Female' ? 'selected' : ''; ?>>Female</option>
                                    <option value="Other" <?php echo $result->gender == 'Other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Marital Status: <span class="requriedstar">*</span></label>
                                <?php echo $marital_status_select ?>
                                <input type="hidden" name="marital_status" id="marital_status" value="<?php echo $result->marital_status ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Occupation: <span class="requriedstar">*</span></label>
                                <label class="form-control input-paf" style="background: #e9ecef; color: #495057;"><?php echo $result->occupation ?></label>
                                <!--
                                <?php /*echo $occupation_select */?>
                                <input type="hidden" name="occupation" id="occupation" value="<?php /*echo $result->occupation */?>" />
                                -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Additional Occupation:</label>
                                <?php echo $add_occupation_select ?>
                                <input type="hidden" name="add_occupation" id="add_occupation" value="<?php echo $result->add_occupation ?>" />
                            </div>
                        </div>
                        <?php /* ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Province: <span class="requriedstar">*</span></label>
                                <?php echo $province_select ?>
                                <input type="hidden" name="province" id="province" value="<?php echo $result->province ?>" />
                            </div>
                        </div>
                        <?php */ ?>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Address: <span class="requriedstar">*</span></label>
                                <textarea name="address" id="address" class="form-control input-paf" required placeholder="Enter Current Address" ><?php echo $result->address ?></textarea>
                            </div>
                        </div>
                        <?php /* ?>
                        <div class="col-md-12">
                            <hr/>
                            <h4 class="text-muted">For the Statement of Need Only</h4>
                            <br/>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">USMLE/ECFMG ID Number: </label>
                                <?php echo form_input('ecfmg_no', set_value('ecfmg_no', $result->ecfmg_no), array('class' => "form-control input-paf", 'id' => 'ecfmg_no', 'placeholder' => '#')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">PMC Registration Number: </label>
                                <?php echo form_input('pmc_no', set_value('pmc_no', $result->pmc_no), array('class' => "form-control input-paf", 'id' => 'pmc_no', 'placeholder' => '#')) ?>
                            </div>
                        </div>
                        <?php */ ?>
                    </div>
                    <div class="form-actions right">
                        <a href="<?php echo site_url('dashboard') ?>" class="btn btn-info">Go back to Dashboard</a>
                        <button type="submit" id="submit-btn" style="display: none;"></button>
                    <?php if ($role_id == 2){ ?>
                        <button type="button" id="next_btn" class="btn btn-primary pull-right">
                            <i class="fa fa-check"></i> Attestation
                        </button>
                    <?php }elseif ($role_id == 1) { ?>
                        <button type="button" id="update_btn" class="btn btn-primary pull-right">
                            Update
                        </button>
                    <?php } ?>

                    <?php /* if ($result->occupation_id == 1 || $result->occupation_id == 2){ */ ?>
                    <?php if ($result->occupation_id == 1 && $is_son_submitted == 0){ ?>
                    <button type="button" id="son-submit-btn" class="btn btn-info pull-right" style="margin-right: 4px;">
                        <i class="fa fa-check"></i> Statement of Need
                    </button>
                    <?php } ?>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    /* Preview Image File While Uploading */
    var loadImageFile = function(event) {
        var profile_image = document.getElementById('profile_image');
        profile_image.src = URL.createObjectURL(event.target.files[0]);
        profile_image.onload = function() {
            URL.revokeObjectURL(profile_image.src) // free memory
        }
    };

    var CorrectPicture = true;
    $(document).ready(function () {
    //    $('#cnic').mask('00000-0000000-0');
        $("#add_occupation_id").prop('required', false);

        $(document).on("change", "#marital_status_id", function () {
            var marital_status = $("#marital_status_id option:selected").text();
            $("#marital_status").val(marital_status);
        });
        /*
        $(document).on("change", "#occupation_id", function () {
            var occupation = $("#occupation_id option:selected").text();
            $("#occupation").val(occupation);
        });
        */

        /*
        $(document).on("change", "#province_id", function () {
            var province = $("#province_id option:selected").text();
            $("#province").val(province);
        });
        */

        $(document).on("change", "#add_occupation_id", function () {
            var user_occupation_id = <?php echo $user_occupation_id ?>;
            if ($("#add_occupation_id").val() == user_occupation_id){
                alert("Occupation already selected. Please select other occupation.");
                $("#add_occupation_id").val('').change();
                return false;
            }
            var add_occupation = $("#add_occupation_id option:selected").text();
            $("#add_occupation").val(add_occupation);
        });
        //for only numeric
        $(document).on("input", ".only_numeric", function () {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });

        $("input#username").on({
            keydown: function (e) {
                if (e.which === 32)
                    return false;
            },
            change: function () {
                this.value = this.value.replace(/\s/g, "");
            }
        });

        $(document).on('click', '#son-submit-btn', function () {
            $('#is_son').val('Y');
        //    window.location.replace('<php echo site_url("statement/request") ?>');
            $('#submit-btn').click();
        });

        $(document).on('click', '#next_btn', function () {
            $('#is_son').val('N');
            $('#submit-btn').click();
        });

        $(document).on('click', '#update_btn', function () {
            $('#is_son').val('N');
            $('#submit-btn').click();
        });

    });

    $('input[id="picture"]').change(function() {
        fname = this.files[0].name;
        var extension = fname.substr((fname.lastIndexOf('.') + 1));
        //alert(extension);

        if (extension != "jpg" && extension != "jpeg" && extension != "png" && extension != "JPG" && extension != "JPEG" && extension != "PNG") {
            $("#picture_error").html("File Type not allowed.<br> (Allowed: jpg|jpeg|gif|png)");
            CorrectPicture = false;
            return false;
        } else {
            $("#picture_error").html("");
        }
        fileSize = this.files[0].size;

        limitCheck = fileSize / 1024;

        if (limitCheck > 1024) {
            $("#picture_error").html("Your File exceed limit (1Mb)");
            CorrectPicture = false;
            return false;
        } else {
            $("#picture_error").html("");
            CorrectPicture = true;
        }
    });

    $(document).on("click", "#submit_btn", function(){
//    $("#submit_btn").on("click",function(){
        if(CorrectPicture == true){
        } else {
            alert("Please Upload Correct Picture...");
            return false;
        }
    });

</script>