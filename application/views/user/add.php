<div class="row">
    <div class="col-md-12">
        <h3>Add User</h3>
        <?php if (validation_errors() != '') { ?>
            <br>
            <?php echo validation_errors(); ?>
        <?php } ?>
        <?php
        $message = $this->session->flashdata('response');
        if (isset($message) && $message != '') {
            echo '<br><div class="bg-red" style="margin: 10px; padding: 10px" role="alert">
                    <strong class="bg-font-green-soft font-lg">' . $message . '</strong></div>';
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
                                <label class="control-label">User Type: <span class="requriedstar">*</span></label>
                                <?php echo $role_select ?>
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Name: <span class="requriedstar">*</span></label>
                                <?php echo form_input('fullname', set_value('fullname'), array('class' => "form-control input-paf", 'id' => 'fullname', 'placeholder' => 'Full Name', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Username: <span class="requriedstar">*</span></label>
                                <?php echo form_input('username', set_value('username'), array('class' => "form-control input-paf", 'id' => 'username', 'placeholder' => 'Username', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Email:  <span class="requriedstar">*</span></label>
                                <?php echo form_email('email', set_value('email'), array('class' => "form-control input-paf", 'id' => 'email', 'placeholder' => 'Email ID', 'required' => '' )) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Password: <span class="requriedstar">*</span></label>
                                <?php echo form_password('password', set_value('password'), array('class' => "form-control input-paf", 'id' => 'password', 'placeholder' => 'Password', 'required' => '' )) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Contact No: </label>
                                <?php echo form_input('contact_number', set_value('contact_number'), array('class' => "form-control input-paf mobile_no", 'id' => 'contact_number', 'placeholder' => '#')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">CNIC/Passport No.: <span class="requriedstar">*</span></label>
                                <?php echo form_input('cnic', set_value('cnic'), array('class' => "form-control input-paf", 'id' => 'cnic', 'placeholder' => '#', 'maxlength' => '13', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Occupation: <span class="requriedstar">*</span></label>
                                <?php echo $occupation_select ?>
                                <input type="hidden" name="occupation" id="occupation" />
                            </div>
                        </div>
                        <!--
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">CNIC: </label>
                                <?php // echo form_input('cnic', set_value('cnic', $result->cnic), array('class' => "form-control input-paf cnic", 'id' => 'cnic', 'placeholder' => '0000000000000')) ?>
                            </div>
                        </div>
                        -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Gender: <span class="requriedstar">*</span></label>
                                <!--
                                <select class="select2 form-control input-paf" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                -->
                                <?php
                                $options = array(
                                    ''         => 'Select Gender',
                                    'Male'     => 'Male',
                                    'Female'   => 'Female',
                                    'Other'    => 'Other',
                                );
                                echo form_dropdown('gender', $options, set_value('gender'), ' class="select2 form-control input-paf" id="gender"');
                                ?>
                            </div>
                        </div>
                        <?php /* ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Province: <span class="requriedstar">*</span></label>
                                <?php echo $province_select ?>
                                <input type="hidden" name="province" id="province" />
                            </div>
                        </div>
                        <?php */ ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <br/>
                                <label class="control-label">Picture: <span class="requriedstar">*</span></label>
                                <input class="btn btn-sm btn-default" size="200000" type="file" id="picture" name="picture" required/>
                                <br>
                                <span id="picture_error" style="color: red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions right">
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var CorrectPicture = true;
    $(document).ready(function () {
    //    $('#cnic').mask('00000-0000000-0');
        //for only nuneric
        $(document).on("input", ".only_numeric", function () {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });

        /*
        $(document).on("change", "#province_id", function () {
            var province = $("#province_id option:selected").text();
            $("#province").val(province);
        });
        */

        $(document).on("change", "#occupation_id", function () {
            var occupation = $("#occupation_id option:selected").text();
            $("#occupation").val(occupation);
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

    $("#submit_btn").on("click",function(){
        if(CorrectPicture == true){
        } else {
            alert("Please Upload Correct Picture...");
            return false;
        }
    });

</script>