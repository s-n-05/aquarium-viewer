<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Post extends Model
{
    // モデルとテーブルの紐づけ
    protected $table = 't_posts';

    use HasFactory;


    /**
     * ユーザ情報の取得
     *
     * @return Model
     */
    public function twitterUser()
    {
        return $this->hasOne('App\Models\TwitterUser','twitter_id','tweet_author_id');
    }


    /**
     * 投稿データの取得(新しい順)
     * 
     * @param Integer $pageCount 取得件数
     * @return Model
     */
    static function getPostNewPage($pageCount)
    {
        $data['posts'] = Post::orderBy('id', 'desc')->simplePaginate($pageCount);
        return $data;
    }


    /**
     * 投稿データの取得(ランダム)
     *
     * @param Integer $pageCount 取得件数
     * @return Model
     */
    static function getPostRandomPage($pageCount)
    {
        $data['posts'] = Post::inRandomOrder()->orderBy('id', 'desc')->simplePaginate($pageCount);
        return $data;
    }



    /**
    * ユーザー別の投稿データの取得
    *
    * @param Integer $pageCount 取得件数
    * @param String $twitter_id twitterのid
    * @return model 
    */
    static function getUserPage($pageCount,$twitter_id)
    {
        $data['posts'] = Post::where('tweet_author_id', '=', $twitter_id)->orderBy('id', 'desc')->simplePaginate($pageCount);
        return $data;
    }

    /**
    * 詳細ページの取得
    *
    * @param Integer $pageCount 取得件数
    * @param String $id twitterのid
    * @return model 
    */
    static function getDetailPage($pageCount,$tweet_id)
    {
        $data['posts'] = Post::where('tweet_id', '=', $tweet_id)->orderBy('id', 'desc')->simplePaginate($pageCount);
        return $data;
    }

    /**
     * ハッシュタグ別ページの取得
     *
     * @param Integer $pageCount
     * @param String $hashtag
     * @return Model
     */
    static function getHashTagPage($pageCount,$hashtag)
    {
        $hashtag = '#' . $hashtag . '';
        $hashtag_ = '%' . addcslashes($hashtag, '%_\\') . '%';
        $data['posts'] = Post::where('tweet_text', 'LIKE', "$hashtag_")->orderBy('id', 'desc')->simplePaginate($pageCount);

        Log::debug("hashtag:" . $hashtag_);

        return $data;
    }

    /**
     * ハッシュタグ別ページの取得(ランダム)
     *
     * @param Integer $pageCount
     * @param String $hashtag
     * @return Model
     */
    static function getHashTagRandomPage($pageCount,$hashtag)
    {
        $hashtag = '#' . $hashtag . '';
        $hashtag_ = '%' . addcslashes($hashtag, '%_\\') . '%';
        $data['posts'] = Post::where('tweet_text', 'LIKE', "$hashtag_")->inRandomOrder()->orderBy('id', 'desc')->simplePaginate($pageCount);
        return $data;
    }

}
