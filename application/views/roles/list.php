<table id="example" class="table table-bordered no-more-tables table-striped table-hover no-footer">
    <thead>
    <tr class="btn-primary">
        <th style="width:3%" class="text-center">Sr#</th>
        <th style="width:25%" class="text-center">Role Name</th>
        <th style="width:5%" class="text-center">Status</th>
        <th style="width:10%" class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $count = 1;
    if (is_array($result) && count($result) > 0):
        foreach ($result as $r):
            //pre($r,1);
            ?>
            <tr>
                <td scope="row"><?php echo $count; ?></td>
                <td><?php echo $r->role_name; ?></td>
                <?php
                if ($r->status == 'N') {
                    echo "<td><p  class='btn btn-danger'> <span class='label'> In Active </span></p></td>";
                } elseif ($r->status == 'Y') {
                    echo "<td><p class='btn btn-success'> <span class='label'> Active </span></p></td>";
                }
                ?>
                <td><a class="btn btn-primary" href="<?php echo site_url("Roles/edit/" . $r->id); ?>">
                        <span class="label">Edit</span></a>
                    <?php if ($r->status == 'N') { ?>
                        <a class="btn btn-danger" onClick="return confirm('Are you sure to delete this Role?');"
                           href="<?php echo site_url("Roles/delete/" . $r->id); ?>">
                            <span class="label">Delete</span></a>
                    <?php } ?>
                </td>
            </tr>

            <?php
            $count++;
        endforeach;
    else:
        ?>
        <tr>
            <th scope="row" colspan="7">
                <div style="color:#FFFFFF;text-align: center; background-color: #ff0000;"
                     class="alert alert-danger " role="alert">
                    <strong>NO DATA FOUND</strong></div>
            </th>

        </tr>
    <?php
    endif;
    ?>
    </tbody>
</table>