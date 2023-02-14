<div class="content-pagination-height borderframe">
    <div class="heading-top">
        <h3 class="page-title text-uppercase"> Roles Management
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
                    <form class="form-horizontal" action="" method="post">
                        <p>
                            <?php
                            error_reporting(0);
                            if (validation_errors() != '') {
                            ?>
                        <div style="color:#FFFFFF;text-align: center; background-color: #ff0000;"
                             class="alert alert-danger " role="alert">
                            <strong>
                                <?php echo validation_errors(); ?>
                            </strong>
                        </div>
                        <?php }
                        ?>
                        </p>
                        <fieldset>
                            <div class="col-md-12">
                                <div class="control-group success  col-md-3 col-xs-6">
                                    <label class="control-label " for="inputSuccess">Roles<span
                                                class="red-star">*</span></label>
                                    <div class="controls">
                                        <?php echo $roles; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="modulesDiv"></div>
                            <div class="col-md-12 hide" id="subDiv">
                                <div class="control-group success  col-md-1 col-xs-6">
                                    <div class="controls" style="margin-top: 35px">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function () {

        $(document.body).on("change", "#role_name", function () {
            var postData = {
                "role_id": $(this).val()
            }
            $.ajax({
                url: '<?php echo site_url('Roles/loadRights') ?>',
                type: 'POST',
                data: postData,
                success: function (data) {
                    $("#modulesDiv").html(data);
                    $('#subDiv').removeClass('hide');
                }
            });
        });
    });

</script>