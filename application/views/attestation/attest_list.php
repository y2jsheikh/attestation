<table class="table table-data-new">
    <thead>
    <tr>
        <th> Sr. #</th>
        <!--<th> Application Type</th>-->
        <th> Application No.</th>
        <th> Full Name</th>
        <th> Submit Date </th>
        <th> Status</th>
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

                <div class="modal fade confirm-delete-modal" id="confirm-delete-<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Confirm Cancel</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>

                            <div class="modal-body">
                                <br>You are about to cancel the application, this procedure is irreversible. Do you want to proceed?</p>
                                <p class="debug-url"></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-danger btn-ok">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>

                <tr role="row" class="<?php echo ($class == 'even' ? 'odd' : 'even') ?>">
                    <td> <b><?php echo $i; ?></b> </td>
                    <!--<td> <span class="text-success">Attestation</span> </td>-->
                    <td> <b class="text-success"><?php echo $r['app_number']; ?></b> </td>
                    <td> <?php echo $r['user_name']; ?> </td>
                    <td> <?php echo date('m/d/Y', $r['attest_request_date']); ?> </td>
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
                        <!--
                        <a onClick="return confirm('Are you sure you want to proceed?');"
                           href="<?php // echo site_url('attestation/status_update/' . $r['app_number']) ?>"
                           class="btn btn-info btn-sm"
                           title="Action"
                           id="btn-view"><i class="fa fa-edit"></i></a>
                        -->
                    </td>
                    <td>
                    <?php if ($role_id == 2){ ?>
                        <?php if ($r['status'] == 'pending'){ ?>

                            <?php if (($r['source'] == 'courier' && $r['current_status'] == 'user_submitted') || ($r['source'] == 'self' && ($r['current_status'] == 'user_submitted' || $r['current_status'] == 'courier_received'))){ ?>
                            <a href="<?php echo site_url('attestation/cancel_application/'.$r['id'].'/'.$r['user_id']) ?>"
                               class="btn btn-danger btn-sm"
                               data-href="<?php echo site_url('attestation/cancel_application/'.$r['id'].'/'.$r['user_id']) ?>"
                               data-toggle="modal"
                               data-target="#confirm-delete-<?php echo $i ?>"
                               title="Cancel"
                               id="btn-view"><i class="fa fa-trash"></i></a>
                            <script>
                                $('#confirm-delete-<?php echo $i ?>').on('show.bs.modal', function(e) {
                                    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
                                //    $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
                                });
                            </script>
                            <?php } ?>

                        <a target="_blank"
                           href="<?php echo site_url('attestation/print_form/'.$r['id'].'/'.$r['user_id']) ?>"
                           class="btn btn-info btn-sm"
                           title="Print Form"
                           id="btn-view"><i class="fa fa-print"></i></a>
                        <?php }else{ ?>
                        <a href="<?php echo site_url('report/attest_detail/' . $r['id']) ?>"
                           class="btn btn-info btn-sm"
                           title="Details"
                           id="btn-view"><i class="fa fa-list"></i></a>
                        <?php } ?>
                        <a href="<?php echo site_url('report/application_track/'.$r['id'].'/'.$r['user_id']) ?>"
                           class="btn btn-info btn-sm"
                           title="Track"
                           data-toggle="popover"
                           data-trigger="hover"
                           id="btn-view"><i class="fa fa-send"></i></a>
                    <?php } ?>
                    <?php if ($role_id == 3 || $role_id == 5){ ?>
                        <a href="<?php echo site_url('report/attest_detail/' . $r['id']) ?>"
                           class="btn btn-info btn-sm"
                           title="Details"
                           id="btn-view"><i class="fa fa-list"></i></a>
                    <?php } ?>
                    <?php if ($role_id == 4){ ?>
                        <a href="<?php echo site_url('attestation/status_update/'.$r['app_number']) ?>"
                           class="btn btn-info btn-sm"
                           title="Proceed"
                           id="btn-view"><i class="fa fa-list"></i></a>
                    <?php } ?>
                    </td>
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
