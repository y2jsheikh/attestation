<table class="table table-data-new">
    <thead>
    <tr>
        <th> Sr. #</th>
        <th> Application No.</th>
        <th> Full Name</th>
        <th> CNIC</th>
        <th> Contact No.</th>
        <th> Occupation</th>
        <th> Submit Date </th>
        <?php if ($role_id != 3){ ?>
        <th> Status</th>
        <?php } ?>
        <th> Courier (if Selected)</th>
        <th> Current Status</th>
        <th> Action</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $class = 'even';
        $i = 1;
        //pre($result);
        if (is_array($result) && count($result) > 0):
            foreach ($result as $r):
//            pre($r,1);
                ?>
                <tr role="row" class="<?php echo ($class == 'even' ? 'odd' : 'even') ?>">
                    <td> <b><?php echo $i; ?></b> </td>
                    <td> <b class="text-success"><?php echo $r['app_number']; ?></b> </td>
                    <td> <?php echo $r['user_name']; ?> </td>
                    <td> <?php echo $r['cnic']; ?> </td>
                    <td> <?php echo $r['contact_number']; ?> </td>
                    <td> <?php echo $r['occupation']; ?> </td>
                    <td> <?php echo date('m/d/Y', $r['attest_request_date']); ?> </td>
                    <?php if ($role_id != 3){ ?>
                    <td>
                    <?php
                    if ($r['status'] == 'pending'){
                        echo "<span class='text-warning'>Pending</span>";
                    } elseif ($r['status'] == 'attested'){
                        echo "<span class='text-success'>Attested</span>";
                    } elseif ($r['status'] == 'partially_attested'){
                        echo "Partially Attested";
                    } elseif ($r['status'] == 'rejected'){
                        echo "<span class='text-danger'>Rejected</span>";
                    } elseif ($r['status'] == 'cancelled'){
                        echo "<span class='text-danger'>Cancelled</span>";
                    }
                    ?>
                    </td>
                    <?php } ?>
                    <td>
                        <?php
                        if ($r['source'] == 'self') {
                            echo "Self Submission";
                        } elseif ($r['source'] == 'courier') {
                            echo $r['courier_receive_role_name'];
                        }else{
                            echo "-";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($r['current_status'] == 'user_submitted'){
                            echo 'Submitted By the Applicant';
                        }elseif ($r['current_status'] == 'courier_received'){

                            if ($r['source'] == 'self') {
                                echo 'Submitted By the Applicant';
                            }else{
                                echo 'Received By the Courier';
                            }

                        }elseif ($r['current_status'] == 'ministry_received'){
                            echo 'Received By the Ministry';
                        }elseif ($r['current_status'] == 'ministry_dispatched'){
                            echo 'Dispatched By the Ministry';
                        }elseif ($r['current_status'] == 'courier_dispatched'){
                            echo 'Dispatched By the Courier';
                        }else{
                            echo '-';
                        }
                        ?>
                    </td>
                    <td>
                    <?php if ($role_id == 3 && $r['current_status'] == 'courier_dispatched'){ ?>
                        <button title="Dispatched" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                    <?php }else{ ?>
                        <a href="<?php echo site_url('report/attest_detail/' . $r['id']) ?>"
                           class="btn btn-info btn-sm"
                           title="Details"
                           id="btn-view"><i class="fa fa-list"></i></a>
                    <?php } ?>
                    <?php if ($role_id == 1){ ?>
                        <a href="<?php echo site_url('attestation/reset_application/' . $r['id']) ?>"
                           class="btn btn-danger btn-sm"
                           title="Reset"
                           onClick="return confirm('Are you sure you want to reset?');"
                           id="btn-view"><i class="fa fa-life-saver"></i></a>
                    <?php } ?>
                    </td>
                </tr>
                <?php
            $i++;
            endforeach;
        else:
            ?>
            <tr>
                <th scope="row" colspan="11">
                    <div style="color:#FFFFFF;text-align: center; background-color: #ff0000;" class="alert alert-danger " role="alert">
                        <strong>NO DATA FOUND</strong></div>
                </th>
            </tr>
        <?php
        endif;
        ?>

    </tbody>
</table>
