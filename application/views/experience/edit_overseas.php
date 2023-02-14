<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <h3>Edit Overseas Experience</h3>
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
                <form method="post" action="">
                    <!--<div class="col-md-12">-->
                    <div class="form-group">
                        <label class="control-label">Experience </label>
                        <div class="row">
                            <div class="col-md-4">
                                <?php echo $country_select ?>
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="institute" class="form-control input-paf" value="<?php echo $result->institute ?>" placeholder="Enter Institute" />
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="position" class="form-control input-paf" value="<?php echo $result->position ?>" placeholder="Position" />
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="joining_date" class="form-control input-paf datepicker" value="<?php echo $result->joining_date ?>" placeholder="Tentative Joining Date" readonly />
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="purpose" class="form-control input-paf" value="<?php echo $result->purpose ?>" placeholder="Purpose" required />
                            </div>
                        </div>
                    </div>
                    <!--</div>-->
                    <div class="form-actions right">
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <button type="submit" class="btn btn-info">
                            <i class="fa fa-check"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
//    $(".datepicker").datepicker();
    });
</script>