<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <h3>Edit Experience</h3>
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
                    <div class="form-group">
                        <label class="control-label">Experience(<span class="text-muted">s</span>) <small class="requriedstar">*</small> </label>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="emp_type" class="form-control input-paf" required>
                                    <option value="" <?php echo $result->emp_type == '' ? 'selected' : ''; ?>>Select Type</option>
                                    <option value="Govt" <?php echo $result->emp_type == 'Govt' ? 'selected' : ''; ?>>Govt</option>
                                    <option value="Semi Govt" <?php echo $result->emp_type == 'Semi Govt' ? 'selected' : ''; ?>>Semi Govt</option>
                                    <option value="Autonomous Body" <?php echo $result->emp_type == 'Autonomous Body' ? 'selected' : ''; ?>>Autonomous Body</option>
                                    <option value="Private" <?php echo $result->emp_type == 'Private' ? 'selected' : ''; ?>>Private</option>
                                </select>
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="institute" value="<?php echo $result->institute ?>" class="form-control input-paf" placeholder="Enter Institute" required />
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="designation" value="<?php echo $result->designation ?>" class="form-control input-paf" placeholder="Enter Designation" required />
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="start_date" value="<?php echo $result->start_date ?>" class="form-control input-paf datepicker" placeholder="Start Date" required readonly />
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="end_date" value="<?php echo $result->end_date ?>" class="form-control input-paf datepicker" placeholder="End Date" required readonly />
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
