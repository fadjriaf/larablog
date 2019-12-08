<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Tutorial</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>
    <body>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Laravel Tutorial</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
              </li>
            </ul>

            <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
                @guest
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                  </li>
                @else
                  <a href="{{ route('post.create') }}" class="btn btn-success my-2 my-sm-0">Create Post</a>

                      <!-- <li class="nav-item dropdown">
                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                              {{ Auth::user()->name }} <span class="caret"></span>
                          </a>

                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="{{ route('logout') }}"
                                 onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                  {{ __('Logout') }}
                              </a>

                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  @csrf
                              </form>
                          </div>
                      </li> -->
                @endguest
          </ul>
        </div>
      </nav>

          <div class="container py-3">
            @if (Session::has('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Success!</h4>
                <p>{{ Session::get('success') }}</p>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif

            @if (Session::has('errors'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Error!</h4>

                <p>
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </p>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
          
          @auth
          <div class="alert alert-danger" role="alert">
            Hello, {{ Auth::user()->name }} <br>Menu Dropdown Doesn't Work if you want Logout <a href="/logout">Click This</a>
          </div>
          @endauth

          <div class="row">
            @foreach($posts as $post)
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header">
                    <h3>{{ $post->title }}</h3>
                  </div>
                  <center>
                    <br>
                    <img src="{{ asset('images/' . $post->image) }}" alt="{{ $post->title }} photo" class="img-fluid" width="300" height="300">
                  </center>
                  <div class="card-body">
                    <p>{{ substr($post->description, 0, 100) }}</p>
                    <a href="{{ route('post.show', $post->slug) }}" class="btn btn-primary btn-block">Read More</a>
                  </div>
                </div>
                <br>
              </div>
            @endforeach
          </div>
        </div>
    </body>
</html>

