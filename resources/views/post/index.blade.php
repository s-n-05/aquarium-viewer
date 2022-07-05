@extends('layout.common')
@section('pageCss')
<style>
</style>
@endsection
@section('pageScript')
  <script>
    window.addEventListener('load', function() {

      const p_count = @json($posts->count());
      if (p_count == 0){
        let main_elem = document.getElementById("main");
        main_elem.classList.remove("bg-gradient-main");
        main_elem.classList.remove("bubble-background");

        let body = document.body;
        body.classList.add("bg-gradient-main");
        body.classList.add("bubble-background");
      }

      window.addEventListener('scroll', scrollEvent);
      function scrollEvent() {
          let c_elem = document.getElementById("fixed-content");

          if(window.scrollY > 2000 && window.scrollY < 3000){          
            c_elem.style.display = "block";
          }else if(window.scrollY > 3000){ 
            c_elem.style.display = "none";
            window.removeEventListener('scroll', scrollEvent);
          }
      }


      var msnry = new Masonry( '#masonry', {
      });

      if ( document.querySelector('.pagination a[rel=next]') ) {
        var infScroll = new InfiniteScroll( '.scroll_area', {
          path : ".pagination a[rel=next]",
          append : ".post",
          outlayer: msnry,
          hideNav: '.pagination',
          status: '.scroller-status',
          history: 'false',
          scrollThreshold: 700,
          loading: {
            msgText : '読み込み中'
          }
        });
      }

    })

    function external_link_click(e,t,title){
      Swal.fire({
        title: '外部リンクを開きますか？' + "\n" + e.target.dataset.href,
        showCancelButton: true,
        confirmButtonText: '開く',
        denyButtonText: '閉じる',
        cancelButtonText:'閉じる',
        confirmButtonColor: '#0D6EFD',
      }).then((result) => {
        if (result.isConfirmed) {
          //開くボタン押下
          window.open(e.target.dataset.href, '_blank')
        }
      })
    }

    async function inquiry_link_click(e,t){

      let tweetid = e.target.dataset.tweetid;

      const { value: type } = await Swal.fire({
        title: 'どのような問題がありますか？',
        input: 'select',
        inputOptions: {
            type1: '不適切な投稿である',
            type2: '投稿画像に問題がある',
            type3: 'ツイート内容に問題がある',
            type4: '画像を削除してほしい'
        },
        inputPlaceholder: 'ここを選択して選んでください。',
        showCancelButton: true,
        confirmButtonText: '送信',
        denyButtonText: '閉じる',
        cancelButtonText:'閉じる',
        confirmButtonColor: '#0D6EFD',
        inputValidator: (value) => {
          return new Promise((resolve) => {
            if (value === '') {
              resolve('選択してください。')
            } else {
              resolve()
            }
          })
        }
      })

      if (type) {
        axios.post("https://aquariumviewer-mt5g8psflkplg6.herokuapp.com/tweetinquiry", {
            tweetid: tweetid,
            type: type
        }).then(function(response) {
            let data = response.data;
            if(data.status = "OK"){
              Swal.fire('送信しました。', '', 'success');
            }else{
              Swal.fire('送信に失敗しました。', '', 'error');
            }
        }).catch(function (error) {
            Swal.fire('送信に失敗しました。', '', 'error');
        })
      }
    }
  </script>
@endsection

@section('content')

  <div id="fixed-content" class="fixed-content p-sm-1 p-md-2 bg-white rounded-3 bg-transparent" style="display:none;">
    <div class="alert alert-info alert-dismissible fade show" role="alert">
      <p>こんな水族館がオススメです&#x1f41f;</p>
      <ul class="list-unstyled mb-0">
      @foreach($aquariums['aquariums'] as $key => $aquarium)
        <li>
          <a class="btn btn-outline-primary mt-1 mb-1" href='{{url("/random/hashtag/".$aquarium->name)}}'>{{$aquarium->name}}</a>
        </li>
      @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>

  <div class="py-2">
    <div class="container mb-2">
      <div class="p-1 rounded text-center">
        @if($kind == My_func::POST_VIEW_KIND_HASHATAG_NEW || $kind == My_func::POST_VIEW_KIND_HASHATAG_RAND)
          {{-- 最新順に表示時(ハッシュタグ) OR ランダム表示時(ハッシュタグ) --}}
          <p class="hashtag display-5 d-inline-block p-2">#{{$hashtag}}</p>
        @endif

        <div class="shadow bg-transparent rounded-3 text-center p-2">
          <p class="mb-1 text-white text-center">
            {{$text_1}}
          </p>
            @if($kind == My_func::POST_VIEW_KIND_NEW)
              {{-- 最新順に表示時(全体の投稿から) --}}
              <a class="btn btn-primary border border-white" href='{{url("/random/")}}'>{{$text_2}}</a>
            @elseif($kind == My_func::POST_VIEW_KIND_RAND)
              {{-- ランダム表示時(全体の投稿から) --}}
              <a class="btn btn-primary border border-white" href='{{url("/")}}'>{{$text_2}}</a>
            @elseif($kind == My_func::POST_VIEW_KIND_HASHATAG_NEW)
              {{-- 最新順に表示時(ハッシュタグ) --}}
              <a class="btn btn-primary border border-white" href='{{url("/random/hashtag/".$hashtag)}}'>{{$text_2}}</a>
            @elseif($kind == My_func::POST_VIEW_KIND_HASHATAG_RAND)
              {{-- ランダム表示時(ハッシュタグ) --}}
              <a class="btn btn-primary border border-white" href='{{url("/hashtag/".$hashtag)}}'>{{$text_2}}</a>
            @endif
        </div>

        @if($posts->count() == 0)
          <p class="text-white pt-5 pb-5">申し訳ありません...表示する内容がありません。</p>
        @endif
      </div>
    </div>

    <div class="container">
      <div id="masonry" class="scroll_area row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 g-3">

        @foreach($posts as $key => $post)
          <div class="col post">
            <div class="card shadow h-100 bg-lb bg-transparent">
              <div class="card-body">
                <!-- Modal -->
                <div class="modal fade" id="modal-tweet-{{$post->tweet_id}}" tabindex="-1" aria-labelledby="modal-tweet-label-{{$post->tweet_id}}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modal-tweet-label-{{$post->tweet_id}}">
                          {{$post->twitterUser->twitter_name."さん" .'(@'.$post->twitterUser->twitter_username.')'}}のツイート
                          <a class="btn btn-sm btn-primary" href='{{url("/user/".$post->twitterUser->twitter_username)}}'>この投稿者の他の画像をみる</a>
                        </h5>
                        <button type="button" class="btn-sm btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div>{!! My_func::convert_clickable_links($post->tweet_text) !!}</div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">閉じる</button>
                      </div>
                    </div>
                  </div>
                </div><!-- Modal -->

              @if($post->tweet_media_url_1 !== '')
                <div class="card-img-box">
                  <img class="bd-placeholder-img card-img-top lazyload" src="{{ $post->tweet_media_url_1 }}?format=jpg&name=small" data-src="{{ $post->tweet_media_url_1 }}?format=jpg&name=small" alt="画像1" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
                  <a class="" href='{{url("/hashtag/".$post->tweet_aquarium_hashtag)}}'>{{$post->tweet_aquarium_hashtag}}</a>
                </div>
              @endif

              @if($post->tweet_media_url_2 !== '')
                <img class="bd-placeholder-img card-img-top lazyload" src="{{ $post->tweet_media_url_2 }}?format=jpg&name=small" data-src="{{ $post->tweet_media_url_2 }}?format=jpg&name=small" alt="画像2" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
              @endif

              @if($post->tweet_media_url_3 !== '')
                <img class="bd-placeholder-img card-img-top lazyload" src="{{ $post->tweet_media_url_3 }}?format=jpg&name=small" data-src="{{ $post->tweet_media_url_3 }}?format=jpg&name=small" alt="画像3" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
              @endif

              @if($post->tweet_media_url_4 !== '')
                <img class="bd-placeholder-img card-img-top lazyload" src="{{ $post->tweet_media_url_4 }}?format=jpg&name=small" data-src="{{ $post->tweet_media_url_4 }}?format=jpg&name=small" alt="画像4" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}'">
              @endif

                <div class="d-flex justify-content-center align-items-center mt-2">
                  <div class="btn-group">
                    <a class="btn btn-sm btn-primary active" data-bs-toggle="modal" data-bs-target="#modal-tweet-{{$post->tweet_id}}">
                      <i class="fas fa-info-circle"></i> 情報
                    </a>
                    <a class="btn btn-sm btn-secondary" href='javascript:void(0);' onclick="inquiry_link_click(arguments[0],this); return false;" data-tweetid="{{ $post->tweet_id }}"><i class="fas fa-flag"></i> 報告</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        @endforeach

      </div>
    </div>
  </div>

  <div class="scroller-status" style="display:none;margin-top:60px;">
    <div class="container text-center text-white">
      <div class="infinite-scroll-request loader-ellips loader">
        読み込み中です...
      </div>
      <p class="infinite-scroll-last">これ以上表示するデータがありません...&#x1f41f;</p>
      <p class="infinite-scroll-error">データをロードできませんでした。</p>
    </div>
  </div>

  {{ $posts->links('pagination::mypagination') }}

  <div class="text-center bg-transparent" role="alert" style="margin-top:30px;margin-bottom:10px;">
      <p class="text-white">こんな水族館がオススメです＞&#x1f41f;</p>
      <ul class="list-unstyled mb-0">
      @foreach($aquariums['aquariums'] as $key => $aquarium)
        <li>
          <a class="btn btn-primary mt-1 mb-1" href='{{url("/random/hashtag/".$aquarium->name)}}'>{{$aquarium->name}}</a>
        </li>
      @endforeach
      </ul>
  </div>

  <div class="bg-transparent" role="alert" style="margin-top:30px;margin-bottom:10px;">
    <div class="d-flex justify-content-center align-items-center mt-2">
      <div class="btn-group">
        <a class="btn btn-primary active" href='{{url("/")}}'>新しい順で表示</a>
        <a class="btn btn-primary" href='{{url("/random")}}'>ランダムで表示</a>
      </div>
    </div>
  </div>




@endsection

@include('layout.submenu')
