<script>
function capitalize (word) {
    return word.charAt(0).toUpperCase() + word.slice(1)
}

async function getDataAPI (url) {
    return fetch(url)
    .then((response) => response.json())
}

function clickOnFav (id) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("fav").innerHTML = this.responseText;
    }
    xhttp.open("GET", "favories.php?pokemon="+id);
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

              if (test.includes(`${poke_id}`)) {
                poke_list.innerHTML += `
                    <div id="card-${poke_id}" class="card" style="width: 18rem;">
                    <img src="${poke_sprite}" class="card-img-top" alt="pokemon">
                    <div class="card-body align">
                    <h5 class="card-title">${capitalize (poke_name)}</h5>
                    <button id="btn-${poke_id}" onclick="clickOnFav(${poke_id})" class="btn btn-danger"><img src="./assets/img/heart.svg"></button>
                    </div>
                </div>
                `;
              } else {
                poke_list.innerHTML += `
                    <div id="card-${poke_id}" class="card" style="width: 18rem;">
                    <img src="${poke_sprite}" class="card-img-top" alt="pokemon">
                    <div class="card-body align">
                    <h5 class="card-title">${capitalize (poke_name)}</h5>
                    <button id="btn-${poke_id}" onclick="clickOnFav(${poke_id})" class="btn btn-dark"><img src="./assets/img/heart.svg"></button>
                    </div>
                </div>
                `;
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