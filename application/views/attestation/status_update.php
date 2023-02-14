<div class="row">
    <div class="col-md-12">
        <h3>Documents to be Attested</h3>
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
                <form method="post" action="">
                    <input type="hidden" name="no_of_docs" id="no_of_docs" value="<?php echo isset($result[0]['no_of_docs']) && $result[0]['no_of_docs'] > 0 ? $result[0]['no_of_docs'] : 0; ?>" />
                    <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                    <h4 style="margin-top: 5%;"><u>Personal Information</u></h4><br/>
                    <div class="row">
                        <div class="col-md-4">
                            <p><b>Name of Applicant</b></p>
                            <p><b>Father's Name</b></p>
                            <p><b>Domicile</b></p>
                            <p><b>CNIC</b></p>
                            <p><b>Correct E-mail Address (valid)</b></p>
                            <p><b>Marital Status</b></p>
                            <p><b>Occupation</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><?php echo isset($result[0]['user_name']) && $result[0]['user_name'] != '' ? $result[0]['user_name'] : '-'; ?></p>
                            <p><?php echo isset($result[0]['father_name']) && $result[0]['father_name'] != '' ? $result[0]['father_name'] : '-'; ?></p>
                            <p><?php echo isset($result[0]['domicile']) && $result[0]['domicile'] != '' ? $result[0]['domicile'] : '-'; ?></p>
                            <p><?php echo isset($result[0]['cnic']) && $result[0]['cnic'] != '' ? $result[0]['cnic'] : '-'; ?></p>
                            <p><?php echo isset($result[0]['email']) && $result[0]['email'] != '' ? $result[0]['email'] : '-'; ?></p>
                            <p><?php echo isset($result[0]['marital_status']) && $result[0]['marital_status'] != '' ? $result[0]['marital_status'] : '-'; ?></p>
                            <p><?php echo isset($result[0]['occupation']) && $result[0]['occupation'] != '' ? $result[0]['occupation'] : '-'; ?></p>
                        </div>
                        <div class="col-md-2">
                            <img src="<?php echo base_url('uploads/user_image/'.$result[0]['picture']) ?>" class="img-thumbnail" width="150">
                        </div>
                    </div>
                    <div class="clearfix"></div><br/>
                    <div class="table-responsive">
                        <table class="table table-data-new">
                            <thead>
                            <tr>
                                <th> Sr. #</th>
                                <th> Document Type</th>
                                <th> Document</th>
                                <th> Submission Date</th>
                                <th> Status</th>
                                <th> Verify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $class = 'even';
                            $i = 1;
                            if (is_array($result) && count($result) > 0):
                                foreach ($result as $r):
                                    ?>
                                    <tr role="row" class="<?php echo ($class == 'even' ? 'odd' : 'even') ?>">
                                        <td> <b><?php echo $i; ?></b> </td>
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
                                        ?>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="hidden" name="rec[]" id="rec_<?php echo $i ?>" value="<?php echo $r['id'] ?>" />
                                                    <input type="hidden" name="user_qualification_id[]" id="user_qualification_id_<?php echo $i ?>" value="<?php echo $r['user_qualification_id'] ?>" />
                                                    <select name="status[]" attr-counter="<?php echo $i ?>" class="form-control input-sm doc_status" id="doc_status_<?php echo $i ?>">
                                                        <option value="pending" <?php echo $r['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="accepted" <?php echo $r['status'] == 'accepted' || $r['status'] == 'attested' ? 'selected' : ''; ?>>Attest</option>
                                                        <option value="rejected" <?php echo $r['status'] == 'rejected' ? 'selected' : ''; ?>>Reject</option>
                                                        <option value="not_received" <?php echo $r['status'] == 'not_received' ? 'selected' : ''; ?>>Not Received</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6" id="remarks_div_<?php echo $i ?>" style="display: none;">
                                                    <input type="text" name="remarks[]" class="form-control input-paf remarks" id="remarks_<?php echo $i ?>" placeholder="Enter Remarks" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
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
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br/>
                            <button type="submit" class="btn btn-info pull-right">
                                <i class="fa fa-check"></i> Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(document).on("change",".doc_status",function () {
            var status = $(this).val();
            var i = $(this).attr('attr-counter');
            if (status == 'rejected') {
                $("#remarks_div_"+i).show();
            //    $("#remarks_"+i).prop('required', true);
            }else{
                $("#remarks_div_"+i).hide();
            //    $("#remarks_"+i).prop('required', false);
                $("#remarks_"+i).val('');
            }
        });
    });
</script>