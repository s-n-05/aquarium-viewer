<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\TwitterUser;
use Illuminate\Support\Facades\Log;
use App\Lib\My_func;
use App\Models\Aquarium;
use App\Models\Inquiry;

class PostController extends Controller
{

    /**
     * 報告を送信
     *
     * @param Request $request 
     * @return void
     */
    public function send_inquiry(Request $request) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With");
        $tweetid = $request->tweetid;
        $type = $request->type;

        if($type=='type4'){
            Post::where('tweet_id', $tweetid)->delete();
        }else{
            $inquiry = new Inquiry();
            $inquiry->tweet_id = $tweetid;
            $inquiry->content = '';
            $inquiry->sender_info = '';
            //saveメソッドが呼ばれると新しいレコードがデータベースに挿入される
            $inquiry->save();
    
        }
        return response()->json(['status' => 'OK']);
    }

    /**
     * 一覧ページ表示
     *
     * @return void
     */
    public function index()
    {
        $data = Post::getPostNewPage(pageCount:4);

        $kind = My_func::POST_VIEW_KIND_NEW;
        $text_1 = "";
        $text_2 = "ランダムで表示する";

        $aquariums = Aquarium::getRandomData(pageCount:3);

        return view('post/index', $data)->with([
            "kind" => $kind,
            "text_1" => $text_1,
            "text_2" => $text_2,
            "aquariums" => $aquariums,
         ]);
    }

    /**
     * ランダムページ表示
     *
     * @return void
     */
    public function random()
    {
        $data = Post::getPostRandomPage(pageCount:4);

        $kind = My_func::POST_VIEW_KIND_RAND;
        $text_1 = "";
        $text_2 = "新しい順で表示する";

        $aquariums = Aquarium::getRandomData(pageCount:3);

        return view('post/index', $data)->with([
            "kind" => $kind,
            "text_1" => $text_1,
            "text_2" => $text_2,
            "aquariums" => $aquariums,
         ]);
    }

    /**
     * ハッシュタグ表示（新しい順）
     *
     * @param String $hashtag
     * @return void
     */
    public function hashtag($hashtag)
    {
        $data = Post::getHashTagPage(pageCount:4,hashtag:$hashtag);

        $kind = My_func::POST_VIEW_KIND_HASHATAG_NEW;
        $text_1 = "新しい順";
        $text_2 = "「#" . $hashtag . "」の画像をランダムで表示してみる";

        $aquariums = Aquarium::getRandomData(pageCount:3);

        return view('post/index', $data)->with([
            "kind" => $kind,
            "text_1" => $text_1,
            "text_2" => $text_2,
            "hashtag" => $hashtag,
            "aquariums" => $aquariums,
        ]);
    }

    /**
     * ハッシュタグ表示（ランダム）
     *
     * @param String $hashtag
     * @return void
     */
    public function hashtag_random($hashtag)
    {
        $data = Post::getHashTagRandomPage(pageCount:4,hashtag:$hashtag);

        $kind = My_func::POST_VIEW_KIND_HASHATAG_RAND;
        $text_1 = "ランダム表示";
        $text_2 = "「#" . $hashtag . "」の画像を新しい順で表示してみる";

        $aquariums = Aquarium::getRandomData(pageCount:3);

        return view('post/index', $data)->with([
            "kind" => $kind,
            "text_1" => $text_1,
            "text_2" => $text_2,
            "hashtag" => $hashtag,
            "aquariums" => $aquariums,
        ]);
    }

    /**
     * ユーザーページ表示
     *
     * @param String $twitter_username
     * @return void
     */
    public function user($twitter_username)
    {
        //ユーザー情報の取得
        $user = TwitterUser::getUserDetailsByUserName(twitter_username:$twitter_username);

        if(is_null($user)){
            // ユーザー該当なし
            return abort(404);
        }

        //ユーザー別の投稿データの取得
        $data = Post::getUserPage(pageCount:6,twitter_id:$user->twitter_id);

        $kind = My_func::POST_VIEW_KIND_USER_NEW;
        $text_1 = "";
        $text_2 = "";

        if($data['posts']->count() == 0){
            // ユーザー該当なし
            return abort(404);
        }else{

            $text_1 = $data['posts'][0]->twitterUser->twitter_name . "さん" . '(@'.$data['posts'][0]->twitterUser->twitter_username . ")の画像を表示しています。";
            $title = $data['posts'][0]->twitterUser->twitter_name . "さん" . '(@'.$data['posts'][0]->twitterUser->twitter_username . ")の画像";

            $aquariums = Aquarium::getRandomData(pageCount:3);

            return view('post/index', $data)->with([
                "kind" => $kind,
                "text_1" => $text_1,
                "text_2" => $text_2,
                "aquariums" => $aquariums,
            ]);
        }
    }

}
