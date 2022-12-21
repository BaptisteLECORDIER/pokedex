<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/output.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg bg-danger navbar-dark">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">POKEDEX</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./index.php">Pokedex</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="./register.php">S'inscrire</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="./login.php">Se connecter</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="./preferences.php">Favoris</a>
                  </li>
                  
                </ul>
                <form class="d-flex" role="search" method="GET" id="search-pokemon">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                </form>
              </div>
            </div>
          </nav>
    </header>
    
    <form method="POST" class="form" action="./modules/controllers/forms/register.php">
      <div>
        <div class="align">
          <h1 class="fs-1">S'inscrire</h1>
        </div>
        
        <div class="mb-3">
          <label for="username" class="form-label">Adresse mail</label>
          <input name="username" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="ex : John Doe">

        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe</label>
          <input name="password" type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="align">
          <button type="submit" class="btn btn-danger">Valider</button>
        </div>
        
      </div>
      
    </form>
   
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script src="./assets/js/script.js"></script>
</html>






