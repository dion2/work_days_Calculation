<?
if ($_POST) {
    $start_day = $_POST['start_day'];
    $work_days = $_POST['work_days'];
    $start_day = str_replace("-", "", $start_day);
} else if ($_GET) {
    $start_day = $_GET['start_day'];
    $work_days = $_GET['work_days'];
    $start_day = str_replace("-", "", $start_day);
} else {
    $start_day = "";
    $work_days = "";
    $start_day = str_replace("-", "", $start_day);
}
if (!filter_var($start_day, FILTER_SANITIZE_STRING)) {
    $start_day = "";
}
if (!filter_var($work_days, FILTER_SANITIZE_STRING)) {
    $work_days = "";
}
// 取回當天星期幾
function get_weekday($datetime)
{
    $week_day = date('w', strtotime($datetime));
    return $week_day;
}
// 算出最後工作天的日期
function get_endless_workday($work_days, $start_day)
{
    $end_day = date("Ymd", strtotime($start_day));
    // 當天是否算一天 是：1 否：0
    $day_count = 1;
    while ($day_count < $work_days) {
        $end_day = date("Ymd", strtotime("+1day", strtotime($end_day)));
        while (get_weekday($end_day) == 0 || get_weekday($end_day) == 6) {
            $end_day = date("Ymd", strtotime("+1day", strtotime($end_day)));
        }
        $day_count++;
    }
    return $end_day;
}

$end_day = get_endless_workday(5, $start_day);

?>
<html>

<head>
    <title>最後工作天日期計算</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <form action="work_days_Calculation.php" method="POST">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align:center">
                            最後工作天日期計算
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            工作天數：
                        </td>
                        <td>
                            <input type="number" name="work_days" id="work_days" value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            開始日期：
                        </td>
                        <td>
                            <input type="date" name="start_day" id="start_day" value="">
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Calculation" class="btn btn-primary">
                        </td>
                    </tr>
                </tfoot>
            </table>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align:center">
                            計算結果
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            開始日期：
                        </td>
                        <td>
                            <p>
                                <?= $start_day ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            指定工作天：
                        </td>
                        <td>
                            <p>
                                <?= $work_days ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            最後工作日日期：
                        </td>
                        <td>
                            <p>
                                <?= $end_day ?>
                            </p>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            此計算規範：周六、周日兩天不列入工作日計算
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>

</body>

</html>