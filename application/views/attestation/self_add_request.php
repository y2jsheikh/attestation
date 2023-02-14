<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <h3>Add Additional Document</h3>
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
                                <input type="hidden" value="self" name="source" id="source" />
                                <label class="control-label">Visit Date: <span class="requriedstar">*</span></label>
                                <input class="form-control input-paf" type="text" name="visit_date" id="visit_date" placeholder="MM/DD/YYYY" readonly required />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label class="control-label">Select Time Slot: <span class="requriedstar">*</span></label>
                                <div id="time_slot_div">
                                    <?php echo $time_slot_select ?>
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
                                    <select attr-counter="0" name="doc_exp[]" id="doc_exp_0" class="form-control input-paf doc_exp open_field" required>
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
                        <button type="submit" id="btn-submit-confirm" class="btn btn-primary">
                            <i class="fa fa-check"></i> Submit
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>

    var counter = 1;
    $(function() {
        var today = "";
        get_time_slots(today);
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
                $('#attest_request').submit();
            } else {
                alert("Please Fill out all open fields...");
                return false;
            }
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