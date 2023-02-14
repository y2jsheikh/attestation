
                <div class="row-fluid sortable borderframe">
                    <div class="heading-top">  
                    <h3 class="page-title text-uppercase">
                            User Detail
                    </h3></div>
                    <div class="box span12">
                      
                        <div class="box-content">
                            <div class="portlet light profile-sidebar-portlet col-md-3 ">
                                <!-- SIDEBAR USERPIC -->
                                <div class="profile-userpic">
                                    <div class="img-border"><?php if(!empty($result->picture)): ?><img src="<?php echo base_url("/uploads/user_image/".$result->picture) ?>" width="140" height="140" /><?php else:?><img src="<?php echo base_url('assets/layouts/layout/img/user.svg'); ?>" alt="User Image" width="140" height="140" id="User Image" class="divpadding"/><?php endif; ?></div>
                                </div>
                                <!-- END SIDEBAR USERPIC -->
                                <!-- SIDEBAR USER TITLE -->
                            </div>
                    

                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="form-group success col-md-12">

                                        <div class="control-group success  col-md-12">
                                            <label class="col-md-6 "><strong>Full Name </strong></label>
                                            <label class="col-md-6 "><?php echo $result->fullname; ?></label>

                                        </div>
                                        <div class="control-group success  col-md-12">
                                            <label class="col-md-6 "><strong>Username</strong></label>
                                            <label class="col-md-6 "><?php echo $result->username; ?></label>

                                        </div>
                                        <div class="control-group success  col-md-12">
                                            <label class="col-md-6 "><strong>Role</strong></label>
                                            <label class="col-md-6 "><?php echo $result->role_name; ?></label>

                                        </div>
                                        <div class="control-group success  col-md-12">
                                            <label class="col-md-6 "><strong>Gender</strong></label>
                                            <label class="col-md-6 "><?php echo $result->gender; ?></label>

                                        </div>
                                        <div class="control-group success  col-md-12">
                                            <label class="col-md-6 "><strong>Role Type</strong></label>
                                            <label class="col-md-6 "><?php echo $result->role_name; ?></label>

                                        </div>
                                        <div class="control-group success  col-md-12">
                                            <label class="col-md-6 "><strong>Contact Number </strong></label>
                                            <label class="col-md-6 "><?php echo $result->contact_number; ?></label>

                                        </div>
                                        <div class="control-group success  col-md-12">
                                            <label class="col-md-6 "><strong>Status</strong></label>
                                            <label class="col-md-6 "><?php echo $result->status; ?></label>

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
                        //for only nuneric
                        $(document).on("input", ".only_numeric", function () {
                            $(this).val($(this).val().replace(/[^0-9]/g, ''));
                        });

                        $("input#username").on({
                            keydown: function (e) {
                                if (e.which === 32)
                                    return false;
                            },
                            change: function () {
                                this.value = this.value.replace(/\s/g, "");
                            }
                        });
                    });
                </script>
            