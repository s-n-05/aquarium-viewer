<?php

namespace App\Lib;

use Illuminate\Support\Facades\Log;

class My_func
{
  const POST_VIEW_KIND_NEW = 1;
  const POST_VIEW_KIND_RAND = 2;
  const POST_VIEW_KIND_HASHATAG_NEW = 3;
  const POST_VIEW_KIND_HASHATAG_RAND = 4;
  const POST_VIEW_KIND_USER_NEW = 5;

  /**
   * ツイートにリンク入れる
   *
   * @param String $tweet
   * @return String
   */
  public static function convert_clickable_links($tweet)
  {

    //ツイートテキストにツイートとURLが一緒に入っているので分割する
    $tweet_r = self::get_tweet_split($tweet);

    $tweet_text = $tweet_r["tweet_text"];
    $tweet_url = $tweet_r["tweet_url"];

    $tweet_text = str_replace("　", " ", $tweet_text);

    $input = htmlspecialchars($tweet_text, ENT_QUOTES, 'UTF-8');

    //すべてのhttp / https / wwwをリンクに変換
    $url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
    $input = preg_replace($url, '<a href="javascript:void(0);" class="external-link" onclick="external_link_click(arguments[0],this); return false;" target="_blank" title="$0" data-href="$0" rel="noopener noreferrer">$0</a>', $input);

    //hashtagをリンクに変換
    $output = preg_replace('/[#＃]([\w\x{05be}\x{05f3}\x{05f4}]*[\p{L}_\x{30FB}]+[\w\x{05be}\x{05f3}\x{05f4}]*)/u', "<a class=\"btn btn-outline-primary mt-1 mb-1\" href=\"" . url("/hashtag/") . "/$1\">#$1</a>", $input );

    //TwitterへのURLの処理
    $tweet_url = preg_replace($url, '<a href="javascript:void(0);" class="external-link btn btn-primary mt-1 mb-1" onclick="external_link_click(arguments[0],this); return false;" target="_blank" title="$0" data-href="$0" rel="noopener noreferrer">ツイートに移動(Twitterを開く)</a>', $tweet_url);


    return $output . '' . $tweet_url;
  }

  /**
   * ツイートの本文とURLを分割
   *
   * @param String $tweet
   * @return String
   */
  public static function get_tweet_split($tweet)
  {

    //後ろから"https://"を検索して位置を取得
    $pos =  mb_strrpos($tweet, "https://");

    //ツイートの最後のURL（ツイートのURL）以降のテキストを取得
    $tweet_temp = mb_substr($tweet, $pos, strlen($tweet), 'UTF-8');
    $pos2 =  mb_strpos($tweet_temp, "#");

    if($pos2){
      //URL（ツイートのURL）の後ろに'#'が存在するとき
      $tweet_url = mb_substr($tweet_temp, 0, $pos2, 'UTF-8');
    }else{
      $tweet_url = mb_substr($tweet_temp, 0, strlen($tweet), 'UTF-8');
    }

    $tweet_text = str_replace($tweet_url, '', $tweet);

    $data = array('tweet_text'=> $tweet_text, 'tweet_url'=> $tweet_url,);
    return $data;
  }


}
