<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>New Config</title>

    <script src="https://telegram.org/js/telegram-web-app.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('css/newConfig.css') }}">
</head>
<body class="secondary_bg_color">
<div class="container-sm text-center ">
    <form id="form">
        @csrf
        <div class="row text-lg text-center font-large  m-2 p-2">
            <div class="col-4 mt-1 p-1 rounded-4 block">
                <div class="rounded bg_color">
                    <img class="m-2 p-1" height="50px" src="{{ asset('svg/stopwatch.svg') }}" alt="My SVG Icon"> <br>
                    <label class="p-1 fw-bold text_color">Minutos</label> <br>
                </div>
                <div style="display: flex">
                    <div class="me-2">
                        <label style="font-size: 10px" class="mb-1 text_color">min</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="min_time" name="min_time"/>
                    </div>
                    <div>
                        <label style="font-size: 10px" class="mb-1 text_color">max</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="max_time" name="max_time"/>
                    </div>
                </div>
            </div>

            <div class="col-4 mt-1 p-1 rounded-4 block">
                <div class="rounded bg_color">
                    <img class="m-2 p-1" height="50px" src="{{ asset('svg/shot.svg') }}" alt="My SVG Icon"> <br>
                    <label class="p-1 fw-bold text_color">Chutes </label> <br>
                </div>
                <div style="display: flex">
                    <div class="me-2">
                        <label style="font-size: 10px" class="mb-1 text_color">min</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="min_sum_shoots"
                               name="min_sum_shoots"/>
                    </div>
                    <div>
                        <label style="font-size: 10px" class="mb-1 text_color">max</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="max_sum_shoots"
                               name="max_sum_shoots"/>
                    </div>
                </div>
            </div>

            <div class="col-4 mt-1 p-1 rounded-4 block">
                <div class="rounded bg_color">
                    <img class="m-2 p-1" height="50px" src="{{ asset('svg/goal.svg') }}" alt="My SVG Icon"> <br>
                    <label class="p-1 fw-bold text_color">Gols </label> <br>
                </div>
                <div style="display: flex">
                    <div class="me-2">
                        <label style="font-size: 10px" class="mb-1 text_color">min</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="min_sum_goals"
                               name="min_sum_goals"/>
                    </div>
                    <div>
                        <label style="font-size: 10px" class="mb-1 text_color">max</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="max_sum_goals"
                               name="max_sum_goals"/>
                    </div>
                </div>
            </div>
        </div>

        {{--  segunda linha  --}}

        <div class="row text-lg text-center font-large  m-2 p-2">
            <div class="col-4 mt-1 p-1 rounded-4 block">
                <div class="rounded bg_color">
                    <img class="m-2 p-1" height="50px" src="{{ asset('svg/shot-on-target.svg') }}" alt="My SVG Icon">
                    <br>
                    <label style="font-size: 12px" class="p-1 fw-bold text_color">Chute a Gol </label> <br>
                </div>
                <div style="display: flex">
                    <div class="me-2">
                        <label style="font-size: 10px" class="mb-1 text_color">min</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="min_sum_shoots_on_target"
                               name="min_sum_shoots_on_target"/>
                    </div>
                    <div>
                        <label style="font-size: 10px" class="mb-1 text_color">max</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="max_sum_shoots_on_target"
                               name="max_sum_shoots_on_target"/>
                    </div>
                </div>
            </div>

            <div class="col-4 mt-1 p-1 rounded-4 block">
                <div class="rounded bg_color">
                    <img class="m-2 p-1" height="50px" src="{{ asset('svg/card.svg') }}" alt="My SVG Icon"> <br>
                    <label style="font-size: 12px" class="p-1 fw-bold text_color">C. Verm. </label> <br>
                </div>
                <div style="display: flex">
                    <div class="me-2">
                        <label style="font-size: 10px" class="mb-1 text_color">min</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="min_sum_red"
                               name="min_sum_red"/>
                    </div>
                    <div>
                        <label style="font-size: 10px" class="mb-1 text_color">max</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="max_sum_red"
                               name="max_sum_red"/>
                    </div>
                </div>
            </div>

            <div class="col-4 mt-1 p-1 rounded-4 block">
                <div class="rounded bg_color">
                    <img class="m-2 p-1" height="50px" src="{{ asset('svg/corner.svg') }}" alt="My SVG Icon"> <br>
                    <label style="font-size: 12px" class="p-1 fw-bold text_color">Escanteios </label> <br>
                </div>
                <div style="display: flex">
                    <div class="me-2">
                        <label style="font-size: 10px" class="mb-1 text_color">min</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="min_sum_corners"
                               name="min_sum_corners"/>
                    </div>
                    <div>
                        <label style="font-size: 10px" class="mb-1 text_color">max</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="max_sum_corners"
                               name="max_sum_corners"/>
                    </div>
                </div>
            </div>

        </div>

        {{--  terceira linha  --}}

        <div class="row text-lg text-center font-large  m-2 p-2">

            <div class="col-4 mt-1 p-1 rounded-4 block">
                <div class="rounded bg_color">
                    <img class="m-2 p-1" height="50px" src="{{ asset('svg/scoreboard.svg') }}" alt="My SVG Icon"> <br>
                    <label style="font-size: 12px" class="p-1 fw-bold text_color">Dif. Gols </label> <br>
                </div>
                <div style="display: flex">
                    <div class="me-2">
                        <label style="font-size: 10px" class="mb-1 text_color">min</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="min_diff_goals"
                               name="min_diff_goals"/>
                    </div>
                    <div>
                        <label style="font-size: 10px" class="mb-1 text_color">max</label> <br>
                        <input type="number" class="form-control text_color bg_color" id="max_diff_goals"
                               name="max_diff_goals"/>
                    </div>
                </div>
            </div>

            <div class="col-8 mt-1 p-1 rounded-4 block">
                <div class="rounded bg_color">
                    <img class="m-2 p-1" height="50px" src="{{ asset('svg/smartphone.svg') }}" alt="My SVG Icon"> <br>
                    <label style="font-size: 12px" class="p-1 fw-bold text_color text_color">Nome da
                        configuração </label> <br>
                </div>
                <div>
                    <label style="font-size: 10px" class="mb-1 text_color">Nome</label> <br>
                    <input type="text" class="form-control bg_color text_color" id="name" name="name"/>
                </div>
            </div>


        </div>
        <input type="number" id="status" name="status" value=1 hidden/>
        <input type="number" id="user_id" name="user_id" hidden/>
    </form>

</div>
</body>

<script>
    console.log("telegramObject:", window.Telegram.WebApp)
    try {
        let name = window.Telegram.WebApp.initDataUnsafe.user.first_name;
        let userId = window.Telegram.WebApp.initDataUnsafe.user.id;
        let mainButton = window.Telegram.WebApp.MainButton;
        var themeParams = window.Telegram.WebApp.themeParams;
        console.log(window.Telegram.WebApp.initDataUnsafe.user);

        document.getElementById("user_id").value = userId;

        mainButton.setText("Salvar");
        mainButton.onClick(() => submitForm())
        mainButton.show();

        let bg_color = document.getElementsByClassName("bg_color")
        for (let i = 0; i < bg_color.length; i++) {
            bg_color[i].style.backgroundColor = themeParams.bg_color;
            bg_color[i].style.border = 0;
            bg_color[i].style.boxShadow = "1px 1px 2px " + themeParams.hint_color;
        }

        let secondary_bg_color = document.getElementsByClassName("secondary_bg_color")
        for (let i = 0; i < secondary_bg_color.length; i++) {
            console.log(secondary_bg_color[i])
            secondary_bg_color[i].style.backgroundColor = themeParams.secondary_bg_color;
        }

        let text_color = document.getElementsByClassName("text_color")
        for (let i = 0; i < text_color.length - 1; i++) {
            text_color[i].style.color = themeParams.text_color;
        }

    } catch (error) {
        console.log("error:", error)
    }

    function submitForm() {
        let form = document.getElementById("form");
        console.log(form);
        mainButton.hide();

        let formData = new FormData(form);
        console.log(Object.fromEntries(formData));

        fetch('api/new-config', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
            },
            body: JSON.stringify(Object.fromEntries(formData))
        }).then(
            function (response) {
                if (response.status !== 201) {
                    console.log('Looks like there was a problem. Status Code: ' +
                        response.status);
                    window.Telegram.WebApp.showAlert("Houve um erro ao salvar a configuração", () => window.Telegram.WebApp.close());
                    mainButton.show();
                    return;
                }

                response.json().then(function (data) {
                    window.Telegram.WebApp.showAlert("Configuração salva com sucesso!", () => window.Telegram.WebApp.close());
                    console.log(data);
                });
            }
        )
    }


</script>
</html>
