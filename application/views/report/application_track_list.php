<table class="table table-data-new">
    <thead>
    <tr>
        <th> Sr. #</th>
        <th> Application No.</th>
        <th> Application Status</th>

        <th> Submission Source</th>
        <th> Track Application</th>

    <?php /* if (is_array($result) && count($result) > 0) { ?>
        <?php if ($result[0]['source'] == 'courier'){ ?>
        <th> Courier</th>
        <th> Track Shipment</th>
        <?php }elseif ($result[0]['source'] == 'self'){ ?>
        <th>Application Source</th>
        <?php } ?>
    <?php } */ ?>

        <th> Current Stage</th>
        <th> Submit Date </th>
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
                        }else{
                            echo "-";
                        }
                        ?>
                    </td>

                <?php if ($r['source'] == 'courier'){ ?>
                    <td> <?php echo $r['courier_role'] != '' ? $r['courier_role'] : '-'; ?> </td>
                    <td>
                        <?php
                        if ($r['cn_number'] != '') {
                            if ($r['courier_role_id'] == 3) {
                                ?>
                                <a href="https://www.tcsexpress.com/tracking"
                                   target="_blank"><?php echo $r['cn_number'] ?></a>
                                <?php
                            } elseif ($r['courier_role_id'] == 5) {
                                ?>
                                <a href="https://www.mulphilog.com/track-shipment.php"
                                   target="_blank"><?php echo $r['cn_number'] ?></a>
                                <?php
                            } else {
                                echo "-";
                            }
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>
                <?php }elseif ($r['source'] == 'self'){ ?>
                    <td>Self Submission</td>
                    <td>-</td>
                <?php } ?>

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
                        }elseif ($r['current_status'] == 'cancelled'){
                            echo 'Application <span class="text-danger">Cancelled</span> by the User';
                        }else{
                            echo '-';
                        }
                    ?>
                    </td>
                    <td> <?php echo $r['date'] ?> </td>
                </tr>
                <?php
            $i++;
            endforeach;
        else:
            ?>
            <tr>
                <th scope="row" colspan="10">
                    <div style="color:#FFFFFF;text-align: center; background-color: #ff0000;" class="alert alert-danger " role="alert">
                        <strong>NO DATA FOUND</strong></div>
                </th>
            </tr>
        <?php
        endif;
        ?>

    </tbody>
</table>
