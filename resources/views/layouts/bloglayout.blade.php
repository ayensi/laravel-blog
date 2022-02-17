<html><head>
    <meta charset="utf-8">
    <link rel = "icon" href =
    "{{asset('images/icon.png')}}"
          type = "image/x-icon">
    <title>Okan Altun Blog</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/stars.css')}}" rel="stylesheet">



    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900&amp;display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="blog.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            @if(@auth()->id())
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="{{route('index')}}">Homepage</a>
            </div>
            @else
                <div class="col-4 text-center">
                    <a class="blog-header-logo text-dark" href="{{route('index')}}">Homepage</a>
                </div>
            @endif
            @if(!@auth()->id())
                <div class="col-2 d-flex justify-content-end align-items-center">
                    <form method="get" action="{{route('searchedArticles')}}">
                        @csrf
                    <div class="form-outline mr-3 mb-2">
                        <input name="article_search" type="search" id="form1" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-primary mr-3 mb-2">
                        <i class="fas fa-search"></i>
                    </button>
                    </form>
                    <a class="btn btn-sm btn-outline-secondary mb-2" href="{{route('login')}}">Login</a>
                    <a class="btn btn-sm btn-outline-secondary mb-2" href="{{route('register')}}">Register</a>
                </div>
            @else

                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <form method="get" action="{{route('searchedArticles')}}">
                            @csrf
                        <div class="form-outline mr-3 mb-2">
                            <input name="article_search" type="search" id="form1" class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-primary mr-3 mb-2">
                            <i class="fas fa-search"></i>
                        </button>
                        </form>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-sm btn-outline-secondary mt-2" href="{{route('logout')}}">Log out</button>
                </form>
                    </div>
            @endif


        </div>
    </header>

   <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
          @foreach ($categories as $category)
              <form method="get" action="{{route('blogs.filtered')}}">
                  @csrf
                  <input type="hidden" name="id" value="{{$category->id}}">
            <button type="submit" class="btn btn-dark" href="#">{{$category->category_name}}</button>
              </form>
            @endforeach
        </nav>
   </div>
</div>

<main class="container">

@yield('content')
</main>





</body></html>
