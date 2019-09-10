<?
require_once __DIR__ . '/vendor/autoload.php';
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require('SuggestClient.php');
use Dadata\SuggestClient as SuggestClient;

function num2str($num) {
  $nul='ноль';
  $ten=array(
    array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
    array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
  );
  $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
  $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
  $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
  $unit=array( // Units
    array('копейка' ,'копейки' ,'копеек',	 1),
    array('рубль'   ,'рубля'   ,'рублей'    ,0),
    array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
    array('миллион' ,'миллиона','миллионов' ,0),
    array('миллиард','милиарда','миллиардов',0),
  );
  //
  list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
  $out = array();
  if (intval($rub)>0) {
    foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
      if (!intval($v)) continue;
      $uk = sizeof($unit)-$uk-1; // unit key
      $gender = $unit[$uk][3];
      list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
      // mega-logic
      $out[] = $hundred[$i1]; # 1xx-9xx
      if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
      else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
      // units without rub & kop
      if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
    } //foreach
  }
  else $out[] = $nul;
  $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
  $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
  return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

function morph($n, $f1, $f2, $f5) {
  $n = abs(intval($n)) % 100;
  if ($n>10 && $n<20) return $f5;
  $n = $n % 10;
  if ($n>1 && $n<5) return $f2;
  if ($n==1) return $f1;
  return $f5;
}


$post = json_decode(file_get_contents("php://input"), true);

$query = '';
if($post['name'] != ''){
  $query = $post['name'];
}elseif($post['inn'] !=''){
  $query = $post['inn'];
}
$tel = ', тел.: '.$post['phone'];


$token = 'b0b33d7842d1355ea5fe09e2a243bee8186cf2a4';
$dadata = new SuggestClient($token);
$data = array(
  'query' => $query
);
$resp = $dadata->suggest("party", $data);

if(empty($resp->suggestions[0])){
  die('nothing');
}
$kpp = $resp->suggestions[0]->data->kpp;
$inn = $resp->suggestions[0]->data->inn;
$name = $resp->suggestions[0]->value;
$add = $resp->suggestions[0]->data->address->data->postal_code.', '.$resp->suggestions[0]->data->address->value;

$ndc = 20/100;
$total = $post['total_price'];
$total2 = $total + ($total*$ndc);

$price_ndc = $total2 - $total;

$price_total = $price_ndc+$total;

$arValues = array (
  "form_text_7" => $name,
  "form_text_8" => $inn,
  "form_text_9" => $post['cnt_name'],
  "form_text_10" => $post['email'],
  "form_text_11" => $post['phone']
);

$FORM_ID = 2;

CModule::IncludeModule("form");

$RESULT_ID = CFormResult::Add($FORM_ID, $arValues);


$result = sprintf("%02d", CFormResult::GetCount($FORM_ID));



ob_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title></title>
  <style>
  .total_price::first-letter{
    text-transform: capitalize;
  }
  </style>
</head>
<body>
  <div style="width:750px;">
    <table style="width:100%;font-size: 9.0pt;border: 1px solid; border-spacing: 0px; border-collapse: collapse;">
      <tr>
        <td colspan="4">ПАО СБЕРБАНК Г. МОСКВА</td>
        <td style=" border: 1px solid;">БИК</td>
        <td>044525225</td>
      </tr>
      <tr style="height: 30px;">
        <td colspan="4" style="vertical-align: bottom;padding-top:10px">Банк получателя</td>
        <td style=" border: 1px solid;vertical-align: top;" valign="top">Сч. №</td>
        <td style="vertical-align: top;" valign="top">30101810400000000225</td>
      </tr>
      <tr>
        <td style="border-top: 1px solid;">ИНН</td>
        <td style="border-top: 1px solid;">7730241227</td>
        <td style="border-left: 1px solid;border-top: 1px solid;">КПП</td>
        <td style="border-top: 1px solid;">773001001</td>
        <td style="border: 1px solid;vertical-align: top;border-top: 1px solid;" rowspan="3">Сч. №</td>
        <td style="border-top: 1px solid;">40702810138000074390</td>
      </tr>
      <tr>
        <td colspan="4" style="border-top: 1px solid;">ООО "Технологии отраслевой трансформации"</td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4" style="vertical-align: bottom;padding-top:10px">Получатель</td>
        <td></td>
      </tr>
    </table>

    <h1>Счет на оплату № <?=$result;?> от <?=date('d.m.Y');?> г.</h1>
    <br>
    <div style="border-top:1px solid; width:100%"></div>
    <br>
    <table style="width:100%;font-size: 9.0pt;border-spacing: 5px;">
      <tr>
        <td>Поставщик<br>(Исполнитель):</td>
        <td>
          <b>ООО "Технологии отраслевой трансформации", ИНН 7730241227, КПП 773001001,<br>121170, Москва г, Кутузовский пр-кт, дом № 32, корпус 1, тел.: (495) 2323957</b>
        </td>
      </tr>
      <tr>
        <td style="padding-top:10px">Покупатель<br>(Заказчик):</td>
        <td style="padding-top:10px;">
          <b><?=$name.', ИНН '.$inn.', КПП '.$kpp.',<br>'.$add.' '.$tel;?></b>
        </td>
      </tr>
    </table>

    <br>
    <table style="width:100%;font-size: 9.0pt;border: 1px solid; border-spacing: 0px; border-collapse: collapse;">
      <thead>
        <tr>
          <td style="border:1px solid;text-align:center"><b>№</b></td>
          <td style="border:1px solid;text-align:center"><b>Товары (работы, услуги)</b></td>
          <td style="border:1px solid;text-align:center"><b>Кол-во</b></td>
          <td style="border:1px solid;text-align:center"><b>Ед.</b></td>
          <td style="border:1px solid;text-align:center"><b>Цена</b></td>
          <td style="border:1px solid;text-align:center"><b>Сумма</b></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="border:1px solid;">1</td>
          <td style="border:1px solid; font-size:8pt"><?=$post['service'];?></td>
          <td style="border:1px solid; text-align:center"><?=$post['qt'];?></td>
          <td style="border:1px solid;"><?=$post['month'];?> мес.</td>
          <td style="border:1px solid; text-align:center"><?=number_format($post['ppu'], 2, ',', ' ');?></td>
          <td style="border:1px solid; text-align:right;"><?=number_format($total, 2, ',', ' ');?></td>
        </tr>
        <tr>
          <td colspan="4"></td>
          <td style="text-align:right"><b>Итого:</b></td>
          <td style="text-align:right"><?=number_format($post['total_price'], 2, ',', ' ');?></td>
        </tr>
        <tr>
          <td colspan="4"></td>
          <td style="text-align:right"><b>В том числе НДС:</b></td>
          <td style="text-align:right"><?=number_format($price_ndc, 2, ',', ' ');?></td>
        </tr>
        <tr>
          <td colspan="4"></td>
          <td style="text-align:right"><b>Всего к оплате:</b></td>
          <td style="text-align:right"><b><?=number_format($price_total, 2, ',', ' ');?></b></td>
        </tr>
      </tbody>
    </table>
    <br>
    <p>Всего наименований 1, на сумму <b><u>&nbsp;&nbsp;<?=number_format($price_total, 2, ',', ' ');?>&nbsp;&nbsp;</u></b> руб.<br>
      <b><u class="total_price"><?=(num2str($price_total));?></b></u>
    </p>
    <p>Оплатить не позднее 3 рабочих дней<br>
      Внимание!<br>
      Оплата данного счета означает согласие с условиями оферты.<br>
      В случае не оплаты настоящего счета в течении 3 рабочих дней счет считается недействительным.
    </p>
    <div style="border-top:1px solid; width:100%"></div>
    <br><br>
    <table style="width:100%">
      <tr>
        <td width="15%"><b>Руководитель</b></td>
        <td width="35%" style="border-bottom:1px solid;text-align:right"><p>Барсуков А. П.</p></td>
        <td width="15%" style="padding-left:30px;"><b>Бухгалтер</b></td>
        <td width="35%" style="border-bottom:1px solid;text-align:right">Обожжонова Т. В.</td>
      </tr>
    </table>
  </div>
</body>
</html>

<? $html = ob_get_clean(); echo $html;
$mpdf = new mPDF('utf-8', 'A4', '8', 'Arial', 10, 10, 7, 7, 10, 10);
$mpdf->charset_in = 'cp1251';
$mpdf->autoScriptToLang = true;
$mpdf->WriteHTML($html);

$mpdf->Output('invoices/invoice_'.$result.'.pdf', 'F');
$pdf = $_SERVER["DOCUMENT_ROOT"].'/invoices/invoice_'.$result.'.pdf';

$arImage = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].'/invoices/invoice_'.$result.'.pdf');

$arValues2 = array (
  "form_file_12" => $arImage,
  "form_text_7" => $name,
  "form_text_8" => $inn,
  "form_text_9" => $post['cnt_name'],
  "form_text_10" => $post['email'],
  "form_text_11" => $post['phone']
);



// update the block//
CFormResult::Update($RESULT_ID, $arValues2, "N", 'N', 1);

$arMail = array(
  "TYPE" => $post['type'],
  "USER" => $post['email']
);
$arMail2 = array(
  "INVOICE" => $name
);

CEvent::Send('ADD_INVOICE', 's1', $arMail, 'N', '', array($pdf));

CEvent::Send('MANAGER_INVOICE', 's1', $arMail2, 'N', '', array($pdf));


ob_clean();
die('sent');?>
