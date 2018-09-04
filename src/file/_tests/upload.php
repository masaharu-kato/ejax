<?php
namespace Ejax\File;

//  一時ファイルができているか（アップロードされているか）を確認する
    if(!is_uploaded_file($_FILES['up_file']['tmp_name'])) die('File not uploaded.');

//  一時ファイルを保存ファイルにコピーできたかを確認する
    if(!move_uploaded_file($_FILES['up_file']['tmp_name'],"./".$_FILES['up_file']['name'])) die('Failed to save file. (Permission Error)');

    echo 'OK';
?>