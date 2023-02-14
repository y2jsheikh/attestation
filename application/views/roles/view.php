<div class="content-pagination-height borderframe">
    <div class="heading-top">
        <h3 class="page-title text-uppercase"> List Roles
            <a href="<?php echo site_url('Roles/add')?>" class="btn btn-warning pull-right">Add Role</a>
        </h3>
    </div>
    <div class="box-header nav-link nav-toggle" data-original-title>

        <?php
        $success_message = $this->session->flashdata('success_response');
        $failure_message = $this->session->flashdata('failure_response');
        if (isset($success_message) && $success_message != '') {
            echo ' <div style="text-align: center;" class="alert btn-success " role="alert"> 
                                    <strong>' . $success_message . '</strong>
                                    </div>';
        } else if (isset($failure_message) && $failure_message != '') {
            echo ' <div style="text-align: center;" class="alert btn-danger " role="alert"> 
                                    <strong>' . $failure_message . '</strong>
                                    </div>';
        }
        ?>
    </div>
    <br/>
    <div class="col-md-12 col-sm-6  badge-white">
        <div class="grid-title no-border">
            <div class="grid-body no-border">
                <div class="row">

                    <div class="col-md-12">
                        <div class="grid simple ">

                            <div class="col-md-6">
                                <label>Show
                                    <select name="select_limit" id="select_limit">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="">All</option>
                                    </select>
                                    entries
                                </label>
                            </div>
                            <div class="col-md-6">
                                <div class="dataTables_filter" id="example_filter" style="float: right"><label>
                                        <input type="text" id="seacrh-field" aria-controls="example"
                                               class="form-control col-md-7 col-xs-12 "
                                               style="float: right" placeholder="Search"></label></div>
                            </div>

                            <div class="grid-body no-border"><br>


                                <div id="my_data"></div>
                                <div class="col-md-4">
                                    <div class="dataTables_info" id="example_info" role="status" aria-live="polite">
                                        Showing
                                        <span id="start"></span> to <span id="end"></span> of <span id="total"></span>
                                        entries
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div id="pagination"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function () {
        $("#seacrh-field").keyup(function () {
            show_ajax_cards('');
        });

        $(document).on('change', '#select_limit', function () {
            show_ajax_cards('');
        });
        show_ajax_cards('');
    });

    function show_ajax_cards(obj) {
        if (obj == '') {
            var baseurl = '<?php echo site_url('roles/content/1'); ?>';
        } else {
            var baseurl = obj.id;
        }

        var post_data = {
            "search_text": $("#seacrh-field").val(),
            "select_limit": $("#select_limit").val(),
            'action': "roles_content"
        }
        $("#example_info").addClass("hidden");
        $.ajax({
            url: baseurl,
            data: post_data,
            type: 'POST',
            success: function (data) {

                var JSONArray = $.parseJSON(data);
                $('#my_data').html(JSONArray.content);
                $('#pagination').html(JSONArray.links);
                $('#start').html(JSONArray.start);
                $('#end').html(JSONArray.end);
                $('#total').html(JSONArray.total);
                $("#example_info").removeClass("hidden");
            }
        });
    }


</script>