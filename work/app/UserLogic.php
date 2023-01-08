<?php

/**クラスを定義
 * class UserLogicは連想配列を使い値を入れていく
 */
class UserLogic
{
  const ADMIN = 'admin';
  /**
   * 同ユーザーIDがないかチェック
   * @param array $number
   * @return bool $result true|false
   */
  public static function checkUser($number)
  {
    $result = false;
    $arr = [];

    $sql = "SELECT COUNT(id) FROM users WHERE name = ? OR number = ?";

    //入力検証して $arr へ代入
    $arr[] = $number['name'];
    $arr[] = $number['number'];

    try {
      $stmt = Database::connect()->prepare($sql);
      $stmt->execute($arr);
      $result = $stmt->fetch();
      if ($result['COUNT(id)'] == 1) {
        $result = true;
        return $result;
      }
      return $result;
    } catch (PDOException $e) {
      echo 'USER_E01接続失敗' . $e->getMessage();
      error_log('['.date('Y年m月d日 H時i分s秒').']'.$e.'USER_E01接続失敗',0);
      return $result;
    }
  }

  /**
   * ユーザを登録する
   * @param array $userData
   * @return bool $result true|false
   */

  public static function createUser($userData)
  {
    $result = false;
    $arr = [];
    $sql = "INSERT INTO users (name, department, number, password) VALUES (?, ?, ?, ?)";

    //入力検証して $arr へ代入
    $arr[] = $userData['name'];
    $arr[] = $userData['department'];
    $arr[] = $userData['number'];
    $arr[] = password_hash($userData['pass'], PASSWORD_DEFAULT);

    try {
      $stmt = Database::connect()->prepare($sql);
      $result = $stmt->execute($arr);
      if (!empty($result)) {
        $result = true;
      }
      return $result;
    } catch(PDOException $e) {
      echo 'USER_E02接続失敗' . $e->getMessage();
      return $result;
    }
  }

  /**
   * ログイン処理
   * @param string $userid
   * @param string $password
   * @return bool $result
   */
  public static function Login($user, $password)
  {
    $result = false;
    $user = self::getUserByName($user);
    // エラー分岐、IDが違う場合
    if (!$user) {
      $_SESSION['message'] = '社員番号またはパスワードが正しくありません';
      return $result;
    }

    // パスワード照会
    if (password_verify($password, $user['password'])) {
      // ログイン成功
      session_regenerate_id(true);
      $_SESSION['login_user'] = $user;
      $result = true;
      return $result;
    } else {
      $_SESSION['message'] = '社員番号またはパスワードが正しくありません';
      return $result;
    }
  }


  /**
   * SQLからuserを取得
   * @param string $user
   * @return array|bool $user|false
   */
  public static function getUserByName($user)
  {
    $arr = [];

    $sql = "SELECT * FROM users WHERE number = ?";

    //入力検証して $arr へ代入
    $arr[] = $user;


    try {
      $stmt = Database::connect()->prepare($sql);
      $stmt->execute($arr);
      $user = $stmt->fetch();
      return $user;
    } catch(PDOException $e) {
      echo 'USER_E03接続失敗' . $e->getMessage();
      return false;
    }
  }

  /**
   * SQLから管理者パスワードを取得
   * @param array $admin
   * @return bool $user
   */
  public static function getAdminByPass($admin_pass)
  {
    $user = false;
    $arr = [];
    $pass_err = [];

    $sql = "SELECT password FROM users WHERE number = ?";
    $pass = $admin_pass['0'];
    $arr[] = self::ADMIN;

    try {
      $stmt = Database::connect()->prepare($sql);
      $stmt->execute($arr);
      $hash = $stmt->fetch();
      // パスワード照会
    if (password_verify($pass, $hash['password'])) {
      $user = true;
      return $user;
    } else {
      $pass_err['admin_err'] = 'パスワードが一致しません';
      $_SESSION['admin_pass_err'] = $pass_err;
    }
    } catch(PDOException $e) {
      echo 'USER_E04接続失敗' . $e->getMessage();
      return $user;
    }
  }

  /**
   * ログインチェック
   * @param void
   * @return bool $result
   */
  public static function checkLogin()
  {
    $result = false;
    if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0) {
      session_regenerate_id(true);
      return $result = true;
    }
    return $result;
  }

  /**
   * ログアウト処理
   */
  public static function logout()
  {
    $result = false;
    $_SESSION = array();
    session_destroy();
    return $result = true;
  }
  /**
   * 退会処理
   * @param string $deleteuser
   * @return bool true|false
   */
  public static function deleteuser()
  {
    $result = false;
    $arr = [];

    $sql = "DELETE FROM users WHERE id = ?";

    if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] >0) {
      $loginuser = $_SESSION['login_user'];
    }

    $arr[] = $loginuser['id'];

    try {
      $stmt = Database::connect()->prepare($sql);
      $stmt->execute($arr);
      $deleteuser = $stmt->fetch();
      $deleteuser = true;

      $_SESSION = array();
      session_destroy();
      return $deleteuser;
    } catch(PDOException $e) {
      echo 'USER_E05接続失敗' . $e->getMessage();
      return false;
    }
  }
}
