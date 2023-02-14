<table class="table table-data-new">
    <thead>
    <tr>
        <th> Sr. #</th>
        <th> Application No.</th>
        <th> Full Name</th>
        <th> Submit Date </th>
        <th> Post-Grad Training</th>
        <th> Status</th>
        <th> <?php echo $role_id == 2 ? 'Ministry' : 'User' ?> Remarks</th>
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
                    <td> <?php echo ucfirst($r['post_grad_training']); ?> </td>
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
                        } elseif ($r['status'] == 'accepted') {
                            echo "<span class='text-success'>Accepted</span>";
                        } elseif ($r['status'] == 'approved') {
                            echo "<span class='text-info'>Approved</span>";
                        } elseif ($r['status'] == 'sent_to_ecfmg') {
                            echo "<span class='text-primary'>Sent To ECFMG</span>";
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>
                    <td><span class="text-info"><?php echo $role_id == 2 ? $r['ministry_comment'] : $r['user_comment'] ?></span></td>
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
                        <?php /* if ($r['application_submitted'] == 'N'){ ?>
                        <a href="<?php echo site_url('statement/statement_of_need_undertaking/'.$r['id']) ?>" title="View Undertaking" class="btn btn-danger btn-sm btn-md btn-xs"><i class="fa fa-list"></i></a>
                        <?php }else{ ?>
                        <!--<button class="btn btn-success btn-sm" title="Saved"><i class="fa fa-check"></i></button>-->
                            <a onClick="return confirm('Are you sure this document has been sent to ECFMG?');" href="<?php echo base_url('statement/sent_to_ecfmg/'.$r['id']) ?>"
                               class="btn btn-info btn-sm"
                               id="btn-view"><i class="fa fa-edit"></i> Sent to ECFMG</a>
                        <?php } */ ?>

                        <?php if ($r['status'] == 'pending'){ ?>
                            <?php if ($r['user_application_submitted'] == 'N'){ ?>
                                <a href="<?php echo site_url('statement/edit_request/'.$r['id']) ?>" title="View Undertaking" class="btn btn-danger btn-sm btn-md btn-xs"><i class="fa fa-edit"></i> Edit</a>
                            <?php }else{ ?>
                                <a href="<?php echo site_url('statement/statement_of_need_undertaking/'.$r['id']) ?>" title="View Undertaking" class="btn btn-danger btn-sm btn-md btn-xs"><i class="fa fa-list"></i></a>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($r['status'] == 'approved'){ ?>
                            <?php if ($role_id == 4){ ?>
                                <a href="<?php echo base_url('statement/doc_view/'.$r['id']) ?>"
                                   class="btn btn-primary btn-sm"
                                   title="Export Word File"
                                   id="btn-view"><i class="fa fa-wordpress"></i></a>
                                <a onClick="return confirm('Are you sure this document has been sent to ECFMG?');" href="<?php echo base_url('statement/sent_to_ecfmg/'.$r['id']) ?>"
                                   class="btn btn-primary btn-sm"
                                   title="Sent to ECFMG"
                                   id="btn-view"><i class="fa fa-edit"></i> To ECFMG</a>
                            <?php }else{ ?>
                                <button type="button"
                                    title="Completed"
                                    class="btn btn-success btn-sm btn-md btn-xs"><i class="fa fa-check"></i> Completed</button>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($r['status'] == 'sent_to_ecfmg'){ ?>
                            <?php if ($r['statement_of_need_file'] != ''){ ?>
                                <?php /* if ($role_id == 4){ ?>
                                <a href="<?php echo base_url('statement/doc_view/'.$r['id']) ?>"
                                   class="btn btn-primary btn-sm"
                                   title="Export Word File"
                                   id="btn-view"><i class="fa fa-wordpress"></i></a>
                                <?php } */ ?>
                                <a href="<?php echo base_url('uploads/statment_of_need/son_letters/'.$r['statement_of_need_file']) ?>"
                                   title="SON Letter"
                                   target="_blank"
                                   class="btn btn-success btn-sm btn-md btn-xs"><i class="fa fa-check"></i> Letter</a>
                            <?php }else{ ?>
                                <?php if ($role_id == 4){ ?>
                                <a onClick="return confirm('Do you want to upload the SON Letter?');"
                                   title="Upload SON Letter"
                                   href="<?php echo base_url('statement/statment_of_need_upload_letter/'.$r['id']) ?>"
                                   class="btn btn-default btn-sm"
                                   id="btn-view"><i class="fa fa-upload"></i></a>
                                <?php }else{ ?>
                                <button type="button"
                                   title="Completed"
                                   class="btn btn-success btn-sm btn-md btn-xs"><i class="fa fa-check"></i> Completed</button>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($role_id == 4){ ?>
                        <a href="<?php echo site_url('statement/statement_of_need_application/'.$r['id']) ?>" title="View Statement of Need" class="btn btn-info btn-sm btn-md btn-xs"><i class="fa fa-paperclip"></i></a>
                        <?php } ?>
                        <a href="<?php echo site_url('statement/statement_of_need_user_fields_print_view/'.$r['id']) ?>" title="View Form" class="btn btn-info btn-sm btn-md btn-xs"><i class="fa fa-file-pdf-o"></i></a>
                    </td>
                </tr>
                <?php
            $i++;
            endforeach;
        else:
            ?>
            <tr>
                <th scope="row" colspan="8">
                    <div style="color:#FFFFFF;text-align: center; background-color: #ff0000;" class="alert alert-danger " role="alert">
                        <strong>NO DATA FOUND</strong></div>
                </th>
            </tr>
        <?php
        endif;
        ?>

    </tbody>
</table>
