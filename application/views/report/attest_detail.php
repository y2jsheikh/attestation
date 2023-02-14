<div class="row">
    <div class="col-md-12">
        <h3>Details of Attestation</h3>
        <?php if (validation_errors() != '') { ?>
            <br>
            <?php echo validation_errors(); ?>
        <?php } ?>
        <?php
        $message = $this->session->flashdata('success_response');
        if (isset($message) && $message != '') {
            echo '<br><div class="bg-green" style="margin: 10px; padding: 10px" role="alert">
                    <strong class="bg-font-green-soft font-lg">' . $message . '</strong></div>';
        }
        ?>
    </div>
    <div class="col-md-12">
        <div class="paf-banks-next">
            <div class="bank-padding">
                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-default">Back to Listing</a>
                <h4 style="margin-top: 2%;"><u>Personal Information</u></h4><br/>
                <div class="row">
                    <div class="col-md-4">
                        <p><b>Name of Applicant</b></p>
                        <p><b>Father's Name</b></p>
                        <p><b>Domicile</b></p>
                        <p><b>CNIC/Passport</b></p>
                        <p><b>Correct E-mail Address (valid)</b></p>
                        <p><b>Marital Status</b></p>
                        <p><b>Occupation</b></p>
                    <?php if (isset($result[0]['cn_number']) && $result[0]['cn_number'] != ''){ ?>
                        <p><b>CN Number</b></p>
                    <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <p><?php echo isset($result[0]['user_name']) && $result[0]['user_name'] != '' ? $result[0]['user_name'] : '-'; ?></p>
                        <p><?php echo isset($result[0]['father_name']) && $result[0]['father_name'] != '' ? $result[0]['father_name'] : '-'; ?></p>
                        <p><?php echo isset($result[0]['domicile']) && $result[0]['domicile'] != '' ? $result[0]['domicile'] : '-'; ?></p>
                        <p><?php echo isset($result[0]['cnic']) && $result[0]['cnic'] != '' ? $result[0]['cnic'] : '-'; ?></p>
                        <p><?php echo isset($result[0]['email']) && $result[0]['email'] != '' ? $result[0]['email'] : '-'; ?></p>
                        <p><?php echo isset($result[0]['marital_status']) && $result[0]['marital_status'] != '' ? $result[0]['marital_status'] : '-'; ?></p>
                        <p><?php echo isset($result[0]['occupation']) && $result[0]['occupation'] != '' ? $result[0]['occupation'] : '-'; ?></p>
                    <?php if (isset($result[0]['cn_number']) && $result[0]['cn_number'] != ''){ ?>
                        <a target="_blank" href="https://www.tcsexpress.com/Tracking/" class="text-success"><?php echo $result[0]['cn_number'] ?></a>
                    <?php } ?>
                    </div>
                    <div class="col-md-2">
                    <?php $user_id = isset($result[0]['user_id']) && $result[0]['user_id'] != '' ? $result[0]['user_id'] : 0; ?>
                        <img src="<?php echo base_url('uploads/user_image/'.$result[0]['picture']) ?>" class="img-thumbnail image-class" style="min-width: 150px;">
                    <?php // if ($role_id == 3 || $role_id == 4){ ?>
                    <?php if ($role_id == 4){ ?>
                        <a target="_blank" href="<?php echo site_url('attestation/print_form/'.$attest_id.'/'.$user_id) ?>" class="btn btn-success btn-sm col-md-12">View Form</a>
                        <a target="_blank" href="<?php echo site_url('statement/statement_of_need_application/'.$user_id) ?>" class="btn btn-primary btn-sm col-md-12">Statement of Need</a>
                    <?php } ?>
                    </div>
                </div>
                <div class="clearfix"></div><br/>
                <?php if ($role_id == 3 || $role_id == 5){ ?>
                <form class="form-inline" name="" method="post" action="">
                <?php if ($not_received_doc_count > 0){ ?>
                    <!--Documents Not Received Yet-->
                <?php } else { ?>
                    <div class="row">
                        <div class="form-group mx-sm-3 mb-2">
                            <?php echo form_input('cn_number', set_value('cn_number'), array('class' => "form-control input-paf", 'id' => 'cn_number', 'placeholder' => 'Enter CN#', 'maxlength' => 12, 'required' => '')) ?>
                            <?php
                                $old_status = "";
                                $current_status = "";
                                if (isset($result[0]['current_status'])){
                                    $old_status = $result[0]['current_status'];
                                    if ($result[0]['current_status'] == 'user_submitted'){
                                        $current_status = "courier_received";
                                    } elseif ($result[0]['current_status'] == 'ministry_dispatched'){
                                        $current_status = "courier_dispatched";
                                    }
                                }
                            ?>
                            <input type="hidden" name="old_status" value="<?php echo $old_status ?>" />
                            <input type="hidden" name="current_status" value="<?php echo $current_status ?>" />
                            <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                        </div>
                        <!--<button type="button" class="btn btn-primary mb-2 disabled" disabled><i class="fa fa-check"></i> Enter</button>-->
                        <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-check"></i> Enter</button>
                    </div>
                <?php } ?>

                </form>
                <br/>
                <?php } ?>
                <div class="table-responsive">
                    <form name="courier_received_form" action="<?php echo site_url('attestation/courier_receive_documents') ?>" id="courier_received_form" method="post">
                        <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                        <input type="hidden" name="attest_request_id" value="<?php echo $attest_id ?>" />
                        <table class="table table-data-new">
                            <thead>
                            <tr>
                                <th> Sr. #</th>
                            <?php if ($role_id == 3 || $role_id == 5){ ?>
                                <th> Received</th>
                            <?php } ?>
                                <th> Document Type</th>
                                <th> Document</th>
                                <th> Submission Date</th>
                                <th> Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $class = 'even';
                            $i = 1;
                            $counter = 0;
                            if (is_array($result) && count($result) > 0):
                                foreach ($result as $r):
                            ?>
                                    <tr role="row" class="<?php echo ($class == 'even' ? 'odd' : 'even') ?>">
                                        <td> <b><?php echo $i; ?></b> </td>
                                    <?php if ($role_id == 3 || $role_id == 5){ ?>
                                        <td>
                                            <?php if ($r['is_courier_recieved'] == 'N'){ ?>
                                                <input type="hidden" value="<?php echo $r['id'] ?>" name="attest_document_id[]" id="attest_document_id_<?php echo $counter ?>">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" name="is_courier_recieved_<?php echo $counter ?>" id="is_courier_recieved_<?php echo $counter ?>">
                                                    <label class="custom-control-label" for="is_courier_recieved_<?php echo $counter ?>"></label>
                                                </div>
                                            <?php }else{ ?>
                                                <label>Received</label>
                                                <input type="hidden" value="<?php echo $r['id'] ?>" name="attest_document_id[]" id="attest_document_id_<?php echo $counter ?>">
                                                <input type="hidden" value="Y" name="is_courier_recieved[]" id="is_courier_recieved_<?php echo $counter ?>">
                                            <?php } ?>
                                        </td>
                                    <?php } ?>
                                        <td> <?php echo $r['doc_type']; ?> </td>
                                        <td> <?php echo $r['qualification']; ?> </td>
                                        <td> <?php echo date('m/d/Y',$r['created']); ?> </td>
                                        <td>
                                        <?php
                                            if ($r['status'] == 'pending'){
                                                echo "Pending";
                                            }elseif ($r['status'] == 'accepted' || $r['status'] == 'attested'){
                                                echo "Attested";
                                            }elseif ($r['status'] == 'not_received'){
                                                echo "Not Received";
                                            }elseif ($r['status'] == 'rejected'){
                                                echo "Rejected";
                                            }

                                            if ($r['status'] == 'rejected' && $r['remarks'] != ''){
                                                echo "<br/> (<b>".$r['remarks']."</b>)";
                                            }
                                        ?>
                                        </td>
                                    </tr>
                            <?php
                                    $i++;
                                    $counter++;
                                endforeach;
                            else:
                            ?>
                                <tr>
                                    <th scope="row" colspan="6">
                                        <div style="color:#FFFFFF;text-align: center; background-color: #ff0000;" class="alert alert-danger " role="alert">
                                            <strong>NO DATA FOUND</strong></div>
                                    </th>
                                </tr>
                            <?php
                            endif;
                            ?>

                            </tbody>
                        </table>
                        <?php if ($role_id == 3 || $role_id == 5){ ?>
                            <?php if (is_array($result) && count($result) > 0): ?>
                                <?php if ($not_received_doc_count > 0){ ?>
                                    <div class="row-fluid">
                                        <div class="col-md-12 col-sm-3 col-xs-3">
                                            <br/>
                                            <button type="submit" class="btn btn-info btn-sm pull-right">
                                                <i class="fa fa-check"></i> Submit
                                            </button>
                                            <br/><br/>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php endif; ?>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    anime({
        targets: '.image-class',
        scale: [
            {value: .1, easing: 'easeOutSine', duration: 600},
            {value: 1, easing: 'easeInOutQuad', duration: 1200}
        ],
        delay: anime.stagger(200, {grid: [14, 5], from: 'center'})
    });
</script>