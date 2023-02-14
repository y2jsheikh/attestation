<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <h3>Edit Qualification</h3>
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
                        <label class="control-label">Qualification(<span class="text-muted">s</span>) <small class="requriedstar">*</small> </label>
                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-control input-paf" name="qualification_area">
                                    <option value="" <?php echo $result->qualification_area == '' ? 'selected' : ''; ?>>Select Area</option>
                                    <option value="Basic" <?php echo $result->qualification_area == 'Basic' ? 'selected' : ''; ?>>Basic</option>
                                    <option value="Graduate" <?php echo $result->qualification_area == 'Graduate' ? 'selected' : ''; ?>>Graduate</option>
                                    <option value="Postgraduate" <?php echo $result->qualification_area == 'Postgraduate' ? 'selected' : ''; ?>>Postgraduate</option>
                                    <option value="Diploma" <?php echo $result->qualification_area == 'Diploma' ? 'selected' : ''; ?>>Diploma</option>
                                    <option value="Course" <?php echo $result->qualification_area == 'Course' ? 'selected' : ''; ?>>Course</option>
                                </select>
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="qualification" value="<?php echo $result->qualification ?>" class="form-control input-paf" placeholder="Enter Qualification" required  />
                                <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="institute" value="<?php echo $result->institute ?>" class="form-control input-paf" placeholder="Enter Institute" required />
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="completion_year" value="<?php echo $result->completion_year ?>" class="form-control input-paf year_mask" min="1970" max="<?php echo date('Y') ?>" placeholder="Enter Year" required />
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
