
# Laravel JNT

Simple JNT api wrapper untuk Laravel


## Installation 

Install melalui composer

Minimal versi Laravel 7.x ke atas

```bash 
  composer require aditia/laravel-jnt
```

Masukkan kredensial api JNT Anda pada file .env

```env
JNT_API_USERNAME= #username Anda
JNT_API_KEY= #api key Anda
JNT_API_URL= #api url JNT yang digunakan
```

## Usage

### Tracking Nomor Resi

```php
use Nextlogique\Jnt\Facades\Jnt;

$noResi = 'XXXXXXXXXXX';

$response = Jnt::tracking($noResi);

$response->cnote; // Object cnote
$response->cnote->cnote_pod_date;

$response->detail; // Object detail
$response->detail->cnote_origin;

foreach ($response->history as $history) {
    $history->date;
    $history->desc;
}
```

### Generate Nomor Resi

```php
use Nextlogique\Jnt\Facades\Jnt;
use Nextlogique\Jnt\Http\Requests\GenerateAwbRequest;

$body = new GenerateAwbRequest([
    'OLSHOP_BRANCH'          => 'CGK000',
    'OLSHOP_CUST'            => '10950700',
    'OLSHOP_ORDERID'         => '23455563348357',
    'OLSHOP_SHIPPER_NAME'    => 'ADIT',
    'OLSHOP_SHIPPER_ADDR1'   => 'AKARTA NO 44',
    'OLSHOP_SHIPPER_ADDR2'   => 'KALIBATA',
    'OLSHOP_SHIPPER_ADDR3'   => 'KALIBATA',
    'OLSHOP_SHIPPER_CITY'    => 'JAKARTA',
    'OLSHOP_SHIPPER_REGION'  => 'JAKARTA',
    'OLSHOP_SHIPPER_ZIP'     => '12345',
    'OLSHOP_SHIPPER_PHONE'   => '+62898XXXXXX',
    'OLSHOP_RECEIVER_NAME'   => 'MURTI',
    'OLSHOP_RECEIVER_ADDR1'  => 'BANDUNG NO 12',
    'OLSHOP_RECEIVER_ADDR2'  => 'CIBIRU',
    'OLSHOP_RECEIVER_ADDR3'  => 'BANDUNG',
    'OLSHOP_RECEIVER_CITY'   => 'BANDUNG',
    'OLSHOP_RECEIVER_REGION' => 'JAWA BARAT',
    'OLSHOP_RECEIVER_ZIP'    => '12345',
    'OLSHOP_RECEIVER_PHONE'  => '+628578XXXXXX',
    'OLSHOP_QTY'             => 1,
    'OLSHOP_WEIGHT'          => 1,
    'OLSHOP_GOODSDESC'       => 'TEST',
    'OLSHOP_GOODSVALUE'      => 1000,
    'OLSHOP_GOODSTYPE'       => 1,
    'OLSHOP_INST'            => 'TEST',
    'OLSHOP_INS_FLAG'        => 'N',
    'OLSHOP_ORIG'            => 'CGK10000',
    'OLSHOP_DEST'            => 'BDO10000',
    'OLSHOP_SERVICE'         => 'REG',
    'OLSHOP_COD_FLAG'        => 'N',
    'OLSHOP_COD_AMOUNT'      => 0,
])

$response = Jnt::generateAwb($body);

$response->awb->airwaybill; // nomor resi
```

### Cek Ongkir

```php
use Nextlogique\Jnt\Facades\Jnt;
use Nextlogique\Jnt\Http\Requests\TariffRequest;

$body = new TariffRequest([
    'from'   => 'CGK10000',
    'thru'   => 'BDO10000',
    'weight' => 1, // dalam kilogram
]);

$response = Jnt::tariff($body);

foreach ($response->price as $price) {
    $price->origin_name;
    $price->destination_name;
    $price->service_display;
    $price->service_code;
    $price->goods_type;
    $price->currency;
    $price->price;
    $price->etd_from;
    $price->etd_thru;
    $price->times;
}
```

### Stock Nomor Resi

```php
use Nextlogique\Jnt\Facades\Jnt;
use Nextlogique\Jnt\Http\Requests\StockAwbRequest;

$body = new StockAwbRequest([
    'BRANCH'      => 'AMI000',
    'CUST_ID'     => '80089400',
    'CREATE_BY'   => 'IT',
    'REQUEST_AWB' => 5,
    'REQUEST_BY'  => 'TESTING',
    'REQUEST_NO'  => '006/AWB/LWA965',
    'REASON'      => 'FLASH SALE',
]);

$response = Jnt::stockAwb($body);

foreach ($response->awb as $awb) {
    $awb->airwaybill;
}
```

### Pickup or Cashless

```php
// TO-DO
```
