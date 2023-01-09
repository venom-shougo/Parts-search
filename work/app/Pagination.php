<?php

class Paging{

  /**
   * ページネーション処理
   *
   * @param string $totalPage
   * @param integer $nowPage
   * @param integer $pageRange
   * @param string $url
   * @return void
   */
  public static function paging($totalPage, $nowPage, $pageRange, $url) {

    $prev = max($nowPage - 1, 1);
    $next = min($nowPage + 1, $totalPage);

    $start = max($nowPage - $pageRange, 2); // ページ番号始点
    $end = min($nowPage + $pageRange, $totalPage - 1); // ページ番号終点

    // ページ番号格納
    $nums = []; // ページ番号格納用
    for ($i = $start; $i <= $end; $i++) {
      $nums[] = $i;
    }

    //ページ式別
    switch ($url) {
      case '/get_parts.php':
        $page_url = $url;
        break;
      case '/get_history.php';
        $page_url = $url;
        break;
      case '/search_history.php':
        $page_url = $url;
        break;
    }

    //最初のページへのリンク
    if ($nowPage > 1) {
      print '<li class="page-item"><a class="page-link" rel="prev" href="'.($page_url).'?page=1">≪</a></li>';
    } else {
      print '';
    }

    // 前のページへのリンク
    if ($nowPage > 1) {
      print '<li class="page-item"><a class="page-link" rel="prev" href="'.($page_url).'?page='.($prev).'">前</a></li>';
    } else {
      print '';
    }

    // 最初のページ番号へのリンク
    if ($nowPage > 1) {
      print '<li class="page-item"><a class="page-link" rel="prev" href="'.($page_url).'?page='.($nowPage - $prev).'">1</a></li>';
    } else {
      print '<li class="page-item active"><a class="page-link">' .($nowPage). '</a></li>';
    }

    if ($start > $pageRange) print '<li class="page-item disabled"><a class="page-link">…</a></li>'; // ドットの表示

    //ページリンク表示ループ
    foreach ($nums as $num) {

      // 現在地のページ番号
      if ($num == $nowPage) {
        print '<li class="page-item active"><a class="page-link">' .($nowPage). '</a></li>';
      } else {
        // ページ番号リンク表示
        print '<li class="page-item"><a class="page-link" rel="" href="'.($page_url).'?page='.($num).'">'.($num).'<span class="visually-hidden">(現ページ)</span></a></li>';
      }
    }

    if (($totalPage - 1) > $end) print '<li class="page-item disabled"><a class="page-link">…</a></li>'; //ドットの表示

    //最後のページ番号へのリンク
    if ($nowPage < $totalPage) {
      print '<li class="page-item"><a class="page-link" rel="" href="'.($page_url).'?page='.($totalPage).'">'.($totalPage).'<span class="visually-hidden">(現ページ)</span></a></li>';
    } elseif ($totalPage == 1) {
      print '';
    } else {
      print '<li class="page-item active"><a class="page-link">' .($totalPage). '</a></li>';
    }

    // 次のページへのリンク
    if ($nowPage < $totalPage) {
      print '<li class="page-item"><a class="page-link" rel="next" href="'.($page_url).'?page='.($next).'">次</a></li>';
    } else {
      print '';
    }

    //最後のページへのリンク
    if ($nowPage < $totalPage) {
      print '<li class="page-item"><a class="page-link" href="'.($page_url).'?page='.($totalPage).'">≫</a></li>';
    } else {
      print '';
    }
  }
}
