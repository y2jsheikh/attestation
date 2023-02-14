<table class="table table-data-new">
    <thead>
    <tr>
        <th> Sr. #</th>
        <th> Name</th>
        <th> Username</th>
        <th> CNIC</th>
        <th> Gender</th>
        <th> Contact</th>
        <th> Email</th>
        <?php if ($role_id == 1){ ?>
        <th> Status </th>
        <?php } ?>
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
                    <td> <?php echo $r['fullname']; ?> </td>
                    <td> <?php echo $r['username']; ?> </td>
                    <td> <?php echo $r['cnic']; ?> </td>
                    <td> <?php echo $r['gender']; ?> </td>
                    <td> <?php echo $r['contact_number']; ?> </td>
                    <td> <?php echo $r['email']; ?> </td>
                    <?php if ($role_id == 1){ ?>
                    <td> <?php
                        if ($r['status'] == 'Y') {
                            echo 'Active';
                        } else {
                            echo 'In-Active';
                        }
                        ?>
                    </td>
                    <?php } ?>
                    <td>
                        <?php if ($role_id == 1){ ?>
                        <a onClick="return confirm('Are you sure you want to update?');" href="<?php echo base_url('user/edit/' . $r['id']) ?>" class="btn btn-info btn-sm" title="Edit User"
                           id="btn-view"><i class="fa fa-edit"></i> Edit</a>
                        <a onClick="return confirm('Are you sure you want to delete?');" href="<?php echo base_url('user/delete/' . $r['id']) ?>" class="btn btn-danger btn-sm" title="Delete User"
                           id="btn-view"><i class="fa fa-trash"></i> Delete</a>
                        <?php } ?>
                        <a onClick="return confirm('Are you sure you want to reset password?');" href="<?php echo base_url('user/reset_user_password/' . $r['id']) ?>" class="btn btn-warning btn-sm" title="Password Reset"
                           id="btn-view"><i class="fa fa-user-secret"></i> Password</a>
                        <?php /* if ($role_id == 4){ ?>
                            <button type="button"
                                    class="btn btn-primary btn-sm"
                                    data-toggle="modal"
                                    data-target="#timeSlotModal_<?php echo $i ?>">
                                <i class="fa fa-edit"></i> Assign Time Slot
                            </button>
                            <!-- The Time Slot Modal -->
                            <div class="modal fade" id="timeSlotModal_<?php echo $i ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Select Time Slot</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <?php echo $timeslot_select ?>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button"
                                                    class="btn btn-danger"
                                                    data-dismiss="modal"><i class="fa fa-trash"></i> Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php } */ ?>
                    </td>
                </tr>
                <?php
            $i++;
            endforeach;
        else:
            ?>
            <tr>
                <th scope="row" colspan="9">
                    <div style="color:#FFFFFF;text-align: center; background-color: #ff0000;" class="alert alert-danger " role="alert">
                        <strong>NO DATA FOUND</strong></div>
                </th>

            </tr>
        <?php
        endif;
        ?>

    </tbody>
</table>
