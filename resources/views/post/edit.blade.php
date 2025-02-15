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
          <div class="row">
            <div class="col-md-8 offset-md-2">
              <form method="POST" action="{{ route('post.update', $post->slug) }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" name="title" class="form-control" value="{{ $post->title }}" placeholder="Post title">
                </div>

                <div class="form-group">
                  <label for="slug">Slug</label>
                  <input type="text" name="slug" class="form-control" value="{{ $post->slug }}" placeholder="post-slug">
                </div>

                <div class="form-group">
                      <label for="category_id">Category</label>
                      <select class="form-control" name="category_id" required>
                        <option value="">Select a Category</option>

                        @foreach ($categories as $category)
                          <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>{{ $category->name }}</option>

                          @if ($category->children)
                            @foreach ($category->children as $child)
                              <option value="{{ $child->id }}" {{ $child->id == $post->category_id ? 'selected' : '' }}>&nbsp;&nbsp;{{ $child->name }}</option>
                            @endforeach
                          @endif
                        @endforeach
                      </select>
                    </div>

                <div class="form-group">
                  <label for="image">Post Image</label>
                    <ul>
                      <li>{{ $post->image }}</li>
                    </ul>
                    <input type="file" class="form-control-file" name="image">
                </div>

                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea name="description" rows="8" cols="80" class="form-control">{{ $post->description }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update Post</button>
              </form>
              <br>
            	@if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
          </div>
        </div>
    </body>
</html>

