<?php

class GetError
{
  // 現在使用していない
  public static function Errors()
  {
    set_error_handler(function($errno, $errstr, $errfile, $errline) {
      if (!(error_reporting() & $errno)) {
        return;
      }
      throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
    });
  }
}
