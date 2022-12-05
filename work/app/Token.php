<?php

class Token
{
  /**
   * CSRF対策：ワンタイムトークン
   * @param void
   * @return string $csrf_token
   */
  // トークン生成
  public static function setToken()
  {
    if (!isset($_SESSION['csrf_token'])) {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
  }
  
  // トークン照会
  public static function validateToken()
  {
    if (empty($_SESSION['csrf_token']) || 
    $_SESSION['csrf_token'] !== filter_input(INPUT_POST, 'csrf_token')) {
      exit('Invalid post request');
    }
  }
}
