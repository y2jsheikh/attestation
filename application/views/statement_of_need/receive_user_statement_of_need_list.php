<table class="table table-data-new">
    <thead>
    <tr>
        <th> Sr. #</th>
        <th> Application No.</th>
        <th> Full Name</th>
        <th> Submit Date </th>
        <th> Status</th>
        <th> Attachments</th>
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
                    <td> <?php echo $r['fullname']; ?> </td>
                    <td> <?php echo date('m/d/Y', $r['created']); ?> </td>
                    <td>
                        <?php
                        /*
                        if ($r['application_submitted'] == 'Y'){
                            echo "<span class='text-success'>Approved</span>";
                        } else {
                            echo "<span class='text-warning'>Pending</span>";
                        }
                        */
                        if ($r['status'] == 'pending'){
                            echo "<span class='text-warning'>Pending</span>";
                        } elseif ($r['status'] == 'approved') {
                            echo "<span class='text-success'>Approved</span>";
                        } elseif ($r['status'] == 'sent_to_ecfmg') {
                            echo "<span class='text-primary'>Sent To ECFMG</span>";
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>
                    <td>
                        <?php if ($r['contract_letter'] != ''){ ?>
                            <a href="<?php echo base_url('uploads/statment_of_need/letters/'.$r['contract_letter']) ?>" target="_blank" title="Letter" class="btn btn-default btn-sm btn-md btn-xs"><i class="fa fa-clipboard"></i></a>
                        <?php } ?>
                        <?php if ($r['ecfmg_certificate'] != ''){ ?>
                            <a href="<?php echo base_url('uploads/statment_of_need/letters/'.$r['ecfmg_certificate']) ?>" target="_blank" title="Certificate" class="btn btn-default btn-sm btn-md btn-xs"><i class="fa fa-list"></i></a>
                        <?php } ?>
                        <?php if ($r['cnic_copy'] != ''){ ?>
                            <a href="<?php echo base_url('uploads/statment_of_need/letters/'.$r['cnic_copy']) ?>" target="_blank" title="Document" class="btn btn-default btn-sm btn-md btn-xs"><i class="fa fa-paperclip"></i></a>
                        <?php } ?>
                        <?php if ($r['other_file'] != ''){ ?>
                            <a href="<?php echo base_url('uploads/statment_of_need/letters/'.$r['other_file']) ?>" target="_blank" title="Other Document" class="btn btn-default btn-sm btn-md btn-xs"><i class="fa fa-folder"></i></a>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="<?php echo site_url('statement/statement_of_need_form/'.$r['id']) ?>" title="View Form" class="btn btn-primary btn-sm btn-md btn-xs"><i class="fa fa-list"></i></a>
                        <a href="<?php echo site_url('statement/statement_of_need_user_fields_print_view/'.$r['id']) ?>" title="View Form" class="btn btn-info btn-sm btn-md btn-xs"><i class="fa fa-file-pdf-o"></i></a>
                    </td>
                </tr>
                <?php
            $i++;
            endforeach;
        else:
            ?>
            <tr>
                <th scope="row" colspan="7">
                    <div style="color:#FFFFFF;text-align: center; background-color: #ff0000;" class="alert alert-danger " role="alert">
                        <strong>NO DATA FOUND</strong></div>
                </th>
            </tr>
        <?php
        endif;
        ?>

    </tbody>
</table>
