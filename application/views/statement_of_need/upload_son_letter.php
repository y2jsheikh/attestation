
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
                            <h3>Statement of Need</h3><hr/>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id ?>" />
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />

                                <div class="image-upload">
                                    <label for="statement_of_need_file">
                                        Statement of Need Letter
                                    </label><br/>
                                    <input id="statement_of_need_file"
                                           name="statement_of_need_file"
                                           size="200000"
                                           type="file"
                                           required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr/>
                            <h4>Remarks/Feedback <small class="text-muted">(Optional)</small></h4>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="ministry_comment"
                                          id="ministry_comment"
                                          class="form-control input-paf"
                                          placeholder="Some Remarks/Feedback"
                                          maxlength="300"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions right">
                        <a href="<?php echo site_url('statement') ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> Go Back</a>
                        <button type="submit" id="submit_btn" class="btn btn-primary pull-right">
                            <i class="fa fa-check"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
