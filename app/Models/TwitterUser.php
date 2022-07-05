<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwitterUser extends Model
{
    // モデルとテーブルの紐づけ
    protected $table = 't_twitter_users';

    //primaryKeyの変更
    // protected $primaryKey = "twitter_id";


    use HasFactory;

    public function posts()
    {
        return $this->hasMany('App\Models\Post','tweet_author_id','twitter_id');
    }


    /**
    * ユーザー詳細の取得(twitter_usernameから取得)
    *
    * @param string $twitter_username twitterのusername
    * @return model 
    */
    static function getUserDetailsByUserName($twitter_username)
    {
        $data = TwitterUser::where('twitter_username', '=', $twitter_username)->first();
        return $data;
    }


}
