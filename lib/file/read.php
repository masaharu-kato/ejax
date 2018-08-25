<?php
namespace File;
    
//  ファイルを読み込みページとして出力する
//  $path: サーバー内におけるファイルのパス
//  $type: ファイルの種類
//  $f_inline: ブラウザ上で表示するかどうか(true:ブラウザ上で表示, false:ダウンロードさせる)
    function read($path, $type, $f_inline = true) {

        $path_parts = pathinfo($path);

        header('Content-Type: ' . $type);
        header('Content-Disposition: '.($f_inline ? 'inline': 'attachment').'; filename="' . $path_parts['basename'] . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);

    }

?>