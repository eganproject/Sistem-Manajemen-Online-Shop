<!doctype html>
<html lang="en">
    <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>{{ $title }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        

        <link href="css/style.css" rel="stylesheet">
       
    </head>
<body class="d-flex h-100 text-center text-white bg-dark">
    
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="mb-auto">
    <div>
      <h3 class="float-md-start mb-0">Desire Store</h3>
      <nav class="nav nav-masthead justify-content-center float-md-end">
        <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="/">Beranda</a>
        <a class="nav-link fw-bold py-1 px-0" href="#">Category</a>
        <a class="nav-link fw-bold py-1 px-0" href="/login">Login</a>
      </nav>
    </div>
  </header>

<div class="container mt-4">

    @yield('container')
</div>


<footer class="mt-auto text-white-50">
 <p>Cover template for <a href="https://getbootstrap.com/" class="text-white">Bootstrap</a>, by <a href="https://twitter.com/mdo" class="text-white">@mdo</a>.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>