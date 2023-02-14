<div class="content-pagination-height borderframe">
    <div class="heading-top">
        <h3 class="page-title text-uppercase"> Welcome</h3>
    </div>
    <div class="box-header nav-link nav-toggle" data-original-title>
        <div class="col-md-12">
            <?php
            $success_message = $this->session->flashdata('success_response');
            $failure_message = $this->session->flashdata('failure_response');
            if (isset($success_message) && $success_message != '') {
                echo ' <div style="text-align: center;" class="alert btn-success " role="alert"> 
                                    <strong>' . $success_message . '</strong>
                                    </div>';
            } else if (isset($failure_message) && $failure_message != '') {
                echo ' <div style="text-align: center;" class="alert btn-danger " role="alert"> 
                                    <strong>' . $failure_message . '</strong>
                                    </div>';
            }
            ?>
        </div>
        <div class="col-md-12">
            <h1 style="margin-bottom: 25px; font-size: 45px;" class="text-center">Welcome to Attestation System</h1>
            <?php if ($role_id != 20): ?>
                <p class="text-center">Kindly use left menu to navigate in the system</p>
            <?php else: ?>
                <div class="col-md-5"></div>
                <div class="col-md-1">
                    <a href="<?php echo site_url('vaccination/index') ?>" class="btn btn-success">View list</a>
                </div>
                <div class="col-md-2">
                    <a href="<?php echo site_url('vaccination/add') ?>" class="btn btn-warning">Add Vaccination</a>
                </div>

            <?php endif; ?>
        </div>
    </div>
</div>
