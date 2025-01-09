<?php


namespace merchant\models\forms;


use common\helpers\TelegramHelper;
use common\helpers\Utilities;
use common\models\Action;
use common\models\constants\OrderStatus;
use common\models\Customer;
use common\models\Leasing;
use common\models\Order;
use common\models\Product;
use common\models\Setting;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 *
 * @property int $id
 * @property int|null $cheque
 * @property int $customer_id
 * @property int $company_id
 * @property int $market_id
 * @property int $user_id
 * @property string $actions
 * @property float $amount
 * @property int $status
 * @property string|null $remote_id
 * @property string|null $transaction_id
 * @property int|null $starts_in
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $leasing_id
 * @property float $cost
 * @property float $price
 * @property float $quantity
 * @property float $prepaid
 * @property float $profit
 * @property float $bonus
 * @property float $leasing
 * @property string $description
 *
 * @property User $user
 * @property Customer $customer
 * @property Leasing $leasing_by_id
 * @property Leasing $_leasing
 */
class OrderForm extends Model
{
    public $id;
    public $cheque;
    public $customer_id;
    public $company_id;
    public $market_id;
    public $leasing_id;
    public $user_id;
    public $amount;
    public $prepaid;
    public $leasing;
    public $bonus;
    public $status;
    public $remote_id;
    public $transaction_id;
    public $starts_in;
    public $created_at;
    public $updated_at;
    public $actions;
    public $barcode;
    public $description;
    public $cost;
    public $profit;

    private $user;
    private $_leasing;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cheque', 'customer_id', 'company_id', 'market_id', 'status', 'starts_in', 'created_at'], 'default', 'value' => null],
            [['cheque', 'customer_id', 'company_id', 'market_id', 'status', 'leasing_id'], 'integer'],
            [['customer_id', 'company_id', 'market_id', 'actions', 'amount', 'leasing_id'], 'required'],
            [['actions', 'starts_in', 'created_at'], 'safe'],
            [['amount', 'prepaid', 'leasing', 'profit', 'cost'], 'number'],
            [['remote_id', 'transaction_id'], 'string', 'max' => 255],
            [['description'], 'string'],
        ];
    }

    /**
     * OrderForm constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->actions = [];
        $this->created_at = date("d.m.Y");
        $this->starts_in = date("d.m.Y");
        $this->user = Yii::$app->user->identity;
        $this->company_id = $this->user->company_id;
        $this->market_id = $this->user->market_id;
        $this->user_id = $this->user->id;
        $this->cost = 0;
        $this->amount = 0;
        $this->prepaid = 0;
        $this->leasing = 0;
        $this->bonus = 0;
        $this->profit = 0;
        $this->status = OrderStatus::STATUS_WAITING;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cheque' => Yii::t('app', 'Cheque'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'market_id' => Yii::t('app', 'Market ID'),
            'leasing_id' => Yii::t('app', 'Leasing ID'),
            'actions' => Yii::t('app', 'Actions'),
            'amount' => Yii::t('app', 'Amount'),
            'prepaid' => Yii::t('app', 'Prepaid'),
            'leasing' => Yii::t('app', 'Leasing'),
            'cost' => Yii::t('app', 'Cost'),
            'profit' => Yii::t('app', 'Profit'),
            'status' => Yii::t('app', 'Status'),
            'remote_id' => Yii::t('app', '{Remote} ID', ['Remote' => Yii::$app->user->isGuest ? 'Saytdagi nomi' : Yii::$app->user->identity->company->name]),
            'transaction_id' => Yii::t('app', 'Transaction ID'),
            'starts_in' => Yii::t('app', 'Starts In'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return bool
     */
    public function save($do_validate = true)
    {
        $telegram = new TelegramHelper(false);
        if ($do_validate && !$this->validate_save())
            return false;
        if (!is_array($this->actions))
            $this->actions = [];
        $order = new Order();
        $order->cheque = $this->cheque;
        $order->company_id = $this->company_id;
        $order->market_id = $this->market_id;
        $order->customer_id = $this->customer_id;
        $order->leasing_id = $this->leasing_id;
        $order->amount = $this->amount;
        $order->prepaid = $this->prepaid;
        $order->leasing = $this->leasing;
        $order->bonus = $this->bonus;
        $order->status = $this->status;
        $order->starts_in = Utilities::toUnixDate($this->starts_in);
        $order->created_at = Utilities::toUnixDate($this->created_at);

        if (!$order->validate() || !$order->save()) {
            $telegram->sendMessage("Error in saving order : " . json_encode($order->errors));
            return false;
        }

        $this->id = $order->id;
        $this->_leasing = $this->leasing_by_id;

        foreach ($this->actions as $action) {
            $new_action = new Action();
            $new_action->company_id = $this->company_id;
            $new_action->market_id = $this->market_id;
            $new_action->user_id = $this->user_id;
            $new_action->customer_id = $this->customer_id;
            $new_action->order_id = $this->id;
            $new_action->leasing_id = $this->leasing_id;
            $new_action->product_id = $action['product_id'];
            $product = $this->getProduct($new_action->product_id);
            if (isset($action['cost']))
                $new_action->cost = $action['cost'];
            else
                $new_action->cost = $product->cost;
            if (Yii::$app->user->identity->branch->id == 4 && strpos($product->name, "xurshid")) {
                /** @var Setting $percent */
                $percent = Setting::find()->andWhere(['name' => "xurshid-leasing-cost-percent"])->one();
                if ($percent != null) {
                    $new_action->cost = $action['price'] / doubleval($percent->value);
                }
            }
            $new_action->price = $action['price'];
            $new_action->quantity = $action['quantity'];
            $new_action->prepaid = $action['prepaid'];
            $new_action->leasing = $new_action->price * $new_action->quantity - $new_action->prepaid;
            $new_action->profit = $new_action->prepaid + $new_action->leasing - $new_action->cost * $new_action->quantity;
            if (!$new_action->validate() || !$new_action->save()) {
                $telegram->sendMessage("Error in saving actions : " . json_encode($new_action->errors));
                Order::deleteAll(['id' => $this->id]);
                return false;
            }
            $order->description .= $new_action->product->name . 'dan ' . $new_action->quantity . ' ta ' . ($new_action->leasing + $new_action->prepaid) . 'ga sotildi ';
            $this->prepaid += $new_action->prepaid;
            $this->leasing += $new_action->leasing;
            $this->amount += $new_action->leasing + $new_action->prepaid;
            $this->profit += $new_action->profit;
            $this->cost += $new_action->cost * $new_action->quantity;
        }
        $order->amount = $this->amount;
        $order->prepaid = $this->prepaid;
        $order->leasing = $this->leasing;
        $order->bonus = $this->bonus;
        $order->cost = $this->cost;
        $order->profit = $this->profit;
        $order->save();
        if ($order->status == OrderStatus::STATUS_ACTIVE) {
            $order->createChildren();
        }
        return true;
    }

    /**
     * @param $client
     * @param $must
     * @return bool
     */
    public function is_valid_date($client, $must)
    {
        $time = time();
        return $client <= $must + $time && $client >= $time - $must;
    }

    /**
     * @return bool
     */
    public function validate_save()
    {
//        if (Yii::$app->user->identity->is_admin)
//        return true;
        $client_starts = Utilities::toUnixDate($this->starts_in);
        $client_create = Utilities::toUnixDate($this->created_at);
        if (!in_array(intval(date('d', $client_starts)), [5, 10, 15, 20])) {
            Yii::$app->session->setFlash('warning', Yii::t('app', "Error is {error}", ['error' => 'Birinchi to\'lov sanasini faqat 5, 10, 15, 20 sanalarni tanlashingiz lozim!']));
            return false;
        }

        $month = 20 * 24 * 60 * 60;
        if (!$this->is_valid_date($client_create, $month)) {
            Yii::$app->session->setFlash('warning', Yii::t('app', "Error is {error}", ['error' => Yii::t('app', 'Created At')]));
            return false;
        }
        if (!$this->is_valid_date($client_starts, $month)) {
            Yii::$app->session->setFlash('warning', Yii::t('app', "Error is {error}", ['error' => Yii::t('app', 'Starts In')]));
            return false;
        }

        return true;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function just_save()
    {
        if (!$this->validate_save())
            return false;
        $order = new Order();
        $order->cheque = $this->cheque;
        $order->company_id = $this->company_id;
        $order->market_id = $this->market_id;
        $order->customer_id = $this->customer_id;
        $order->leasing_id = $this->leasing_id;
        $order->amount = $this->leasing + $this->prepaid;
        $order->cost = $this->cost;
        $order->profit = $this->profit;
        $order->leasing = $this->leasing;
        $order->bonus = $this->bonus;
        $order->status = $this->status;
        $order->prepaid = $this->prepaid;
        $order->description = $this->description;
        $order->starts_in = Utilities::toUnixDate($this->starts_in);
        $order->created_at = Utilities::toUnixDate($this->created_at);
        if (!$order->validate() || !$order->save())
            return false;

        $this->id = $order->id;
        $order->save();
        if ($order->status == OrderStatus::STATUS_ACTIVE) {
            $order->createChildren();
        }
        return true;
    }

    /**
     * @return Leasing|null
     */
    public function getLeasing_by_id()
    {
        return Leasing::findOne($this->leasing_id);
    }

    /**
     * @param $id
     * @return Product|null
     */
    public function getProduct($id)
    {
        $product = Product::findOne($id);
        if ($product == null)
            $product = new Product();
        return $product;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer()
    {
        return Customer::findOne($this->customer_id);
    }

    public function setByApi($order)
    {
        if (!isset($order['leasings']) || !is_array($order['leasings']))
            $product['leasings'] = [];
        $this->company_id = Yii::$app->user->identity->company_id;
        $this->market_id = Yii::$app->user->identity->market_id;
        $this->customer_id = $order['customer_id'] . '';
        $this->customer_id = $order['customer_id'] . '';
        $this->leasing_id = $order['leasing_id'] . '';
        $this->amount = $order['amount'];
        $this->cost = $order['cost'];
        $this->user_id = $order['user_id'];
        $this->prepaid = $order['prepaid'];
        $this->remote_id = $order['remote_id'];
        $this->starts_in = $order['starts_in'];
        $this->created_at = $order['created_at'];
        $this->status = $order['status'];
    }
}
