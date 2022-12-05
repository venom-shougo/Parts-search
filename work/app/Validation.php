<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\CaseConvert;

class ValidateForm
{
  /**
   * サインアップバリデーション
   * @param array $userData
   * @return array $err
   */
  public static function setSignup($userData)
  {
    $err = [];

    if (empty(trim($userData['name']))) {
      $err['name_err'] = '氏名を入力してください';
    } else {
      $var = Utils::checkInput(trim($userData['name']));
      $str = mb_strlen($var);
      if ($str > 16){
        $err['name_err'] = '全角16文字以内で入力してください';
      }
    }
    
    if (empty($userData['department'])) {
      $err['department_err'] = '部署を選択してください';
    } else {
      Utils::checkInput($userData['department']);
    }

    if (empty(trim($userData['number']))) {
      $err['number_err'] = '社員番号を入力してください';
    } else {
      $var = Utils::checkInput(trim($userData['number']));
      $str = mb_strlen($var);
      if ($str > 10){
        $err['number_err'] = '10文字以内で入力してください';
      } else {
        if (!ctype_digit(trim($userData['number']))) {
          $err['number_err'] = '半角数字で入力してください';
        }
      }
    }

    
    $password = Utils::checkInput(trim($userData['pass']));
    if (!preg_match("/\A[a-z\d]{4,8}+\z/i", $password)) {
      $err['pass_err'] = '4文字以上8文字以内の半角小文字英字を入力してください';
    } else {
      Utils::checkInput(trim($userData['pass']));
    }
    return $err;
  }

  /**
   * ログインバリデーション
   * @param array $userData
   * @param array $arr
   * @return array $err
   */
  public static function setForm($userData)
  {
    // var_dump($userData);
    // exit;
    $err = [];

    if (empty(trim($userData['employee']))) {
      $err['empl_err'] = '社員番号を入力してください';
    } else {
      $var = Utils::checkInput(trim($userData['employee']));
      $str = mb_strlen($var);
      if ($str > 10){
        $err['empl_err'] = '10文字以内で入力してください';
      }
    }
    
    if (empty(trim($userData['mypass']))) {
      $err['mypass_err'] = 'パスワードを入力してください';
    } else {
      Utils::checkInput(trim($userData['mypass']));
    }
    return $err;
  }
  /**
   * 管理者パスワードバリデーション
   */
  public static function adminPass()
  {
    $err = [];
    if (isset($_SESSION['delete_parts'])) {
      $delete_parts = $_SESSION['delete_parts'];
    }

    if (empty(trim($delete_parts['admin_pass']))) {
      $err['admin_err'] = 'パスワードを入力してください';
    } else {
      Utils::checkInput(trim($delete_parts['admin_pass']));
    }
    return $err;
  }

  /**
   * ログイン実行
   * @param array $userData
   * @return array $arr
   */

  public static function setLogin($userData)
  {
    $arr = [];
    if (!empty($userData)) {
      $arr = $userData;
    }
      return $arr;
  }
}