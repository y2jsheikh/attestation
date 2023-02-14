<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="border-bottom margin-bottom-25">
            <h3>Welcome to Attestation portal.</h3>
        </div>
    </div>
    <div class="col-md-12">
        <?php if (validation_errors() != '') { ?>
            <br>
            <?php echo validation_errors(); ?>
        <?php } ?>

        <?php
        /*
        $message = $this->session->flashdata('success_response');
        if (isset($message) && $message != '') {
            echo '<br><div class="bg-green" style="margin: 10px; padding: 10px" role="alert">
                    <strong class="bg-font-green-soft font-lg">' . $message . '</strong></div>';
        }
        */
        ?>

        <?php
        $message = $this->session->flashdata('success_response');
        if (isset($message) && $message != '') {
            ?>
            <div id="sessionMsgModal" class="modal fade" style="display: none;" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="sessionMsgModalLabel">
                <div class="modal-dialog modal-confirm">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center" style="background: #218838; color: white;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body text-center">
                            <h4>Dear Applicant!</h4>
                            <p><?php echo $message ?></p>
                            <button class="btn btn-success" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $('#sessionMsgModal').modal({backdrop: 'static', keyboard: false});
            </script>
            <?php
        }
        ?>

    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="custom-card userinfocard">
            <div class="dateinfo height-auto">
                <h3>Welcome back!</span>
                    <strong><?php echo isset($user_fullname) && $user_fullname != '' ? $user_fullname : 'User'; ?></strong></h3>
                <!--<div class="dateinfo">Last Login From :
                    <span>Pakistan, at </span>
                    <span>Tuesday, August 24, 2021</span>
                </div>-->
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border padding-tb-10 bg-white">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <h4>My Applications</h4>
            </div>
            <div class="col-lg-3 col-md-2 col-sm-3 col-xs-6">
                Refresh Section <a href="javascript:" id="ref_app" class=""><i class="fa fa-refresh"></i></a>
            </div>
            <div class="input-group mb-3 col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <input type="text" class="form-control" placeholder="Filter"
                       onfocus="this.placeholder = 'Application ID'" name="keyword" id="keyword"
                       onblur="this.placeholder = 'Filter'"/>
                <input type="hidden" id="cnic" value="<?php echo $_SESSION['logged_in']['cnic'] ?>" />
                <div class="input-group-append">
                    <button id="searchme" class="btn btn-outline-secondary search-button-green" type="button"> <i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border padding-tb-10 bg-white">
            <div class="col-md-12">
                <h4>Attestation List</h4>
            </div>
            <div class="table-responsive" id='my_data'></div>
            <div class="row margin-top-20">
                <div class="col-md-6 col-sm-12">
                    <!--<div id="pages">
                        Showing <span id="start"></span> to <span id="end"></span> of <span id="total"></span> entries
                    </div>
                    -->
                    <div class="dataTables_info" id="example_info" role="status" aria-live="polite">
                        &nbsp; Showing
                        <span id="start"></span> to <span id="end"></span> of <span id="total"></span>
                        entries
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="table-group-actions pull-right" style="padding-right: 2%;">
                        <label>
                            <select id="select_limit" name="sample_1_length" aria-controls="sample_1" class="form-control input-paf">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="">All</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 right">
                    <div class="pagination pull-right" style="padding-right: 2%; margin-top: 2%;" id="pagination">

                    </div>
                </div>

            </div>
        </div>

        <?php if ($occupation_id == 1){ ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border padding-tb-10 bg-white">
            <div class="col-md-12">
                <h4>Statement of Need List</h4>
            </div>
            <div class="table-responsive" id='statement_data'></div>
            <div class="row margin-top-20">
                <div class="col-md-6 col-sm-12">
                    <div class="dataTables_info" id="example_info_statement" role="status" aria-live="polite">
                        &nbsp; Showing
                        <span id="start_statement"></span> to <span id="end_statement"></span> of <span id="total_statement"></span>
                        entries
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="table-group-actions pull-right" style="padding-right: 2%;">
                        <label>
                            <select id="select_limit_statement" name="sample_1_length" aria-controls="sample_1" class="form-control input-paf">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="">All</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 right">
                    <div class="pagination pull-right" style="padding-right: 2%; margin-top: 2%;" id="pagination_statement">

                    </div>
                </div>

            </div>
        </div>
        <?php } ?>

    </div>
    <!--<div class="col-lg-1 col-md-1"></div>-->
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 offset-0 km-profile-strength">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border padding-tb-10 bg-white ">
            <h4 class="text-center">Profile</h4>
            <center>
                <?php if (!empty($result->picture)): ?>
                    <img src="<?php echo base_url('uploads/user_image/' . $result->picture) ?>" class="image-class" alt="picture">
                <?php else: ?>
                    <img src="<?php echo base_url('assets/images/blank_user.png') ?>" class="image-class" alt="picture">
                <?php endif; ?>
            </center>
            <div class="col-md-12 col-sm-12">
                <p>Profile Picture <i class="fa fa-<?php echo ($result->picture != '') ? 'check' : 'times'; ?>-circle"></i></p>
                <p>Personal Details <i class="fa fa-<?php echo ($result->fullname != '') ? 'check' : 'times'; ?>-circle"></i></p>
                <p>Contact Details <i class="fa fa-<?php echo ($result->contact_number != '') ? 'check' : 'times'; ?>-circle"></i></p>
                <p>Address Details <i class="fa fa-<?php echo ($result->address != '') ? 'check' : 'times'; ?>-circle"></i></p>
                <p>Education Details <i class="fa fa-<?php echo $is_edu > 0 ? 'check' : 'times'; ?>-circle"></i></p>
            </div>
            <div class="updatebtnrow">
                <a class="updatebtn" href="<?php echo site_url('user/edit/' . $result->id) ?>">Update Profile</a>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        /*
        anime({
            targets: '.image-class',
            scale: [
                {value: .1, easing: 'easeOutSine', duration: 500},
                {value: 1, easing: 'easeInOutQuad', duration: 1200}
            ],
            delay: anime.stagger(200, {grid: [14, 5], from: 'center'})
        });
        */

        anime({
            targets: '.image-class',
            translateX: anime.stagger(0, {grid: [14, 5], from: 'center', axis: 'x'}),
            translateY: anime.stagger(0, {grid: [14, 5], from: 'center', axis: 'y'}),
            rotateZ: anime.stagger([0, 360], {grid: [14, 5], from: 'center', axis: 'x'}),
            delay: anime.stagger(200, {grid: [14, 5], from: 'center'}),
            easing: 'easeInOutQuad'
        });

        $(document).on('click', '#ref_app', function () {
            show_ajax_cards_attestation('');
        });
        $(document).on('click', '#searchme', function () {
            var app_number = $("#keyword").val();
            if (app_number != '') {
                show_ajax_cards_attestation('');
            } else {
                alert("Please Enter Application ID!");
                return false;
            }
        });
        $(document).on('change', '#select_limit', function () {
            show_ajax_cards_attestation('');
        });
        <?php if ($occupation_id == 1){ ?>
        $(document).on('change', '#select_limit_statement', function () {
            show_ajax_cards_statement('');
        });
        <?php } ?>
        //load page for fitrs time
        show_ajax_cards_attestation('');
        <?php if ($occupation_id == 1){ ?>
        show_ajax_cards_statement('');
        <?php } ?>
    });

    function show_ajax_cards_attestation(obj) {
        if (obj == '') {
            var baseurl = '<?php echo base_url('ajax/content/1'); ?>';
        } else {
            var baseurl = obj.id;
        }
        var post_data = {
            "cnic": $("#cnic").val(),
            "app_number": $("#keyword").val(),
            "select_limit": $("#select_limit").val(),
            'action': "attestation_request_content"
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
                    $('#pages').show();
                    $('#start').html(JSONArray.start);
                    $('#end').html(JSONArray.end);
                    $('#total').html(JSONArray.total);
                } else {
                    $('#sample_1_info').hide();
                }
            }
        });
    }

    <?php if ($occupation_id == 1){ ?>
    function show_ajax_cards_statement(obj) {
        if (obj == '') {
            var baseurl = '<?php echo base_url('ajax/content/1'); ?>';
        } else {
            var baseurl = obj.id;
        }
        var post_data = {
        //    "cnic": $("#cnic").val(),
        //    "app_number": $("#keyword").val(),
            "select_limit": $("#select_limit_statement").val(),
            'action': "user_statement_of_need_content"
        };

        $.ajax({
            url: baseurl,
            data: post_data,
            type: 'POST',
            success: function (data) {
                var JSONArray = $.parseJSON(data);
                $('#statement_data').html(JSONArray.content);
                $('#pagination_statement').html(JSONArray.links);
                if (JSONArray.total > 0) {
                    $('#pages_statement').show();
                    $('#start_statement').html(JSONArray.start);
                    $('#end_statement').html(JSONArray.end);
                    $('#total_statement').html(JSONArray.total);
                } else {
                    $('#sample_1_info_statement').hide();
                }
            }
        });
    }
    <?php } ?>

</script>