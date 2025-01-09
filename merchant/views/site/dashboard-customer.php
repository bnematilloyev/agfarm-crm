<?php

use common\helpers\Utilities;
use common\models\constants\CustomerDegree;
use common\models\constants\CustomerStatus;
use common\models\constants\UserRole;
use yii\helpers\Url;
use yii\web\View;

/* @var $date string */
/* @var $markets \common\models\Market[] */
/* @var $this View */
$this->title = Yii::t('app', "Maqomlar");
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="headline">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="col-md-9">
                <h2 class="title-dashboard"><?= html_entity_decode($this->title) ?></h2>
            </div>
        </div>
    </div>
    <div class="content with-padding padding-bottom-0 dashboard__customer-new-box">
        <!-- Fun Facts Container -->
        <div class="fun-facts-container mb-0">
            <div class="fun-fact d-flex justify-content-start" style="gap: 30px">
                <img src="/images/userdashboard/all_user-customer.svg">

                <div class="fun-fact-text ">
                    <a id="1" href="<?= Url::to(['/customer/index-by-order']) ?>">
                        <div class="ftitle" style="color: #008DFF">
                            <div id="total_customer_count">0</div>
                        </div>
                    </a>
                    <span> <?= Yii::t('app', 'Umumiy xaridorlar soni') ?></span>
                </div>
            </div>
            <div class="fun-fact d-flex justify-content-start" data-fun-fact-color="#6a78d4" style="gap: 30px">
                <img src="/images/userdashboard/active_user-customer.svg">
                <div class="fun-fact-text ">
                    <a id="1"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[status]' => CustomerStatus::STATUS_MEMBER]) ?>">
                        <div class="ftitle" style="color: #00BFAF">
                            <div id="active_customer_count">0</div>
                        </div>
                    </a>
                    <span> <?= Yii::t('app', 'Faol xaridorlar soni') ?></span>
                </div>
            </div>
            <div class="fun-fact  d-flex justify-content-start" data-fun-fact-color="black" style="gap: 30px">
                <img src="/images/userdashboard/cencel_user-customer.svg">
                <div class="fun-fact-text ">
                    <a id="1"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[status]' => CustomerStatus::STATUS_ARCHIVED]) ?>">
                        <div class="ftitle" style="color: #E83333">
                            <div id="cancel_customer_count">0</div>
                        </div>
                    </a>
                    <span> <?= Yii::t('app', 'Bekor qilingan xaridorlar soni') ?></span>
                </div>
            </div>
            <div class="fun-fact  d-flex justify-content-start" data-fun-fact-color="#9d9892" style="gap: 30px">
                <img src="/images/userdashboard/degrees_user-customer.svg">
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_PASSIVE]) ?>">
                        <div class="ftitle" style="color: #F4A022">
                            <div id="degree_passive">0</div>
                        </div>
                    </a>
                    <span><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_PASSIVE)) ?></span>
                </div>
            </div>
            <div class="fun-fact  d-flex justify-content-start" data-fun-fact-color="#9d9892" style="gap: 30px">
                <img src="/images/userdashboard/degrees_user-customer.svg">
                <div class="fun-fact-text">
                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_RHODIUM]) ?>">
                        <div class="ftitle" style="color: #5C5F63">
                            <div id="degree_rhodium">0</div>
                        </div>
                    </a>
                    <span style="color:#5C5F63;"><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_RHODIUM)) ?></span>
                </div>
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_RHODIUM]) ?>">
                        <div class="ftitle">
                            <div style="color: #F4A022" id="degree_rhodium_passive">0</div>
                        </div>
                    </a>
                    <span style="color:#F4A022 "><?= " Passiv" ?></span>
                </div>
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_RHODIUM]) ?>">
                        <div class="ftitle" style="color:#00BFAF ">
                            <div id="degree_rhodium_active">0</div>
                        </div>
                    </a>
                    <span><?= "Aktiv" ?></span>
                </div>
            </div>

            <div class="fun-fact  d-flex justify-content-start" data-fun-fact-color="#9d9892" style="gap: 30px">
                <img src="/images/userdashboard/platinium_user-customer.svg">
                <div class="fun-fact-text">
                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_PLATINUM]) ?>">
                        <div class="ftitle" style="color: #5C5F63">
                            <div id="degree_platinum" style="color: #5C5F63">0</div>
                        </div>
                    </a>
                    <span><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_PLATINUM)) ?></span>

                </div>
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_PLATINUM]) ?>">
                        <div class="ftitle" style="color: #F4A022">
                            <div id="degree_platinum_passive">0</div>
                        </div>
                    </a>
                    <span style="color: #F4A022"><?= "Passiv" ?></span>
                </div>
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_PLATINUM]) ?>">
                        <div class="ftitle" style="color: #00BFAF">
                            <div id="degree_platinum_active">0</div>
                        </div>
                    </a>
                    <span style="color: #00BFAF"><?= "Aktiv" ?></span>
                </div>
            </div>
            <div class="fun-fact d-flex justify-content-start " data-fun-fact-color="#FFD700" style="gap: 30px">
                <img src="/images/userdashboard/gold.svg" width="70">
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_GOLD]) ?>">
                        <div class="ftitle" style="color: #E0A03B">
                            <div id="degree_gold">0</div>
                        </div>
                    </a>
                    <span><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_GOLD)) ?></span>
                </div>
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_GOLD]) ?>">
                        <div class="ftitle" style="color: #F4A022">
                            <div id="degree_gold_passive">0</div>
                        </div>
                    </a>
                    <span style="color:#F4A022;"><?= "Passiv" ?></span>
                </div>
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_GOLD]) ?>">
                        <div class="ftitle" style="color: #00BFAF">
                            <div id="degree_gold_active">0</div>
                        </div>
                    </a>
                    <span style="color: #00BFAF"><?= "Aktiv" ?></span>
                </div>
            </div>
            <div class="fun-fact d-flex justify-content-start " data-fun-fact-color="#C0C0C0" style="gap: 30px">
                <img src="/images/userdashboard/kumush.svg" width="70">
                <div class="fun-fact-text">
                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_SILVER]) ?>">
                        <div class="ftitle" style="color: #475165">
                            <div id="degree_silver">0</div>
                        </div>
                    </a>
                    <span style="color: #475165"><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_SILVER)) ?></span>

                </div>
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_SILVER]) ?>">
                        <div class="ftitle" style="color: #F4A022">
                            <div id="degree_silver_passive">0</div>
                        </div>
                    </a>
                    <span style="color: #F4A022"><?= "Passiv" ?></span>
                </div>
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_SILVER]) ?>">
                        <div class="ftitle" style="color: #00BFAF">
                            <div id="degree_silver_active">0</div>
                        </div>
                    </a>
                    <span style="color: #00BFAF"><?= "Aktiv" ?></span>
                </div>
            </div>
            <div class="fun-fact d-flex justify-content-start" data-fun-fact-color="#CD7F32" style="gap: 30px">
                <img src="/images/userdashboard/bronzaa.svg" width="70">
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_BRONZE]) ?>">
                        <div class="ftitle" style="color: #4B4B4B">
                            <div id="degree_bronze">0</div>
                        </div>
                    </a>
                    <span style="color: #4B4B4B"><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_BRONZE)) ?></span>
                </div>
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_BRONZE]) ?>">
                        <div class="ftitle" style="color: #F4A022">
                            <div id="degree_bronze_passive">0</div>
                        </div>
                    </a>
                    <span style="color: #F4A022"><?= "Passiv" ?></span>
                </div>

                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_BRONZE]) ?>">
                        <div class="ftitle" style="color: #00BFAF">
                            <div id="degree_bronze_active">0</div>
                        </div>
                    </a>
                    <span style="color: #00BFAF"> <?= "Aktiv" ?></span>
                </div>
            </div>
            <div class="fun-fact d-flex justify-content-start" data-fun-fact-color="#b81b7f" style="gap: 30px">
                <img src="/images/userdashboard/oddiy.svg" width="70">
                <div class="fun-fact-text">
                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_SIMPLE, 'CustomerSearch[status]' => CustomerStatus::STATUS_MEMBER]) ?>">
                        <div class="ftitle" style="color: #5C4548">
                            <div id="degree_simple">0</div>
                        </div>
                    </a>
                    <span style="color: #5C4548"><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_SIMPLE)) ?></span>
                </div>

                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_SIMPLE, 'CustomerSearch[status]' => CustomerStatus::STATUS_MEMBER]) ?>">
                        <div class="ftitle" style="color: #F4A022">
                            <div id="degree_simple_passive">0</div>
                        </div>
                    </a>
                    <span style="color: #F4A022"><?= "Passiv" ?></span>
                </div>
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_SIMPLE, 'CustomerSearch[status]' => CustomerStatus::STATUS_MEMBER]) ?>">
                        <div class="ftitle" style="color: #00BFAF">
                            <div id="degree_simple_active">0</div>
                        </div>
                    </a>
                    <span style="color: #00BFAF"><?= "Aktiv" ?></span>
                </div>
            </div>
            <div class="fun-fact " data-fun-fact-color="#67cfff" style="gap: 30px">
                <img src="/images/userdashboard/need_user-customer.svg" width="70">
                <div class="fun-fact-text">
                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_NEEDY]) ?>">
                        <div class="ftitle" style="color: #A12EE8">
                            <div id="degree_needy">0</div>
                        </div>
                    </a>
                    <span><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_NEEDY)) ?></span>
                </div>
            </div>
            <div class="fun-fact d-flex justify-content-start" data-fun-fact-color="#67cfff" style="gap: 30px">
                <img src="/images/userdashboard/finished_user-customer.svg" width="70">
                <div class="fun-fact-text">
                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::FINISHED_DEGREE_NEEDY]) ?>">
                        <div class="ftitle" style="color: #A12EE8">
                            <div id="finished_degree_needy">0</div>
                        </div>
                    </a>
                    <span><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::FINISHED_DEGREE_NEEDY)) ?></span>
                </div>
            </div>
            <div class="fun-fact d-flex justify-content-start" data-fun-fact-color="#67cfff" style="gap: 30px">
                <img src="/images/userdashboard/imprisoned.svg">
                <div class="fun-fact-text">
                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_IMPRISONED]) ?>">
                        <div class="ftitle" style="color: black">
                            <div id="degree_imprisoned">0</div>
                        </div>
                    </a>
                    <span><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_IMPRISONED)) ?></span>
                </div>
            </div>
            <div class="fun-fact d-flex justify-content-start" data-fun-fact-color="#67cfff" style="gap: 30px">
                <img src="/images/userdashboard/deid_user-customer.svg" width="70">
                <div class="fun-fact-text">
                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_DEAD]) ?>">
                        <div class="ftitle" style="color: #E40F0F">
                            <div id="degree_dead">0</div>
                        </div>
                    </a>
                    <span style="color: #E40F0F"><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_DEAD)) ?></span>
                </div>
            </div>
            <div class="fun-fact d-flex justify-content-start" data-fun-fact-color="#000" style="gap: 30px">
                <img src="/images/userdashboard/black.svg" width="70">
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_NEGRO, 'CustomerSearch[status]' => CustomerStatus::STATUS_MEMBER]) ?>">
                        <div class="ftitle" style="color: black">
                            <div id="degree_negro">0</div>
                        </div>
                    </a>
                    <span><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_NEGRO)) ?></span>
                </div>
            </div>
            <div class="fun-fact d-flex justify-content-start" data-fun-fact-color="#596183" style="gap: 30px">
                <img src="/images/userdashboard/fraudster.svg" width="70">
                <div class="fun-fact-text">
                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_FRAUDSTER, 'CustomerSearch[status]' => CustomerStatus::STATUS_MEMBER]) ?>">
                        <div class="ftitle" style="color: black">
                            <div id="degree_fraundster">0</div>
                        </div>
                    </a>
                    <span><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_FRAUDSTER)) ?></span>
                </div>
            </div>
            <div class="fun-fact d-flex justify-content-between" data-fun-fact-color="#59877b" style="gap: 30px">
                <img src="/images/userdashboard/yalmogiz_user-customer.svg" width="70">
                <div class="fun-fact-text">

                    <a id="2"
                       href="<?= Url::to(['/customer/index-by-order', 'CustomerSearch[degree]' => CustomerDegree::DEGREE_DEVIL]) ?>">
                        <div class="ftitle" style="color: #384CB3">
                            <div id="degree_devil">0</div>
                        </div>
                    </a>
                    <span><?= Yii::t('app', CustomerDegree::getString(CustomerDegree::DEGREE_DEVIL)) ?></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-30">
                <div class="background-white main-box-in-row dashboard-box ">
                    <div class="content">
                        <div class="chart">
                            <canvas id="chart" width="1772" height="600"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="/js/chart.min.js"></script>
<?php
$main_url = Yii::$app->params['dashboardUrl'];

$url = $main_url . "/dashboard-customer-info";
$market_url = Url::to(['site/dashboard-customer']);
$customer_url = $main_url . "/customer-chart";
if (Yii::$app->user->identity->role == UserRole::ROLE_MERCHANT) {
    $url .= "&market_id=" . Yii::$app->user->identity->market_id;
    $customer_url .= "&market_id=" . Yii::$app->user->identity->market_id;
}

$jwt_auth_key = \common\models\constants\AppConstants::BEARER_AUTH_HEADER_PREFIX;
$jwt_auth_key .= (!\Yii::$app->user->isGuest ? \Yii::$app->jwtService->generateAccessToken(\Yii::$app->user->identity->id) : '');
$scripts = <<<JS
$.ajaxSetup({
  headers: {
    'Authorization': '$jwt_auth_key'
  }
});

  var ctx = document.getElementById('chart').getContext('2d');

var DashChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: '',
	   		datasets: [{
				label: " Jami yaratilgan xaridorlar soni",
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
				label: " Faol holatga otkazilganlar ",
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
			},{
				label: " Bekor qilinganlar ",
				backgroundColor: 'rgba(0,0,232,0.08)',
				borderColor: 'black',
				borderWidth: "3",
				data: [],
				pointRadius: 5,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2"
			},
            ]
		},
		// Configuration options
		options: {

		    layout: {
		      padding: 10
		  	},

			// legend: { display: false },
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
        let mUrl = '$market_url';
        let chUrl = '$customer_url';
        totalInOne();
        function totalInOne(){
            updateData();
            updateCustomerChart();
        }
          function updateData() {
            $.ajax({ url: cUrl, type: 'GET',
                success: function(result) {
                    $('#total_customer_count').text(result.total_customer_count);
                    $('#active_customer_count').text(result.active_customer_count);
                    $('#cancel_customer_count').text(result.cancel_customer_count);
                    $('#degree_devil').text(result.degree_devil);
                    $('#degree_fraundster').text(result.degree_fraundster);
                    $('#degree_negro').text(result.degree_negro);
                    $('#degree_imprisoned').text(result.degree_imprisoned);
                    $('#degree_dead').text(result.degree_dead);
                    $('#degree_needy').text(result.degree_needy);
                    $('#finished_degree_needy').text(result.finished_degree_needy);
                    $('#degree_simple').text(result.degree_simple);
                    $('#degree_bronze').text(result.degree_bronze);
                    $('#degree_silver').text(result.degree_silver);
                    $('#degree_gold').text(result.degree_gold);
                    $('#degree_platinum').text(result.degree_platinum);
                    $('#degree_rhodium').text(result.degree_rhodium);
                    $('#degree_passive').text(result.degree_passive);
                    $('#degree_simple_active').text(result.degree_simple_active);
                    $('#degree_simple_passive').text(result.degree_simple_passive);
                    $('#degree_bronze_active').text(result.degree_bronze_active);
                    $('#degree_bronze_passive').text(result.degree_bronze_passive);
                    $('#degree_silver_active').text(result.degree_silver_active);
                    $('#degree_silver_passive').text(result.degree_silver_passive);
                    $('#degree_gold_active').text(result.degree_gold_active);
                    $('#degree_gold_passive').text(result.degree_gold_passive);
                    $('#degree_platinum_active').text(result.degree_platinum_active);
                    $('#degree_platinum_passive').text(result.degree_platinum_passive);
                    $('#degree_rhodium_active').text(result.degree_rhodium_active);
                    $('#degree_rhodium_passive').text(result.degree_rhodium_passive);
                }               
            });
        }

        function updateCustomerChart() {
            
            $.ajax({ 
                    url: chUrl, 
                    type: 'GET',
                success: function(result) {
                     DashChart.data.labels = result.month_date;
                     DashChart.data.datasets[0].data = result.new_customer_count;
                     DashChart.data.datasets[1].data = result.active_customer_count;
                     DashChart.data.datasets[2].data = result.cancel_customer_count;
                     DashChart.update();        
                        
                }               
            });
        }
JS;
$this->registerJs($scripts, View::POS_END);
?>