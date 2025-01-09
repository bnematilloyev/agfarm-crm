<?php


namespace merchant\models\forms;


use common\helpers\TelegramHelper;
use common\helpers\Utilities;
use common\models\constants\CustomerStatus;
use common\models\constants\OrderStatus;
use common\models\constants\PaymentType;
use common\models\Customer;
use common\models\CustomerCard;
use common\models\CustomerPassport;
use common\models\Divest;
use common\models\Expense;
use common\models\Invest;
use common\models\Investor;
use common\models\Order;
use common\models\OrderInvestor;
use common\models\OrderItem;
use common\models\OrderItemAwait;
use common\models\RequestExcel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ExcelForm extends Model
{
    public const FIRST_DAY = 1616612400;
    public const ONE_DAY = 24 * 60 * 60;
    public $file;
    private $cell_rows;
    private $first_day;
    private $last_day;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'xls, xlsx'],
            [['file'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Excel fayl'
        ];
    }

    public function reportFinancial()
    {
        $this->make_rows();
        $header = [];
        $header[] = "Sana";
        $investors = Investor::find()->orderBy(['id' => SORT_ASC])->all();
        foreach ($investors as $investor) {
            /** @var Investor $investor */
            $header[] = $investor->full_name . " invest";
            $header[] = $investor->full_name . " divest";
            $header[] = $investor->full_name . " rassrochkalar";
        }
        $header[] = "Umumiy invest";
        $header[] = "Umumiy divest";
        $header[] = "Umumiy rassrochkalar";
        $length = count($header);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $row = 1;
        for ($i = 0; $i < $length; $i++) {
//            $sheet->getColumnDimension($this->getCellName($i) . $row)->setAutoSize(true);
            $sheet->setCellValue($this->getCellName($i) . $row, $header[$i]);
        }
        $row = 2;
        $day = self::FIRST_DAY;
        $last_day = time();
        while ($day < $last_day) {
            $orders = Order::find()->where(['between', 'created_at', $day, $day + self::ONE_DAY - 1])->select('id')->asArray()->column();
            $sheet->setCellValue('A' . $row, date('d.m.Y', $day));
            $col = 1;
            $total_invest_sum = 0;
            $total_divest_sum = 0;
            $total_order_sum = 0;
            foreach ($investors as $investor) {
                /** @var Investor $investor */
                $invest_sum = Invest::find()->where(['and', ['investor_id' => $investor->id], ['between', 'created_at', $day, $day + self::ONE_DAY - 1]])->sum('amount_uzs');
                $sheet->setCellValue($this->getCellName($col) . $row, (string)Utilities::print_format($invest_sum));
                $col++;

                $divest_sum = Divest::find()->where(['and', ['investor_id' => $investor->id], ['between', 'created_at', $day, $day + self::ONE_DAY - 1]])->sum('amount_uzs');
                $sheet->setCellValue($this->getCellName($col) . $row, (string)Utilities::print_format($divest_sum));
                $col++;

                $order_sum = OrderInvestor::find()->where(['and', ['in', 'order_id', $orders], ['investor_id' => $investor->id]])->sum('amount');
                $sheet->setCellValue($this->getCellName($col) . $row, (string)Utilities::print_format($order_sum));
                $col++;

                $total_invest_sum += $invest_sum;
                $total_divest_sum += $divest_sum;
                $total_order_sum += $order_sum;
            }
            $sheet->setCellValue($this->getCellName($col) . $row, (string)Utilities::print_format($total_invest_sum));
            $col++;
            $sheet->setCellValue($this->getCellName($col) . $row, (string)Utilities::print_format($total_divest_sum));
            $col++;
            $sheet->setCellValue($this->getCellName($col) . $row, (string)Utilities::print_format($total_order_sum));
            $day += self::ONE_DAY;
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $name = "Report-" . time() . ".xlsx";
        $new_fileName = Yii::getAlias('@assets/excel/report/') . $name;
        $writer->save($new_fileName);
        $document = 'https://assets.abrand.uz/excel/report/' . $name;
        $telegram = new TelegramHelper(false);
        $telegram->sendMessage("  Excel so'rovingniz tayyor boldi \r\n" . $document);


    }

    private function make_rows()
    {
        $this->cell_rows = [];
        $cells = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < 26; $i++)
            $this->cell_rows[] = $cells[$i];
        for ($i = 0; $i < 26; $i++)
            for ($j = 0; $j < 26; $j++) {
                $this->cell_rows[] = $cells[$i] . $cells[$j];
            }
    }

    public function getCellName($number)
    {
        return $this->cell_rows[$number];
    }

    public function reportFinancialSimple()
    {
        $this->make_rows();
        $header = [];
        $header[] = "Sana";
        $investors = Investor::find()->orderBy(['id' => SORT_ASC])->all();
        foreach ($investors as $investor) {
            /** @var Investor $investor */
            $header[] = $investor->full_name . " rassrochkalar";
        }
        $header[] = "Umumiy rassrochkalar";
        $length = count($header);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $row = 1;
        for ($i = 0; $i < $length; $i++) {
            $sheet->setCellValue($this->getCellName($i) . $row, $header[$i]);
        }
        $row = 2;
        $day = self::FIRST_DAY;
        $last_day = time();
        while ($day < $last_day) {
            $orders = Order::find()->where(['between', 'created_at', $day, $day + self::ONE_DAY - 1])->select('id')->asArray()->column();
            $sheet->setCellValue('A' . $row, date('d.m.Y', $day));
            $col = 1;
            $total_order_sum = 0;
            foreach ($investors as $investor) {
                /** @var Investor $investor */
                $order_sum = OrderInvestor::find()->where(['and', ['in', 'order_id', $orders], ['investor_id' => $investor->id]])->sum('amount');
                $sheet->setCellValue($this->getCellName($col) . $row, $order_sum);
                $col++;

                $total_order_sum += $order_sum;
            }
            $sheet->setCellValue($this->getCellName($col) . $row, $total_order_sum);
            $day += self::ONE_DAY;
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $name = "Simple-Report-" . time() . ".xlsx";
        $new_fileName = Yii::getAlias('@assets/excel/report/') . $name;
        $writer->save($new_fileName);
        $document = 'https://assets.abrand.uz/excel/report/' . $name;
        $telegram = new TelegramHelper(false);
        $telegram->sendMessage("  Excel so'rovingniz tayyor boldi \r\n" . $document);


    }


    /**
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function import_leasing()
    {
        $objPHPExcel = $this->uploader();

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $user = \Yii::$app->user->identity;
        for ($row = 2; $row <= $highestRow;) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . 'R' . $row, NULL, TRUE, FALSE);
            $order = new Order();
            $order->created_at = Utilities::toUnixDate($rowData[0][0] . '');
            $order->remote_id = $rowData[0][1] . '';
            $order->company_id = $user->company_id;
            $order->market_id = intval($rowData[0][2]);
            $order->customer_id = intval($rowData[0][3]);
            if (!$order->customer_id)
                continue;
            $order->description = $rowData[0][4];
            $order->prepaid = doubleval($rowData[0][5]);
            $order->leasing = doubleval($rowData[0][6]);
            $order->cost = doubleval($rowData[0][9]);
            $order->profit = doubleval($rowData[0][10]);
            $order->user_id = $order->market->userOne->id;
            $order->starts_in = Utilities::toUnixDate($rowData[0][14] . '.' . $rowData[0][15] . '.2021');
            $next_row = $row + 1;
            $next_rowData = $sheet->rangeToArray('A' . $next_row . ':' . 'R' . $next_row, NULL, TRUE, FALSE);
            while (intval($next_rowData[0][3]) == $order->customer_id) {
                $order->description .= doubleval($next_rowData[0][4]);
                $order->prepaid += doubleval($next_rowData[0][5]);
                $order->leasing += doubleval($next_rowData[0][6]);
                $order->cost += doubleval($next_rowData[0][9]);
                $order->profit += doubleval($next_rowData[0][10]);
                $next_row = $next_row + 1;
                $next_rowData = $sheet->rangeToArray('A' . $next_row . ':' . 'R' . $next_row, NULL, TRUE, FALSE);
            }
            $order->amount = $order->prepaid + $order->leasing;
            $order->leasing_id = 8;
            $order->bonus = 0;
            $order->status = OrderStatus::STATUS_ACTIVE;
            $order->save();
            $order->createChildren();
            $row = $next_row;
        }
    }

    /**
     * @return \PHPExcel
     * @throws \PHPExcel_Reader_Exception
     */
    public function uploader()
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        $inputFile = 'uploads/import/' . $this->file->baseName . time() . '.' . $this->file->extension;
        if ($this->file) {
            $this->file->saveAs($inputFile);
        }
        try {
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);
        } catch (Exception $e) {
            die('Error');
        }
        return $objPHPExcel;
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_customer()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $row = 1;
        for ($i = 0; $i < 10; $i++) {
            if ($i == 1) continue;
            $sheet->getColumnDimension(chr(65 + $i))->setAutoSize(true);
        }
        $sheet->getColumnDimension('B')->setWidth(17);

        $sheet->setCellValue('A' . $row, 'ID');
        $sheet->setCellValue('B' . $row, 'JShShR');
        $sheet->setCellValue('C' . $row, 'F.I.Sh');
        $sheet->setCellValue('D' . $row, 'Viloyat');
        $sheet->setCellValue('E' . $row, 'Shahar');
        $sheet->setCellValue('F' . $row, 'Tug\'ilgan sanasi');
        $sheet->setCellValue('G' . $row, 'Telefon raqami');
        $sheet->setCellValue('H' . $row, 'Telefon raqami q');
        $sheet->setCellValue('I' . $row, 'Yaratilgan vaqti');
        $sheet->setCellValue('J' . $row, 'Holati');
        $row = 2;
        $customers = Customer::find()->orderBy(['id' => SORT_ASC])->all();
        /** @var Customer $customers */
        foreach ($customers as $customer) {
            $sheet->getRowDimension($row)->setRowHeight(20);
            /**
             * @var $customer Customer
             */
            $pin = $customer->pin;
            $sheet->setCellValue('A' . $row, $customer->id);
            $sheet->setCellValue('B' . $row, $pin);
            $sheet->setCellValue('C' . $row, $customer->full_name);
            $sheet->setCellValue('D' . $row, $customer->region->name);
            $sheet->setCellValue('E' . $row, $customer->city->name);
            $sheet->setCellValue('F' . $row, date("d.m.Y", $customer->birth_date));
            $sheet->setCellValue('G' . $row, (string)$customer->phone);
            $sheet->setCellValue('H' . $row, (string)$customer->extra_phone);
            $sheet->setCellValue('I' . $row, date("d.m.Y", $customer->created_at));
            $sheet->setCellValue('J' . $row, CustomerStatus::getString(\Yii::t('app', $customer->status)));
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('export/customer/Export.xlsx');
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_customer_with_saldo($filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        $sheet->setCellValue('A' . $row, 'Asaxiy ID');
        $sheet->setCellValue('B' . $row, 'JShShIR');
        $sheet->setCellValue('C' . $row, 'Passport');
        $sheet->setCellValue('D' . $row, 'F.I.Sh');
        $sheet->setCellValue('E' . $row, 'Qarzdorligi');
        $sheet->setCellValue('F' . $row, 'Tug\'ilgan sanasi');
        $sheet->setCellValue('G' . $row, 'Telefon raqami');
        $row = 2;
        $customers = Customer::find()->where(['status' => CustomerStatus::STATUS_PREMIUM_MEMBER])->orderBy(['id' => SORT_ASC])->all();
        /** @var Customer $customers */
        foreach ($customers as $customer) {
            $sheet->getRowDimension($row)->setRowHeight(20);
            /**
             * @var $customer Customer
             */
            $pin = $customer->pin;
            $sheet->setCellValue('A' . $row, $customer->id);
            $sheet->setCellValue('B' . $row, $pin);
            $sheet->setCellValue('C' . $row, $customer->passport);
            $sheet->setCellValue('D' . $row, $customer->full_name);
            $sheet->setCellValue('E' . $row, $customer->saldo);
            $sheet->setCellValue('F' . $row, date("d.m.Y", $customer->birth_date));
            $sheet->setCellValue('G' . $row, (string)$customer->phone);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
    }

    /**
     * @param $filename
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_customer_simple($filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $row = 1;
        $sheet->setCellValue('A' . $row, 'Ism');
        $sheet->setCellValue('B' . $row, 'Familya');
        $sheet->setCellValue('C' . $row, 'Otasining ismi');
        $sheet->setCellValue('D' . $row, 'Passport');
        $row = 2;
        $customers = Customer::find()->orderBy(['id' => SORT_ASC])->all();
        /** @var Customer $customers */
        foreach ($customers as $customer) {
            /**
             * @var $customer Customer
             */
            $passport = CustomerPassport::findOne(['customer_id' => $customer->id]);
            if ($passport == null)
                continue;
            $sheet->setCellValue('A' . $row, $customer->first_name);
            $sheet->setCellValue('B' . $row, $customer->last_name);
            $sheet->setCellValue('C' . $row, $customer->middle_name);
            $sheet->setCellValue('D' . $row, (string)($passport->passport_seria . $passport->passport_number));
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
    }

    /**
     * @param $filename
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_customer_cards($filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $row = 1;
        $sheet->setCellValue('A' . $row, 'HOLDER');
        $sheet->setCellValue('B' . $row, 'PAN');
        $sheet->setCellValue('C' . $row, 'TOKEN');
        $row = 2;
        $customer_cards = CustomerCard::find()->orderBy(['id' => SORT_ASC])->all();
        /** @var CustomerCard $customer_cards */
        foreach ($customer_cards as $customer_card) {
            /**
             * @var $customer_card CustomerCard
             */
            $customer = Customer::findOne($customer_card->customer_id);
            if ($customer_card->holder[0] !== "8" || $customer_card->myuzkard_id != null || $customer_card->card_token == null || $customer == null)
                continue;

            $holder = $customer->full_name;
            $sheet->setCellValue('A' . $row, $holder);
            $sheet->setCellValue('B' . $row, (string)$customer_card->holder);
            $sheet->setCellValue('C' . $row, $customer_card->card_token);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
    }

    /**
     * @param string $fileName
     * @param null $ids
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_transaction($fileName = 'Tranzaksiyalar.xlsx', $status = null, $is_card = -1, $ids = null, $type, $is_web = false)
    {


        if ($ids == null || !is_array($ids) || count($ids) < 1)
            $transactions = OrderItemAwait::findActive()->andWhere(['>', 'response', 100]);
        else {
            $transactions = OrderItemAwait::findActive()
                ->andWhere(['and', ['>', 'response', 100], ['in', 'id', $ids]]);
        }
        if ($type == "UNIRED") {
            $transactions = $transactions->andWhere(['ilike', 'text', "UNIRED"]);
        } else if ($type == "PAYMO") {
            $transactions = $transactions->andWhere(['not ilike', 'text', "UNIRED"]);
        }


        $ids = [];
        $sql = "";
        if (in_array($status, [40, 50, 60]) && $status != null) {
            switch ($status) {
                case 40:
                    $sql = "select oia.id from order_item inner join order_item_await oia on order_item.id = oia.item_id  where oia.responsed_at-order_item.starts_in < 0 and oia.response > 0";
                    break;
                case 50:
                    $sql = "select oia.id from order_item inner join order_item_await oia on order_item.id = oia.item_id  where oia.responsed_at-order_item.starts_in >= 0 and oia.responsed_at-order_item.starts_in < 86400 and oia.response > 0";
                    break;
                case 60:
                    $sql = "select oia.id from order_item inner join order_item_await oia on order_item.id = oia.item_id  where oia.responsed_at-order_item.starts_in >= 86400 and oia.response > 0";
                    break;
                default:
                    break;
            }
            $ids = \Yii::$app->db->createCommand($sql)->queryColumn();
        }
        if (intval($status) == 20) {
            $transactions = $transactions->andWhere(['not ilike', 'text', 'kassadan']);
        } else if (intval($status) == 30) {
            $transactions = $transactions->andWhere(['ilike', 'text', 'kassadan']);
        } else if (in_array($status, [40, 50, 60])) {
            $transactions = $transactions->andWhere(['in', 'id', $ids]);
        }
        $transactions = $transactions->orderBy(['id' => SORT_DESC]);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        for ($i = 0; $i < 8; $i++) {
            $sheet->getColumnDimension(chr(65 + $i))->setAutoSize(true);
        }
        $sheet->setCellValue('A' . $row, 'Rassrochka IDsi');
        $sheet->setCellValue('B' . $row, 'Tranzaksiya IDsi');
        $sheet->setCellValue('C' . $row, 'JShShR');
        $sheet->setCellValue('D' . $row, 'F.I.Sh');
        $sheet->setCellValue('E' . $row, 'Miqdori');
        $sheet->setCellValue('F' . $row, 'Sana');
        $sheet->setCellValue('G' . $row, 'Vaqt');
        $sheet->setCellValue('H' . $row, 'Kartasi');
        $row = 2;
        foreach ($transactions->each() as $transaction) {
            /**
             * @var $transaction OrderItemAwait
             */
            $sheet->setCellValue('A' . $row, 1);
            if (!isset($transaction->order)) continue;
            $sheet->setCellValue('A' . $row, $transaction->order_id);
            $sheet->setCellValue('B' . $row, $transaction->success_trans_id ?? '');
            $sheet->setCellValue('C' . $row, $transaction->order->customer->pin . ' ');
            $sheet->setCellValue('D' . $row, $transaction->order->customer->full_name ?? '');
            $sheet->setCellValue('E' . $row, $transaction->response);
            $sheet->setCellValue('F' . $row, date("d.m.Y", $transaction->responsed_at));
            $sheet->setCellValue('G' . $row, date("H:i:s", $transaction->responsed_at));
            if ($transaction->success_trans_id == null && !strpos($transaction->text, "UNIRED")) {
                $sheet->setCellValue('H' . $row, "Kassa");
            } else if ($transaction->is_uzcard == true) {
                $sheet->setCellValue('H' . $row, "UzCard");
            } else {
                $sheet->setCellValue('H' . $row, "Humo");
            }
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $new_fileName = 'uploads/transaction/' . $fileName;
        $writer->save($new_fileName);
        if (!$is_web && file_exists($new_fileName)) {
            $document = 'http://assets.crm.abrand.uz/uploads/transaction/' . $fileName;
            if ($this->sendToTelegram(array('text' => $document, 'chat_id' => '-1001234893931', 'parse_mode' => 'html')))
                return true;
        }
        return $is_web;
        return file_exists($new_fileName);
    }

    public function export_transaction_prepaid($fileName = 'Tranzaksiyalar.xlsx', $ids = null)
    {
        if ($ids == null || !is_array($ids) || count($ids) < 1)
            $transactions = Order::findActive()->orderBy(['created_at' => SORT_DESC])->all();
        else
            $transactions = Order::findActive()->andWhere(['in', 'id', $ids])->orderBy(['created_at' => SORT_DESC])->all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        for ($i = 0; $i < 6; $i++) {
            $sheet->getColumnDimension(chr(65 + $i))->setAutoSize(true);
        }
        $sheet->setCellValue('A' . $row, 'Buyurtma IDsi');
        $sheet->setCellValue('B' . $row, 'JShShR');
        $sheet->setCellValue('C' . $row, 'F.I.Sh');
        $sheet->setCellValue('D' . $row, 'Miqdori');
        $sheet->setCellValue('E' . $row, 'Sana');
        $sheet->setCellValue('F' . $row, 'Vaqt');
        $row = 2;
        /** @var Order $transaction */
        foreach ($transactions as $transaction) {

            $sheet->setCellValue('A' . $row, $transaction->id);
            $sheet->setCellValue('B' . $row, $transaction->customer->pin);
            $sheet->setCellValue('C' . $row, $transaction->customer->full_name);
            $sheet->setCellValue('D' . $row, $transaction->prepaid);
            $sheet->setCellValue('E' . $row, date("d.m.Y", $transaction->created_at));
            $sheet->setCellValue('F' . $row, date("H:i:s", $transaction->created_at));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $new_fileName = 'uploads/order/' . $fileName;
        $writer->save($new_fileName);
        return file_exists($new_fileName);
    }


    /**
     * @param string $fileName
     * @param null $ids
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_invest($fileName = 'Invests.xlsx', $ids = null)
    {
        if ($ids == null || !is_array($ids) || count($ids) < 1)
            $invests = Invest::findActive()->orderBy(['created_at' => SORT_DESC])->all();
        else
            $invests = Invest::findActive()->andWhere(['in', 'id', $ids])->orderBy(['created_at' => SORT_DESC])->all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        for ($i = 0; $i < 5; $i++) {
            $sheet->getColumnDimension(chr(65 + $i))->setAutoSize(true);
        }
        $sheet->setCellValue('A' . $row, 'Kompaniya IDsi');
        $sheet->setCellValue('B' . $row, 'Investor IDsi');
        $sheet->setCellValue('C' . $row, 'Miqdor UZSda');
        $sheet->setCellValue('D' . $row, 'Miqdor USDda');
        $sheet->setCellValue('E' . $row, 'Yaratilgan Vaqti');
        $row = 2;

        /** @var Invest $invest */
        foreach ($invests as $invest) {
            $sheet->setCellValue('A' . $row, $invest->company->name);
            $sheet->setCellValue('B' . $row, $invest->investor->full_name);
            $sheet->setCellValue('C' . $row, $invest->amount_uzs);
            $sheet->setCellValue('D' . $row, $invest->amount_usd);
            $sheet->setCellValue('E' . $row, date("d.m.y", $invest->created_at));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $new_fileName = 'uploads/order/' . $fileName;
        $writer->save($new_fileName);
        return file_exists($new_fileName);
    }

    /**
     * @param string $fileName
     * @param null $ids
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_divest($fileName = 'Divests.xlsx', $ids = null)
    {
        if ($ids == null || !is_array($ids) || count($ids) < 1)
            $invests = Divest::findActive()->orderBy(['created_at' => SORT_DESC])->all();
        else
            $invests = Divest::findActive()->andWhere(['in', 'id', $ids])->orderBy(['created_at' => SORT_DESC])->all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        for ($i = 0; $i < 5; $i++) {
            $sheet->getColumnDimension(chr(65 + $i))->setAutoSize(true);
        }
        $sheet->setCellValue('A' . $row, 'Kompaniya IDsi');
        $sheet->setCellValue('B' . $row, 'Investor IDsi');
        $sheet->setCellValue('C' . $row, 'Miqdor UZSda');
        $sheet->setCellValue('D' . $row, 'Miqdor USDda');
        $sheet->setCellValue('E' . $row, 'Yaratilgan Vaqti');
        $row = 2;

        /** @var Invest $invest */
        foreach ($invests as $invest) {
            $sheet->setCellValue('A' . $row, $invest->company->name);
            $sheet->setCellValue('B' . $row, $invest->investor->full_name);
            $sheet->setCellValue('C' . $row, $invest->amount_uzs);
            $sheet->setCellValue('D' . $row, $invest->amount_usd);
            $sheet->setCellValue('E' . $row, date("d.m.y", $invest->created_at));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $new_fileName = 'uploads/order/' . $fileName;
        $writer->save($new_fileName);
        return file_exists($new_fileName);
    }

    /**
     * @param string $fileName
     * @param null $ids
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_order($fileName = 'Rassrochkalar.xlsx', $ids = null)
    {

        if ($ids != null) {
            $orders = Order::findActive()->where(['in', 'id', $ids])->all();
        } else {
            $orders = Order::findActive()->all();
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        for ($i = 0; $i < 11; $i++) {
            $sheet->getColumnDimension(chr(65 + $i))->setAutoSize(true);
        }
        $sheet->setCellValue('A' . $row, 'Rassrochka IDsi');
        $sheet->setCellValue('B' . $row, 'Status');
        $sheet->setCellValue('C' . $row, 'Do\'kon IDsi');
        $sheet->setCellValue('D' . $row, 'F.I.Sh');
        $sheet->setCellValue('E' . $row, 'Rassrochka');
        $sheet->setCellValue('F' . $row, 'Saldo Balansi');
        $sheet->setCellValue('G' . $row, 'Keyingi to\'lov sanasi');
        $row = 2;

        /** @var Order $order */
        foreach ($orders as $order) {
            $sheet->setCellValue('A' . $row, $order->id);
            $sheet->setCellValue('B' . $row, OrderStatus::getString(\Yii::t('app', $order->status)));
            $sheet->setCellValue('C' . $row, $order->market->name);
            $sheet->setCellValue('D' . $row, $order->customer->full_name);
            $sheet->setCellValue('E' . $row, $order->leasing);
            $sheet->setCellValue('F' . $row, $order->getBalance());
            $sheet->setCellValue('G' . $row, date("d.m.y", $order->next_pay_date));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $new_fileName = 'uploads/order/' . $fileName;
        $writer->save($new_fileName);
        return file_exists($new_fileName);
    }

    public function import_transaction()
    {
        $objPHPExcel = $this->uploader();
        $sheet = $objPHPExcel->getSheet(0);
        $telegram = new TelegramHelper(false);
        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . 'K' . $row, NULL, FALSE, TRUE);
            $item_await = OrderItemAwait::findOne(['transaction_id' => $rowData[0][0]]);

            if ($item_await != null) {
                $telegram->sendMessage($rowData[0][0] . ' - tranzaksiya mavjud');
                $item_await->created_at = strtotime($rowData[0][10]);
                $item_await->save();
                continue;
            }
//            $item_await = new OrderItemAwait();
//            $item_await->findOrder(intval($rowData[0][1]));
//            if ($item_await->order_id == null) {
//                $telegram->sendMessage('paymo id = ' . $rowData[0][1] . ' bo`lgan rassrochka topilmadi');
//                continue;
//            }
//            $item = new OrderItem();
//            $item->order_id = $item_await->order_id;
//            $item = $item->first_waiting;
//            if ($item == null) {
//                $telegram->sendMessage('paymo id = ' . $rowData[0][1] . ' bo`lgan rassrochkaning  oylik to`lovi topilmadi');
//                continue;
//            }
//
//            $item_await->item_id = $item->id;
//            $item_await->transaction_id = intval($rowData[0][0]);
//            $item_await->success_trans_id = $item_await->transaction_id;
//            $item_await->requested_at = Utilities::toUnixDate($rowData[0][4]);
//            $item_await->responsed_at = $item_await->requested_at;
//            $item_await->request = $rowData[0][2];
//            $item_await->response = $rowData[0][3];
//            $item_await->text = $item_await->response . " so`m paymodan import qilindi";
//            if ($item_await->save()) {
//                $item->doBest($item_await->response);
//            } else {
//                $telegram->sendMessage('Tranzaksiyani saqlay olmadi xatolik : ' . json_encode($item_await->firstErrors));
//            }
        }
        return true;
    }

    /**
     * @param string $fileName
     * @param null $ids
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export_debit_customer($fileName)
    {

        $orders = Order::findActive()->all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        for ($i = 0; $i < 10; $i++) {
            $sheet->getColumnDimension(chr(65 + $i))->setAutoSize(true);
        }
        $sheet->setCellValue('A' . $row, 'Customer IDsi');
        $sheet->setCellValue('B' . $row, 'JSHSHIR');
        $sheet->setCellValue('C' . $row, 'FISH');
        $sheet->setCellValue('D' . $row, 'Telefon raqami');
        $sheet->setCellValue('E' . $row, 'Qo\'shimcha telefon raqami');
        $sheet->setCellValue('F' . $row, 'Passport (seria,raqami)');
        $sheet->setCellValue('G' . $row, 'Karta Pani');
        $sheet->setCellValue('H' . $row, 'Karta Tokeni');
        $sheet->setCellValue('I' . $row, 'Karta amal qilish muddati');
        $sheet->setCellValue('J' . $row, 'Kechiktirilgan kunlar');
        $row = 2;

        /** @var Order $order */
        foreach ($orders as $order) {
            if ($order->overdue_days < 20) continue;
            /** @var Customer $customer */
            $customer = $order->customer;
            /** @var CustomerCard $card */
            $card = $customer->customer_cards;
            if (count($card) > 0) $card = $card[0];
            $sheet->setCellValue('A' . $row, $customer->id);
            $sheet->setCellValue('B' . $row, $customer->pin . "");
            $sheet->setCellValue('C' . $row, $customer->full_name . "");
            $sheet->setCellValue('D' . $row, $customer->phone);
            if ($customer->extra_phone)
                $sheet->setCellValue('E' . $row, $customer->extra_phone);
            $sheet->setCellValue('F' . $row, $customer->passport);
            if (isset($card->pan))
                $sheet->setCellValue('G' . $row, $card->pan);
            if (isset($card->card_token))
                $sheet->setCellValue('H' . $row, $card->card_token);
            if (isset($card->cv))
                $sheet->setCellValue('I' . $row, $card->cv);
            $sheet->setCellValue('J' . $row, $order->overdue_days);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $new_fileName = 'uploads/order/' . $fileName;
        $writer->save($new_fileName);
        return file_exists($new_fileName);
    }

    /**
     * @param $fileName
     * @param $sql
     */
    public function request_export($fileName, $sql, $type)
    {
        $new_request = new RequestExcel();
        $new_request->company_id = Yii::$app->user->identity->company_id;
        $new_request->user_id = Yii::$app->user->identity->id;
        $new_request->type = $type;
        $new_request->file_name = $fileName;
        $new_request->sql = $sql;
        if (!$new_request->save()) {
            echo "<pre>";
            var_dump($new_request);
            die();
        } else {
            Yii::$app->session->setFlash('info', "So'rovingiz qabul qilindi tez fursatda tayyor bo`ladi va telegram orqali qabul qilasiz!");
        }
        return true;
    }


    /**
     * @param \common\models\RequestExcel $model
     * @param $is_run
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @throws \yii\db\Exception
     */
    public function all_order_to_tg(RequestExcel $model, $is_run)
    {
//        Alisher aka uchun
        if ($model == null || !$is_run) return false;
        $orders = Yii::$app->db->createCommand($model->sql)->queryAll();
        $this->make_rows();
        $header = [];
        $header[] = "Rassrochka IDsi";
        $header[] = "Yaratilgan sana";
        $header[] = "F.I.Sh";
        $header[] = "Jami summa";
        $header[] = "Boshlang'ich summa";
        $header[] = "Grafik boyicha jami";

        for ($i = 1; $i <= 12; $i++) {
            $header[] = $i . " tulov sanasi";
        }
        $header[] = "Tannarx";
        $investors = Investor::find()->orderBy(['id' => SORT_ASC])->all();
        foreach ($investors as $investor) {
            $header[] = $investor->full_name;
        }
        $length = count($header);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $row = 1;
        for ($i = 0; $i < $length; $i++) {
            $sheet->setCellValue($this->getCellName($i) . $row, $header[$i]);
        }
        $row = 2;
        foreach ($orders as $order) {
            $order = Order::findOne($order['id']);
            if ($order->status < OrderStatus::STATUS_ACTIVE) continue;
            $col = 0;
            $sheet->setCellValue($this->getCellName($col++) . $row, $order->id);
            $sheet->setCellValue($this->getCellName($col++) . $row, date('d.m.Y', $order->created_at));
            $sheet->setCellValue($this->getCellName($col++) . $row, $order->customer->full_name ?? '');
            $sheet->setCellValue($this->getCellName($col++) . $row, $order->amount);
            $sheet->setCellValue($this->getCellName($col++) . $row, $order->prepaid);
            $sheet->setCellValue($this->getCellName($col++) . $row, $order->leasing);
            $order_items = OrderItem::find()->andWhere(['order_id' => $order->id])->orderBy('starts_in')->all();
            /** @var OrderItem $item */
            foreach ($order_items as $item) {
                $sheet->setCellValue($this->getCellName($col++) . $row, date('d.m.Y', $item->starts_in));
            }
            for ($i = min(count($order_items), 12); $i < 12; $i++) {
                $sheet->setCellValue($this->getCellName($col++) . $row, " ");
            }
            $sheet->setCellValue($this->getCellName($col++) . $row, $order->cost);
            $order_investor = OrderInvestor::find()->andWhere(['order_id' => $order->id]);
            $investors_id = $order_investor->select('investor_id')->asArray()->column();
            foreach ($investors as $investor) {
                if (in_array($investor->id, $investors_id)) {
                    $sheet->setCellValue($this->getCellName($col++) . $row, $order_investor->andWhere(['investor_id' => $investor->id])->sum('amount'));
                } else {
                    $sheet->setCellValue($this->getCellName($col++) . $row, " ");
                }
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $new_fileName = Yii::getAlias('@assets/excel/order_excel/') . $model->file_name;
        $writer->save($new_fileName);
//        if (file_exists('assets/excel/order/' . $model->file_name)) {
        $document = 'https://assets.abrand.uz/excel/order_excel/' . $model->file_name;
        $telegram = new TelegramHelper(false);
        $user_full_name = \common\models\User::findOne($model->user_id)->full_name;
        $telegram->sendMessage($user_full_name . "  Excel so'rovingniz tayyor boldi \r\n" . $document);
        $telegram->setChatId(-1001234893931);
        $telegram->sendMessage($user_full_name . "  Excel so'rovingniz tayyor boldi \r\n" . $document);

//        }
        return file_exists($model->file_name);
    }

    public function transaction_to_tg(RequestExcel $model, $is_run = false)
    {
        if ($model == null || !$is_run) return false;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        for ($i = 0; $i < 8; $i++) {
            $sheet->getColumnDimension(chr(65 + $i))->setAutoSize(true);
        }
        $sheet->setCellValue('A' . $row, 'Rassrochka IDsi');
        $sheet->setCellValue('B' . $row, 'Tranzaksiya IDsi');
        $sheet->setCellValue('C' . $row, 'JShShR');
        $sheet->setCellValue('D' . $row, 'F.I.Sh');
        $sheet->setCellValue('E' . $row, 'Miqdori');
        $sheet->setCellValue('F' . $row, 'Sana');
        $sheet->setCellValue('G' . $row, 'Vaqt');
        $sheet->setCellValue('H' . $row, 'To\'lov');
        $row = 2;
        $transactions = OrderItemAwait::find()->andWhere(['>', 'response', 0])->orderBy(['id' => SORT_DESC]);
        foreach ($transactions->each() as $transaction) {
            /**
             * @var $transaction OrderItemAwait
             */
            $order = $transaction->order;
            $customer = $order->customer;
            if ($customer == null || $order == null) continue;
            $sheet->setCellValue('A' . $row, $order->id);
            $sheet->setCellValue('B' . $row, $transaction->success_trans_id ?? -1);
            $sheet->setCellValue('C' . $row, $customer->pin . " ");
            $sheet->setCellValue('D' . $row, $customer->full_name . " ");
            $sheet->setCellValue('E' . $row, $transaction->response);
            $sheet->setCellValue('F' . $row, date("d.m.Y", $transaction->responsed_at ?? 0));
            $sheet->setCellValue('G' . $row, date("H:i:s", $transaction->responsed_at ?? 0));
            $sheet->setCellValue('H' . $row, PaymentType::getString($transaction->payment_type ?? -1));
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $new_fileName = Yii::getAlias('@assets/excel/transaction/') . $model->file_name;
        $writer->save($new_fileName);
//        if (file_exists('assets/excel/transaction/' . $model->file_name)) {
        $document = 'https://assets.abrand.uz/excel/transaction/' . $model->file_name;
        $telegram = new TelegramHelper(false);
        $user_full_name = \common\models\User::findOne($model->user_id)->full_name;
//        $telegram->sendMessage($user_full_name . "  Excel so'rovingniz tayyor boldi \r\n" . $document);
        $telegram->setChatId(-1001234893931);
        $telegram->sendMessage($user_full_name . "  Excel so'rovingniz tayyor boldi \r\n" . $document);
//        }
        return file_exists($model->file_name);
    }

    public function expense_to_tg(RequestExcel $model, $is_run = false)
    {
        if ($model == null || !$is_run) return false;
        $expenses = Yii::$app->db->createCommand($model->sql)->queryAll();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        for ($i = 0; $i < 8; $i++) {
            $sheet->getColumnDimension(chr(65 + $i))->setAutoSize(true);
        }
        $sheet->setCellValue('A' . $row, 'ID');
        $sheet->setCellValue('B' . $row, 'Company ID');
        $sheet->setCellValue('C' . $row, 'Market ID');
        $sheet->setCellValue('D' . $row, 'Name');
        $sheet->setCellValue('E' . $row, 'Amount');
        $sheet->setCellValue('F' . $row, 'Description');
        $sheet->setCellValue('G' . $row, 'Created_at');
        $sheet->setCellValue('H' . $row, 'Tag ID');
        $sheet->setCellValue('I' . $row, 'Is Invest');
        $row = 2;
        foreach ($expenses as $expense) {
            /**
             * @var $expense \common\models\Expense
             */
            $expense = Expense::findOne(intval($expense['id']));
            if ($expense == null) continue;
            $sheet->setCellValue('A' . $row, $expense->id ?? -1);
            $sheet->setCellValue('B' . $row, $expense->company->name ?? '');
            $sheet->setCellValue('C' . $row, $expense->market->name ?? '');
            $sheet->setCellValue('D' . $row, $expense->name ?? '');
            $sheet->setCellValue('E' . $row, $expense->amount ?? 0);
            $sheet->setCellValue('F' . $row, $expense->description ?? '');
            $sheet->setCellValue('G' . $row, date("d . m . Y", $expense->created_at) ?? '01.01.2021');
            $sheet->setCellValue('H' . $row, $expense->tag_id ?? -1);
            $sheet->setCellValue('I' . $row, intval($expense->is_invest) ?? 0);

            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $new_fileName = Yii::getAlias('@assets/excel/expense/') . $model->file_name;
        $writer->save($new_fileName);
//        if (file_exists('assets/excel/transaction/' . $model->file_name)) {
        $document = 'https://assets.abrand.uz/excel/expense/' . $model->file_name;
        $telegram = new TelegramHelper(false);
        $user_full_name = \common\models\User::findOne($model->user_id)->full_name;
        $telegram->sendMessage($user_full_name . "  Excel so'rovingniz tayyor boldi \r\n" . $document);
        $telegram->setChatId(-1001234893931);
        $telegram->sendMessage($user_full_name . "  Excel so'rovingniz tayyor boldi \r\n" . $document);
//        }
        return file_exists($model->file_name);
    }

    /**
     * @param \common\models\RequestExcel $model
     * @param $is_run
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @throws \yii\db\Exception
     */
    public function all_order_document_to_tg(RequestExcel $model, $is_run)
    {
        if ($model == null || !$is_run) return false;
        $orders = Yii::$app->db->createCommand($model->sql)->queryAll();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        for ($i = 0; $i < 14; $i++) {
            $sheet->getColumnDimension(chr(65 + $i))->setAutoSize(true);
        }

        $sheet->setCellValue('A' . $row, 'Rassrochka IDsi');
        $sheet->setCellValue('B' . $row, 'Paymodagi IDsi');
        $sheet->setCellValue('C' . $row, 'Do\'kon IDsi');
        $sheet->setCellValue('D' . $row, 'F.I.Sh');
        $sheet->setCellValue('E' . $row, 'JShShIR');
        $sheet->setCellValue('F' . $row, 'Umumiy Rassrochkaga');
        $sheet->setCellValue('G' . $row, 'Oldindan to\'langan');
        $sheet->setCellValue('H' . $row, 'Rassrochka');
        $sheet->setCellValue('I' . $row, 'Tan narxi');
        $sheet->setCellValue('J' . $row, 'Yaratilgan sanasi');
        $sheet->setCellValue('K' . $row, 'Birinchi to\'lov sanasi');
        $sheet->setCellValue('L' . $row, 'Keyingi to\'lov sanasi');
        $sheet->setCellValue('M' . $row, 'Status');
        $row = 2;
        /** @var Order $order */
        foreach ($orders as $order) {
            $order = Order::findOne($order['id']);
            if ($order->status < OrderStatus::STATUS_ACTIVE) continue;
            $sheet->setCellValue('A' . $row, $order->id);
            $sheet->setCellValue('B' . $row, $order->remote_id ?? '');
            $sheet->setCellValue('C' . $row, $order->market->name ?? '');
            $sheet->setCellValue('D' . $row, $order->customer->full_name ?? '');
            if (isset($order->customer->pin))
                $sheet->setCellValue('E' . $row, $order->customer->pin . " ");
            $sheet->setCellValue('F' . $row, $order->amount);
            $sheet->setCellValue('G' . $row, $order->prepaid);
            $sheet->setCellValue('H' . $row, $order->leasing);
            $sheet->setCellValue('I' . $row, $order->cost);
            $sheet->setCellValue('J' . $row, date("d.m.y", $order->created_at));
            $sheet->setCellValue('K' . $row, date("d.m.y", $order->firstPayDate));
            $sheet->setCellValue('L' . $row, date("d.m.y", $order->next_pay_date));
            $sheet->setCellValue('M' . $row, OrderStatus::getString(\Yii::t('app', $order->status)));
            $row++;
        }


        $writer = new Xlsx($spreadsheet);
        $new_fileName = Yii::getAlias('@assets/excel/order_excel/') . $model->file_name;
        $writer->save($new_fileName);
        $document = 'https://assets.abrand.uz/excel/order_excel/' . $model->file_name;
        $telegram = new TelegramHelper(false);
        $user_full_name = \common\models\User::findOne($model->user_id)->full_name;
        $telegram->sendMessage($user_full_name . "  Excel so'rovingniz tayyor boldi (document)\r\n" . $document);
        $telegram->setChatId(-1001234893931);
        $telegram->sendMessage($user_full_name . "  Excel so'rovingniz tayyor boldi (document) \r\n" . $document);

//        }
        return file_exists($model->file_name);
    }

    /**
     * @param \common\models\RequestExcel $model
     * @param $is_run
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @throws \yii\db\Exception
     */
    public function all_order_investor_to_tg(RequestExcel $model, $is_run)
    {
//        Shahriddin aka uchun
        if ($model == null || !$is_run) return false;
        $this->make_rows();
        $header = [];
        $header[] = "Investitsiya turi";
        $header[] = "Rassrochka Idsi";
        $header[] = "Miqdor";
        $header[] = "Foyda";
        $header[] = "Necha % sizniki";
        $header[] = "Qaytib kelgan pul";
        $header[] = "Qaytib kelgan foyda";

        $investors = Investor::find()->orderBy(['id' => SORT_ASC])->all();

        $length = count($header);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $row = 1;
        for ($i = 0; $i < $length; $i++) {
            $sheet->setCellValue($this->getCellName($i) . $row, $header[$i]);
        }
        $row = 2;
        foreach ($investors as $investor) {
            $sheet->setCellValue($this->getCellName(1) . $row, $investor->full_name ?? '');

            $row++;
            $orders_investor = OrderInvestor::find()->andWhere(['investor_id' => $investor->id])->all();
            foreach ($orders_investor as $item) {
                $col = 0;
                /** @var OrderInvestor $item */
                if (!isset($item)) continue;
                $sheet->setCellValue($this->getCellName($col++) . $row, ($item->re_invest ?? 0) ? 0 : 1);
                $sheet->setCellValue($this->getCellName($col++) . $row, $item->order_id ?? -1);
                $sheet->setCellValue($this->getCellName($col++) . $row, $item->amount ?? 0);
                $sheet->setCellValue($this->getCellName($col++) . $row, $item->profit ?? 0);
                $sheet->setCellValue($this->getCellName($col++) . $row, substr($item->percent ?? "111111111", 0, 6) . ' %');
                $sheet->setCellValue($this->getCellName($col++) . $row, $item->current_paid ?? 0);
                $sheet->setCellValue($this->getCellName($col++) . $row, $item->current_profit ?? 0);
                $row++;
            }
        }

        $writer = new Xlsx($spreadsheet);
        $new_fileName = Yii::getAlias('@assets/excel/order_investor/') . $model->file_name;
        $writer->save($new_fileName);
//        if (file_exists('assets/excel/order/' . $model->file_name)) {
        $document = 'https://assets.abrand.uz/excel/order_investor/' . $model->file_name;
        $telegram = new TelegramHelper(false);
        $user_full_name = \common\models\User::findOne($model->user_id)->full_name;
        $telegram->sendMessage($user_full_name . "  Excel so'rovingniz tayyor boldi \r\n" . $document);
        $telegram->setChatId(-1001234893931);
        $telegram->sendMessage($user_full_name . "  Excel so'rovingniz tayyor boldi \r\n" . $document);

//        }
        return file_exists($model->file_name);
    }
}