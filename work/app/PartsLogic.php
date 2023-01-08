<?php

/**クラスを定義
 * class UserLogicは連想配列を使い値を入れていく
 */
class PartsLogic
{
  /**
   * 同パーツIDチェック処理
   * @param array $check
   * @return bool $result true|false
   */
  public static function checkParts($check)
  {
    $result = false;
    $arr = [];

    $sql = "SELECT COUNT(id) FROM parts WHERE model LIKE ?";

    $check = $check['model_name'];
    $check = '%'.$check.'%';
    $arr[] = $check;

    try {
      $stmt = Database::connect()->prepare($sql);
      $stmt->execute($arr);
      $result = $stmt->fetch();
      if ($result['COUNT(id)'] > 0) {
        $result = true;
        return $result;
      }
      $result = false;
      return $result;
    } catch (PDOException $e) {
      echo 'PARTS_E01接続失敗' . $e->getMessage();
      return $result;
    }
  }
  /**
   * パーツ検索件数取得
   */
  public static function totalParts()
  {
    $result = false;
    // $kind = [];
    $arr = [];
    //パーツ検索セッションの値を評価
    if (isset($_SESSION['category'])) {
      $search = $_SESSION['category'];
    }
    //カテゴリー選択の値を代入
    // $kind = $search['search'];
    //検索方法分岐
    // switch($kind) {
    //   case '1':
    //     $sql = "SELECT COUNT(*) AS count FROM parts WHERE manufacturer LIKE ?";
    //     break;
    //   case '2':
    //     $sql = "SELECT COUNT(*) AS count FROM parts WHERE partname LIKE ?";
    //     break;
    //   case '3':
    //     $sql = "SELECT COUNT(*) AS count FROM parts WHERE category LIKE ?";
    //     break;
    //   case '4':
    //     $sql = "SELECT COUNT(*) AS count FROM parts WHERE size LIKE ?";
    //     break;
    // }
    $sql = "SELECT COUNT(*) AS count FROM parts WHERE category LIKE ?";

    // $search = $search['search'];
    $search = $search;
    $search = '%'.$search.'%';
    $arr[] = $search;
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
   * パーツ検索取得
   * @param string $now, $per_page
   * @return array|bool $result
   */
  public static function searchParts($now, $per_page)
  {
    $result = false;
    // $kind = [];
    $arr = [];
    //パーツ検索セッションの値を評価
    if (isset($_SESSION['category'])) {
      $search = $_SESSION['category'];
    }
    // $kind = $search['search'];
    //検索方法分岐
    // switch($kind) {
    //   case '1':
    //     $sql = "SELECT id, partname FROM parts WHERE manufacturer LIKE ? ORDER BY id LIMIT ?, ?";
    //     break;
    //   case '2':
    //     $sql = "SELECT id, partname FROM parts WHERE partname LIKE ? ORDER BY id LIMIT ?, ?";
    //     break;
    //   case '3':
    //     $sql = "SELECT id, partname FROM parts WHERE category LIKE ? ORDER BY id LIMIT ?, ?";
    //     break;
    //   case '4':
    //     $sql = "SELECT id, partname FROM parts WHERE size LIKE ? ORDER BY id LIMIT ?, ?";
    //     break;
    // }

    $sql = "SELECT
              parts.id, partname, images.img_path
            FROM
              parts INNER JOIN images ON parts.image_id = images.id
            WHERE category LIKE ? ORDER BY id LIMIT ?, ?";

    // $search = $search['search_name'];
    $search = $search;
    $search = '%'.$search.'%';
    $arr[] = $search;

    //ページ数判定
    if ($now == 1) {
      $arr[] = $now - 1;
      $arr[] = $per_page;
    } else {
      $arr[] = ($now - 1) * $per_page;
      $arr[] = $per_page;
    }

    try {
      $stmt = Database::connect()->prepare($sql);
      $stmt->execute($arr);
      $result = $stmt->fetchAll();
      if (empty($result)) {
        $_SESSION['search_err'] = '検索結果 0 件';
      }
      return $result;
    } catch(PDOException $e) {
      echo 'PARTS_E02接続失敗' . $e->getMessage();
      return $result;
    }
  }

  /**
   * パーツ登録処理
   * @param array $registparts
   * @return bool $result
   */
  public static function createParts($registparts)
  {
    $result = false;
    $arr = [];

    if (isset($registparts['register'])) {
        $sch[] = $registparts['image_name'];
      $result_img = ImageAcqu::searchImage($sch);

      $sql = "INSERT INTO parts (partname, model, manufacturer, category, size, price, supplier, code, phone, image_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

      $arr[] = $registparts['parts_name'];
      $arr[] = $registparts['model_name'];
      $arr[] = $registparts['manufact_name'];
      $arr[] = $registparts['category'];
      $arr[] = $registparts['size'];
      $arr[] = $registparts['price'];
      $arr[] = $registparts['supplier'];
      $arr[] = $registparts['code'];
      $arr[] = $registparts['phone'];
      $arr[] = $result_img['id'];
    } elseif (isset($registparts['edit'])) {
      $sql = "UPDATE parts SET partname = ?, model = ?, manufacturer = ?, category = ?, size = ?, price = ?, supplier = ?, code = ?, phone = ? WHERE id = ?";

      $arr[] = $registparts['parts_name'];
      $arr[] = $registparts['model_name'];
      $arr[] = $registparts['manufact_name'];
      $arr[] = $registparts['category'];
      $arr[] = $registparts['size'];
      $arr[] = $registparts['price'];
      $arr[] = $registparts['supplier'];
      $arr[] = $registparts['code'];
      $arr[] = $registparts['phone'];
      $arr[] = $registparts['id'];
    }

    try {
      $stmt = Database::connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    } catch(PDOException $e) {
      echo 'PARTS_E03接続失敗' . $e->getMessage();
      return $result;
    }
  }
  /**
   * パーツ検索詳細
   * @param array
   * @return bool|array $result
   */
  public static function getParts()
  {
    $result = false;
    $geted = [];
    $arr = [];

    $sql = "SELECT * FROM parts WHERE id LIKE :id";

    if (isset($_SESSION['detail_parts'])) {
      $geted = $_SESSION['detail_parts'];
    }

    $arr[] = $geted['id'];

    try {
      $stmt = Database::connect()->prepare($sql);
      $stmt->execute($arr);
      $result = $stmt->fetch();
      if (!empty($result)) {
        $getimg = ImageAcqu::getImage($result);
        $result = array_merge($result, $getimg);
        return $result;
      }
    } catch (PDOException $e) {
      echo 'PARTS_E04接続失敗' . $e->getMessage();
      return $result;
    }
  }

  /**
   * パーツ削除処理
   * @return bool $result
   */
  public static function deleteParts()
  {
    $result = false;
    $delete = [];
    $admin_pass = [];
    $arr = [];
    if (isset($_SESSION['delete_parts'])) {
      $delete = $_SESSION['delete_parts'];
    }
    //管理者パスワード代入
    $admin_pass[] = $delete['admin_pass'];
    // var_dump($admin_pass);
    // exit;

    $sql = "DELETE FROM parts WHERE id = ?";

    //管理者パスワード確認
    $result = UserLogic::getAdminByPass($admin_pass);
    if (!empty($result)) {
      //パーツID代入
      $arr[] = $delete['delete'];
    }

    try {
      $stmt = Database::connect()->prepare($sql);
      $stmt->execute($arr);
      $result = $stmt->fetch();
      $result = true;
      return $delete;
    } catch(PDOException $e) {
      echo 'PARTS_E05接続失敗' . $e->getMessage();
      return $result;
    }
  }
}
