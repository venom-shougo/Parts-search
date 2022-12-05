<?php
require_once (__DIR__ . '/../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;

class ExcelLogic
{
  /**
   * @param array $history
   * @return bool $result true|false
   */
  public static function Excelout($history)
  {
    $login_user = $_SESSION['login_user'];

    // Excel処理、注文書作成
    $reader = new Reader;
    $file_name = 'excel/parts-order.xlsx';
    $spreadsheet = $reader->load($file_name);
    
    //DBからの配列を変数に代入
    $user = $login_user['name'];
    $partname = $history['partname'];
    $model = $history['model'];
    $manufacturer = $history['manufacturer'];
    $size = $history['size'];
    $price = $history['price'];
    $supplier = $history['supplier'];
    $phone = $history['phone'];
    $code = $history['code'];
    $order_num = $history['order_num'];
    $order_price = $history['order_price'];
    $judge = $history['judge'];
    $department = $login_user['department'];
    $remarks = $history['remarks'];
    $date = $history['date'];
    
    //シートに書き込み
    $sheet = $spreadsheet->getActiveSheet();
    
    //注文詳細シート
    $sheet->setCellValue('E5', $partname);
    $sheet->getStyle('E5')
        ->getFont()
        ->setSize(15);
    $sheet->getStyle('E5')
        ->getAlignment()
        ->setVertical('top');

    $sheet->setCellValue('E7', $manufacturer);
    $sheet->getStyle('E7')
        ->getFont()
        ->setSize(15);
    $sheet->getStyle('E7')
        ->getAlignment()
        ->setVertical('top');

    $sheet->setCellValue('E10', $model);
    $sheet->getStyle('E10')
        ->getFont()
        ->setSize(15);
    $sheet->getStyle('E10')
        ->getAlignment()
        ->setVertical('top');

    $sheet->setCellValue('E13', $size);
    $sheet->getStyle('E13')
        ->getFont()
        ->setSize(15);
    $sheet->getStyle('E13')
        ->getAlignment()
        ->setVertical('top');

    $sheet->setCellValue('E16', $supplier);
    $sheet->getStyle('E16')
        ->getFont()
        ->setSize(15);
    $sheet->getStyle('E16')
        ->getAlignment()
        ->setVertical('top');

    $sheet->setCellValue('E20', $phone);
    $sheet->getStyle('E20')
        ->getFont()
        ->setSize(15);
    $sheet->getStyle('E20')
        ->getAlignment()
        ->setVertical('top');
    //請求伝票
    $sheet->setCellValue('Z3', $date);
    $sheet->getStyle('Z3')
    ->getFont()
    ->setSize(16);

    if ($judge === '物品修理') {
      $sheet->setCellValue('U5', '○');
      $sheet->getStyle('U5')
        ->getFont()
        ->setSize(22);
      $sheet->getStyle('U5')
        ->getAlignment()
        ->setVertical('top');
        $sheet->getStyle('U5')
        ->getAlignment()
        ->setHorizontal('center');
    } else {
      $sheet->setCellValue('U6', '○');
      $sheet->getStyle('U6')
        ->getFont()
        ->setSize(22);
      $sheet->getStyle('U6')
        ->getAlignment()
        ->setVertical('top');
      $sheet->getStyle('U6')
        ->getAlignment()
        ->setHorizontal('center');
    }
    $sheet->setCellValue('T9', $department);
    $sheet->getStyle('T9')
        ->getFont()
        ->setSize(18);
    $sheet->getStyle('T9')
        ->getAlignment()
        ->setVertical('center');
    $sheet->getStyle('T9')
        ->getAlignment()
        ->setHorizontal('center');

    $sheet->setCellValue('Y8', $user);
    $sheet->getStyle('Y8')
        ->getFont()
        ->setSize(30);
    $sheet->getStyle('Y8')
        ->getAlignment()
        ->setVertical('center');
    $sheet->getStyle('Y8')
        ->getAlignment()
        ->setHorizontal('center');

    $text = $partname . "\n" . 'メーカー：'.$manufacturer . "\n" . '型番：'.$model . "\n" . '注文コード：'.$code;
    $sheet->getStyle('Q12')
        ->getAlignment()
        ->setWrapText(true);
    $sheet->setCellValue('Q12', $text);
    $sheet->getStyle('Q12')
        ->getFont()
        ->setSize(12);

    $sheet->setCellValue('Y12', $order_num .'個');
    $sheet->getStyle('Y12')
        ->getFont()
        ->setSize(20);
    $sheet->getStyle('Y12')
        ->getAlignment()
        ->setVertical('center');
    $sheet->getStyle('Y12')
        ->getAlignment()
        ->setHorizontal('center');

    $sheet->setCellValue('Y14', '(単価)￥'.number_format($price));
    $sheet->getStyle('Y14')
        ->getFont()
        ->setSize(12);
    $sheet->getStyle('Y14')
        ->getAlignment()
        ->setVertical('center');
    $sheet->getStyle('Y14')
        ->getAlignment()
        ->setHorizontal('center');

    $sheet->setCellValue('Q17', $remarks);
    $sheet->getStyle('Q17')
        ->getFont()
        ->setSize(13);
    $sheet->getStyle('Q17')
        ->getAlignment()
        ->setVertical('center');

    $sheet->setCellValue('T22', $supplier);
    $sheet->getStyle('T22')
        ->getFont()
        ->setSize(12);
    $sheet->getStyle('T22')
        ->getAlignment()
        ->setVertical('center');
    $sheet->getStyle('T22')
        ->getAlignment()
        ->setHorizontal('center');

    $sheet->setCellValue('AA22', '￥'. number_format($order_price));
    $sheet->getStyle('AA22')
        ->getFont()
        ->setSize(13);
    $sheet->getStyle('AA22')
        ->getAlignment()
        ->setVertical('center');
    $sheet->getStyle('AA22')
        ->getAlignment()
        ->setHorizontal('center');

        //出力ファイル名
        $outputName = 'parts-output.xlsx';
        //ブラウザーでエクセルファイルダウンロード
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$outputName}\"");
        header('Cache-Control: max-age=0');
        
        //ファイル出力
        $writer = new Writer($spreadsheet);
        $writer->save('php://output');
        exit();
  }
}