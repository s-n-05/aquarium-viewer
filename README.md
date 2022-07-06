<p align="center">
aquarium-viewer
</p>

## サービス内容

Twitterに投稿されている水族館の写真を閲覧できるビューア

![AGDRec_Trim_Trim_400x250](https://user-images.githubusercontent.com/108703232/177446123-0d05340f-ab20-4fc8-afc2-7b8534f92cd6.gif)


## 開発の目的

- Laravel学習のため
- Twitterは投稿画像のサイズによってはタイムラインに表示されるサイズが元のものではなく、トリミングされた状態で表示されるので見づらいことも多いので、それを解消したかった。

## URL (DEMO)

https://aquariumviewer-mt5g8psflkplg6.herokuapp.com/

## 環境

- Laravel
- Heroku

## ツイートの取得について
別のPythonで作成したプログラムで「Twitter API」を使用してツイートを取得してMySQLに登録しています。