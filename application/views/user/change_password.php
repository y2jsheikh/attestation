<style>
    /*Password Strength Checker Start*/
    /*
    .passwordInput{
        margin-top: 5%;
        text-align :center;
    }
    */
    .displayBadge{
        margin-top: 5%;
        display: none;
        text-align :center;
    }
    /*Password Strength Checker End*/
</style>
<div class="row-fluid sortable borderframe">
    <div class="box span12">
        <h3 class="page-title">
            Change Password
        </h3>
        <div class="box-content">
            <form class="form-horizontal" action="" method="post">
                <?php if (validation_errors() != '') { ?>
                    <?php echo validation_errors(); ?>
                <?php }
                    $message = $this->session->flashdata('response');
                    if (isset($message) && $message != '') {
                        echo ' <div style="color:#FFFFFF;text-align: center;" class="alert alert-success " role="alert"> 
                                    <strong>' . $message . '</strong>
                                    </div>';
                    } ?>
                <fieldset>
                    <br/>
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <label class="control-label " for="inputSuccess">Old Password</label>
                            <div class="form-group">
                                <input type="password" placeholder="Old Password" id="inputSuccess"
                                       name="old_password" required=""
                                       value="<?php echo set_value('old_password'); ?>"
                                       class="form-control input-paf">
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                            </div>
                        </div><br/>
                        <div class="col-md-6 col-xs-6">
                            <label class="control-label" for="inputSuccess">New Password (<small class="text-muted">At least 1 Capital and Small Alphabet, 1 Symbol, 1 Number</small>)</label>
                            <div class="form-group">
                                <input type="password" id="PassEntry" placeholder="New Password"
                                       name="new_password" required=""
                                       value="<?php echo set_value('new_password'); ?>"
                                       class="form-control input-paf passwordInput">
                                <span id="StrengthDisp" class="badge displayBadge">Weak</span>
                            </div>
                        </div><br/>
                        <div class="col-md-6 col-xs-6">
                            <label class="control-label" for="inputSuccess">Confirm Password</label>
                            <div class="form-group">
                                <input type="password" id="confirm-password" placeholder="Confirm Password"
                                       name="confirm_password" required=""
                                       value="<?php echo set_value('confirm_password'); ?>"
                                       class="form-control input-paf">
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <label class="control-label" for="inputSuccess"> &nbsp; </label>
                            <div class="form-group">
                                <button type="submit" id="btn-update" class="btn btn-primary pull-right">Update</button>

                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>

        </div>
    </div><!--/span-->

</div><!--/row-->
<!--/.fluid-container-->
<script>
    $(document).ready(function () {

        $("#btn-update").addClass("disabled");
        $("#btn-update").prop("disabled", true);

        // Password Strength Checker Start
        // timeout before a callback is called

        let timeout;
        // traversing the DOM and getting the input and span using their IDs
        let password = document.getElementById('PassEntry');
        let strengthBadge = document.getElementById('StrengthDisp');
        // The strong and weak password Regex pattern checker
        let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})');
        let mediumPassword = new RegExp('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))');
        function StrengthChecker(PasswordParameter){
            // We then change the badge's color and text based on the password strength
            if(strongPassword.test(PasswordParameter)) {
                strengthBadge.style.backgroundColor = "green";
                strengthBadge.style.color = "white";
                strengthBadge.textContent = 'Strong';

                $("#btn-update").removeClass("disabled");
                $("#btn-update").prop("disabled", false);

            } else if(mediumPassword.test(PasswordParameter)){
                strengthBadge.style.backgroundColor = 'blue';
                strengthBadge.style.color = 'white';
                strengthBadge.textContent = 'Medium';

            //    $("#btn-update").addClass("disabled");
            //    $("#btn-update").prop("disabled", true);

                $("#btn-update").removeClass("disabled");
                $("#btn-update").prop("disabled", false);

            } else{
                strengthBadge.style.backgroundColor = 'red';
                strengthBadge.style.color = 'white';
                strengthBadge.textContent = 'Weak';

                $("#btn-update").addClass("disabled");
                $("#btn-update").prop("disabled", true);

            }
        }
        // Adding an input event listener when a user types to the  password input
        password.addEventListener("input", () => {
            //The badge is hidden by default, so we show it
            strengthBadge.style.display= 'block';
            clearTimeout(timeout);
            //We then call the StrengChecker function as a callback then pass the typed password to it
            timeout = setTimeout(() => StrengthChecker(password.value), 400);
            //Incase a user clears the text, the badge is hidden again
            if(password.value.length !== 0){
                strengthBadge.style.display != 'block';
            } else{
                strengthBadge.style.display = 'none';
            }
        });
        // Password Strength Checker End

    });
</script>