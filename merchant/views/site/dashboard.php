<?php
/* @var $this yii\web\View */

use common\models\constants\MixedStatus;
use common\models\constants\UserRole;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $logProvider yii\data\ActiveDataProvider */
/* @var $commentProvider yii\data\ActiveDataProvider */
///* @var $order array */
/* @var $markets \common\models\Market[] */

$this->title = Yii::t('app', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;
$me = Yii::$app->user->identity;

$debts_table_days = [10, 20, 30, 40, 50, 60, -60]
?>
<div class="">
    <!-- Fun Facts Container -->
    <div class="pt-20 pb-20 pl-20 row">
        <div class="col-md-9">
            <h2 class="title-dashboard"><?= Yii::t('app', 'Umumiy') ?> <?= Yii::t('app', 'Leasings') ?> <?= Yii::t('app', 'bo\'yicha') ?> <?= Yii::t('app', 'Dashboard') ?> </h2>
        </div>
    </div>

    <div class="fun-facts-container">
        <div class="fun-fact px-3 py-2" data-fun-fact-color="#36bd78">
            <div class="fun-fact-text d-flex justify-content-start" style="gap: 30px">
                <img src="/images/icon/all_rass.svg">
                <div class="box">
                    <a id="link_count" href="<?= Url::to(['/order/index', 'status' => 5]) ?>">
                        <div class="ftitle" id="active-instalmets" style="color: #38B36E"></div>
                    </a>
                    <span> <?= Yii::t('app', 'Barcha rassrochkalar soni') ?></span>

                </div>
            </div>

        </div>
        <div class="fun-fact px-3 py-2" data-fun-fact-color="#b81b7f">
            <div class="fun-fact-text d-flex justify-content-start" style="gap: 30px">
                <img src="/images/icon/all_rass-Summ.svg">
                <div class="box">
                    <a id="link_sum" href="<?= Url::to(['/order/index', 'status' => 5]) ?>">
                        <div class="ftitle d-flex" style="color:#AD2073;gap: 10px">
                            <div id="total-instalment-sum"></div>
                            uzs
                        </div>
                    </a>
                    <span> <?= Yii::t('app', 'Barcha rassrochkalar summasi') ?></span>
                </div>
            </div>

        </div>
        <div class="fun-fact px-3 py-2" data-fun-fact-color="#36bd78">
            <div class="fun-fact-text d-flex justify-content-start" style="gap: 30px">
                <img src="/images/icon/today_rass-count.svg">
                <div class="box">
                    <a id="link_count_daily"
                       href="<?= Url::to(['/order/index', 'status' => MixedStatus::TODAY_ORDER]) ?>">
                        <div class="ftitle d-flex" id="today-active-instalmets" style="color: #38B36E"></div>
                    </a>
                    <span> <?= Yii::t('app', 'Bugun sotilgan rassrochkalar soni') ?></span>
                </div>
            </div>

        </div>
        <div class="fun-fact px-3 py-2" data-fun-fact-color="#b81b7f">
            <div class="fun-fact-text d-flex justify-content-start" style="gap: 30px">
                <img src="/images/icon/today-rass-sum.svg">
                <div class="box">
                    <a id="link_sum_daily"
                       href="<?= Url::to(['/order/index', 'status' => MixedStatus::TODAY_ORDER]) ?>">
                        <div class="ftitle d-flex" style="color: #AD2073 ; gap: 10px">
                            <div id="today-instalment-sum"></div>
                            uzs
                        </div>
                    </a>
                    <span> <?= Yii::t('app', 'Bugun sotilgan rassrochkalar summasi') ?></span>
                </div>
            </div>

        </div>

        <div class="fun-fact px-3 py-2" data-fun-fact-color="#ff7e10">
            <div class="fun-fact-text d-flex justify-content-start" style="gap: 30px">
                <img src="/images/icon/investor-icon.svg">
                <div class="box">
                    <a id="expense_order" href="<?= Url::to(['/expense/index-dashboard', 'which' => 1]) ?>">
                        <div class="ftitle d-flex" style="color: #FE9758 ;gap: 10px">
                            <div id="expense-order">0</div>
                            uzs
                        </div>
                    </a>
                    <span> <?= Yii::t('app', 'Investorlar o\'rtasidagi xarajat') ?></span>
                </div>
            </div>
        </div>
        <div class="fun-fact px-3 py-2" data-fun-fact-color="#00c5ff">
            <div class="fun-fact-text d-flex justify-content-start" style="gap: 30px">
                <img src="/images/icon/kompany-icon.svg">
                <div class="box">
                    <a id="expense_company" href="<?= Url::to(['/expense/index-dashboard', 'which' => 0]) ?>">
                        <div class="ftitle d-flex" style="color: #17BEFD ;gap: 10px">
                            <div id="expense-company">0</div>
                            uzs
                        </div>
                        <span> <?= Yii::t('app', 'Kompaniya xarajati') ?></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="fun-fact px-3 py-2" data-fun-fact-color="#efa80f">
            <div class="fun-fact-text d-flex justify-content-start" style="gap: 30px">
                <img src="/images/icon/rass-count.svg">
                <div class="box">
                    <a id="link_pros" href="<?= Url::to(['/order/late', 'day' => 0, 'market_id' => null]) ?>">
                        <div class="ftitle d-flex" id="overdue-instalments" style="color: #EB9D22 ; gap: 10px"></div>
                    </a>
                    <span> <?= Yii::t('app', 'Prosrochkadagi rassrochkalar soni') ?></span>
                </div>
            </div>
        </div>
        <div class="fun-fact px-3 py-2" data-fun-fact-color="#2a41e6">
            <div class="fun-fact-text d-flex justify-content-start" style="gap: 30px">
                <img src="/images/icon/rass-sum.svg">
                <div class="box">

                    <a id="link_deb_sum" href="<?= Url::to(['/order/late', 'day' => 0, 'market_id' => null]) ?>">
                        <div class="ftitle d-flex" style="color: #203FDF ;gap: 10px">
                            <div id="total-debt"></div>
                            uzs
                        </div>
                    </a>
                    <span> <?= Yii::t('app', 'Prosrochkadagi rassrochkalar summasi') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row -->
<div class="row">

    <!--        NEW DIAGRAM-->
    <div class="col-md-7 d-none">
        <!-- Dashboard Box -->
        <div class="dashboard-box main-box-in-row">
            <div class="headline">
                <h3><i class="icon-feather-bar-chart-2"></i>New diagram</h3>
            </div>
            <div class="content">
                <!-- Chart -->
                <div class="chart">
                    <canvas id="chartBar" width="100" height="45"></canvas>
                </div>
            </div>
        </div>
        <!-- Dashboard Box / End -->
    </div>

    <div class="col-md-7 mt-40">
        <!-- Dashboard Box -->
        <div class="dashboard-box chart-box main-box-in-row " style=" border-radius: 16px">
            <div class="headline">
                <h3 class="d-flex align-items-center"><img src="/images/icon/graph.svg"
                                                           class="mr-10"><?= Yii::t('app', 'Leasings') ?></h3>
                <div class="sort-by">
                    <select class="selectpicker hide-tick">
                        <option><?= Yii::t('app', 'Last 6 Months') ?></option>
                        <option><?= Yii::t('app', 'This Year') ?></option>
                        <option><?= Yii::t('app', 'This Month') ?></option>
                    </select>
                </div>
            </div>
            <div class="content">
                <!-- Chart -->
                <div class="chart">
                    <canvas id="chart" width="100" height="45"></canvas>
                </div>
            </div>
        </div>
        <!-- Dashboard Box / End -->
    </div>
    <div class="col-md-5 mt-40  ">

        <!-- Dashboard Box -->

        <div class="dashboard-box chart-box" style=" border-radius: 16px">
            <div class="headline">
                <h3><img src="/images/icon/delay.svg"><?= Yii::t('app', ' Просрочки') ?></h3>
            </div>
            <div class="content pl-15 pr-15 pt-30">
                <table id="debt-by-period" class="table table-bordered w-100">
                    <thead>
                    <tr class="delay">
                        <th><?= Yii::t('app', 'Срок') ?></th>
                        <th><?= Yii::t('app', 'Кол-во') ?></th>
                        <th><?= Yii::t('app', 'Сумма долга (сум)') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($debts_table_days as $day) {
                        $row_text = $day < 0
                            ? Yii::t('app', 'Более {day} дней', ['day' => -$day])
                            : Yii::t('app', 'До {day} дней', ['day' => $day]);
                        echo "
                        <tr class=\"link-info late-loader\"
                            onclick=\"location.href = '/order/late?day={$day}'\"
                            style=\"cursor: pointer;\">
                            <td>$row_text</td>
                            <td id=\"debt_{$day}_count\">00</a></td>
                            <td id=\"debt_{$day}_sum\">0.00</td>
                        </tr>";
                    }
                    ?>
                    </tbody>
                </table>

            </div>
            <div class="notification notice mt-20" style="background-color: transparent;!important;">
                <div class="row justify-content-between">
                    <?php if (Yii::$app->user->identity->is_ceo) { ?>
                        <div class="npl-box">
                            <h1>NPL : <strong id="npl" class="some-calc-percent">1 %</strong></h1>
                        </div>
                    <?php } ?>
                    <div class="npl-box">
                        <h1>eNPL : <strong id="enpl">1 %</strong></h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dashboard Box / End -->
    </div>
    <!-- Row / End -->
</div>
<!-- Row -->
<div class="row">

    <!-- Dashboard Box -->
    <div class="col-xl-6">
        <div class="dashboard-box chart-box mt-30 dashboard__box-card">
            <div class="headline">
                <h3 class="d-flex align-items-center"><img src="/images/icon/comment.svg"
                                                           class="mr-3"><?= Yii::t('app', 'Comments') ?></h3>
            </div>
            <div class="content" style="padding: 10px">
                <?= GridView::widget([
                    'pager' => array(
                        'maxButtonCount' => 5
                    ),
                    'dataProvider' => $commentProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'market_id',
                            'value' => function ($model) {
                                /** @var \common\models\OrderComment $model */
                                return $model->order->market->name;
                            },
                        ],
                        [
                            'attribute' => 'order_id',
                            'format' => 'raw',
                            'value' => function ($model) {
                                /** @var \common\models\OrderComment $model */
                                return Html::a($model->order_id, ['/order/view', 'id' => $model->order_id]);
                            },
                        ],
                        'text:ntext',
                        [
                            'attribute' => 'created_at',
                            'value' => function ($model) {
                                return date("Y-m-d H:i:s", $model->created_at);
                            }
                        ]
                    ],
                ]); ?>
            </div>
        </div>
    </div>

    <!-- Dashboard Box -->
    <div class="col-xl-6">
        <div class="dashboard-box chart-box mt-30 dashboard__box-card" >
            <div class="headline">
                <h3><img src="/images/icon/paper.svg"> <?= Yii::t('app', 'Transactions') ?></h3>
            </div>
            <div class="content" style="padding: 10px">
                <?= GridView::widget([
                    'pager' => array(
                        'maxButtonCount' => 5,
                    ),
                    'dataProvider' => $logProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'market_id',
                            'value' => function ($model) {
                                /** @var \common\models\OrderItemAwait $model */
                                return $model->item->market->name;
                            },
                        ],
                        [
                            'attribute' => 'item_id',
                            'value' => function ($model) {
                                /** @var \common\models\OrderItemAwait $model */
                                return $model->item->date;
                            },
                            'label' => Yii::t('app', 'Starts In')

                        ],
                        [
                            'attribute' => 'order_id',
                            'format' => 'raw',
                            'value' => function ($model) {
                                /** @var \common\models\OrderItemAwait $model */
                                return Html::a($model->order_id, ['/order/view', 'id' => $model->order_id]);
                            },
                        ],
                        'text:ntext',
                        'created_at:datetime',
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>
<!-- Row / End -->
<script>

</script>
<script src="/js/chart.min.js"></script>

<?php
$main_url = Yii::$app->params['dashboardUrl'];

$url = $main_url . '/dashboard-info';
$url_debt = $main_url . '/dashboard-debt';
$url_mib = $main_url . '/dashboard-mib';
$url_order = $main_url . '/order-chart';
$today_trans = $main_url . '/today-transaction';
$url_npl = $main_url . '/dashboard-npl';
$debts_table_days_js = json_encode($debts_table_days, JSON_PRETTY_PRINT);

$jwt_auth_key = \common\models\constants\AppConstants::BEARER_AUTH_HEADER_PREFIX;
$jwt_auth_key .= (!\Yii::$app->user->isGuest ? \Yii::$app->jwtService->generateAccessToken(\Yii::$app->user->identity->id) : '');
$js = <<<JS
$.ajaxSetup({
  headers: {
    'Authorization': '$jwt_auth_key'
  }
});

Chart.defaults.global.defaultFontFamily = "Nunito";
Chart.defaults.global.defaultFontColor = '#888';
Chart.defaults.global.defaultFontSize = '14';

var ctx = document.getElementById('chart').getContext('2d');
    
var DashChart = new Chart(ctx, {
    type: 'line',
    // The data for our dataset
    data: {
        labels: [],
        // Information about the dataset
        datasets: [{
            label: " Millionda ",
            backgroundColor: 'rgba(42,65,232,0.08)',
            borderColor: '#2a41e8',
            borderWidth: "3",
            data: [],
            pointRadius: 5,
            pointHoverRadius:5,
            pointHitRadius: 10,
            pointBackgroundColor: "#fff",
            pointHoverBackgroundColor: "#fff",
            pointBorderWidth: "2"
        }, {
            label: " Donada ",
            backgroundColor: 'rgba(0,0,232,0.08)',
            borderColor: '#00ffe8',
            borderWidth: "3",
            data: [],
            pointRadius: 5,
            pointHoverRadius:5,
            pointHitRadius: 10,
            pointBackgroundColor: "#fff",
            pointHoverBackgroundColor: "#fff",
            pointBorderWidth: "2"
        }, {
            label: " Millionda ",
            backgroundColor: 'rgba(42,65,232,0.08)',
            borderColor: '#808080',
            borderWidth: "3",
            data: [],
            pointRadius: 3,
            pointHoverRadius:3,
            pointHitRadius: 5,
            pointBackgroundColor: "#fff",
            pointHoverBackgroundColor: "#fff",
            pointBorderWidth: "1"
        }, {
            label: " Donada ",
            backgroundColor: 'rgba(0,0,232,0.08)',
            borderColor: ' #7F7F7F',
            borderWidth: "3",
            data: [],
            pointRadius: 3,
            pointHoverRadius:3,
            pointHitRadius: 5,
            pointBackgroundColor: "#fff",
            pointHoverBackgroundColor: "#fff",
            pointBorderWidth: "1"
        }]
    },
    // Configuration options
    options: {

        layout: {
          padding: 10
        },
        legend: { display: false },
        title:  { display: false },
        scales: {
            yAxes: [{
                scaleLabel: {
                    display: false
                },
                gridLines: {
                     borderDash: [6, 10],
                     color: "#d8d8d8",
                     lineWidth: 1
                }
            }],
            xAxes: [{
                scaleLabel: { display: false },  
                gridLines:  { display: false }
            }]
        },
        tooltips: {
          backgroundColor: '#333',
          titleFontSize: 13,
          titleFontColor: '#fff',
          bodyFontColor: '#fff',
          bodyFontSize: 13,
          displayColors: false,
          xPadding: 10,
          yPadding: 10,
          intersect: false
        }
    }
});

let cUrl = '$url';
let dUrl = '$url_debt';
let mibUrl = '$url_mib';
let oUrl = '$url_order';
let tTrans = '$today_trans';
let nplUrl = '$url_npl';
let debtsTableDays = $debts_table_days_js;

totalInOne();

function totalInOne(market_id = null) {
    updateData(market_id);
    updateExpenseOrder(market_id);
    updateExpenseCompany(market_id);
    updateDebts(market_id);
    updateDebt(market_id);
    updateDebtMib(market_id);
    updateInvest(market_id);
    updateOrderChart(market_id);
    updateNpl(market_id);

}

function someCalc() {
    let str = document.querySelector('#total-instalment-sum').innerText;
    // console.log(str);
    let index = str.indexOf(' ');
    // console.log(index);
    let maxraj = parseFloat(str.substring(0, index));
    let surat = parseFloat(document.querySelector('#till-total-sum-number').innerText);
    surat /= maxraj * 100000;
    surat = parseInt(surat + "");
    $('.some-calc-percent').text(parseFloat(surat / 100) + " %")

}

function updateNpl(market_id = null) {
    if (isNaN(market_id) || market_id == null)
        market_id = 0;
    $.ajax({
        url: nplUrl,
        data: {market_id: market_id},
        type: 'GET',
        success: function (result) {
            $('#enpl').text(result.enpl + " %");
            $('#npl').text(result.npl + " %");
        }
    });
}

function updateExpenseOrder(market_id = null) {

    $.ajax({
        url: dUrl,
        data: {type: 'expense_order', market_id: market_id},
        type: 'GET',
        success: function (result) {
            $('#expense-order').text(result.expense_order);
        }
    });
}

function updateOrderChart(market_id = null) {

    $.ajax({
        url: oUrl,
        data: {market_id: market_id},
        type: 'GET',
        success: function (result) {
            DashChart.data.labels = result.date;
            DashChart.data.datasets[0].data = result.amount;
            DashChart.data.datasets[1].data = result.count;
            DashChart.data.datasets[2].data = result.total_amount;
            DashChart.data.datasets[3].data = result.total_count;
            DashChart.update();

        }
    });
}

function updateExpenseCompany(market_id = null) {

    $.ajax({
        url: dUrl,
        data: {type: 'expense_company', market_id: market_id},
        type: 'GET',
        success: function (result) {
            $('#expense-company').text(result.expense_company);
        }
    });
}

function updateData(market_id = null) {
    $.ajax({
        url: cUrl, data: {market_id: market_id}, type: 'GET',
        success: function (result) {
            $('#today-active-instalmets').text(result.today_leasing_count);
            $('#today-instalment-sum').text(result.today_leasing_sum);
            $('#active-instalmets').text(result.total_leasing);
            $('#total-instalment-sum').text(result.total_sum);
            $('#overdue-instalments').text(result.absent_total_leasing);
            $('#total-debt').text(result.absent_total_sum);
        }
    });
}

function updateDebts(market_id = null) {
    for (var day of debtsTableDays) {
        (function (currentDay) {
            $.ajax({
                url: dUrl,
                data: {type: currentDay, market_id: market_id},
                type: 'GET',
                success: function (result) {
                    $('#debt_' + currentDay + '_count').text(result.absent_total_leasing_item);
                    let rowSumText = result.absent_total_item_sum;
                    if (result.absent_total_item_saldo_sum) {
                        rowSumText += ' / ' + result.absent_total_item_saldo_sum;
                    }
                    $('#debt_' + currentDay + '_sum').text(rowSumText);
                }
            });
        })(day);
    }
}

function updateDebtMib(market_id = null) {
    $.ajax({
        url: mibUrl,
        data: {market_id: market_id},
        type: 'GET',
        success: function (result) {
            $('#mib-count').text(result.count);
            $('#mib-total-sum').text(result.amount + ' / ' + result.total_sum);
        }
    });
}

function updateInvest(market_id = null) {
    $.ajax({
        url: dUrl,
        data: {type: 're-invest', market_id: market_id},
        type: 'GET',
        success: function (result) {
            $('#total-re-invest').text(result.total_re_invest);
            $('#re-invest').text(result.re_invest);
        }
    });
}

function updateDebt(market_id = null) {
    $.ajax({
        url: dUrl,
        data: {market_id: market_id},
        type: 'GET',
        success: function (result) {
            $('#till-total').text(result.absent_total_leasing_item);
            $('#till-total-sum').text(ReplaceNumberWithCommas(result.absent_total_item_sum));
            $('#till-total-sum-number').text(result.absent_total_item_sum);
        }
    });
}

function updateTodayTransaction(market_id = null) {
    console.log(market_id);
    $.ajax({
        url: tTrans,
        data: {market_id: market_id},
        type: 'GET',
        success: function (result) {
            $('#cash_count').text(result.cash_count);
            $('#cash_amount').text(ReplaceNumberWithCommas(result.cash_amount));
            $('#unired_count').text(result.unired_count);
            $('#unired_amount').text(ReplaceNumberWithCommas(result.unired_amount));
            $('#paymo_count').text(result.paymo_count);
            $('#paymo_amount').text(ReplaceNumberWithCommas(result.paymo_amount));
            $('#total_count').text(result.totak_count);
            $('#total_amount').text(ReplaceNumberWithCommas(result.total_amount));
        }
    });
}

function updateLocationUrl(row, marketId) {
    try {
        let oldUrl = row.getAttribute("onclick");
        if (oldUrl.startsWith("location.href")) {
            oldUrl = oldUrl.replace("location.href = ", "").replace("location.href=", "").replaceAll("'", "").replaceAll('"', "");
            const newUrl = buildUrl(oldUrl, {market_id: marketId});
            row.setAttribute('onclick', 'location.href=\'' + newUrl + '\'');
        }
    } catch (e) {
        console.error(e);
    }
}

$('.market-selection').on("change", function (e) {
    let marketId = $('.market-selection').val();
    totalInOne(marketId);
    if (marketId === 0) {
        marketId = null;
    }
    const rows = document.querySelectorAll('.link-info');
    rows.forEach(row => updateLocationUrl(row, marketId));
});

$(document).ready(function () {
    $("a#link_pros").click(function (e) {
        e.preventDefault();
        let href_new = $(this).attr("href");
        let market_id = $('.market-selection').val();
        if (market_id !== '0' && market_id != null) href_new = href_new + "&market_id=" + market_id;
        window.location = href_new;
        return false;
    });
});

$(document).ready(function () {
    $("a#link_count").click(function (e) {
        e.preventDefault();
        let href_new = $(this).attr("href");
        let market_id = $('.market-selection').val();
        if (market_id !== '0' && market_id != null) href_new = href_new + "&market_id=" + market_id;
        window.location = href_new;
        return false;
    });
});

$(document).ready(function () {
    $("a#link_sum").click(function (e) {
        e.preventDefault();
        let href_new = $(this).attr("href");
        let market_id = $('.market-selection').val();
        if (market_id !== '0' && market_id != null) href_new = href_new + "&market_id=" + market_id;
        window.location = href_new;
        return false;
    });
});

$(document).ready(function () {
    $("a#link_deb_sum").click(function (e) {
        e.preventDefault();
        let href_new = $(this).attr("href");
        let market_id = $('.market-selection').val();
        if (market_id !== '0' && market_id != null) href_new = href_new + "&market_id=" + market_id;
        window.location = href_new;
        return false;
    });
});

function ReplaceNumberWithCommas(yourNumber) {
    var n = yourNumber.toString().split(".");
    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    return n.join(".");

}
JS;
$this->registerJs($js);
?>

