<?php
include "php/Functions.php";
include "php/config.php";
include "php/discord.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php generateMeta(); ?>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Glossar</title>
</head>
<body class="blue-grey darken-4">
<?php
if (isset($_SESSION['user']) && !isset($_SESSION['user']['message'])) {
    echo '
<div class="row" id="mainRow">
    ';showCards();echo '
</div>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large deep-orange accent-4">
        <i class="large material-icons">menu</i>
    </a>
    <ul>
        <li><a class="btn-floating deep-orange accent-4" id="logout-btn"><i class="material-icons">logout</i></a></li>
        <li><a class="btn-floating light-blue darken-3 modal-trigger" data-target="search_modal"><i class="material-icons">search</i></a></li>
        <li><a class="btn-floating green darken-2 modal-trigger" data-target="add_modal"><i class="material-icons">mode_edit</i></a></li>
    </ul>
</div>

<div id="add_modal" class="modal blue-grey darken-3">
    <div class="modal-content blue-grey darken-3">
        <h4>Add Word Explanation</h4>
        <div class="row">
            <form class="col s12" id="addForm">
                <div class="row modal-form-row">
                    <div class="input-field col s12">
                        <input id="word" type="text" class="validate" data-length="100">
                        <label for="word">Word | max 100 Characters</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="explanation" type="text" class="validate" data-length="200">
                        <label for="explanation">Explanation | max 200 Characters</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row modal-footer blue-grey darken-3">
        <a class="col push-s8 s4 modal-action waves-effect waves-light btn" id="addSubmit">Submit</a>
    </div>
</div>

<div id="search_modal" class="modal blue-grey darken-3">
    <div class="modal-content">
        <h4>Apply Filters</h4>
        <div class="row">
            <form class="col s12" id="searchForm">
                <div class="row modal-form-row">
                    <div class="input-field col s12">
                        <input id="searchWord" type="text" class="validate">
                        <label for="searchWord">Word</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="searchExplanation" type="text" class="validate">
                        <label for="searchExplanation">Explanation</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="searchUser" type="text" class="validate">
                        <label for="searchUser">Added by Discord User</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="searchID" type="number" class="validate">
                        <label for="searchID">ID | if filled out it only searches for the ID</label>
                    </div>
                    <form action="#" >
                        <h5>Order by: </h5>
                        <p>
                            <label>
                                <input class="with-gap" name="sortGroup" type="radio" checked value="old" />
                                <span>Old -> New</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input class="with-gap" name="sortGroup" type="radio" value="new" />
                                <span>New -> Old</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input class="with-gap" name="sortGroup" type="radio" value="word" />
                                <span>Word</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input class="with-gap" name="sortGroup" type="radio" value="explanation" />
                                <span>Explanation</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input class="with-gap" name="sortGroup" type="radio" value="discord_name" />
                                <span>Discord User</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input class="with-gap" name="sortGroup" type="radio" value="id" />
                                <span>Word Id</span>
                            </label>
                        </p>
                    </form>
                </div>
            </form>
        </div>
    </div>
    <div class="row modal-footer blue-grey darken-3">
        <a class="col s3 modal-action waves-effect waves-light btn deep-orange accent-4" id="resetFilter" onclick="location.assign(' . "'" . $this_site . "'" . ')">Reset Filter</a>
        <div class="col s5"></div>
        <a class="col s4 modal-action waves-effect waves-light btn" id="searchSubmit">Submit</a>
    </div>
</div>';
} else {
    echo '<div id="discord-login" class="row">
    <h4 class="center-align">Login With Discord To Start Using The Site!</h4>
    <a id="login-btn" class="col s8 offset-s2 m6 offset-m3 l4 offset-l4 waves-effect waves-light btn"><i class="material-icons left">discord</i>Login</a>
</div>';
}
?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript" src="main.js"></script>
</body>
</html>