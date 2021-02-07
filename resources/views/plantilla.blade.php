<!doctype html>

<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>PokeApp</title>
  </head>
  
  <body style="background-color: ligthyellow">    
      <div id="app">
      <nav class="navbar navbar-expand-lg text-white bg-danger">
        <div class="m-1">
        <img src="https://fontmeme.com/permalink/210207/0fe5af533429364ee28e9a61936b7432.png" alt="fuente-pokemon" border="0">
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="{{route('inicio')}}">
                <i class="material-icons nav-link text-white">home</i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('pokemones')}}">
                <i class="material-icons nav-link text-white">catching_pokemon</i>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="{{route('nosotros')}}">
                <i class="material-icons nav-link text-white">contact_page</i>
              </a>
            </li>

          </ul>
        </div>
      </nav>
      <header></header>
   
      <div class="container">
        @yield('seccion')
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script  type="application/javascript" src="{{ mix('/js/app.js') }}"></script>
  </body>
</html>
