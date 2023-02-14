<table class="table table-data-new">
    <thead>
    <tr>
        <th> Sr. #</th>
        <?php if ($role_id == 1){ ?>
        <th> User</th>
        <?php } ?>
        <th> Country</th>
        <th> Institute</th>
        <th> Position</th>
        <th> Tentative joining date</th>
        <th> Purpose </th>
        <th> Status </th>
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
                    <?php if ($role_id == 1){ ?>
                        <td> <?php echo $r['user_name']; ?></td>
                    <?php } ?>
                    <td> <?php echo $r['country']; ?> </td>
                    <td> <?php echo $r['institute']; ?> </td>
                    <td> <?php echo $r['position']; ?> </td>
                    <td> <?php echo $r['joining_date']; ?> </td>
                    <td> <?php echo $r['purpose']; ?> </td>
                    <td> <?php
                        if ($r['status'] == 'Y') {
                            echo 'Active';
                        } else {
                            echo 'In-Active';
                        }
                        ?></td>
                    <td>
                        <a onClick="return confirm('Are you sure you want to update?');" href="<?php echo base_url('experience/edit_overseas/' . $r['id']) ?>" class="btn btn-info btn-sm"
                           id="btn-view"><i class="fa fa-edit"></i> Edit</a>
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
