<?php
/**
 * 画像処理関連
 */
class ImageAcqu
{

  /**
   * 画像表示
   * @param array $_FILES['image']['tmp_name']
   * @return bool|array $result
   */
  public static function imageDisp()
  {
    $result = false;

    if (!empty($_FILES['image']['tmp_name'])) {
      if (is_uploaded_file($_FILES['image']['tmp_name'])) {
      $fp = fopen($_FILES['image']['tmp_name'], "rb");
      $img = fread($fp, filesize($_FILES['image']['tmp_name']));
      $enc_img = base64_encode($img);
      fclose($fp);
      }
      $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
      $result = '<img src="data:' . $imginfo['mime'] . ';base64,'.$enc_img.'" class="img-thumbnail">';
      //ブラウザーバック画像表示処理ができない時
      $_SESSION['image'] = $result;
    } else {
      //ブラウザーバック後の画像表示
      $result = $_SESSION['image'];
    }
    return $result;
  }

  /**
   * DB部品登録前画像取得処理
   * @param array $search
   * @return bool|array $result
   */
  public static function searchImage($search)
  {
    $result = false;
    $arr = [];
    $sql = "SELECT id FROM images WHERE name LIKE :name";

    $search = $search[0];
    $search = '%'.$search.'%';
    $arr[] = $search;

    try {
      $stmt = Database::connect()->prepare($sql);
      $stmt->execute($arr);
      $result = $stmt->fetch();
      if (empty($result)) {
        echo '画像検索失敗';
      }
      return $result;
    } catch(PDOException $e) {
      echo 'IMG_E01接続失敗' . $e->getMessage();
      return $result;
    }
  }

  /**
   * 画像登録処理
   * @param array $registparts
   * @see move_uploaded_file
   * @return bool $result
   */
  public static function createImage($registparts)
  {
    $result = false;
    $arr = [];

    //画像ファイル代入
    if (isset($_FILES['image']['tmp_name'])) {
      $file = $_FILES['image'];
      $tmp_name = $file['tmp_name'];
      $name = basename($file['name']);
    }

    //画像をディレクトリに保存
    $save_name = date('YmdHis') . $name;
    $upload_dir = 'upload/';
    $save_path = $upload_dir.$save_name;
    if (!move_uploaded_file($tmp_name, $save_path)) {
      $_SESSION['imgdir_err'] = '画像を保存できません';
      return $result;
    }

    $sql = "INSERT INTO images (img_name, img_path, name) VALUES (?, ?, ?)";

    $arr[] = $name;
    $arr[] = $save_path;
    $arr[] = $registparts['image_name'];

    try {
      $stmt = Database::connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    } catch(PDOException $e) {
      echo 'IMG_E02接続失敗' . $e->getMessage();
      return $result;
    }
  }

  /**
   * 部品検索画像取得
   * @param array $getimg
   * @return bool $result
   */
  public static function getImage($getimg)
  {
    $result = false;
    $arr = [];

    if (isset($getimg['image_id'])) {
      $arr[] = $getimg['image_id'];
      $sql = "SELECT img_path FROM images WHERE id = :id";
      try {
        $stmt = Database::connect()->prepare($sql);
        $stmt->execute($arr);
        $result = $stmt->fetch();
        return $result;
      } catch(PDOException $e) {
        echo 'IMG_E03接続失敗' . $e->getMessage();
        return $result;
      }
    } else {
      $sql = "SELECT id, img_path FROM images";
      try {
        $stmt = Database::connect()->prepare($sql);
        $stmt->execute($arr);
        $result = $stmt->fetchAll();
        return $result;
      } catch (PDOException $e) {
        echo 'IMG_E03接続失敗' . $e->getMessage();
        return $result;
      }
    }
  }
}
