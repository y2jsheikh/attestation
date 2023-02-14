<table class="table table-data-new">
    <thead>
    <tr>
        <th> Sr. #</th>
        <th> Name</th>
        <th> Designation</th>
        <th> Department</th>
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
                <tr role="row" class="<?php echo ($class == 'even' ? 'odd' : 'even') ?>">
                    <td> <b><?php echo $i; ?></b> </td>
                    <td> <b class="text-success"><?php echo $r['name']; ?></b> </td>
                    <td> <?php echo $r['designation']; ?> </td>
                    <td> <?php echo $r['department']; ?> </td>
                    <td>
                    <?php
                        if ($r['status'] == 'Y') {
                            echo '<span class="text-success">Active</span>';
                        } else {
                            echo '<span class="text-danger">In-Active</span>';
                        }
                    ?>
                    </td>
                    <td>
                        <a onClick="return confirm('Are you sure you want to update?');" href="<?php echo site_url('signatory/edit/'.$r['id']) ?>" title="Edit" class="btn btn-warning btn-sm btn-md btn-xs"><i class="fa fa-edit"></i></a>
                        <?php if ($role_id == 1){ ?>
                        <a onClick="return confirm('Are you sure you want to delete?');" href="<?php echo site_url('signatory/delete/'.$r['id']) ?>" title="Edit" class="btn btn-danger btn-sm btn-md btn-xs"><i class="fa fa-trash"></i></a>
                        <?php } ?>
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
