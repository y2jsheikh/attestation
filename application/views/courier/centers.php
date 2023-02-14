<style>
    /*
    .image-upload>input {
        display: none;
    }
    */
</style>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="image-upload">
                                    <label for="picture">
                                        <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                    </label><br/>
                                    <input id="file" name="file" size="200000" accept="application/pdf" type="file" required />
                                    <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                                </div>
                                <span id="picture_error" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    <?php
                                    $courier_centers = 'tcs_centers.pdf';
                                    if ($role_id == 3){
                                        $courier_centers = 'tcs_centers.pdf';
                                    }elseif ($role_id == 5){
                                        $courier_centers = 'mnp_centers.pdf';
                                    }
                                    ?>
                                    <a href="<?php echo base_url('assets/docs/'.$courier_centers) ?>" target="_blank">
                                        <img src="<?php echo base_url('assets/images/pdf_sample_01.png') ?>" width="50" />
                                    </a>
                                </label><br/>
                                Courier Centers
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"> &nbsp; </label><br/><br/>
                                <button type="submit" id="submit_btn" class="btn btn-primary pull-right">
                                    Upload
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var CorrectPicture = true;
    $(document).ready(function () {

    });

    $('input[id="picture"]').change(function() {
        fname = this.files[0].name;
        var extension = fname.substr((fname.lastIndexOf('.') + 1));
        //alert(extension);

        if (extension != "pdf") {
            $("#picture_error").html("File Type not allowed.<br> (Allowed: pdf)");
            CorrectPicture = false;
            return false;
        } else {
            $("#picture_error").html("");
        }
        fileSize = this.files[0].size;
    //    limitCheck = fileSize / 1024;
    });

    $(document).on("click", "#submit_btn", function(){
//    $("#submit_btn").on("click",function(){
        if(CorrectPicture == true){
        } else {
            alert("Please Upload Correct PDF File...");
            return false;
        }
    });

</script>