<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('favicon.ico'); ?>"/>
    <title>Attestation | Login </title>
    <link href="<?php echo base_url('assets/'); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/'); ?>css/style.css" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/select2.full.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.mask.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.table2excel.js'); ?>"></script>
    <!-- Datepicker Links -->
    <link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet"  type="text/css"/>
    <script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
    <!-- / Datepicker Links -->
    <script src="<?php echo base_url('assets/js/attestation.js'); ?>" type="text/javascript" ></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<style>
    .makeRed {
        box-shadow: 1px 1px 2px #ffd2dc, 0 0 25px #ff2825, 0 0 5px white;
    }
</style>
</head>

<body>

<div class="row">
    <div id="answerModal" class="modal fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header justify-content-center" style="background: #e85e6c; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body text-center">
                    <h4>Ooops!</h4>
                    <p>Please Enter the Correct Answer</p>
                    <button class="btn btn-success" data-dismiss="modal">Try Again</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">



    <div id="userInstructionModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- SOPs Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">
                        <strong>Dear Visitor!</strong>
                    </h4>
                    <!--<button type="button" class="close" id="closing" data-dismiss="modal">&times;</button>-->
                </div>
                <!-- Older Instructions
                <div class="modal-body">
                    <p>Following are guidelines for the process of attestation of documents:</p><br/>
                    <label> 1. The User will login through this page (if already a member), otherwise will create his/her account by clicking <b>Sign Up</b>.</label><br/>
                    <label> 2. The User will fill out the basic information in the registration form and submit.</label><br/>
                    <label> 3. On submitting, a One Time Password will be generated and will be send via email given at the time of registration.</label><br/>
                    <label> 4. The User will be redirected to the '<b>Enter OTP</b>' screen. The User will enter OTP (Sent by email) and on entering correct OTP, User will be directed to his/her Dashboard.</label><br/>
                    <label> 5. In order to Place Attestation request, The User will fill out further information required by either clicking '<b>Update Profile</b>' (on the down right side) or '<b>Attestation</b>' (on the left menu).</label><br/>
                    <label> 6. The User will fill out <b>Basic Information</b>, then by clicking Next Step <b>Qualification</b> -> <b>Experience</b> (Optional) -> <b>Overseas Employment Information</b> then by clicking Next Step, <b>Attestation Request</b> page will be displayed.</label><br/>
                    <label> 7. SOP's will be displayed here which are to be followed throughout the process. Click Ok to close.</label><br/>
                    <label> 8. The User will select <b>Province</b>, <b>Submission Type</b> (Either by Walk-in -> 'Self', Or Courier -> 'Courier'). In case of Self Submission, the User will select his/her preferred Visit Date and Time Slot (To be selected from the available ones). </label><br/>
                    <label> 9. By filling out the required information and Consent Form, an Application print form will be displayed. The User will print out the form and will take it along with other documents to the Ministry (in case of Self Submission) Or Courier (in case of Courier Submission).</label>
                    <small style="color: red;">Note: You should follow each step carefully so it may not result in failing the attestation of documents.</small>
                </div>
                -->
                <div class="modal-body">
                    <p>Following are guidelines for the process of attestation of documents:</p><br/>
                    <label> 1. The User will login through this page (if already a member), otherwise will create his/her account by clicking <b>Sign Up</b>.</label><br/>
                    <label> 2. After registration, on successful Login, User will be directed to his/her Dashboard.</label><br/>
                    <label> 3. In order to Place Attestation request, The User will fill out further information required by either clicking '<b>Update Profile</b>' (on the down right side) or '<b>Attestation</b>' (on the left menu).</label><br/>
                    <label> 4. The User will fill out <b>Basic Information</b>, then by clicking Next Step <b>Qualification</b> -> <b>Experience</b> (Optional) -> <b>Overseas Employment Information</b> then by clicking Next Step, <b>Attestation Request</b> page will be displayed.</label><br/>
                    <label> 5. SOP's will be displayed here which are to be followed throughout the process. Click Ok to close.</label><br/>
                    <label> 6. The User will select <b>Province</b>, <b>Submission Type</b> (Either by Walk-in -> 'Self', Or Courier -> 'Courier'). In case of Self Submission, the User will select his/her preferred Visit Date and Time Slot (To be selected from the available ones). </label><br/>
                    <label> 7. By filling out the required information and Consent Form, an Application print form will be displayed. The User will print out the form and will take it along with other documents to the Ministry (in case of Self Submission) Or Courier (in case of Courier Submission).</label>
                    <small style="color: red;">Note: You should follow each step carefully so it may not result in failing the attestation of documents.</small>
                </div>
                <div class="modal-footer">
                    <!--<a target="_blank" title="Video Tutorial" class="btn btn-danger" href="<?php /*echo base_url('assets/docs/Video Tutorial DAS.mp4') */?>"><i class="fa fa-play"></i></a>-->
                    <a target="_blank" href="<?php echo base_url('assets/docs/SOPs for Documents Attestation.pdf') ?>" class="btn btn-info"><i class="fa fa-paperclip"></i> SOPs</a>
                    <button type="button" id="closing_2" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Login PAF -->
<div class="cc-login-main">
    <div class="container">
        <div class="col-sm-12">
            <div class="form-group  col-xs-12" align="center">

                <?php
                if (validation_errors() != '') {
                    /*
                    echo ' <div style="color:#c9302c !important;text-align: center;" class="alert alert-danger " role="alert">
                                <strong>' . validation_errors() . '</strong>
                                </div>';
                    */
                ?>
                <div id="errorModal" class="modal fade" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-confirm">
                        <div class="modal-content">
                            <div class="modal-header justify-content-center" style="background: #e85e6c; color: white;">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body text-center">
                                <h4>Ooops!</h4>
                                <p><?php echo validation_errors() ?></p>
                                <button class="btn btn-success" data-dismiss="modal">Try Again</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $('#errorModal').modal({backdrop: 'static', keyboard: false});
                </script>
                <?php
                }
                $failure_message = $this->session->flashdata('failure_response');
                $success_message = $this->session->flashdata('success_response');
                if (isset($failure_message) && $failure_message != '') {
                    echo ' <div style="color:#FFFFFF;text-align: center;" class="alert alert-success " role="alert"> 
                                    <strong>' . $failure_message . '</strong>
                                    </div>';
                }
                if (isset($success_message) && $success_message != '') {
                    /*
                    echo ' <div style="color:#FFFFFF;text-align: center;" class="alert alert-success " role="alert"> 
                                    <strong>' . $success_message . '</strong>
                                    </div>';
                    */
                ?>
                <div id="successModal" class="modal fade" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-confirm">
                        <div class="modal-content">
                            <div class="modal-header justify-content-center" style="background: #749939; color: white;">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body text-center">
                                <h4>Congratulations!</h4>
                                <p><?php echo $success_message ?></p>
                                <button class="btn btn-success" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $('#successModal').modal({backdrop: 'static', keyboard: false});
                </script>
                <?php
                }
                ?>
            </div>
            <div class="login-area-cc">
                <div class="center-frmlogin-cc">
                    <div class="bg-cc">
                        <!--<a href="#answerModal" class="trigger-btn" data-toggle="modal">Click to Open Answer Error Modal</a>-->
                        <div class="logo-login-cc mb-3 text-center">
                            <a href="#"><img src="<?php echo base_url('assets/'); ?>images/logo.png" width="145" alt="logo" class="img-responsive"></a>
                            <div class="Paf-head" style="font-size: 150%;">Ministry of National Health Services, Regulations & Coordination Islamabad</div>
                            <!--<div class="skyview-golf">Document Attestation</div>-->
                            <div class="accounting-procurement">Documentation | Verification System</div>
                        </div>
                        <form action="" method="post">
                            <div class="col-sm-12 cc-formgroup no-padding">
                                <input type="text" class="form-control new-form-cntrl-cc" name="username" id="username" placeholder="Username" autofocus required />
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                            </div>
                            <div class="col-sm-12 cc-formgroup no-padding">
                                <input type="password" class="form-control new-form-cntrl-cc" name="password" id="password" placeholder="Password" required />
                            </div>

                            <div class="col-md-12 cc-formgroup no-padding">
                                <div class="form-group">
                                    <label class="control-label">Give the answer &nbsp; </label>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-5 col-sm-3 col-xs-2">
                                            <input type="number"
                                                   id="num_1"
                                                   class="form-control input-paf"
                                                   placeholder="#"
                                                   value="<?php echo rand(0,9) ?>"
                                                   readonly />
                                        </div>
                                        +
                                        <div class="col-lg-3 col-md-5 col-sm-3 col-xs-2">
                                            <input type="number"
                                                   id="num_2"
                                                   class="form-control input-paf"
                                                   placeholder="#"
                                                   value="<?php echo rand(0,9) ?>"
                                                   readonly />
                                        </div>
                                        =
                                        <div class="col-lg-5 col-md-12 col-sm-5 col-xs-6">
                                            <input type="number"
                                                   id="answer_num"
                                                   class="form-control input-paf"
                                                   placeholder="Your Answer"
                                                   required/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 text-center no-padding cc-formgroup">
                                <a class="forgot-password-cc" href="<?php echo site_url('forgetpassword')?>">Forgot Password?</a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12 no-padding">
                                <button type="submit" class="btn-login-cc" id="btn_login_cc">Login</button>
                                <small>Don't have an account ?? <a href="<?php echo site_url('register') ?>">Sign Up</a></small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/anime.min.js'); ?>" type="text/javascript" ></script>
<script>

    var counter = 0;
    function setCookie(){
        document.cookie = 'counter=1;';
    }
    function getCookie(){
        cookieArray = document.cookie.split("=");
        if (cookieArray[0] == 'counter') {
            counterString = cookieArray[1];
            counterArray = counterString.split(";");
            counter = counter + parseInt(counterArray[0]);
        }
    }

    $(document).ready(function () {
        <?php
        if (validation_errors() == '') {
        ?>
        getCookie();
        if (counter == 0) {
            $('#userInstructionModal').modal({backdrop: 'static', keyboard: false});
        }
        setCookie();
        <?php
        }
        ?>
        /*
        anime({
            targets: '.modal-content',
            translateX: anime.stagger(0, {grid: [14, 5], from: 'center', axis: 'x'}),
            translateY: anime.stagger(0, {grid: [14, 5], from: 'center', axis: 'y'}),
            rotateZ: anime.stagger([0, 360], {grid: [14, 5], from: 'center', axis: 'x'}),
            delay: anime.stagger(200, {grid: [14, 5], from: 'center'}),
            easing: 'easeInOutQuad'
        });
        */
        anime({
            targets: '.input-paf',
            scale: [
                {value: .1, easing: 'easeOutSine', duration: 600},
                {value: 1, easing: 'easeInOutQuad', duration: 1200}
            ],
            delay: anime.stagger(200, {grid: [14, 5], from: 'center'})
        });
    });

    /*
    $(document).ready(function () {
    //    $(".cnic").mask('00000-0000000-0');
        $(".cnic").mask('0000000000000');

        $(document).on("keyup", "#answer_num", function () {
            var num_1 = $("#num_1").val();
            var num_2 = $("#num_2").val();
            var answer = parseInt(num_1) + parseInt(num_2);
            var result = $(this).val();
            if (answer != result) {
                $("#answer_num").addClass("makeRed");
                $(".btn-login-cc").addClass("disabled");
                $(".btn-login-cc").prop("disabled", true);
                return false;
            }else{
                $("#answer_num").removeClass("makeRed");
                $(".btn-login-cc").removeClass("disabled");
                $(".btn-login-cc").prop("disabled", false);
                return false;
            }
        });
        $('.btn-login-cc').click(function(){
            $("input, select").each( function(){ //iterate all inputs
                var $this = $(this);
                var value = $this.val();
                $this.removeClass("makeRed"); //reset the class first
                if (value.length == 0){
                    $this.addClass("makeRed"); //add if input is empty
                }
            });
        });
        $("input,select").focus(function(){
            $(this).removeClass("makeRed"); //on focus of the input remove the markRed class
        })
    });
    */
</script>
</body>
</html>
