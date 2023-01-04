<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Config</title>

    <script src="https://telegram.org/js/telegram-web-app.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('css/newConfig.css') }}">
</head>

<div class="container-sm text-center">
    <div class="container-sm text-center">
        Concluído com sucesso!
    </div>
</div>



<script>
    console.log(window.Telegram.WebApp)
    let name = window.Telegram.WebApp.initDataUnsafe.user.first_name;
    let userId = window.Telegram.WebApp.initDataUnsafe.user.id;
    //set name to label
    console.log(userId);
    console.log(window.Telegram.WebApp.initDataUnsafe.user);
    // document.getElementById("user_id").value = userId;


    function getTime(){
        let time = document.getElementById("time-min").value;
        console.log(time);
        window.Telegram.WebApp.close();
    }

    function confirm(){
        let time = document.getElementById("time-min").value;
        console.log(time);
        window.Telegram.WebApp.close();
    }

</script>
</html>
