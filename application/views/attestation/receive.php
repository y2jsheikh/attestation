<style>
    /*
    .table tr {
        cursor: pointer;
    }
    .table{
        background-color: #fff !important;
    }
    .hedding h1{
        color:#fff;
        font-size:25px;
    }
    .main-section{
        margin-top: 120px;
    }
    .hiddenRow {
        padding: 0 0px !important;
        background-color: #eeeeee;
        font-size: 13px;
    }
    .accordian-body span{
        color:#a2a2a2 !important;
    }
    */
</style>
<div class="row">
    <div class="col-md-12">
        <h3>Application(s)</h3>
        <?php if (validation_errors() != '') { ?>
            <br>
            <?php echo validation_errors(); ?>
        <?php } ?>
        <?php
        $message = $this->session->flashdata('success_response');
        if (isset($message) && $message != '') {
            echo '<br><div class="bg-green" style="margin: 10px; padding: 10px" role="alert">
                    <strong class="bg-font-green-soft font-lg">' . $message . '</strong></div>';
        }
        ?>
    </div>
    <div class="col-md-12">
        <div class="paf-banks-next">
            <div class="bank-padding">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">CNIC:</label>
                            <input type="text" placeholder="Enter CNIC" id="cnic" class="form-control input-paf cnic" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Occupation:</label>
                            <?php echo $occupation_select ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label"> &nbsp; </label><br/>
                            <button id="search-btn" type="button" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>

                <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="table-group-actions pull-right">
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
                    </div>
                    <div class="table-responsive" id='my_data'>

                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">
                                Showing <span id="start"></span> to <span id="end"></span> of <span id="total"></span> entries
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

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>-->
<script>
    $(document).ready(function () {
        $('.accordion-toggle').click(function(){
            $('.hiddenRow').hide();
            $(this).next('tr').find('.hiddenRow').show();
        });
        $(document).on('click', '#search-btn', function () {
            show_ajax_cards('');
        });
        $(document).on('change', '#select_limit', function () {
            show_ajax_cards('');
        });
        //load page for fitrs time
        show_ajax_cards('');
    });
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
            "cnic": $("#cnic").val(),
            "occupation_id": $("#occupation_id").val(),
            "current_status": 'courier_received',
            "select_limit": $("#select_limit").val(),
            'action': "attestation_receive_dispatch_content"
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