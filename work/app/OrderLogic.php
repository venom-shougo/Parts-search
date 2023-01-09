<?php

class OrderLogic
{

  /**
   * パーツ注文処理
   * @param array $_SESSION['order_parts']
   * @param array $_SESSION['get_parts']
   * @param array $_SESSION['login_user']
   * @see self::orderInquiry
   * @return bool|array $result
   */
  public static function orderParts()
  {
    $result = false;
    $arr = [];

    if (!empty($_SESSION['get_parts'])) {
      $get_parts = $_SESSION['get_parts']; //パーツ詳細
      $order_parts = $_SESSION['order_parts']; //注文数
      $login_user = $_SESSION['login_user']; //ログインユーザ
    } else {
      return $result;
    }


    $sql = "INSERT INTO order_history
              (user_id, part_id, order_part_name, order_num, order_price, judge, remarks)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $n = (isset($order_parts['num_ord'])) ? $order_parts['num_ord'] : $order_parts['his_num_ord'];
    $p = $get_parts['price'];
    $price = $n * $p;
    $arr[] = $login_user['id'];
    $arr[] = $get_parts['id'];
    $arr[] = $get_parts['partname'];
    $arr[] = (isset($order_parts['num_ord'])) ? $order_parts['num_ord'] : $order_parts['his_num_ord'];
    $arr[] = $price;
    $arr[] = (isset($order_parts['judge'])) ? $order_parts['judge'] : $order_parts['his_judge'];
    $arr[] = (isset($order_parts['remarks'])) ? $order_parts['remarks'] : $order_parts['his_remarks'];


    try {
      $stmt = Database::connect()->prepare($sql);
      $result = $stmt->execute($arr);

      //登録処理後の時間
      $date = date('Y-m-d H:i:s');
      // 購入した部品を取得してリターン
      if (!empty($result)) {
        $result = self::orderInquiry($get_parts, $date);
      }
      if (isset($result)) {
        return $result;
      }
    } catch(PDOException $e) {
      echo 'ORDER_E01接続失敗' . $e->getMessage();
      return $result;
    }
  }

  /**
   * パーツ注文処理後に注文詳細結果を返す処理
   * @param string $part_id, $date
   * @return bool|array $result
   */
  public static function orderInquiry($part_id, $date)
  {
    $result = false;
    $arr = [];

    $sql = "SELECT
              id,
              order_part_name,
              order_num,
              order_price,
              remarks,
              DATE_FORMAT(created_at,'%Y年%m月%d日') AS date
            FROM order_history WHERE part_id = ? AND created_at = ?";

    $arr[] = $part_id['id'];
    $arr[] = $date;
    try {
      $stmt = Database::connect()->prepare($sql);
      $stmt->execute($arr);
      $result = $stmt->fetch();
      return $result;
    } catch(PDOException $e) {
      echo 'ORDER_E02接続失敗' . $e->getMessage();
      return $result;
    }
  }

  /**
   * 注文履歴全件取得
   * @param array $login_user
   * @return bool|array $result
   */
  public static function totalHistory($login_user)
  {
    $result = false;
    $arr = [];

    $sql = "SELECT COUNT(*) AS count FROM order_history WHERE user_id = ?";

    $arr[] = $login_user['id'];

    try {
      $stmt = Database::connect()->prepare($sql);
      $stmt->execute($arr);
      $result = $stmt->fetchAll();
      return $result;
    } catch(PDOException $e) {
      echo 'ORDER_E03接続失敗' . $e->getMessage();
      return $result;
    }

  }
  /**
   * 注文履歴検索全件取得
   * @param array $login_user, $search_history
   * @return bool|array $result
   */
  public static function searchHistry($login_user, $search_history)
  {
    $result = false;
    $arr1 = [];
    $arr2 = [];

      //カテゴリー選択の値を代入
      $kind = $search_history['search'];

    if (!empty($kind)) {
      //検索方法分岐、２つのテーブルから条件検索をかけコピーテーブルに一時保存し内部結合で最終出力
      switch($kind) {
        case '1':
          $sql1 = "DROP TABLE IF EXISTS count_parts";
          $sql2 = "DROP TABLE IF EXISTS count_history";
          $sql3 = "CREATE TABLE count_parts AS SELECT id FROM parts WHERE manufacturer LIKE ?";
          $sql4 = "CREATE TABLE count_history AS SELECT * FROM order_history WHERE user_id = ?";
          $sql5 = "SELECT COUNT(*) AS count FROM count_parts INNER JOIN count_history ON count_parts.id = count_history.part_id";
          break;
        case '2':
          $sql1 = "DROP TABLE IF EXISTS count_parts";
          $sql2 = "DROP TABLE IF EXISTS count_history";
          $sql3 = "CREATE TABLE count_parts AS SELECT id FROM parts WHERE partname LIKE ?";
          $sql4 = "CREATE TABLE count_history AS SELECT * FROM order_history WHERE user_id = ?";
          $sql5 = "SELECT COUNT(*) AS count FROM count_parts INNER JOIN count_history ON count_parts.id = count_history.part_id";
          break;
        case '3':
          $sql1 = "DROP TABLE IF EXISTS count_parts";
          $sql2 = "DROP TABLE IF EXISTS count_history";
          $sql3 = "CREATE TABLE count_parts AS SELECT id FROM parts WHERE category LIKE ?";
          $sql4 = "CREATE TABLE count_history AS SELECT * FROM order_history WHERE user_id = ?";
          $sql5 = "SELECT COUNT(*) AS count FROM count_parts INNER JOIN count_history ON count_parts.id = count_history.part_id";
          break;
        case '4':
          $sql1 = "DROP TABLE IF EXISTS count_parts";
          $sql2 = "DROP TABLE IF EXISTS count_history";
          $sql3 = "CREATE TABLE count_parts AS SELECT id FROM parts WHERE size LIKE ?";
          $sql4 = "CREATE TABLE count_history AS SELECT * FROM order_history WHERE user_id = ?";
          $sql5 = "SELECT COUNT(*) AS count FROM count_parts INNER JOIN count_history ON count_parts.id = count_history.part_id";
          break;
      }
    }

    if (!empty($search_history['search_name'])) {
      $search = $search_history['search_name'];
      $search = '%'.$search.'%';
      $arr1[] = $search;
      $arr2[] = $login_user['id'];
    }

    Database::connect()->beginTransaction();
    try {
      Database::connect()->query($sql1);
      Database::connect()->query($sql2);
      $stmt = Database::connect()->prepare($sql3);
      $stmt->execute($arr1);
      $stmt = Database::connect()->prepare($sql4);
      $stmt->execute($arr2);
      $stmt = Database::connect()->query($sql5);
      $result = $stmt->fetchAll();
      return $result;
      Database::connect()->commit();
    } catch(PDOException $e) {
      echo 'ORDER_E04接続失敗' . $e->getMessage();
      return $result;
      Database::connect()->rollBack();
    }
  }

  /**
   * 注文履歴照会
   * @param array $userORsearch, $now, $perPage
   * @return bool|array $result
   */
  public static function orderHistory($userORsearch, $now, $perPage)
  {
    $result = false;
    $arr = [];

    //カテゴリー選択の値を代入
    if (isset($userORsearch['search'])) {
      $kind = $userORsearch['search'];
    }

    if (!isset($userORsearch['search'])) {
      $sql = "SELECT
                id,
                DATE_FORMAT(created_at,'%Y年%m月%d日%H%i%s') AS date,
                order_part_name
              FROM order_history
              WHERE user_id = ? ORDER BY id DESC LIMIT ?, ?";
    } elseif (isset($userORsearch['search'])) {
      //検索方法分岐、２つのテーブルから条件検索をかけコピーテーブルに一時保存し内部結合で最終出力
      switch($kind) {
        case '1':
          $sql1 = "DROP TABLE IF EXISTS parts_copy";
          $sql2 = "DROP TABLE IF EXISTS history_copy";
          $sql3 = "CREATE TABLE parts_copy AS SELECT id FROM parts WHERE manufacturer LIKE ?";
          $sql4 = "CREATE TABLE history_copy AS SELECT * FROM order_history WHERE user_id = ?";
          $sql5 = "SELECT
                    history_copy.id,
                    DATE_FORMAT(created_at,'%Y年%m月%d日%H%i%s') AS date,
                    order_part_name
                  FROM parts_copy INNER JOIN history_copy ON parts_copy.id = history_copy.part_id ORDER BY history_copy.id DESC LIMIT ?, ?";
          break;
        case '2':
          $sql1 = "DROP TABLE IF EXISTS parts_copy";
          $sql2 = "DROP TABLE IF EXISTS history_copy";
          $sql3 = "CREATE TABLE parts_copy AS SELECT id FROM parts WHERE partname LIKE ?";
          $sql4 = "CREATE TABLE history_copy AS SELECT * FROM order_history WHERE user_id = ?";
          $sql5 = "SELECT
                    history_copy.id,
                    DATE_FORMAT(created_at,'%Y年%m月%d日%H%i%s') AS date,
                    order_part_name
                  FROM parts_copy INNER JOIN history_copy ON parts_copy.id = history_copy.part_id ORDER BY history_copy.id DESC LIMIT ?, ?";
          break;
        case '3':
          $sql1 = "DROP TABLE IF EXISTS parts_copy";
          $sql2 = "DROP TABLE IF EXISTS history_copy";
          $sql3 = "CREATE TABLE parts_copy AS SELECT id FROM parts WHERE category LIKE ?";
          $sql4 = "CREATE TABLE history_copy AS SELECT * FROM order_history WHERE user_id = ?";
          $sql5 = "SELECT
                    history_copy.id,
                    DATE_FORMAT(created_at,'%Y年%m月%d日%H%i%s') AS date,
                    order_part_name
                  FROM parts_copy INNER JOIN history_copy ON parts_copy.id = history_copy.part_id ORDER BY history_copy.id DESC LIMIT ?, ?";
          break;
        case '4':
          $sql1 = "DROP TABLE IF EXISTS parts_copy";
          $sql2 = "DROP TABLE IF EXISTS history_copy";
          $sql3 = "CREATE TABLE parts_copy AS SELECT id FROM parts WHERE size LIKE ?";
          $sql4 = "CREATE TABLE history_copy AS SELECT * FROM order_history WHERE user_id = ?";
          $sql5 = "SELECT
                    history_copy.id,
                    DATE_FORMAT(created_at,'%Y年%m月%d日%H%i%s') AS date,
                    order_part_name
                  FROM parts_copy INNER JOIN history_copy ON parts_copy.id = history_copy.part_id ORDER BY history_copy.id DESC LIMIT ?, ?";
          break;
      }
    }
    //購入履歴表示
    if (!isset($userORsearch['search'])) {
      $arr[] = $userORsearch ['id'];
      //ページ数判定
      if ($now == 1) {
        $arr[] = $now - 1;
        $arr[] = $perPage;
      } else {
        $arr[] = ($now - 1) * $perPage;
        $arr[] = $perPage;
      }
    } else {
      //購入検索履歴
      $search = $userORsearch['search_name'];
      $search = '%'.$search.'%';
      $arr1[] = $search;
      $arr2[] = $userORsearch ['id'];
      //ページ数判定
      if ($now == 1) {
        $arr[] = $now - 1;
        $arr[] = $perPage;
      } else {
        $arr[] = ($now - 1) * $perPage;
        $arr[] = $perPage;
      }
    }

    Database::connect()->beginTransaction();
    try {
      if (!empty($sql)) {
        $stmt = Database::connect()->prepare($sql);
        $stmt->execute($arr);
        $result = $stmt->fetchAll();
      } else {
        Database::connect()->query($sql1);
        Database::connect()->query($sql2);
        $stmt = Database::connect()->prepare($sql3);
        $stmt->execute($arr1);
        $stmt = Database::connect()->prepare($sql4);
        $stmt->execute($arr2);
        $stmt = Database::connect()->prepare($sql5);
        $stmt->execute($arr);
        $result = $stmt->fetchAll();
      }
      if (empty($result)) {
          $_SESSION['history_err'] = '購入履歴 0 件';
        }
      return $result;
      Database::connect()->commit();
    } catch(PDOException $e) {
      echo 'ORDER_E05接続失敗' . $e->getMessage();
      return $result;
      Database::connect()->rollBack();
    }
  }

  /**
   * 注文履歴詳細
   * @param array $order_id
   * @return bool|array $result
   */
  public static function detailHistory($order_id)
  {
    $result = false;
    $arr = [];

    //インナージョインでテーブルを内部結合する
    $sql = "SELECT
              -- *
              parts.id,
              partname,
              model,
              manufacturer,
              category,
              size,
              price,
              supplier,
              code,
              phone,
              image_id,
              order_history.order_num,
              order_history.order_price,
              order_history.judge,
              order_history.remarks,
              DATE_FORMAT(order_history.created_at,'%Y年%m月%d日') AS date
            FROM
              order_history INNER JOIN parts ON parts.id = order_history.part_id
            WHERE order_history.id = ?";

    if (isset($order_id['id'])) {
      $arr[] = $order_id['id'];
    } else {
      $arr[] = $order_id;
    }

    try {
      $stmt = Database::connect()->prepare($sql);
      $stmt->execute($arr);
      $result = $stmt->fetch();
      return $result;
    } catch(PDOException $e) {
      echo 'ORDER_E06接続失敗' . $e->getMessage();
      return $result;
    }
  }
}
