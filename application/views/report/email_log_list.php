<table class="table table-data-new">
    <thead>
    <tr>
        <th> Sr. #</th>
        <th> Action</th>
        <th> From</th>
        <th> Message</th>
        <th> To</th>
        <th> Status</th>
        <th> Date</th>
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
                    <td>
                        <?php
                        if ($r['send_status'] == "sent") {
                            ?>
                            <button class="btn btn-success btn-sm"><i class="fa fa-check"></i> Email Sent</button>
                            <?php
                        }elseif ($r['send_status'] == "not_sent"){
                            ?>
                            <button class="btn btn-primary btn-sm send-again-btn" id="send_again_<?php echo $i ?>" value="<?php echo $r['id'] ?>"><i class="fa fa-mail-reply-all"></i> Send Again</button>
                            <?php
                        }
                        ?>
                    </td>
                    <td> <b class="text-success"><?php echo $r['from']; ?></b> </td>
                    <td> <?php echo $r['message']; ?> </td>
                    <td> <?php echo $r['to']; ?> </td>
                    <td>
                    <?php
                        if ($r['send_status'] == "sent") {
                            echo "<span class='text-success'>Sent</span>";
                        }elseif ($r['send_status'] == "not_sent"){
                            echo "<span class='text-danger'>Not Sent</span>";
                        }
                    ?>
                    </td>
                    <td> <?php echo $r['datetime']; ?> </td>
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
