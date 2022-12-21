<?php
session_start();
include_once('./modules/models/classes/database.php');


$db = new DataBase('Localhost','root','','pokedex');
?>

<!DOCTYPE html>
<html lang="fr">
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
    
    <div id="fav"></div>
    <div id="poke_list"></div>
   
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- <script src="./assets/js/script.js"></script> -->



<script>
function capitalize (word) {
    return word.charAt(0).toUpperCase() + word.slice(1)
}

async function getDataAPI (url) {
    return fetch(url)
    .then((response) => response.json())
}

function clickOnFav (id) {
    console.log(id);

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("fav").innerHTML = this.responseText;
    }
    xhttp.open("GET", "favories.php?pokemon=" + id);
    xhttp.send(); 



    if (document.getElementById('btn-' + id).classList.contains('btn-danger')) {
        
        document.getElementById('btn-' + id).classList.remove('btn-danger');
        document.getElementById('btn-' + id).classList.add('btn-dark');
    } else {

        document.getElementById('btn-' + id).classList.add('btn-danger');
        document.getElementById('btn-' + id).classList.remove('btn-dark');
    }
}

<?php
  if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $datas = $db -> read_condition ('users', $db -> construct_cond_equal (['username' => $username, 'password' => $password]));

    $preferences = $datas[0]['preferences'];

    echo "let test = ".$preferences;
  } else {
    echo "let test = []";
  }
?>

console.log(test);

function putPokeCard (data, condition) {
    poke_list.innerHTML = "";
    for (let pokemon of data['results']) {
        fetch(pokemon['url'])
        .then((response) => response.json())
        .then((data) => {
    
            let poke_name   = data['forms'][0]['name'];
            let poke_sprite = data['sprites']['other']['official-artwork']['front_default'];
            let poke_id     = data['game_indices'][19]['game_index'];
        
            if (poke_name.includes(condition)) {

              console.log(test.includes(`${poke_id}`));

              if (test.includes(`${poke_id}`)) {

                poke_list.innerHTML += `
                    <div id="card-${poke_id}" class="card" style="width: 18rem;">
                    <img src="${poke_sprite}" class="card-img-top" alt="pokemon">
                    <div class="card-body align">
                    <h5 class="card-title">${capitalize (poke_name)}</h5>
                    <button id="btn-${poke_id}" onclick="clickOnFav(${poke_id})" class="btn btn-danger"><img src="./assets/img/heart.svg"></button>
                    </div>
                </div>`;

              } 
            }
        })
    }
}

const searchPokemon = document.getElementById('search-pokemon');

getDataAPI ('https://pokeapi.co/api/v2/pokemon?limit=100').then((data) => {
    putPokeCard (data, "");

    searchPokemon.addEventListener('keyup', (event) => {
        if (searchPokemon.querySelector('input').value == "") {
            putPokeCard (data, "");
        } else {
            putPokeCard (data, searchPokemon.querySelector('input').value);
        }
    });
});

</script>


</html>






