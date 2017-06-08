<?php
 require "vendor/autoload.php";
 use Abraham\TwitterOAuth\TwitterOAuth;
 $consumer_key = 'onYRMfDAKslKaTxfRKyB4TaAy';
 $consumer_secret = 'aSJ0C6Q9CWJeYljnoQJZAqmKN71oGKAvV5yUCAZWRX1yCqJnc5';
 $access_token = '1949073762-w6Jd3JliZQnS679JKkWdEQNFtrb3hE7gHyhDjCP';
 $access_token_secret = '2xqpNfL39WUnthtrCAweLdT3CIFsTViw0ifSWFC06AlF6';

 $connection = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

 $userlist = [
  '2916574280', //月餅
  '3308832553', //いちか
  '3230451480', //ヒジリー
  '4609650378', //キジニワ
  '4689513738', //カラナシソウ
  '3226206517', //まさろー
  '1949073762', //にゃんぱす氏
  '2600025182', //ゆにてぃ
  '2665677865'  //マギアさん
 ];

  $lunaObj = $connection->get("users/show",["user_id"=>$userlist[0]]);
  $lunaId = $lunaObj->{"screen_name"};
  $lunaName = $lunaObj->{"name"};
  $lunaIcon = str_replace('_normal','',$lunaObj->{"profile_image_url_https"});
  $lunaDesc = str_replace("\n",'<br>',$lunaObj->{"description"});

  $ichikaObj = $connection->get("users/show",["user_id"=>$userlist[1]]);
  $ichikaId = $ichikaObj->{"screen_name"};
  $ichikaName = $ichikaObj->{"name"};
  $ichikaIcon = str_replace('_normal','',$ichikaObj->{"profile_image_url_https"});
  $ichikaDesc = str_replace("\n",'<br>',$ichikaObj->{"description"});

  $hijiriObj = $connection->get("users/show",["user_id"=>$userlist[2]]);
  $hijiriId = $hijiriObj->{"screen_name"};
  $hijiriName = $hijiriObj->{"name"};
  $hijiriIcon = str_replace('_normal','',$hijiriObj->{"profile_image_url_https"});
  $hijiriDesc = str_replace("\n",'<br>',$hijiriObj->{"description"});

  $kijiniwaObj = $connection->get("users/show",["user_id"=>$userlist[3]]);
  $kijiniwaId = $kijiniwaObj->{"screen_name"};
  $kijiniwaName = $kijiniwaObj->{"name"};
  $kijiniwaIcon = str_replace('_normal','',$kijiniwaObj->{"profile_image_url_https"});
  $kijiniwaDesc = str_replace("\n",'<br>',$kijiniwaObj->{"description"});

  $karanasiObj = $connection->get("users/show",["user_id"=>$userlist[4]]);
  $karanasiId = $karanasiObj->{"screen_name"};
  $karanasiName = $karanasiObj->{"name"};
  $karanasiIcon = str_replace('_normal','',$karanasiObj->{"profile_image_url_https"});
  $karanasiDesc = str_replace("\n",'<br>',$karanasiObj->{"description"});

  $masaObj = $connection->get("users/show",["user_id"=>$userlist[5]]);
  $masaId = $masaObj->{"screen_name"};
  $masaName = $masaObj->{"name"};
  $masaIcon = str_replace('_normal','',$masaObj->{"profile_image_url_https"});
  $masaDesc = str_replace("\n",'<br>',$masaObj->{"description"});

  $nyanpassObj = $connection->get("users/show",["user_id"=>$userlist[6]]);
  $nyanpassId = $nyanpassObj->{"screen_name"};
  $nyanpassName = $nyanpassObj->{"name"};
  $nyanpassIcon = str_replace('_normal','',$nyanpassObj->{"profile_image_url_https"});
  $nyanpassDesc = str_replace("\n",'<br>',$nyanpassObj->{"description"});

  $unityObj = $connection->get("users/show",["user_id"=>$userlist[7]]);
  $unityId = $unityObj->{"screen_name"};
  $unityName = $unityObj->{"name"};
  $unityIcon = str_replace('_normal','',$unityObj->{"profile_image_url_https"});
  $unityDesc = str_replace("\n",'<br>',$unityObj->{"description"});

  $magiaObj = $connection->get("users/show",["user_id"=>$userlist[8]]);
  $magiaId = $magiaObj->{"screen_name"};
  $magiaName = $magiaObj->{"name"};
  $magiaIcon = str_replace('_normal','',$magiaObj->{"profile_image_url_https"});
  $magiaDesc = str_replace("\n",'<br>',$magiaObj->{"description"});
