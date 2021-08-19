document.addEventListener('DOMContentLoaded', function () {
    let elems = document.querySelectorAll('.fixed-action-btn');
    let instances = M.FloatingActionButton.init(elems, {
        direction: 'left',
        hoverEnabled: false
    });

    $('#login-btn').on('click', function () {
        window.location.replace('https://discord.com/api/oauth2/authorize?client_id=877638507135377520&redirect_uri=http%3A%2F%2Flocalhost%3A63342%2FGIBZGlossar%2Fphp%2Flogin.php&response_type=code&scope=identify')
    })

    $("#addSubmit").on('click', function () {
        addWordToDB();
    });
    $("#searchSubmit").on('click', function () {
        applyFilter();
    });

    $('#logout-btn').on('click', function () {
        window.location.replace('http://localhost:63342/GIBZGlossar/php/logout.php')
    })

});

$(document).ready(function () {
    $('.modal').modal();
    $('input#explanation,input#word').characterCounter();
    $('.dropdown-trigger').dropdown();
    $('.tooltipped').tooltip();
    $("#searchForm").on("keypress", function (event) {
        let keyPressed = event.keyCode || event.which;
        if (keyPressed === 13) {
            event.preventDefault();
            //applyFilter();
            return false;
        }
    });

    $("#addForm").on("keypress", function (event) {
        let keyPressed = event.keyCode || event.which;
        if (keyPressed === 13) {
            event.preventDefault();
            addWordToDB();
            return false;
        }
    });
});

function addWordToDB() {
    if (checkFormInput() === true) {
        let word = document.getElementById("word");
        let explanation = document.getElementById("explanation");

        $.ajax({
            url: "php/DB-Actions.php",
            type: "post",
            dataType: 'json',
            data: {word: word.value, author: explanation.value},
            success: function () {
                word.value = "";
                explanation.value = "";
                location.reload();
            }
        });
    } else {

    }
}

function checkFormInput() {
    let word = document.getElementById("word");
    let explanation = document.getElementById("explanation");

    return (word.value.length < 200 && explanation.value.length < 100) && (word.value.length > 0 && explanation.value.length > 0);
}

function applyFilter() {
    let urlString = "";
    if (document.getElementById("searchID").value !== "") {
        urlString += location.protocol + '//' + location.host + location.pathname + "?ID=" + document.getElementById("searchID").value;
    } else {
        urlString += location.protocol + '//' + location.host + location.pathname + "?word=" + document.getElementById("searchWord").value;
        urlString += "&explanation=" + document.getElementById("searchExplanation").value;
        urlString += "&user=" + document.getElementById("searchUser").value;
        urlString += "&sort=" + document.querySelector('input[name="sortGroup"]:checked').value;
    }
    document.getElementById("searchExplanation").value = "";
    document.getElementById("searchWord").value = "";
    document.getElementById("searchID").value = "";
    $('.modal').modal();
    location.assign(urlString);
}

function copy(text) {
    let input = document.createElement('textarea');
    input.innerHTML = location.protocol + '//' + location.host + location.pathname + "?ID=" + text;
    document.body.appendChild(input);
    input.select();
    let result = document.execCommand('copy');
    document.body.removeChild(input);
    return result;
}