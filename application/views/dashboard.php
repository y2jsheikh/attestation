<style>
    .no-of-transdashboard > small, .no-of-transdashboard > a > small{
        font-weight: bold;
    }
    .no-of-transdashboard > a{
        text-decoration: none !important;
    }
    div.no-of-transdashboard {
        /* line-height: 120%; */
    }
    .text-warning{
        color: #ff9406 !important;
    }
</style>
<div class="row" style="margin-top: -2%;" id="dashboard_print">
    <div class="col-md-3 col-sm-12">
        <div class="dashboard-dashboardboxes-main">
            <div class="dashboard-dashboardboxes dashboard-dashboardboxes-transparent">
                <div class="no-of-transdashboard">System Usage</div>
                <?php $total_courier = $total_tcs_application_count + $total_mnp_application_count ?>
                <div class="no-of-transdashboard"><small class="text-success">Total Profiles : <?php echo $users_count ?></small></div>
                <div class="no-of-transdashboard"><small class="text-primary">Courier Selected : <?php echo $total_courier ?></small></div>
                <div class="no-of-transdashboard"><small class="text-info"> &nbsp; &nbsp; TCS : <?php echo $total_tcs_application_count ?></small></div>
                <div class="no-of-transdashboard"><small class="text-info"> &nbsp; &nbsp; M&P : <?php echo $total_mnp_application_count ?></small></div>
                <div class="no-of-transdashboard"><small class="text-primary">In Person : <?php echo $total_self_application_count ?></small></div>
            </div>
        </div>
        <div class="dashboard-dashboardboxes-main">
            <div class="dashboard-dashboardboxes dashboard-dashboardboxes-transparent">
                <div class="no-of-transdashboard">Attestation Wing</div>
                <?php $courier_not_submitted_application_count = $tcs_not_submitted_application_count + $mnp_not_submitted_application_count; ?>
                <?php $not_received_count = $tcs_application_count + $mnp_application_count + $self_application_count + $courier_not_submitted_application_count; ?>
                <div class="no-of-transdashboard"><a href="<?php echo site_url('report') ?>"><small class="text-primary">Total : <?php echo $total_application_count - $not_received_count ?></small></a></div>
                <div class="no-of-transdashboard"><a href="<?php echo site_url('report/processed') ?>"><small class="text-success"> &nbsp; &nbsp; Processed : <?php echo $in_process_application_count ?></small></a></div>
                <div class="no-of-transdashboard"><small class="text-warning"> &nbsp; &nbsp; Pending : <?php echo $pending_application_count ?></small></div>
            </div>
        </div>


        <!--
        <div class="text-center">
            <br/>
            <span><b><?php // echo date('D, d M Y H:i:s') ?></b></span>
        </div>
        -->
    </div>
    <div class="col-md-6 col-sm-12">
        <figure style="margin-top: -2.3%; padding-bottom: 2%;">
            <div class="filter-main" style="padding-bottom: 10%;">
                <!--<div id="total_counts"></div>-->
                <div id="user_by_occupation_graph"></div>
            </div>
        </figure>
    </div>
    <div class="col-md-3 col-sm-12">
        <?php /*
        <div class="dashboard-dashboardboxes-main">
            <div class="dashboard-dashboardboxes dashboard-dashboardboxes-transparent">
                <div class="no-of-transdashboard">TCS : <span class="text-warning"><?php echo $tcs_received_until_returned_count + $tcs_returned_application_count ?></span></div>
                <div class="no-of-transdashboard"><small class="text-info">Received : <?php echo $tcs_received_until_returned_count ?></small></div>
                <div class="no-of-transdashboard"><small class="text-primary">To be Collected<br/>(From Ministry) : <?php echo $tcs_to_be_collected_application_count ?></small></div>
                <div class="no-of-transdashboard"><small class="text-success">Returned : <?php echo $tcs_returned_application_count ?></small></div>
            </div>
        </div>
        <div class="dashboard-dashboardboxes-main">
            <div class="dashboard-dashboardboxes dashboard-dashboardboxes-transparent">
                <div class="no-of-transdashboard">M&P : <span class="text-warning"><?php echo $mnp_received_until_returned_count + $mnp_returned_application_count ?></span></div>
                <div class="no-of-transdashboard"><small class="text-info">Received : <?php echo $mnp_received_until_returned_count ?></small></div>
                <div class="no-of-transdashboard"><small class="text-primary">To be Collected<br/>(From Ministry) : <?php echo $mnp_to_be_collected_application_count ?></small></div>
                <div class="no-of-transdashboard"><small class="text-success">Returned : <?php echo $mnp_returned_application_count ?></small></div>
            </div>
        </div>
        */ ?>
        <div class="dashboard-dashboardboxes-main">
            <div class="dashboard-dashboardboxes dashboard-dashboardboxes-transparent" style="padding-bottom: 13.5%;">
                <div class="no-of-transdashboard">No. of Documents</div>
                <div class="no-of-transdashboard"><small class="text-success">Attested : <?php echo $attested_document_count ?></small></div>
                <div class="no-of-transdashboard"><small class="text-danger">Rejected : <?php echo $rejected_document_count ?></small></div>
                <div class="no-of-transdashboard"><small class="text-warning">In Process : <?php echo $pending_document_count ?></small></div>
            </div>
        </div>
        <div class="dashboard-dashboardboxes-main">
            <div class="dashboard-dashboardboxes dashboard-dashboardboxes-transparent">
                <div class="no-of-transdashboard"><small class="text-warning"> &nbsp; &nbsp; No Show - In Person : <?php echo $self_application_count ?></small></div>
            </div>
        </div>

        <div class="dashboard-dashboardboxes-main">
            <div class="dashboard-dashboardboxes dashboard-dashboardboxes-transparent">
                <div class="no-of-transdashboard"><small> &nbsp; &nbsp; <?php echo date('D, d M Y H:i:s') ?></small></div>
            </div>
        </div>
    </div>

    <!--
    <div class="col-md-12 col-sm-12">
        <div class="filter-main">
            <div id="user_by_occupation_graph"></div>
        </div>
    </div>
    -->

</div>

<script src="<?php echo base_url('assets/js/jquery.print.js'); ?>"></script>
<script>
    $(document).ready(function () {
        $('#print_dashboard_btn').on('click', function () {
            $.print("#dashboard_print");
        });
    });
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    /*
    Highcharts.chart('user_by_occupation_graphs', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                ''
            ],
            crosshair: true
        },
        credits: {
            enabled: false
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Count'
            }
        },

        colors: [
            '#191313',
            '#aa8ef2',
            '#99663d',
            '#749939',
            '#419299'
        ],

        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [<php echo $occupation_users_data ?>]
    });
    */

    $(function () {
        $('#user_by_occupation_graph').highcharts({
            chart: {
                type: 'column',
                backgroundColor: null,
                style: {
                    fontFamily: 'helvetica, arial'
                }
            },
            credits: false,
            title: {
                text: 'Registered Applicants',
                align: 'center',
                y:4,
                x:0
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                title: {
                    text: ""
                },
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '11px',
                        fontFamily: 'helvetica, arial, Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                type:'logarithmic',
                title: {
                    text: 'Total Count'
                }
            },
            colors: [
                '#2f7ed8',
                '#0d233a',
                '#8bbc21',
                '#910000',
                '#1aadce',
                '#492970',
                '#f28f43',
                '#77a1e5',
                '#c42525',
                '#a6c96a'
            ],
            legend: {
                enabled: false
            },
            tooltip: {
                enabled: false
            },
            series: [{
                name: 'IPS',
                data: [<?php echo $occupation_users_data ?>],
                dataLabels: {
                    enabled: true,
                    rotation: 0,
                    color: '#000000',
                    align: 'center',
                    y: 0, // 10 pixels down from the top
                    style: {
                        fontSize: '14px',
                        fontFamily: 'helvetica, arial, sans-serif',
                        textShadow: false,
                        fontWeight: 'bold'
                    }
                }
            }]
        });

    });

    Highcharts.chart('total_counts', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Total Counts'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.f}</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>:<br>value: {point.y}'
                }
            }
        },
        series: [{
            name: 'Count',
            colorByPoint: true,
            data: [{
                name: 'Processed',
                y: <?php echo $in_process_application_count > 0 ? $in_process_application_count : 0; ?>
            }, {
                name: 'Pending',
                y: <?php echo $pending_application_count > 0 ? $pending_application_count : 0; ?>
            }, {
                name: 'Not Received',
                y: <?php echo $not_received_count > 0 ? $not_received_count : 0; ?>
            }, {
                name: 'Total TCS Applications',
                y: <?php echo $total_tcs_application_count > 0 ? $total_tcs_application_count : 0; ?>
            }, {
                name: 'Total M&P Applications',
                y: <?php echo $total_mnp_application_count > 0 ? $total_mnp_application_count : 0; ?>
            }, {
                name: 'Total Self Applications',
                y: <?php echo $total_self_application_count > 0 ? $total_self_application_count : 0; ?>
            }, {
                name: 'TCS Received Application',
                y: <?php echo $tcs_application_count > 0 ? $tcs_application_count : 0; ?>
            }, {
                name: 'TCS Returned Application',
                y: <?php echo $tcs_returned_application_count > 0 ? $tcs_returned_application_count : 0; ?>
            }, {
                name: 'TCS Received Application',
                y: <?php echo $mnp_application_count > 0 ? $mnp_application_count : 0; ?>
            }, {
                name: 'TCS Returned Application',
                y: <?php echo $mnp_returned_application_count > 0 ? $mnp_returned_application_count : 0; ?>
            }]
        }]
    });

</script>













