<!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" itemprop="description" content="@yield('description')">
    <meta name="robots" content="noindex">
    <meta name="robots" content="nofollow">
    <meta name="keywords" itemprop="keywords" content="@yield('keywords')">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>@yield('title') - AquariumViewer</title>
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bubble.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    @yield('pageCss')
  </head>
  <body class="d-flex flex-column" style="min-height: 100vh">
    <header>

      <div class="navbar navbar-dark gradient shadow-sm">
        <div class="container">
          <a href="{{url('/')}}" class="navbar-brand d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            <strong>AquariumViewer</strong>
          </a>

          <div class="d-flex justify-content-start">
            <small class="m-sm-1 m-md-2 text-white"></small>
            <div class="d-flex align-items-center">
              <a id="qr-link" class="btn btn-sm btn-primary">
                スマホ用QRコードを表示
              </a>
              <a id="qr-link" class="btn btn-sm btn-secondary" href="https://github.com/s-n-05/aquarium-viewer">
                GitHub
              </a>
            </div>
          </div>
        </div>
      </div>
    </header>

    <main id="main" class="bg-gradient-main bubble-background">
        <!-- 共通メニュー -->
        <div class="sub">
            @yield('submenu')
        </div>

        @yield('content')
    </main>

    <footer class="footer mt-auto py-3" style="background:#000;">
      <div class="footer-container">
        <span class="text-muted text-center">© AquariumViewer</span>
      </div>
    </footer>

    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/infinite-scroll-v4.0.1.pkgd.min.js') }}"></script>
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('/js/intersection-observer.js') }}"></script>
    <script src="{{ asset('/js/bubble.js') }}"></script>
    <script>
        window.addEventListener('load', function() {

          function qrClick(){
            Swal.fire({
              title: 'QRコード',
              html: '<p>スマホやタブレットでも見ることができます。</p><img src="{{ asset('images/QR.png') }}" alt="QRコード" width="160" height="160">',
              denyButtonText: '閉じる',
              cancelButtonText:'閉じる',
              confirmButtonColor: '#0D6EFD',
            }).then((result) => {
            })
          }

          let qr_link = document.getElementById('qr-link');
          qr_link.addEventListener('click', qrClick);

        });
    </script>

    @yield('pageScript')

  </body>
</html>
