<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>New Config</title>

    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <style>    {!! include ('css/newConfig.css') !!}</style>

</head>
<body class="secondary_bg_color">
    <div class="body_container secondary_bg_color">
        <form id="form">
            @csrf
            <div class="row">
                <div class="block_container">
                    <div class="img_container bg_color">
                        <div class="img_bg">
                            <img class="img_icon" src="{{ asset('svg/stopwatch.svg') }}" alt="My SVG Icon">
                        </div>
                        <div class="img_text text_color">Minutos</div>
                    </div>
                    <div class="inputs_container">
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="min_time" name="min_time"
                                   placeholder="min"/>
                        </div>
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="max_time" name="max_time"
                                   placeholder="max"/>
                        </div>
                    </div>
                </div>

                <div class="block_container">
                    <div class="img_container bg_color">
                        <div class="img_bg">
                            <img class="img_icon" src="{{ asset('svg/shot.svg') }}" alt="My SVG Icon">
                        </div>
                        <div class="img_text text_color">Chutes</div>
                    </div>
                    <div class="inputs_container">
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="min_sum_shoots"
                                   name="min_sum_shoots" placeholder="min"/>
                        </div>
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="max_sum_shoots"
                                   name="max_sum_shoots" placeholder="max"/>
                        </div>
                    </div>
                </div>

                <div class="block_container">
                    <div class="img_container bg_color">
                        <div class="img_bg">
                            <img class="img_icon" src="{{ asset('svg/goal.svg') }}" alt="My SVG Icon">
                        </div>
                        <div class="img_text text_color">Gols</div>
                    </div>
                    <div class="inputs_container">
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="min_sum_goals"
                                   name="min_sum_goals" placeholder="min"/>
                        </div>
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="max_sum_goals"
                                   name="max_sum_goals" placeholder="max"/>
                        </div>
                    </div>
                </div>
            </div>

            {{--  segunda linha  --}}
            <div class="row">
                <div class="block_container">
                    <div class="img_container bg_color">
                        <div class="img_bg">
                            <img class="img_icon" src="{{ asset('svg/shot-on-target.svg') }}" alt="My SVG Icon">
                        </div>
                        <div class="img_text text_color">Chutes a Gol</div>
                    </div>
                    <div class="inputs_container">
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="min_sum_shoots_on_target"
                                   name="min_sum_shoots_on_target" placeholder="min"/>
                        </div>
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="max_sum_shoots_on_target"
                                   name="max_sum_shoots_on_target" placeholder="max"/>
                        </div>
                    </div>
                </div>

                <div class="block_container">
                    <div class="img_container bg_color">
                        <div class="img_bg">
                            <img class="img_icon" src="{{ asset('svg/card.svg') }}" alt="My SVG Icon">
                        </div>
                        <div class="img_text text_color">Cartões Vermelhos</div>
                    </div>
                    <div class="inputs_container">
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="min_sum_red"
                                   name="min_sum_red" placeholder="min"/>
                        </div>
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="max_sum_red"
                                   name="max_sum_red" placeholder="max"/>
                        </div>
                    </div>
                </div>

                <div class="block_container">
                    <div class="img_container bg_color">
                        <div class="img_bg">
                            <img class="img_icon" src="{{ asset('svg/corner.svg') }}" alt="My SVG Icon">
                        </div>
                        <div class="img_text text_color">Total de Escanteios</div>
                    </div>
                    <div class="inputs_container">
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="min_sum_corners"
                                   name="min_sum_corners" placeholder="min"/>
                        </div>
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="max_sum_corners"
                                   name="max_sum_corners" placeholder="max"/>
                        </div>
                    </div>
                </div>

            </div>

            {{--  terceira linha  --}}

            <div class="row">

                <div class="block_container">
                    <div class="img_container bg_color">
                        <div class="img_bg">
                            <img class="img_icon" src="{{ asset('svg/scoreboard.svg') }}" alt="My SVG Icon">
                        </div>
                        <div class="img_text text_color">Diferença de Gols</div>
                    </div>
                    <div class="inputs_container">
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="min_diff_goals"
                                   name="min_diff_goals" placeholder="min"/>
                        </div>
                        <div class="input_group">
                            <input type="number" class="text_color bg_color" id="max_diff_goals"
                                   name="max_diff_goals" placeholder="max"/>
                        </div>
                    </div>
                </div>

                <div class="block_container">
                    <div class="img_container bg_color">
                        <div class="img_bg">
                            <img class="img_icon" src="{{ asset('svg/smartphone.svg') }}" alt="My SVG Icon">
                        </div>
                        <div class="img_text text_color">Nome da config</div>
                    </div>
                    <div class="inputs_container">
                        <div class="input_group">
                            <input type="text" class="text_color bg_color text_double" id="name" name="name" placeholder="..."/>
                        </div>
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
        var mainButton = window.Telegram.WebApp.MainButton;
        var themeParams = window.Telegram.WebApp.themeParams;
        console.log(window.Telegram.WebApp.initDataUnsafe.user);

        document.getElementById("user_id").value = userId;

        mainButton.setText("Salvar");
        mainButton.onClick(() => submitForm())
        mainButton.show();

        let bg_color = document.getElementsByClassName("bg_color")
        for (let i = 0; i < bg_color.length; i++) {
            bg_color[i].style.backgroundColor = themeParams.secondary_bg_color;
            bg_color[i].style.border = 0;
            // bg_color[i].style.boxShadow = "1px 1px 2px " + themeParams.hint_color;
        }

        let secondary_bg_color = document.getElementsByClassName("secondary_bg_color")
        for (let i = 0; i < secondary_bg_color.length; i++) {
            secondary_bg_color[i].style.backgroundColor = themeParams.bg_color;
        }

        let text_color = document.getElementsByClassName("text_color")
        for (let i = 0; i < text_color.length; i++) {
            text_color[i].style.color = themeParams.text_color;

        }

    } catch (error) {
        console.log("error:", error)
    }

    async function submitForm() {
        let form = document.getElementById("form");
        console.log(form);
        mainButton.hide();

        let formData = new FormData(form);
        console.log(Object.fromEntries(formData));

        let response = await fetch('api/new-config', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        let data = await response.json();

        if (response.status === 422) {
            console.log('Erro 422');
            window.Telegram.WebApp.showAlert("Erro: " + data.error, () => window.Telegram.WebApp.close());
            mainButton.show();
            return;
        }

        if (response.status === 201) {
            window.Telegram.WebApp.showAlert("Configuração salva com sucesso!", () => window.Telegram.WebApp.close());
            console.log(data);
            return;
        }

        if (response.status !== 201) {
            console.log('Looks like there was a problem.');
            window.Telegram.WebApp.showAlert("Ocorreu um erro inesperado", () => window.Telegram.WebApp.close());
            mainButton.show();
            return;
        }


    }


</script>
</html>
