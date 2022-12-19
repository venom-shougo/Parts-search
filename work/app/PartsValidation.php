<?php

class PartsValidateForm
{
  /**
   * パーツ登録バリデーション
   * @param array $setparts
   * @return array $err
   */
  public static function setParts($register)
  {
    $err = [];
    //パーツ登録の値を評価
    if (empty($register)) {
      header('Location: mypage.php');
      exit();
    }

    if (empty(trim($register['parts_name']))) {
      $err['parts_err'] = '部品名を記入してください';
    } else {
      $var = Utils::checkInput($register['parts_name']);
      $str = mb_strlen(trim($var));
      if ($str > 64){
        $err['parts_err'] = '64文字以内で入力してください';
      }
    }

    if (empty(trim($register['model_name']))) {
      $err['model_err'] = '型番を記入してください';
    } else {
      $var = Utils::checkInput($register['model_name']);
      $str = mb_strlen(trim($var));
      if ($str > 64){
        $err['model_err'] = '64文字以内で入力してください';
      }
    }

    if (empty(trim($register['manufact_name']))) {
      $err['manufact_err'] = 'メーカーを記入してください';
    } else {
      $var = Utils::checkInput($register['manufact_name']);
      $str = mb_strlen(trim($var));
      if ($str > 64){
        $err['manufact_err'] = '64文字以内で入力してください';
      }
    }

    if (empty(trim($register['category']))) {
      $err['category_err'] = 'カテゴリーを選んでください';
    } else {
      Utils::checkInput($register['category']);
    }

    if (empty(trim($register['size']))) {
      $err['size_err'] = 'サイズを入力してください';
    } else {
      $var = Utils::checkInput($register['size']);
      $str = mb_strlen(trim($var));
      if ($str > 64){
        $err['size_err'] = '64文字以内で入力してください';
      }
    }

    if (empty(trim($register['price']))) {
      $err['price_err'] = '値段を入力してください';
    } else {
      $var = Utils::checkInput($register['price']);
      $str = mb_strlen(trim($var));
      if ($str > 10){
        $err['price_err'] = '10桁以内で入力してください';
      }
    }

    if (empty(trim($register['supplier']))) {
      $err['supplier_err'] = '発注先を入力してください';
    } else {
      $var = Utils::checkInput($register['supplier']);
      $str = mb_strlen(trim($var));
      if ($str > 64){
        $err['supplier_err'] = '64文字以内で入力してください';
      }
    }

    if (empty($register['code'])) {
      if (empty(trim($register['phone']))) {
        $err['phone_err'] = '電話番号を入力してください';
      } else {
        $var = Utils::checkInput($register['phone']);
        $str = mb_strlen(trim($var));
        if ($str > 16){
          $err['phone_err'] = '16文字以内で入力してください';
        }
      }
    } else {
      $var = Utils::checkInput($register['code']);
      $str = mb_strlen(trim($var));
      if ($str > 16){
        $err['code_err'] = '16文字以内で入力してください';
      }
    }

    if (!is_uploaded_file($_FILES['image']['tmp_name'])) {
      $err['img_err'] = '画像を選択してください';
    } else {
      $file = $_FILES['image'];
      $filename = $file['name'];
      //拡張子確認
      $allow_ext = array('jpg', 'jpeg', 'png', 'webp');
      $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
      //入力された画像の拡張子を小文字に変える
      // 拡張子が許容された物と一致するか
      if (!in_array(strtolower($file_ext), $allow_ext)) {
        $err['img_err'] = '画像ファイルの拡張子は.jpg .jpeg .png .webp を選択してください';
      }
    }

    if (empty(trim($register['image_name']))) {
      $err['imgname_err'] = '画像名を入力してください';
    } else {
      $var = Utils::checkInput($register['image_name']);
      $str = mb_strlen(trim($var));
      if ($str > 16){
        $err['imgname_err'] = '16文字以内で入力してください';
      }
    }

    return $err;
  }

  /**
   * 部品検索バリデーション
   * @param array $parts
   * @return array $err
   */
  public static function searchParts()
  {
    $err = [];
    //パーツ検索セッションの値を評価
    if (isset($_SESSION['category'])) {
      $parts = $_SESSION['category'];
    } else {
      header('Location: mypage2.php');
      exit();
    }

    // if (empty(trim($parts['search']))) {
    //   $err['category_err'] = '検索方法を選択してください';
    // } else {
    //   Utils::checkInput($parts['search']);
    // }

    if (!empty(trim($parts))) {
      $var = Utils::checkInput($parts);
      $str = mb_strlen(trim($var));
      if ($str > 10){
        $err['search_category_err'] = '不正な入力';
    }

    }
    return $err;
  }

  /**
   * パーツ編集バリデーション
   * @param array $setparts
   * @return array $err
   */
  public static function editParts($register)
  {
    $err = [];
    //パーツ登録の値を評価
    if (empty($register)) {
      header('Location: mypage.php');
      exit();
    }

    if (empty(trim($register['part_name']))) {
      $err['parts_err'] = '部品名を記入してください';
    } else {
      $var = Utils::checkInput($register['part_name']);
      $str = mb_strlen(trim($var));
      if ($str > 64){
        $err['parts_err'] = '64文字以内で入力してください';
      }
    }

    if (empty(trim($register['model_name']))) {
      $err['model_err'] = '型番を記入してください';
    } else {
      $var = Utils::checkInput($register['model_name']);
      $str = mb_strlen(trim($var));
      if ($str > 64){
        $err['model_err'] = '64文字以内で入力してください';
      }
    }

    if (empty(trim($register['manufact_name']))) {
      $err['manufact_err'] = 'メーカーを記入してください';
    } else {
      $var = Utils::checkInput($register['manufact_name']);
      $str = mb_strlen(trim($var));
      if ($str > 64){
        $err['manufact_err'] = '64文字以内で入力してください';
      }
    }

    if (empty(trim($register['category']))) {
      $err['category_err'] = 'カテゴリーを選んでください';
    } else {
      Utils::checkInput($register['category']);
    }

    if (empty(trim($register['size']))) {
      $err['size_err'] = 'サイズを入力してください';
    } else {
      $var = Utils::checkInput($register['size']);
      $str = mb_strlen(trim($var));
      if ($str > 64){
        $err['size_err'] = '64文字以内で入力してください';
      }
    }

    if (empty(trim($register['price']))) {
      $err['price_err'] = '値段を入力してください';
    } else {
      $var = Utils::checkInput($register['price']);
      $str = mb_strlen(trim($var));
      if ($str > 10){
        $err['price_err'] = '10桁以内で入力してください';
      }
    }

    if (empty(trim($register['supplier']))) {
      $err['supplier_err'] = '発注先を入力してください';
    } else {
      $var = Utils::checkInput($register['supplier']);
      $str = mb_strlen(trim($var));
      if ($str > 64){
        $err['supplier_err'] = '64文字以内で入力してください';
      }
    }

    if (empty($register['code'])) {
      if (empty(trim($register['phone']))) {
        $err['phone_err'] = '電話番号を入力してください';
      } else {
        $var = Utils::checkInput($register['phone']);
        $str = mb_strlen(trim($var));
        if ($str > 16){
          $err['phone_err'] = '16文字以内で入力してください';
        }
      }
    } else {
      $var = Utils::checkInput($register['code']);
      $str = mb_strlen(trim($var));
      if ($str > 16){
        $err['code_err'] = '16文字以内で入力してください';
      }
    }
    return $err;
  }
}
