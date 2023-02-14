<div class="row-fluid sortable borderframe">
    <div class="heading-top">
          <h3 class="page-title text-uppercase"> Add Role
        </h3>
    </div>
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
                            <label class="control-label " for="inputSuccess">Role Name <span
                                        class="red-star">*</span></label>
                            <div class="controls">
                                <input type="text" placeholder="Enter Role Name" id="role_name"
                                       name="role_name"  required
                                       value="<?php echo set_value('role_name') ? set_value('role_name') : (isset($role_name) ? $role_name : '') ?>"
                                       class="form-control col-md-7 col-xs-12 ">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions col-md-12">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </fieldset>
            </form>

        </div>
    </div><!--/span-->
</div><!--/row-->
