<?php

require_once __DIR__ . '/vendor/autoload.php';
//composerが自動生成するfile。依存関係を解決してダウンロード
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
//phpでは変数名の前に'$'記号が付きます
//変数httpClientに環境変数'CHANNEL_ACCESS_TOKEN'の値を取得(getenv : 環境変数の値を取得)
$bot =new \LINE\LINEBot($httpClient,['channelSecret' => getenv('CHANNEL_SECRET')]);
//変数botに環境変数'ChannelSecret'の値を取得
$signature = $_SERVER["HTTP_" . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
//変数signatureに、オブジェクト_SERVERのkey''の値を代入？
try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log("parseEventRequest failed. InvalidSignatureException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log("parseEventRequest failed. UnknownEventTypeException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log("parseEventRequest failed. UnknownMessageTypeException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log("parseEventRequest failed. InvalidEventRequestException => ".var_export($e, true));
}
//err処理っぽいよね。たぶんinput時の

foreach ($events as $event) {
  //foreach処理。eventsオブジェクトの値が順に変数eventに代入されてはループする
  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent)) {
    error_log('Non message event has come');
    continue;
  }
    //メッセージ以外の場合にエラーを吐いてcontinueで抜け
    //if (!($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
    //  error_log('Non text message has come');
    //  continue;
    //}//テキスト以外の場合もエラー吐いてcontinueで抜け
    
    $text = $event->getText();
    function say($word){
      $bot->replyText($event->getReplyToken(), $word);
    } 
    //記述を簡単にするためのコード

    switch($event->getText()){
      case 'てす' :
        $bot->replyText($event->getReplyToken(), 'にゃーん');
        break;

      default :
        if(preg_match("/荒|野|行|動|走|野郎/u", $text)){
          $phrase = array(
            '遠ざかって行く英雄、その後ろは人々の期待と荒野の夕焼け',
            '平和な生活は我が夢、しかし挫折の前に、高まる戦意は我が心',
            '米蒔くも罪ぞよ鶏が蹴合うぞよ',
            '英雄は困難を恐れない、続ければきっと勝利を招く',
            '親愛なる荒野エリート達:荒野行動へようこそ。',
            '草は風を知り、戦場は英雄を知る。',
            '荒野の群雄、困難を克服して、仲間を信じて、前に向かって突き進む',
            '一番切れる剣は箱の底に置かない。英雄も同様',
            '武器と補給等、通常は建築に出現する',
            '左手射撃と右手エイム設定が最も効率が良い',
            '野に生きる草木のようにたくましく生きよ',
            '仲間と共に困難を乗り切れ:背中を預けられる友と一緒に戦え',
            '最後の生存者、荒野の光',
            'あとチョット、もう一局！',
          );
          $meigen = $phrase[array_rand($phrase, 1)];
          $bot->replyText($event->getReplyToken(), $meigen);
        }
        if(preg_match("/戦況/u", $text)){
          $bot->replyText($event->getReplyToken(),"調整中だよ(はあと");
        }


        if(preg_match("/日付/u", $text)){

//          $json = file_get_contents('senkyou.json');
//          if($json === false){
//            error_log('File loading error - senkyou.json');
//          }
//          $data = json_decode($json, true);
//          if($data->{"date"} < date("Y-m-d H:i:s" ,strtotime("-1 day"))){
            $fp = fopen("senkyou.txt",'r');
            //読み込みモードでファイルを開く
            if($fp === false){
              error_log("file open error");
            }
            $date = fgets($fp);
            $key = fgets($fp);
            $date = rtrim($date);
            $date = (float)$date;
            $hour5 = $date - (5 * 60 * 60);
            $bot->replyText($event->getReplyToken(), '$key='.$key.'5時間前='.$hour5.'型='.gettype($date));
            $yogen = '良い';
           if(rand(0 ,10) >= 7){
              $yogen = '悪い';
           }
//           $data->{"date"} = date("Y-m-d H:i:s");
//           $data->{"key"} = $yogen;
//           $jsonfile = fopen('senkyou.json', 'w+b');
//           fwrite($jsonfile, json_encode($data));
//           fclose($jsonfile);
//          }else{
//            $yogen = $data->key;
//          }
           $bot->replyText($event->getReplyToken(),'戦況予想：'.$yogen);
          }
        if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
          /*  $image = rand(1, 10);
          say($image);
          if($image > 5){
            $image = rand(1, 10);
            if($image >= 8){
              $bot->replyText($event->getReplyToken(), 'ヌいた');
            }else if($image >= 6){
              $bot->replyText($event->getReplyToken(), 'シコい');
            }else if($image >= 4){
              $bot->replyText($event->getReplyToken(), 'シコくない');
            }else if($image > 1){
              say('ヌけない');
            }else{
              say('エラーでち！');
            }
          }*/
        }
    }
    
}
    //たぶんここが主の挙動
    //ここで分岐させて、いろんな条件加えて...って作ってったら良さそうだな
    //$bot->replyText($event->getReplyToken(), $event->getText());
    /*$profile = $bot->getProfile($event->getUserId())->getJSONDecodedBody();
    $message = $profile["displayName"] . "さん、おはようございます！今日も頑張りましょう！";
    $bot->replyMessage($event->getReplyToken(),
      (new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder())
        ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message))
        ->add(new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1, 114))
    );*/

  //ここに書いた奴は何打っても返信するタイプ（分岐いらないタイプ)
  //replyTextMessage($bot, $event->getReplyToken(), "TextMessage");
  //replyImageMessage($bot, $event->getReplyToken(), "https://" . $_SERVER["HTTP_HOST"] . "/imgs/original.jpg", "https://" . $_SERVER["HTTP_HOST"] . "/imgs/preview.jpg");

  //んで、こっから下は呼び出す関数
  function replyTextMessage($bot, $replyToken, $text) {
    $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text));
    if (!$response->isSucceeded()) {
      error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
    }
  }
  function replyImageMessage($bot, $replyToken, $originalImageUrl, $previewImageUrl) {
    $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalImageUrl, $previewImageUrl));
    if (!$response->isSucceeded()) {
      error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
    }
  }
?>