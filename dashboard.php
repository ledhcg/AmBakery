<?php

$proceeds = 0;

$sql_product = "SELECT * FROM tbl_product";
$query_product = mysqli_query($connect, $sql_product);
$rows_product = mysqli_num_rows($query_product);

$sql_customer = "SELECT * FROM tbl_customer";
$query_customer = mysqli_query($connect, $sql_customer);
$rows_customer = mysqli_num_rows($query_customer);

$sql_order = "SELECT * FROM tbl_order";
$query_order = mysqli_query($connect, $sql_order);
$rows_order = mysqli_num_rows($query_order);
if ($rows_order > 0) {
    while ($row_array_order = mysqli_fetch_array($query_order)) {
        $proceeds += $row_array_order["order_total"];
    }
}

//Select data follơw day
$table_order_today = '';
$sql_order_today = "SELECT * FROM tbl_order WHERE created_at >= CURDATE() AND created_at < CURDATE() + INTERVAL 1 DAY";
$query_order_today = mysqli_query($connect, $sql_order_today);
$rows_order_today = mysqli_num_rows($query_order_today);
if ($rows_order_today > 0) {
    while ($row_order_today = mysqli_fetch_array($query_order_today)) {
        $table_order_today .= '
            <tr>
                <td>' . $row_order_today["order_id"] . '</td>
                <td>' . $row_order_today["order_total"] . '</td>
                <td>' . $row_order_today["order_discount"] . '</td>
                <td>' . $row_order_today["order_received"] . '</td>
                <td>' . $row_order_today["order_debit"] . '</td>
            </tr>
            ';
    }

}

// $sql = "SELECT * FROM table WHERE time >=  $fisrt_day_of_year AND time < $fisrt_day_of_year + INTERVAL 1 YEAR";
$const_order_kpi = 100;
$const_production_kpi = 200;
$order_this_month = 0;
$production_this_month = 0;

$fisrt_day_of_month = date('Y-m-01') . ' 00:00:00';
$total_this_month = 0;

$sql_this_month = "SELECT * FROM tbl_order WHERE created_at >=  '$fisrt_day_of_month' AND created_at < '$fisrt_day_of_month' + INTERVAL 1 MONTH";
$query_this_month = mysqli_query($connect, $sql_this_month);
$rows_this_month = mysqli_num_rows($query_this_month);
if ($rows_this_month > 0) {
    while ($row_this_month = mysqli_fetch_array($query_this_month)) {
        $total_this_month += $row_this_month["order_total"];
        $order_this_month += 1;
    }
}

$sql_production_this_month = "SELECT * FROM tbl_inventory_production WHERE created_at >=  '$fisrt_day_of_month' AND created_at < '$fisrt_day_of_month' + INTERVAL 1 MONTH";
$query_production_this_month = mysqli_query($connect, $sql_production_this_month);
$rows_production_this_month = mysqli_num_rows($query_production_this_month);
if ($rows_production_this_month > 0) {
    while ($row_production_this_month = mysqli_fetch_array($query_production_this_month)) {
        $production_this_month += $row_production_this_month["quantity_updated"];
    }
}

$order_kpi = number_format($order_this_month / $const_order_kpi * 100, 2);
$production_kpi = number_format($production_this_month / $const_production_kpi * 100, 2);

$total_last_month = 0;
$sql_last_month = "SELECT * FROM tbl_order WHERE created_at >=  '$fisrt_day_of_month' - INTERVAL 1 MONTH AND created_at < '$fisrt_day_of_month'";
$query_last_month = mysqli_query($connect, $sql_last_month);
$rows_last_month = mysqli_num_rows($query_last_month);
if ($rows_last_month > 0) {
    while ($row_last_month = mysqli_fetch_array($query_last_month)) {
        $total_last_month += $row_last_month["order_total"];
    }
}

$name_current_day = date('d/m');
$name_last_day = date('d/m', strtotime('-1 day'));
$name_day3 = date('d/m', strtotime('-2 day'));
$name_day4 = date('d/m', strtotime('-3 day'));
$name_day5 = date('d/m', strtotime('-4 day'));
$name_day6 = date('d/m', strtotime('-5 day'));
$name_day7 = date('d/m', strtotime('-6 day'));

$total_current_day = 0;
$sql_total_current_day = "SELECT * FROM tbl_order WHERE created_at >= CURDATE() AND created_at < CURDATE() + INTERVAL 1 DAY";
$query_total_current_day = mysqli_query($connect, $sql_total_current_day);
$rows_total_current_day = mysqli_num_rows($query_total_current_day);
if ($rows_total_current_day > 0) {
    while ($row_total_current_day = mysqli_fetch_array($query_total_current_day)) {
        $total_current_day += $row_total_current_day["order_total"];
    }
}

$total_last_day = 0;
$sql_total_last_day = "SELECT * FROM tbl_order WHERE created_at >= CURDATE() - INTERVAL 1 DAY AND created_at < CURDATE()";
$query_total_last_day = mysqli_query($connect, $sql_total_last_day);
$rows_total_last_day = mysqli_num_rows($query_total_last_day);
if ($rows_total_last_day > 0) {
    while ($row_total_last_day = mysqli_fetch_array($query_total_last_day)) {
        $total_last_day += $row_total_last_day["order_total"];
    }
}

$total_day3 = 0;
$sql_total_day3 = "SELECT * FROM tbl_order WHERE created_at >= CURDATE() - INTERVAL 2 DAY AND created_at < CURDATE() - INTERVAL 1 DAY";
$query_total_day3 = mysqli_query($connect, $sql_total_day3);
$rows_total_day3 = mysqli_num_rows($query_total_day3);
if ($rows_total_day3 > 0) {
    while ($row_total_day3 = mysqli_fetch_array($query_total_day3)) {
        $total_day3 += $row_total_day3["order_total"];
    }
}

$total_day4 = 0;
$sql_total_day4 = "SELECT * FROM tbl_order WHERE created_at >= CURDATE() - INTERVAL 3 DAY AND created_at < CURDATE() - INTERVAL 2 DAY";
$query_total_day4 = mysqli_query($connect, $sql_total_day4);
$rows_total_day4 = mysqli_num_rows($query_total_day4);
if ($rows_total_day4 > 0) {
    while ($row_total_day4 = mysqli_fetch_array($query_total_day4)) {
        $total_day4 += $row_total_day4["order_total"];
    }
}

$total_day5 = 0;
$sql_total_day5 = "SELECT * FROM tbl_order WHERE created_at >= CURDATE() - INTERVAL 4 DAY AND created_at < CURDATE() - INTERVAL 3 DAY";
$query_total_day5 = mysqli_query($connect, $sql_total_day5);
$rows_total_day5 = mysqli_num_rows($query_total_day5);
if ($rows_total_day5 > 0) {
    while ($row_total_day5 = mysqli_fetch_array($query_total_day5)) {
        $total_day5 += $row_total_day5["order_total"];
    }
}

$total_day6 = 0;
$sql_total_day6 = "SELECT * FROM tbl_order WHERE created_at >= CURDATE() - INTERVAL 5 DAY AND created_at < CURDATE() - INTERVAL 4 DAY";
$query_total_day6 = mysqli_query($connect, $sql_total_day6);
$rows_total_day6 = mysqli_num_rows($query_total_day6);
if ($rows_total_day6 > 0) {
    while ($row_total_day6 = mysqli_fetch_array($query_total_day6)) {
        $total_day6 += $row_total_day6["order_total"];
    }
}

$total_day7 = 0;
$sql_total_day7 = "SELECT * FROM tbl_order WHERE created_at >= CURDATE() - INTERVAL 6 DAY AND created_at < CURDATE() - INTERVAL 5 DAY";
$query_total_day7 = mysqli_query($connect, $sql_total_day7);
$rows_total_day7 = mysqli_num_rows($query_total_day7);
if ($rows_total_day7 > 0) {
    while ($row_total_day7 = mysqli_fetch_array($query_total_day7)) {
        $total_day7 += $row_total_day7["order_total"];
    }
}

if ($total_last_day) {
    $total_difference = number_format(($total_current_day / $total_last_day * 100) - 100, 2);
} else {
    $total_difference = 100;
}
if ($total_difference >= 0) {
    $text_difference = '<p class="text-xs"><span class="text-green"><i data-feather="bar-chart" width="15"></i> +' . $total_difference . '%</span> than last day</p>';
} else {
    $text_difference = '<p class="text-xs"><span class="text-green"><i data-feather="bar-chart" width="15"></i> ' . $total_difference . '%</span> than last day</p>';
}

$chart_info = '
        <h1 class="mt-5">$' . $total_current_day . '</h1>
        ' . $text_difference . '
        <div class="legends">
            <div class="legend d-flex flex-row align-items-center">
                <div class="w-3 h-3 rounded-full bg-info mr-2"></div><span class="text-xs">Last Day</span>
            </div>
            <div class="legend d-flex flex-row align-items-center">
                <div class="w-3 h-3 rounded-full bg-blue mr-2"></div><span class="text-xs">Current Day</span>
            </div>
        </div>
';

?>

<div class="page-title">
        <h3>Dashboard</h3>
        <p class="text-subtitle text-muted">Have a good day! Today: <?php echo date('d-m-Y') ?></p>
    </div>
    <section class="section">
        <div class="row mb-2">
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>PRODUCTS</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p><?php echo $rows_product ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>CUSTOMERS</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p><?php echo $rows_customer ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>ORDERS</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p><?php echo $rows_order ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>EARNINGS</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p>$ <?php echo $proceeds ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class='card-heading p-1 pl-3'>CHART</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="pl-3" id="chart-info">
                                <?php echo $chart_info; ?>
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <canvas id="bar"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Orders Today</h4>
                        <div class="d-flex">
                            <a href="admin.php?page_layout=all_orders"> ALL ORDERS <i data-feather="chevrons-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="table-responsive">
                            <table class='table mb-0' id="table1">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Total</th>
                                        <th>Discount</th>
                                        <th>Received</th>
                                        <th>Debit</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
echo $table_order_today;
?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card ">
                    <div class="card-header">
                        <h4>KPI OF MONTH</h4>
                    </div>
                    <div class="card-body">
                        <div id="radialBars"></div>
                        <div class="text-center mb-5">
                            <h6>From last month</h6>
                            <h1 class='text-green'>+$<?php echo $total_last_month; ?> </h1>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <script src="assets/js/pages/dashboard.js"></script>
    <script>

    var ctxBar = document.getElementById("bar").getContext("2d");
        var myBar = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: [
                "<?php echo $name_day7; ?>",
                "<?php echo $name_day6; ?>",
                "<?php echo $name_day5; ?>",
                "<?php echo $name_day4; ?>",
                "<?php echo $name_day3; ?>",
                "<?php echo $name_last_day; ?>",
                "<?php echo $name_current_day; ?>"],
            datasets: [{
            label: 'TOTAL',
            backgroundColor: [chartColors.grey, chartColors.grey, chartColors.grey, chartColors.grey, chartColors.grey, chartColors.info, chartColors.blue],
            data: [
                <?php echo $total_day7; ?>,
                <?php echo $total_day6; ?>,
                <?php echo $total_day5; ?>,
                <?php echo $total_day4; ?>,
                <?php echo $total_day3; ?>,
                <?php echo $total_last_day; ?>,
                <?php echo $total_current_day; ?>,
            ]
            }]
        },
        options: {
            responsive: true,
            barRoundness: 1,
            title: {
            display: false,
            text: "AmBakery Chart"
            },
            legend: {
            display:false
            },
            scales: {
            yAxes: [{
                ticks: {
                beginAtZero: true,
                suggestedMax: 40 + 20,
                padding: 10,
                },
                gridLines: {
                drawBorder: false,
                }
            }],
            xAxes: [{
                    gridLines: {
                        display:false,
                        drawBorder: false
                    }
                }]
            }
        }
        });


        var radialBarsOptions = {
        series: [
            <?php echo $order_kpi; ?>,
            <?php echo $production_kpi; ?>
            ],
        chart: {
            height: 350,
            type: "radialBar",
        },
        theme: {
            mode: "light",
            palette: "palette1",
            monochrome: {
            enabled: true,
            color: "#3245D1",
            shadeTo: "light",
            shadeIntensity: 0.65,
            },
        },
        plotOptions: {
            radialBar: {
            dataLabels: {
                name: {
                offsetY: -15,
                fontSize: "22px",
                },
                value: {
                fontSize: "2.5rem",
                },
                total: {
                show: true,
                label: "Earnings",
                color: "#25A6F1",
                fontSize: "16px",
                formatter: function(w) {
                    return "$<?php echo $total_this_month; ?>";
                },
                },
            },
            },
        },
        labels: ["Production", "Orders"],
        };
        var radialBars = new ApexCharts(document.querySelector("#radialBars"), radialBarsOptions);
radialBars.render();
    </script>

