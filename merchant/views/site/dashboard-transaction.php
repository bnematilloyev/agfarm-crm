<?php

use common\helpers\Utilities;
use common\models\constants\UserRole;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
use yii\web\View;

/* @var $start_time string */
/* @var $end_time string */
/* @var $markets \common\models\Market[] */
$user = Yii::$app->user->identity;
$this->title = Yii::t('app', "Analitika");
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="headline">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="col-md-7">
                <h2 class="title-dashboard"><?= $this->title ?></h2>
            </div>
            <div class="col-md-3 pt-3">
                <form action="">
                    <?= DateRangePicker::widget([
                        'name' => 'date_range',
                        'value' => date('d.m.Y', $start_time) . '—' . date('d.m.Y', $end_time),
                        'convertFormat' => true,
                        'useWithAddon' => false,
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'd.m.Y',
                                'separator' => '—',
                            ],
                            'opens' => 'left'
                        ],
                        'options' => [
                            'autocomplete' => 'off',
                            'class' => 'form-control monthCal',
                            'id' => 'date_range'
                        ]
                    ]) ?>
                </form>
            </div>
            <?php if (Yii::$app->user->identity->role > UserRole::ROLE_SALER) { ?>
                <div class="col-md-2">
                    <select id="markets" name="market_id" class="form-control market-selection mt-5"
                            onclick="updateMarket()">
                        <option value="0"><?= Yii::t('app', 'Barcha viloyatlar') ?></option>
                        <?php foreach ($markets as $market) : ?>
                            <option value="<?= $market->id ?>"><?= $market->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="content with-padding padding-bottom-0">
        <!-- Fun Facts Container -->
        <div class="fun-facts-container mb-0">
            <div class="fun-fact" data-fun-fact-color="#36bd78">
                <div class="fun-fact-text d-flex justify-content-start" style="gap: 30px">
                    <img src="/images/icon/users-tr.svg">
                    <div class="box">
                        <a id="1" href="<?= Url::to(['/customer/index']) ?>">
                            <div class="ftitle" style="color: #38B36E;">
                                <div id="total_customer">0</div>
                            </div>
                            <span> <?= Yii::t('app', 'Umumiy xaridorlar soni') ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="fun-fact" data-fun-fact-color="#b81b7f">
                <div class="fun-fact-text d-flex justify-content-start" style="gap: 30px">
                    <img src="/images/icon/must-pay.svg">

                    <div class="box">
                        <a id="2" href="<?= Url::to(['/order/index']) ?>">
                            <div class="ftitle" style="color: #D4C10F">
                                <div id="total_need_money">0</div>
                            </div>
                        </a>
                        <span> <?= Yii::t('app', 'To\'lanishi kerak') ?></span>
                    </div>
                </div>
            </div>
            <div class="fun-fact" data-fun-fact-color="#efa80f">
                <div class="fun-fact-text d-flex justify-content-start" style="gap: 30px">
                    <img src="/images/icon/paid.svg">
                    <div class="box">

                        <a id="3" href="<?= Url::to(['/order/index']) ?>">
                            <div class="ftitle" style="color: #38B36E">
                                <div id="total_payed_money">0</div>
                            </div>
                        </a>
                        <span><?= Yii::t('app', 'To\'langan') ?></span>
                    </div>
                </div>
            </div>

            <!-- Last one has to be hidden below 1600px, sorry :( -->
            <div class="fun-fact" data-fun-fact-color="#2a41e6">
                <div class="fun-fact-text d-flex justify-content-start" style="gap: 30px">
                    <img src="/images/icon/unpaid.svg">

                    <div class="box">

                        <a id="4" href="<?= Url::to(['/order/index']) ?>">
                            <div class="ftitle" style="color: #F00B0B">
                                <div id="total_not_payed_money">0</div>
                            </div>
                        </a>
                        <span> <?= Yii::t('app', 'To\'lanmagan') ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-30">
                <!-- Dashboard Box -->
                <div class="dashboard-box main-box-in-row background__dashboard-transaction mt-0">
                    <div class="headline">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3><img src="/images/icon/chart.svg"> <?= Yii::t('app', 'Tranzaksiya grafigi (1 oylik)') ?>
                            </h3>
                        </div>
                    </div>
                    <div class="content">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="myChart3" width="100" height="25"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Dashboard Box / End -->
            </div>

            <div class="col-12 col-md-6 mt-30">
                <!-- Dashboard Box -->
                <div class="dashboard-box main-box-in-row background__dashboard-transaction mt-0">
                    <div class="headline">
                        <h3><img src="/images/icon/chart.svg"> <?= Yii::t('app', 'Statistika foizlarda') ?></h3>
                    </div>
                    <div class="content">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="myChart2" width="800" height="450"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Dashboard Box / End -->
            </div>

            <div class="col-12 col-md-6 mt-30">
                <!-- Dashboard Box -->
                <div class="dashboard-box main-box-in-row background__dashboard-transaction mt-0">
                    <div class="headline">
                        <h3><img src="/images/icon/chart.svg"> <?= Yii::t('app', 'Statistika to\'lovlar bo\'yicha') ?>
                        </h3>
                    </div>
                    <div class="content">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="polarChart" width="800" height="450"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Dashboard Box / End -->

            </div>
        </div>
    </div>
    <div class="row">
        <div class=" col-12 col-md-6 mt-30">
            <!-- Dashboard Box -->
            <div class="dashboard-box main-box-in-row background__dashboard-transaction mt-0 h-100">
                <div class="headline">
                    <h3> <?= Yii::t('app', 'Bu oydagi tranzaksiyalar') ?></h3>
                </div>
                <a id="link_count_daily" href="#">
                    <table class="table table-striped table-bordered" style="font-size: 18px ; color: black">
                        <tr>
                            <td style="padding: 8px"><?= Yii::t('app', 'Naqd') ?></td>
                            <td style="padding: 8px" id="total_cash"></td>
                            <td style="padding: 8px" class="cash_percent"></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px">Paymo</td>
                            <td style="padding: 8px" id="total_paymo"></td>
                            <td style="padding: 8px" id="paymo_percent"></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px">Unired</td>
                            <td style="padding: 8px" id="total_unired"></td>
                            <td style="padding: 8px" id="unired_percent"></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px">Genesis</td>
                            <td style="padding: 8px" id="total_genesis"></td>
                            <td style="padding: 8px" id="genesis_percent"></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px">MyUzkard</td>
                            <td style="padding: 8px" id="total_myuzcard"></td>
                            <td style="padding: 8px" id="myuzcard_percent"></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px" title="Payme/Asaxiy/UzumBank"> <?= Yii::t('app', 'Online') ?></td>
                            <td style="padding: 8px" id="total_online"></td>
                            <td style="padding: 8px" id="online_percent"></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px">MIB/Bank</td>
                            <td style="padding: 8px" id="total_mib_bank"></td>
                            <td style="padding: 8px" id="mib_bank_percent"></td>
                        </tr>
                        <tr class="d-none">
                            <td style="padding: 8px">Naqd</td>
                            <td style="padding: 8px">P/U/M</td>
                            <td style="padding: 8px">Mib/Online</td>
                        </tr>
                        <tr class="d-none">
                            <td style="padding: 8px" class="cash_percent"></td>
                            <td style="padding: 8px" id="total_pum_percent"></td>
                            <td style="padding: 8px" id="online_mib_percent"></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px"> <?= Yii::t('app', 'Umumiy') ?></td>
                            <td style="padding: 8px" id="total_transaction"></td>
                        </tr>
                    </table>
                </a>

            </div>
        </div>
        <div class="col-12 col-md-6 mt-30">
            <!-- Dashboard Box -->
            <div class="dashboard-box main-box-in-row background__dashboard-transaction mt-0">
                <div class="headline">
                    <h3>
                        <img src="/images/icon/chart.svg"><?= Yii::t('app', 'Tranzaksiyalar bo\'yicha umumiy Analitika') ?>
                    </h3>
                </div>
                <div class="content">
                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="myTChart" width="100" height="64"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/chart.min.js"></script>
<?php

$url = Yii::$app->params['dashboardUrl'] . "/transaction-info?user_id=" . $user->id;
$url_payment = Yii::$app->params['dashboardUrl'] . "/payments?user_id=" . $user->id;
$data_url = Yii::$app->params['dashboardUrl'] . "/transaction-data?user_id=" . $user->id;
$data_transaction_url = Yii::$app->params['dashboardUrl'] . "/transaction-chart?user_id=" . $user->id;
if (!$user->is_admin) {
    $url_payment .= "&market_id=" . $user->market_id;
    $url .= "&market_id=" . $user->market_id;
    $data_url .= "&market_id=" . $user->market_id;
}
$jwt_auth_key = \common\models\constants\AppConstants::BEARER_AUTH_HEADER_PREFIX;
$jwt_auth_key .= (!\Yii::$app->user->isGuest ? \Yii::$app->jwtService->generateAccessToken(\Yii::$app->user->identity->id) : '');
$scripts = <<<JS
$.ajaxSetup({
  headers: {
    'Authorization': '$jwt_auth_key'
  }
});

        
        
        var ttx = document.getElementById('myTChart').getContext('2d');
        var myTChart = new Chart(ttx, {
                type: 'line',
                // The data for our dataset
                data: {
                    labels: [],
                    // Information about the dataset
                    datasets: [{
                        label: "Milliard",
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
                    },]
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

var stx = document.getElementById('myChart3').getContext('2d');
      var myChart3 = new Chart(stx, {
          type: 'line',
          	data: {
			labels: [],
			// Information about the dataset
	   		datasets: [{
				label: "Total",
				backgroundColor: 'rgba(42,65,232,0.08)',
				borderColor: '#2a41e8',
				borderWidth: "1",
				data: [],
				pointRadius: 2,
				pointHoverRadius:5,
				pointHitRadius: 5,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "1",
			},{
				label: "Unired",
				backgroundColor: 'rgba(42,65,232,0.08)',
				borderColor: 'red',
				borderWidth: "1",
				data: [],
				pointRadius: 2,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "1",
			},{
				label: "Paymo",
				backgroundColor: 'rgba(42,65,232,0.08)',
				borderColor: 'green',
				borderWidth: "1",
				data: [],
				pointRadius: 2,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2",
			},{
				label: "Kassa",
				backgroundColor: 'rgba(196,88,80,0.1)',
				borderColor: '#FF9300',
				borderWidth: "1",
				data: [],
				pointRadius: 2,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2",
			},{
				label: "Genesis",
				backgroundColor: 'rgba(42,65,232,0.08)',
				borderColor: '#2a41e8',
				borderWidth: "1",
				data: [],
				pointRadius: 2,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2",
			},{
				label: "MyUzcard",
				backgroundColor: 'rgba(42,1,232,0.08)',
				borderColor: '#04305f',
				borderWidth: "1",
				data: [],
				pointRadius: 2,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2",
			},{
				label: "Payme",
				backgroundColor: 'rgba(196,88,80,0.1)',
				borderColor: '#012F2F',
				borderWidth: "1",
				data: [],
				pointRadius: 2,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2",
			},{
				label: "Apelsin",
				backgroundColor: 'rgb(185,164,239)',
				borderColor: '#110237',
				borderWidth: "1",
				data: [],
				pointRadius: 2,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2",
			},{
				label: "Asaxiy",
				backgroundColor: 'rgb(130,193,243)',
				borderColor: '#034377',
				borderWidth: "1",
				data: [],
				pointRadius: 2,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2",
			},{
				label: "MIB",
				backgroundColor: 'rgb(148,144,144)',
				borderColor: '#231D1D',
				borderWidth: "1",
				data: [],
				pointRadius: 2,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2",
			},
			{
				label: "BANK",
				backgroundColor: 'rgb(223,221,202)',
				borderColor: '#A7A373',
				borderWidth: "1",
				data: [],
				pointRadius: 2,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2",
			},
			]
		},
        });
      
 var ctx = document.getElementById('myChart2').getContext('2d');
      var myChart2 = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: ["To'langan", "To'lanmagan","Kelgusida"],
            datasets: [{ 
                data: [],
                borderColor:[
                  "#3cba9f",
                  "#ffa500",
                  "#c45850",
                ],
                backgroundColor: [
                  "rgb(60,186,159,0.1)",
                  "rgb(255,165,0,0.1)",
                  "rgb(196,88,80,0.1)",
                ],
                borderWidth:2,
              }]
          },
        options: {
          scales: {
            xAxes: [{ 
               display: false,
            }],
            yAxes: [{
               display: false,
            }],
          }
        },

      });

 var xtx = document.getElementById('polarChart').getContext('2d');
      var myChart = new Chart(xtx, {
          type: 'pie',
          data: {
            labels: ["Kassa", "Paymo", "Unired", "Genesis", "MyUzcard", "Payme", "Apelsin", "Asaxiy", "MIB", "BANK"],
            datasets: [{ 
                data: [],
                borderColor:[
                  "#c45850",
                  "#3cba9f",
                  "#ffa500",
                  "#2a41e8",
                  "#04305f",
                  "#012F2F",
                  "#110237",
                  "#034377",
                  "#231D1D",
                  "#A7A373",
                ],
                backgroundColor: [
                  "rgb(196,88,80,0.1)",
                  "rgb(60,186,159,0.1)",
                  "rgb(255,165,0,0.1)",
                  "rgb(42,65,232,0.08)",
                  "rgb(42,186,80,0.08)",
                  "rgb(124,250,250)",
                  "rgb(185,164,239)",
                  "rgb(130,193,243)",
                  "rgb(148,144,144)",
                  "rgb(223,221,202)",
                ],
                borderWidth:2,
              }]
          },
        options: {
          scales: {
            xAxes: [{ 
               display: false,
            }],
            yAxes: [{
               display: false,
            }],
          }
        },
      });
      
       let cUrl = '$url';
       let pUrl = '$url_payment';
       let urlChart = '$data_url';
       let urlTransactionChart = '$data_transaction_url';

        totalInOne();
        function totalInOne(market_id = null){
            let date_range = $('.monthCal').val();
            updateData(market_id);
            updatePayments(market_id);
            updateChart(market_id,date_range);
            updateTransactionChart(market_id);
        }
          function updateData(market_id) {
            market_id = $('#markets').val();
            let date_range = $('#date_range').val();
            $.ajax({ url: cUrl,  data: {market_id: market_id, date_range: date_range}, type: 'GET',
                success: function(result) {
                    $('#total_customer').text(result.total_customer);
                    $('#total_need_money').text(result.total_need_money);
                    $('#total_payed_money').text(result.total_payed_money);
                    $('#total_not_payed_money').text(result.total_not_payed_money);
                    $('#today_sum').text(result.today_sum);
                    $('#today_count').text(result.today_count);
                    $('#total_customer_date').text(result.total_customer_date);
                    $('#total_payed_money_date').text(result.total_payed_money_date);
                    $('#total_not_payed_money_date').text(result.total_not_payed_money_date);
                }               
            });
        }
         function updatePayments(market_id) {
            market_id = $('#markets').val();
            let date_range = $('#date_range').val();
            $.ajax({ url: pUrl,  data: {market_id: market_id, date_range: date_range}, type: 'GET',
                success: function(result) {
                    $('#total_cash').text(result.total_cash);
                    $('#total_paymo').text(result.total_paymo);
                    $('#total_unired').text(result.total_unired);
                    $('#total_genesis').text(result.total_genesis);
                    $('#total_myuzcard').text(result.total_myuzcard);
                    $('#total_transaction').text(result.total_transaction);
                    $('#bonus_percent').text(result.bonus_percent);
                    $('#bonus_amount').text(result.bonus_amount);
                    $('#total_cash_without_offline').text(result.total_cash_without_offline);
                    $('#only_online_transaction').text(result.only_online_transaction);
                    $('.only_online_transaction_percent').text(result.only_online_transaction_percent);
                    $('#paymo_percent').text(result.paymo_percent+'%');
                    $('.cash_percent').text(result.cash_percent+'%');
                    $('#unired_percent').text(result.unired_percent+'%');
                    $('#genesis_percent').text(result.genesis_percent+'%');
                    $('#myuzcard_percent').text(result.myuzcard_percent+'%');
                    $('#online_percent').text(result.online_percent+'%');
                    $('#mib_bank_percent').text(result.mib_bank_percent+'%');
                    $('#total_online').text(result.total_online);
                    $('#total_mib_bank').text(result.total_mib_bank);
                    let total_pum_percent = parseFloat(result.paymo_percent) + parseFloat(result.unired_percent) + parseFloat(result.myuzcard_percent);
                    let online_mib_percent = parseFloat(result.mib_bank_percent) + parseFloat(result.online_percent);
                    $('#total_pum_percent').text(total_pum_percent.toFixed(2)+"%");
                    $('#online_mib_percent').text(online_mib_percent.toFixed(2)+"%");
                }               
            });
        }
        function updateGraphics() {
               let market_id = $('#markets').val();
            $.ajax({ url: cUrl,  data: {market_id:2 }, type: 'GET',
                success: function(result) {
                    $('#total_customer').text(result.total_customer);
                    $('#total_need_money').text(result.total_need_money);
                    $('#total_payed_money').text(result.total_payed_money);
                    $('#total_not_payed_money').text(result.total_not_payed_money);
                }             
            });
        }

        function updateChart(market_id, date_range) {
            $.ajax({ 
                    url: urlChart, 
                    data: {market_id: market_id,date_range: date_range},
                    type: 'GET',
                success: function(result) {
                     myChart3.data.labels = result.transaction_date;
                     myChart3.data.datasets[0].data = result.transaction_amount;
                     myChart3.data.datasets[1].data = result.transaction_unired;
                     myChart3.data.datasets[2].data = result.transaction_paymo;
                     myChart3.data.datasets[3].data = result.transaction_offline;
                     myChart3.data.datasets[4].data = result.transaction_genesis;
                     myChart3.data.datasets[5].data = result.transaction_myuzcard;
                     myChart3.data.datasets[6].data = result.transaction_payme;
                     myChart3.data.datasets[7].data = result.transaction_apelsin;
                     myChart3.data.datasets[8].data = result.transaction_asaxiy;
                     myChart3.data.datasets[9].data = result.transaction_mib;
                     myChart3.data.datasets[10].data = result.transaction_bank;
                     myChart.data.datasets[0].data = result.payment;
                     myChart2.data.datasets[0].data = result.percent;
                     myChart3.update();
                     myChart.update();
                     myChart2.update();
                        
                }               
            });
        }

      function updateTransactionChart(market_id) {
            $.ajax({ 
                    url: urlTransactionChart, 
                    data: {market_id: market_id},
                    type: 'GET',
                success: function(result) {
                     myTChart.data.labels = result.transaction_date;
                     myTChart.data.datasets[0].data = result.total_transaction_amount;
                     myTChart.data.datasets[1].data = result.total_transaction_count;
                     myTChart.update();                        
                }               
            });
        }

        function updateMarket() {
            let market_id = parseInt($('#markets').val());
            let month = parseInt($('#monthCal').val());
            updateData(market_id);
            updateChart(market_id,month);
            updateTransactionChart(market_id);
        }

        $('.monthCal').on('change',function (e){
            let market = $('#markets').val();
            let date_range = $('#date_range').val();
            window.location = 'https://merchant.abrand.uz/site/dashboard-transaction?date_range='+date_range;
        })
JS;
$this->registerJs($scripts, View::POS_END);
?>