<div class="row-fluid sortable borderframe">
    <div class="box span12">
        <h3 class="page-title"> Reset Password </h3>
        <div class="box-content">
            <form class="form-horizontal" action="" method="post">
                <?php if (validation_errors() != '') { ?>
                    <?php echo validation_errors(); ?>
                <?php
                }
                $message = $this->session->flashdata('response');
                if (isset($message) && $message != '') {
                    echo ' <div style="color:#FFFFFF;text-align: center;" class="alert alert-success " role="alert"> 
                                    <strong>' . $message . '</strong>
                                    </div>';
                }
                ?>
                <fieldset>
                    <div class="col-md-12">

                        <div class="control-group col-md-6">
                            <label class="control-label" for="inputSuccess">New Password (<strong>Password Must have at least 6 characters</strong>)</label>
                            
                            <div class="controls">
                            <!--<input type="password"
                                   id="new-password"
                                   placeholder="New Password"
                                   name="new-password"
                                   value=""
                                   class="form-control col-md-12 col-xs-12 ">-->
                                <input id="password" name="new-password" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" placeholder="Password" required class="form-control col-md-12 col-xs-12 ">
                                <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                            </div>
                        </div>
					<div class="control-group col-md-6">
                            <label class="control-label" for="inputSuccess">Confirm Password</label>
                            <div class="controls">
                            

<input id="password_two" name="password_two" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as new password' : '');" placeholder="Verify Password" required class="form-control col-md-12 col-xs-12 ">
                                <!--<input type="password" id="conf_password" placeholder="Confirm Password"
                                       name="conf_password"
                                       value=""
                                       class="form-control col-md-12 col-xs-12 ">-->
                            </div>
                        </div>	                        

                    </div>
                    <div class="form-actions col-md-3" style="padding-left: 30px;"> <br/>
                        <button type="submit" class="btn btn-success">Update</button>
                        <a onclick="window.history.back();" class="btn btn-danger">Cancel</a>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <!--/span--> 

</div>
<!--/row--> 