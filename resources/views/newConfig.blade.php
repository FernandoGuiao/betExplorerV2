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
<form action="{{ route('newConfigStore') }}" method="post">
    @csrf
    <div class="row text-lg text-center font-large  m-2 p-2">
        <div class="col-4 mt-1 p-3 rounded-4 block">
            <div class="border rounded">
                <img class="m-2 p-1" height="50px" src="{{ asset('svg/stopwatch.svg') }}" alt="My SVG Icon">  <br>
                <label class="p-1 fw-bold">Minutos </label> <br>
            </div>
            <div style="display: flex">
                <div class="me-2">
                    <label style="font-size: 10px" class="mb-1">min</label> <br>
                    <input type="number" class="form-control" id="min_time" name="min_time"/>
                </div>
                <div>
                    <label style="font-size: 10px" class="mb-1">max</label> <br>
                    <input type="number" class="form-control" id="max_time" name="max_time"/>
                </div>
            </div>
        </div>

        <div class="col-4 mt-1 p-3 rounded-4 block">
            <div class="border rounded">
                <img class="m-2 p-1" height="50px" src="{{ asset('svg/shot.svg') }}" alt="My SVG Icon">  <br>
                <label class="p-1 fw-bold">Chutes </label> <br>
            </div>
            <div style="display: flex">
                <div class="me-2">
                    <label style="font-size: 10px" class="mb-1">min</label> <br>
                    <input type="number" class="form-control" id="min_sum_shoots" name="min_sum_shoots"/>
                </div>
                <div>
                    <label style="font-size: 10px" class="mb-1">max</label> <br>
                    <input type="number" class="form-control" id="max_sum_shoots" name="max_sum_shoots"/>
                </div>
            </div>
        </div>

        <div class="col-4 mt-1 p-3 rounded-4 block">
            <div class="border rounded">
                <img class="m-2 p-1" height="50px" src="{{ asset('svg/goal.svg') }}" alt="My SVG Icon">  <br>
                <label class="p-1 fw-bold">Gols </label> <br>
            </div>
            <div style="display: flex">
                <div class="me-2">
                    <label style="font-size: 10px" class="mb-1">min</label> <br>
                    <input type="number" class="form-control" id="min_sum_goals" name="min_sum_goals" />
                </div>
                <div>
                    <label style="font-size: 10px" class="mb-1">max</label> <br>
                    <input type="number" class="form-control" id="min_sum_goals" name="min_sum_goals"/>
                </div>
            </div>
        </div>
    </div>

{{--  segunda linha  --}}

    <div class="row text-lg text-center font-large  m-2 p-2">
        <div class="col-4 mt-1 p-3 rounded-4 block">
            <div class="border rounded">
                <img class="m-2 p-1" height="50px" src="{{ asset('svg/shot-on-target.svg') }}" alt="My SVG Icon">  <br>
                <label style="font-size: 12px" class="p-1 fw-bold">Chute a Gol </label> <br>
            </div>
            <div style="display: flex">
                <div class="me-2">
                    <label style="font-size: 10px" class="mb-1">min</label> <br>
                    <input type="number" class="form-control" id="min_sum_shoots_on_target" name="min_sum_shoots_on_target"/>
                </div>
                <div>
                    <label style="font-size: 10px" class="mb-1">max</label> <br>
                    <input type="number" class="form-control" id="max_sum_shoots_on_target" name="max_sum_shoots_on_target"/>
                </div>
            </div>
        </div>

        <div class="col-4 mt-1 p-3 rounded-4 block">
            <div class="border rounded">
                <img class="m-2 p-1" height="50px" src="{{ asset('svg/card.svg') }}" alt="My SVG Icon">  <br>
                <label style="font-size: 12px" class="p-1 fw-bold">C. Verm. </label> <br>
            </div>
            <div style="display: flex">
                <div class="me-2">
                    <label style="font-size: 10px" class="mb-1">min</label> <br>
                    <input type="number" class="form-control" id="min_sum_red" name="min_sum_red"/>
                </div>
                <div>
                    <label style="font-size: 10px" class="mb-1">max</label> <br>
                    <input type="number" class="form-control" id="max_sum_red" name="max_sum_red"/>
                </div>
            </div>
        </div>

        <div class="col-4 mt-1 p-3 rounded-4 block">
            <div class="border rounded">
                <img class="m-2 p-1" height="50px" src="{{ asset('svg/corner.svg') }}" alt="My SVG Icon">  <br>
                <label style="font-size: 12px" class="p-1 fw-bold">Escanteios </label> <br>
            </div>
            <div style="display: flex">
                <div class="me-2">
                    <label style="font-size: 10px" class="mb-1">min</label> <br>
                    <input type="number" class="form-control" id="min_sum_corners" name="min_sum_corners"/>
                </div>
                <div>
                    <label style="font-size: 10px" class="mb-1">max</label> <br>
                    <input type="number" class="form-control" id="max_sum_corners" name="max_sum_corners"/>
                </div>
            </div>
        </div>

    </div>

    {{--  terceira linha  --}}

    <div class="row text-lg text-center font-large  m-2 p-2">

        <div class="col-4 mt-1 p-3 rounded-4 block">
            <div class="border rounded">
                <img class="m-2 p-1" height="50px" src="{{ asset('svg/scoreboard.svg') }}" alt="My SVG Icon">  <br>
                <label style="font-size: 12px" class="p-1 fw-bold">Dif. Gols </label> <br>
            </div>
            <div style="display: flex">
                <div class="me-2">
                    <label style="font-size: 10px" class="mb-1">min</label> <br>
                    <input type="number" class="form-control" id="min_diff_goals" name="min_diff_goals"/>
                </div>
                <div>
                    <label style="font-size: 10px" class="mb-1">max</label> <br>
                    <input type="number" class="form-control" id="max_diff_goals" name="max_diff_goals"/>
                </div>
            </div>
        </div>

        <div class="col-8 mt-1 p-3 rounded-4 block">
            <div class="border rounded">
                <img class="m-2 p-1" height="50px" src="{{ asset('svg/smartphone.svg') }}" alt="My SVG Icon">  <br>
                <label style="font-size: 12px" class="p-1 fw-bold">Nome da configuração </label> <br>
            </div>
            <div>
                <label style="font-size: 10px" class="mb-1">Nome</label> <br>
                <input type="text" class="form-control" id="name" name="name"/>
            </div>
        </div>


    </div>
    <div class="row text-lg text-center font-large  m-2 p-2">
        <div class="col-12 mt-1 p-3 rounded-4 block">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </div>
    <input type="number" id="status" name="status" value=1 hidden/>
    <input type="number" id="user_id" name="user_id" hidden/>
</form>

</div>



<script>
    console.log(window.Telegram.WebApp)
    let name = window.Telegram.WebApp.initDataUnsafe.user.first_name;
    let userId = window.Telegram.WebApp.initDataUnsafe.user.id;
    //set name to label
    console.log(userId);
    console.log(window.Telegram.WebApp.initDataUnsafe.user);
    document.getElementById("user_id").value = userId;


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
