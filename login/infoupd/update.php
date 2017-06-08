<?php
$pageLevel = 2;
include_once("../load.php");//アクセス制限用
include_once("../template.php");//テンプレート用（左バー）


$date = date('Y/m/d');  //日付取得
$new = $date." ".$_POST['content']; //新規内容＝日付＋送信内容
$base = file_get_contents('../../info.html');  //元のinfo.htmlを取得
$put = str_replace('<!--replace-->',"<!--replace-->\n<p>".$new."</p>",$base); //info.html内の<!--replace-->と記述されている場所に新規内容挿入
file_put_contents('../../info.html',$put); //データ書き込み

$noti = [
  "title"=>"luna-labo.net更新通知",
  "body"=>$_POST['content'],
  "icon"=>"https://luna-labo.net/luna.jpg",
  "url"=>"https://luna-labo.net",
  "apikey"=>"00cb73df0f6a46f39d55e02ed2fcfa11"
];  //通知内容作成

$jsonTxt = json_encode($noti);//通知内容をjsonでencode
$ch = curl_init("https://api.push7.jp/api/v1/072a3abe42d7411b91099a44a61d44da/send");//送信先URL指定
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,POST);//POSTで送信
curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-type: Application/json']);//ヘッダーにコンテンツタイプがjsonであることを記述
curl_setopt($ch,CURLOPT_POSTFIELDS,$jsonTxt);//postの送信内容を$jsonTxtに設定
curl_exec($ch);//送信
curl_close($ch);//終了
?>

<a href="/">TOPへ戻る</a>
</div></div></body></html>
