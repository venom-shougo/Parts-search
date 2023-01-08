<?php

class Utils
{
  /**
   * 配列確認、NULLバイト攻撃対策、文字エンコードチェック、制御文字チェック
   * @param string $var
   * @return string
   */
  public static function checkInput($var)
  {

    if (is_array($var)) {
      return array_map('checkInput', $var);
    } else {
      //NULLバイト攻撃対策
      if (preg_match('/\0/', $var)) {
        die('1不正な入力です');
      }
      //文字エンコードチェック
      if (!mb_check_encoding($var, 'UTF-8')) {
        die('2不正な入力です');
      }
      //改行/タブ以外の制御文字チェック
      if (preg_match('/\A[\r\n\t[:^cntrl:]]*\z/u', $var) == 0) {
        die('制御文字は使用できません');
      }
      return $var;
    }
  }

  /**
   * XSS対策：エスケープ処理
   * @param string $str
   * @return string
   */
  public static function h($str)
  {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }
}
