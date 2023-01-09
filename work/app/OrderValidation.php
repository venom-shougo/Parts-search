<?php
class OrderValidation
{
  /**
   * 注文バリデーション
   * @param array $_SESSION['order_parts']
   * @param array $order_parts
   * @return array $err
   */
  public static function setOrder()
  {
    $order_parts = $_SESSION['order_parts'];

    $err = [];

    if (isset($order_parts['num_ord'])) {
      if (empty(trim($order_parts['num_ord']))) {
        $err['num_err'] = '注文個数を入力してください';
      }
      if (empty($order_parts['judge'])) {
        $err['judge_err'] = '物品修理または物品購入にチェックを入れてください';
      }
      if (empty($order_parts['remarks'])) {
        $err['remarks_err'] = '購入目的または請求理由を入力してください';
      }
    } else {
      if (empty(trim($order_parts['his_num_ord']))) {
        $err['his_num_err'] = '注文個数を入力してください';
      }
      if (empty($order_parts['his_judge'])) {
        $err['his_judge_err'] = '物品修理または物品購入にチェックを入れてください';
      }
      if (empty(trim($order_parts['his_remarks']))) {
        $err['his_remarks_err'] = '購入目的または請求理由を入力してください';
      }
    }
    return $err;
  }
}
