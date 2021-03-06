<?php
//-----------------------------------------------------------------------//
//htmlspecialcharsを簡単にする
//function h(引数１,引数２,引数３){}
//概要：[引数１]に無害化する値を入れる[]
//-----------------------------------------------------------------------//

function h($value) {
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
//-----------------------------------------------------------------------//
//本文内のURLリンクを設定
//function makeLinl(引数1){}
//概要：[引数1]内のURLを見つけて[<a href="URL">URL</a>]というタグを作成して返す
//-----------------------------------------------------------------------//

function makeLink($value) {
    return mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;¥?\.%,!#~*/:@&=_-]+)", '<a href="\1\2">\1\2</a>', $value);
}
?>