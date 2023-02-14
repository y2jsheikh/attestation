<div class="row-fluid sortable borderframe">
    <div class="heading-top"><h3 class="page-title text-uppercase"> Update Role
        </h3></div>
    <div class="box span12">

        <div class="box-content">
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
                    <div class="form-group success col-md-12">
                        <div class="control-group success  col-md-4">
                            <label class="control-label " for="role_name">Role Name <span
                                        class="red-star">*</span></label>
                            <div class="controls">
                                <input type="text" placeholder="Enter Role Name" id="role_name"
                                       name="role_name"
                                       value="<?php echo $result->role_name; ?>"
                                       class="form-control col-md-7 col-xs-12 ">
                            </div>
                        </div>
                        <div class="control-group success col-md-4">
                            <input type="hidden" name="role_id" value="<?php echo $result->id; ?>"/>
                            <label class="control-label " for="inputSuccess">Status</label>
                            <select name="status" id="status" class="span12 form-control ">
                                <?php $status = $result->status; ?>
                                <option value="Y" <?php echo set_select('status', 'Y') ? set_select('status', 'Y') : (isset($status) && $status == 'Y' ? 'selected' : ''); ?>>
                                    Active
                                </option>
                                <option value="N" <?php echo set_select('status', 'N') ? set_select('status', 'N') : (isset($status) && $status == 'N' ? 'selected' : ''); ?>>
                                    In Active
                                </option>
                            </select>
                        </div>

                    </div>
                    <div class="form-actions col-md-12">
                        <button type="submit" class="btn btn-primary">Update</button>

                    </div>
                </fieldset>
            </form>

        </div>
    </div><!--/span-->

</div><!--/row-->