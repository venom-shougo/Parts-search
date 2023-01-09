<?php

// 現在使用していない

class Multibyte
{
  public static function mbChar($str)
  {
    //ひらがなのみか判断
    if (preg_match('/^[ぁ-ゞ]+$/u', $str)) {
      $str = mb_convert_kana($str, "c");
      return $str;
    } else {
      return $str;
    }

    //カタカナのみか検索
    if (preg_match('/^[ァ-ヾ]+$/u', $str)) {
      return $str;
    } else {
      $str = mb_convert_kana($str, "C");
      return $str;
    }
  }
}
