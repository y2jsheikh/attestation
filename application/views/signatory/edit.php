
<div class="row">
    <div class="col-md-12">
        <?php if (validation_errors() != '') { ?>
            <br>
            <?php echo validation_errors(); ?>
        <?php } ?>
        <?php
        $message = $this->session->flashdata('response');
        if (isset($message) && $message != '') {
            echo '<br><div class="bg-red" style="margin: 10px; padding: 10px" role="alert">
                    <strong class="bg-font-red-soft font-lg">' . $message . '</strong></div>';
        }
        $success_message = $this->session->flashdata('success_response');
        if (isset($success_message) && $success_message != '') {
            echo '<br><div class="bg-green" style="margin: 10px; padding: 10px" role="alert">
                    <strong class="bg-font-green-soft font-lg">' . $success_message . '</strong></div>';
        }
        ?>
    </div>
    <div class="col-md-12">
        <div class="paf-banks-next">
            <div class="bank-padding">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Add Signatory</h3><hr/>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Name: <span class="text-danger">*</span></label>
                                <?php echo form_input('name', set_value('name', $result->name), array('class' => "form-control input-paf", 'id' => 'name', 'minlength' => 3, 'placeholder' => 'Name', 'required' => '')) ?>
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Designation: <span class="text-danger">*</span></label>
                                <?php echo form_input('designation', set_value('designation', $result->designation), array('class' => "form-control input-paf", 'id' => 'designation', 'placeholder' => 'Designation', 'required' => '')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Department: </label>
                                <?php echo form_input('department', set_value('department', $result->department), array('class' => "form-control input-paf", 'id' => 'department', 'placeholder' => 'Department')) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Status: </label>
                                <select name="status" id="status" class="form-control select2" required>
                                    <option value="Y" <?php echo $result->status == 'Y' ? 'selected' : ''; ?>>Active</option>
                                    <option value="N" <?php echo $result->status == 'N' ? 'selected' : ''; ?>>In-Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group float-right">
                                <label class="control-label"> &nbsp; </label><br/>
                                <button type="submit" id="submit_btn" class="btn btn-warning pull-right">
                                    <i class="fa fa-check"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
