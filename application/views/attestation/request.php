<style>
    .ui-datepicker-calendar {
        display: none;
    }
    th.ui-datepicker-week-end,
    td.ui-datepicker-week-end {
        display: none;
    }
</style>
<div class="row">
    <div id="sopsModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- SOPs Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">
                        <strong>SOP's</strong>
                    </h4>
                    <button type="button" class="close" id="closing" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="img-responsive">
                        <img src="<?php echo base_url('assets/images/SOPs_1.png') ?>" style="width: 100%">
                    </div>
                    <hr/>
                    <small style="color: red;">Note: Please Read SOPs Carefully</small>
                    <a target="_blank" href="<?php echo base_url('assets/docs/SOPs for Documents Attestation.pdf') ?>" class="btn btn-default pull-right">Download SOP</a>
                    <a target="_blank" href="<?php echo base_url('assets/docs/SPECIMEN AFFIDAVIT.pdf') ?>" class="btn btn-default pull-right">Download Affidavit</a>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closing_2" class="btn btn-default" data-dismiss="modal">OK</button>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3>Attestation Request</h3>
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
                <form method="post" action="" name="attest_request" id="attest_request">
                    <!--<div class="col-md-12">-->
                    <?php if ($role_id == 1){ ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">User: <small class="requriedstar">*</small> </label>
                                <?php echo $user_select ?>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id ?>" />
                    <?php } ?>
                    <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />

                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label class="control-label">Submission Type: <span class="requriedstar">*</span></label>
                                <select class="form-control input-paf" name="source" id="source" required >
                                    <option value="self">Self</option>
                                    <option value="courier" selected>Courier</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 province-div">
                            <div class="form-group">
                                <label class="control-label">Province: <span class="requriedstar">*</span></label>
                                <?php echo $province_select ?>
                                <input type="hidden" name="province" id="province" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 slot-div" style="display: none;">
                            <div class="form-group">
                                <label class="control-label">Visit Date: <span class="requriedstar">*</span></label>
                                <input class="form-control input-paf" type="text" name="visit_date" id="visit_date" placeholder="MM/DD/YYYY" readonly required />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 slot-div" style="display: none;">
                            <div class="form-group">
                                <label class="control-label">Select Time Slot: <span class="requriedstar">*</span></label>
                                <div id="time_slot_div">
                                    <?php echo $time_slot_select ?>
                                    <!--
                                    <select name="slot_id" id="slot_id" class="form-control input-paf" required >
                                        <option value="">Select</option>
                                    </select>
                                    -->
                                    <span><small class="text-danger">Note: Submission time is Till 12:30, Receiving time is After 15:00</small></span>
                                </div>
                                <input type="hidden" name="slot" id="slot" value="<?php echo set_value('slot') ?>" />
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <div>
                        <a href="javascript:;" class="pull-right" onclick="addMore('experience')" style="box-shadow: 1px 1px 2px #e6e6e6, 0 0 25px #94d9ff, 0 0 5px white; text-decoration: none; padding: 0.25%; position: relative;"><b>Add More</b></a>
                        </div>
                        <label class="control-label">Request Document(<span class="text-muted">s</span>) <small class="requriedstar">*</small> </label>
                        <div id="experience_div">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="doc_type[]" id="doc_type_0" attr-counter="0" class="form-control input-paf doc_type open_field" required>
                                        <option value="">Select Type</option>
                                        <option value="Degree">Degree</option>
                                        <option value="Transcript">Transcript</option>
                                        <option value="DMC">DMC</option>
                                        <option value="Certificate">Certificate</option>
                                        <option value="Diploma">Diploma</option>
                                        <option value="Council Registration Certificate">Council Registration Certificate</option>
                                        <option value="Experience Certificate">Experience Certificate</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-3" id="exp_div_0" style="display: none;">
                                    <select attr-counter="0" name="doc_exp[]" id="doc_exp_0" class="form-control input-paf doc_exp open_field">
                                        <option value="">Select Experience</option>
                                        <option value="Govt">Govt</option>
                                        <option value="Private">Private</option>
                                    </select>
                                </div>
                                <div class="col-md-3" id="other_doc_div_0" style="display: none;">
                                    <input type="text" name="other_doc[]" id="other_doc_0" class="form-control input-paf" placeholder="Document" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--</div>-->
                    <div class="form-actions right">
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <button type="button" id="btn-submit-confirm" class="btn btn-primary">
                            <i class="fa fa-check"></i> Submit
                        </button>
                    </div>

                    <!-- Confirmation Modal content-->
                    <div id="confirmModal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title text-center">
                                        <strong>Please Confirm <i class="fa fa-exclamation-circle"></i></strong>
                                    </h4>
                                    <button type="button" class="close" id="closing" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>Please confirm you have attached the following</p><br/>
                                    <!--<label><input type="checkbox" id="is_application_form" name="is_application_form" /> Application Form</label><br/>-->
                                    <label><input type="checkbox" id="is_affidavit_attested" name="is_affidavit_attested" /> Affidavit (Attested by Oath Commissioner / Notary Public)</label><br/>
                                    <label><input type="checkbox" id="is_copy_of_degree" name="is_copy_of_degree" /> Copy of Degree / Diploma from the Faculty/Board/University</label><br/>

                                    <?php if ($user_data->add_occupation_id == 1): ?>
                                        <label><input type="checkbox" id="is_copy_of_pmc" name="is_copy_of_pmc" /> Copy of valid PMC Certificate (if any)</label><br/>
                                    <?php endif; ?>
                                    <?php if ($occupation_id == 1): ?>
                                        <label><input type="checkbox" id="is_copy_of_pmc" name="is_copy_of_pmc" /> Copy of valid PMC Certificate</label><br/>
                                    <?php endif; ?>

                                    <?php if ($user_data->add_occupation_id == 2): ?>
                                        <label><input type="checkbox" id="is_copy_of_pnc" name="is_copy_of_pnc" /> Copy of valid PNC Card (if any)</label><br/>
                                    <?php endif; ?>
                                    <?php if ($occupation_id == 2): ?>
                                        <label><input type="checkbox" id="is_copy_of_pnc" name="is_copy_of_pnc" /> Copy of valid PNC Card</label><br/>
                                    <?php endif; ?>

                                    <?php if ($user_data->add_occupation_id == 4 || $user_data->add_occupation_id == 5 || $user_data->add_occupation_id == 6): ?>
                                        <label><input type="checkbox" id="is_copy_of_crc" name="is_copy_of_cnic" /> Copy of Council Registration Certificate (valid)</label><br/>
                                    <?php endif; ?>
                                    <?php if ($occupation_id == 4 || $occupation_id == 5 || $occupation_id == 6): ?>
                                        <label><input type="checkbox" id="is_copy_of_crc" name="is_copy_of_cnic" /> Copy of Council Registration Certificate (valid)</label><br/>
                                    <?php endif; ?>

                                <?php /* if ($occupation_id == 1 || $user_data->add_occupation_id == 1): ?>
                                    <label><input type="checkbox" id="is_copy_of_pmc" name="is_copy_of_pmc" /> Copy of valid PMC Certificate (for doctors)</label><br/>
                                <?php elseif ($occupation_id == 2 || $user_data->add_occupation_id == 2): ?>
                                    <label><input type="checkbox" id="is_copy_of_pnc" name="is_copy_of_pnc" /> Copy of valid PNC Card (for nurse)</label><br/>
                                <?php elseif (($occupation_id == 4 || $occupation_id == 5 || $occupation_id == 6) OR ($user_data->add_occupation_id == 4 || $user_data->add_occupation_id == 5 || $user_data->add_occupation_id == 6)): ?>
                                    <!--<label><input type="checkbox" id="is_copy_of_pmdc" name="is_copy_of_pmdc" /> Copy of valid PMDC Certificate</label><br/>-->
                                    <label><input type="checkbox" id="is_copy_of_crc" name="is_copy_of_cnic" /> Copy of Council Registration Certificate (valid)</label><br/>
                                <?php endif; */ ?>

                                    <label><input type="checkbox" id="is_copy_of_cnic" name="is_copy_of_cnic" /> Copy of CNIC (valid)</label><br/>
                                    <label><input type="checkbox" id="is_copy_of_passport" name="is_copy_of_passport" /> Copy of Passport (if available)</label><br/>
                                    <label><input type="checkbox" id="is_copy_of_experience" name="is_copy_of_experience" /> Copy of all Documents/Experience Certificates submitted for attestation</label><br/>
                                    <label><input type="checkbox" id="is_orignal_doc_attached" name="is_orignal_doc_attached" /> Original Document(s) required to be attested are attached</label><br/>
                                    <small style="color: red;">Note: All copies should be attested</small>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id="submit_form_confirm" class="btn btn-info"><i class="fa fa-check"></i> Confirm</button>
                                    <button type="button" id="closing_confirm" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-cross"></i> Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>

    var counter = 1;
    $(function() {
        $("#slot_id").prop('required', false);
        $("#slot_id").val('').change();

    //    var date = new Date();
        $('#sopsModal').modal({backdrop: 'static', keyboard: false});
        $('#visit_date').datepicker({
            startDate: new Date(),
            daysOfWeekDisabled: [0,6]
        });
        $(document).on("change", "#province_id", function () {
            var province = $("#province_id option:selected").text();
            $("#province").val(province);
        });
        $(document).on("change", "#source", function () {
            var source = $(this).val();
            if (source == 'self'){
                $(".province-div").hide();
                $("#province_id").removeClass('open_field');
                $("#province_id").prop('required', false);
                $("#province_id").val('').change();

                $(".slot-div").show();
                $("#visit_date").prop('required', true);
                $("#slot_id").prop('required', true);
            }else if (source == 'courier') {
                $(".province-div").show();
                $("#province_id").addClass('open_field');
                $("#province_id").prop('required', true);

                $(".slot-div").hide();
                $("#visit_date").prop('required', false);
                $("#visit_date").val('');
                $("#slot_id").prop('required', false);
                $("#slot_id").val('').change();
            }
        });
        $(document).on("change", "#visit_date", function () {
            get_time_slots($(this).val());
        });
        $(document).on("change", "#slot_id", function () {
            var slot = $("#slot_id option:selected").text();
            $("#slot").val(slot);
        });
        $(document).on('change','.doc_type',function () {
            var val = $(this).val();
            var i = $(this).attr("attr-counter");
            if (val != ''){
                $("#other_doc_"+i).addClass('open_field');
                $("#other_doc_div_"+i).show();
                if (val == 'Experience Certificate') {
                    $("#doc_exp_"+i).addClass('open_field');
                    $("#exp_div_"+i).show();
                }else{
                    $("#doc_exp_"+i).removeClass('open_field');
                    $("#doc_exp_"+i).val('').change();
                    $("#exp_div_"+i).hide();
                }
            }else{
                $("#doc_exp_"+i).removeClass('open_field');
                $("#doc_exp_"+i).val('').change();
                $("#exp_div_"+i).hide();
                $("#other_doc_"+i).removeClass('open_field');
                $("#other_doc_div_"+i).hide();
            }
        });
        $(document).on('click','#btn-submit-confirm',function () {
            var not_empty = true;
            $('.open_field').each(function(i, obj) {
                if (obj.value == '') {not_empty = false; }
            });
            if (not_empty){
                $('#confirmModal').modal();
            } else {
                alert("Please Fill out all open fields...");
                return false;
            }

        });
        $(document).on('click','#submit_form_confirm',function () {
            /*
            $('#attest_request').submit(function(e){
                e.preventDefault();
            });
            */
            $('#attest_request').submit();
        });
    });

    function addMore(type) {
        var htm = '<div class="row"><div class="col-md-12"><a href="javascript:;" class="pull-right remove-btn" style="text-decoration: none; color: red;" onclick="$(this).parent().parent().remove();">Delete</a></div>\n\
            <div class="col-md-3"><select name="doc_type[]" id="doc_type_'+counter+'" attr-counter="'+counter+'" class="form-control input-paf doc_type open_field" required><option value="">Select Type</option><option value="Degree">Degree</option><option value="Transcript">Transcript</option><option value="DMC">DMC</option><option value="Certificate">Certificate</option><option value="Diploma">Diploma</option><option value="Council Registration Certificate">Council Registration Certificate</option><option value="Experience Certificate">Experience Certificate</option><option value="Other">Other</option></select></div>\n\
            <div class="col-md-3" id="exp_div_'+counter+'" style="display: none;"><select attr-counter="'+counter+'" name="doc_exp[]" id="doc_exp_'+counter+'" class="form-control input-paf doc_exp open_field" required><option value="">Select Experience</option><option value="Govt">Govt</option><option value="Private">Private</option></select></div>\n\
            <div class="col-md-3" id="other_doc_div_'+counter+'" style="display: none;"><input type="text" name="other_doc[]" id="other_doc_'+counter+'" class="form-control input-paf" placeholder="Document" required /></div>\n\
            </div>';
        //alert(htm);return false;
        $("#" + type + "_div").append(htm);
        $(".datepicker").datepicker();
    //    $(".select2").select2();
        counter++;
    //    console.log(counter);
    }

    function get_time_slots(visit_date) {
        $.ajax({
            url: '<?php echo base_url('ajax/get_time_slots'); ?>',
            data: {"visit_date": visit_date},
            type: 'POST',
            success: function (data) {
                var JSONArray = $.parseJSON(data);
                $('#time_slot_div').html(JSONArray);
            }
        });
    }

</script>