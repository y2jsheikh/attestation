<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <?php /* if ($role_id == 2){ ?>
        <ul class="nav nav-tabs nav-fill" style="border: none;">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('user/edit/'.$user_id) ?>">Basic Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="javascript:void(0)">Qualification</a>
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
        <?php if ($role_id == 2) { ?>
            <br class="d-block d-sm-none"/>
            <br class="d-block d-sm-none"/>
            <nav class="nav nav-pills nav-fill" style="border: none;">
                <a id="basic_info_tab" class="nav-item nav-link" href="<?php echo site_url('user/edit/' . $user_id) ?>">Basic
                    Information</a>
                <a class="nav-item nav-link active" href="javascript:void(0)">Qualification</a>
                <a id="experience_tab" class="nav-item nav-link"
                   href="<?php echo site_url('experience') ?>">Experience</a>
                <!--<a class="nav-item nav-link disabled" href="#">Disabled</a>-->
                <a id="overseas_experience_tab"
                   class="nav-item nav-link <?php echo $is_qualification_entered == 'Y' ? '' : 'disabled'; ?>"
                   href="<?php echo site_url('experience/overseas') ?>">Overseas Employment Information</a>
            </nav>
        <?php } ?>
        <?php if (validation_errors() != '') { ?>
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
                <form method="post" action="" name="add_qualification" id="add_qualification">
                    <?php if ($role_id == 1) { ?>
                        <div class="col-md-12">
                            <div class="row">
                                <label class="control-label">User:
                                    <small class="requriedstar">*</small>
                                </label>
                                <?php echo $user_select ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id ?>"/>
                    <?php } ?>

                    <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>"/>
                    <div class="form-group">
                        <!--
                        <label class="control-label">Add Qualification(<span class="text-muted">s</span>)
                            <small class="requriedstar">*</small>
                        </label>
                        -->
                        <div id="qualification_div">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control-label">Qualification Area <span class="requriedstar">*</span></label>
                                    <select class="form-control input-paf open_field" name="qualification_area[]"
                                            id="qualification_area_0" required>
                                        <option value="">Select Area</option>
                                        <option value="Basic">Basic</option>
                                        <option value="Graduate">Graduate</option>
                                        <option value="Postgraduate">Postgraduate</option>
                                        <option value="Diploma">Diploma</option>
                                        <option value="Course">Course</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Qualification <span class="requriedstar">*</span></label>
                                    <input type="text" name="qualification[]" class="form-control input-paf open_field"
                                           placeholder="Enter Qualification" required/>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Institute <span class="requriedstar">*</span></label>
                                    <input type="text" name="institute[]" class="form-control input-paf open_field"
                                           placeholder="Enter Institute" required/>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Completion Year <span class="requriedstar">*</span></label>
                                    <input type="number" name="completion_year[]"
                                           class="form-control input-paf open_field year_mask" min="1970"
                                           max="<?php echo date('Y') ?>" placeholder="Maximum Year <?php echo date("Y") ?>" required/>
                                </div>
                                <div class="col-md-8">
                                    <label class="label-paf"> &nbsp; </label>
                                    <a href="javascript:;" class="pull-right btn btn-success btn-sm"
                                       onclick="addMore('qualification')"><i class="fa fa-plus"></i> Add More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions right">
                        <a href="<?php echo site_url('user/edit/' . $user_id) ?>" class="btn btn-danger btn-sm btn-md btn-xs">Go Back</a>
                        <!--
                        <button type="button" name="submit_btn" id="submit_btn" value="dashboard" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Close
                        </button>
                        -->
                        <button type="submit" id="submit-btn" style="display: none;"></button>
                        <a href="<?php echo site_url('dashboard') ?>" class="btn btn-success  btn-sm btn-md btn-xs">
                            <i class="fa fa-cross"></i> Close Application
                        </a>
                        <button type="button" id="qualify-submit-btn" class="btn btn-primary pull-right btn-sm btn-md btn-xs">
                            <i class="fa fa-check"></i> Next Step
                        </button>
                    </div>
                </form>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-muted"><b class="text-danger">Note:</b> The Qualification is required first time only. Please don't re-add same qualification if already added in the list below.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php if (validation_errors() != '') { ?>
                            <br>
                            <?php echo validation_errors(); ?>
                        <?php } ?>
                        <?php
                        $message = $this->session->flashdata('success_response');
                        if (isset($message) && $message != '') {
                            /*
                            echo '<br><div class="bg-green" style="margin: 10px; padding: 10px" role="alert">
                    <strong class="bg-font-green-soft font-lg">' . $message . '</strong></div>';
                            */
                        ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Success!</strong> <?php echo $message ?>
                            </div>
                        <?php

                        }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label"> &nbsp; </label>
                            <input type="text" class="form-control input-paf" id="qualification"
                                   placeholder="Enter Qualification"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label"> &nbsp; </label><br/>
                            <button id="search-btn" type="button" class="btn btn-primary"><i class="fa fa-search"></i>
                                Search
                            </button>
                        </div>
                    </div>
                </div>

                <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="table-group-actions pull-right">
                                <label>
                                    <select id="select_limit" name="sample_1_length" aria-controls="sample_1"
                                            class="form-control input-paf">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="">All</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive" id='my_data'></div>
                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">
                                Showing <span id="start"></span> to <span id="end"></span> of <span id="total"></span>
                                entries
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 right">
                            <div class="dataTables_paginate paging_bootstrap_number pull-right" id="pagination">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var counter = 1;
    $(document).ready(function () {
        $("#name").keyup(function () {
            show_ajax_cards('');
        });
        $(document).on('click', '#search-btn', function () {
            show_ajax_cards('');
        });
        $(document).on('click', '#qualify-submit-btn', function () {
            var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
            $.ajax({
                url: '<?php echo base_url('qualification/isQualificationEntered'); ?>',
                data: {[csrfName]: csrfHash, "user_id": $("#user_id").val()},
                type: 'POST',
                success: function (data) {
                    var JSONArray = $.parseJSON(data);
                    console.log(JSONArray);
                    if (JSONArray.status == 'success') {


                        var not_empty = false;
                        $('.open_field').each(function (i, obj) {
                            if (obj.value != '') {
                                not_empty = true;
                            }
                        });
                        if (not_empty) {
                            $('#submit-btn').click();
                            //    $('#add_qualification').submit();
                        } else {
                            window.location.replace('<?php echo site_url("experience") ?>');
                        }
                    } else {
                        $('#submit-btn').click();
                    }
                }
            });

        });
        $(document).on('change', '#select_limit', function () {
            show_ajax_cards('');
        });
        //load page for fitrs time
        show_ajax_cards('');
    });

    function addMore(type) {
        var htm = '<div class="row">\n\
            <div class="col-md-4"><label class="control-label">Qualification Area</label><select class="form-control input-paf open_field" name="qualification_area[]" required ><option value="">Select Area</option><option value="Basic">Basic</option><option value="Graduate">Graduate</option><option value="Postgraduate">Postgraduate</option><option value="Diploma">Diploma</option><option value="Course">Course</option></select></div>\n\
            <div class="col-md-4"><label class="control-label">Qualification</label><input type="text" name="qualification[]" class="form-control input-paf open_field" placeholder="Enter Qualification" required /></div>\n\
            <div class="col-md-4"><label class="control-label">Institute</label><input type="text" name="institute[]" class="form-control input-paf open_field" placeholder="Enter Institute" required /></div>\n\
            <div class="col-md-4"><label class="control-label">Completion Year</label><input type="number" name="completion_year[]" class="form-control input-paf open_field year_mask" min="1970" max="<?php echo date("Y") ?>" placeholder="Maximum Year <?php echo date("Y") ?>" required /></div>\n\
            <div class="col-md-8"><label class="label-paf"> &nbsp; </label><a href="javascript:;" class="pull-right btn btn-danger btn-sm" onclick="$(this).parent().parent().remove();"><i class="fa fa-trash"></i> Delete</a></div>\n\
            </div>';
        //alert(htm);return false;
        $("#" + type + "_div").append(htm);
        counter++;
    }

    function show_ajax_cards(obj) {
        //$("#my_data").html('<tr><td colspan="7" style="text-align: center !important;float: left;margin-left: 80% !important;"><img width="134"
        // src="<?php echo base_url() ?>assets/img/loadingicon.gif"></td></tr>');
        // $("#pagination").html('')
        //return false;
        if (obj == '') {
            var baseurl = '<?php echo base_url('ajax/content/1'); ?>';

        } else {
            var baseurl = obj.id;
        }
        var post_data = {
            "qualification": $("#qualification").val(),
            "select_limit": $("#select_limit").val(),
            'action': "user_qualification_content"
        };

        $.ajax({
            url: baseurl,
            data: post_data,
            type: 'POST',
            success: function (data) {

                var JSONArray = $.parseJSON(data);
                $('#my_data').html(JSONArray.content);
                $('#pagination').html(JSONArray.links);
                if (JSONArray.total > 0) {
                    $('#sample_1_info').show();
                    $('#start').html(JSONArray.start);
                    $('#end').html(JSONArray.end);
                    $('#total').html(JSONArray.total);
                } else {
                    $('#sample_1_info').hide();
                }
            }
        });
    }

</script>