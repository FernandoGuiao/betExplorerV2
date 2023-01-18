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
            <x-config-card
                icon="{{ asset('svg/smartphone.svg') }}"
                text="Nome"
                minName="name"
                maxName="name"
                minPlaceholder="..."
                inputType="text"
            />
            <x-config-card
                icon="{{ asset('svg/stopwatch.svg') }}"
                text="Minutos"
                minName="min_time"
                maxName="max_time"
            />
        </div>
        <div class="details_container secondary_bg_color text_color">
            <div class="details summary bg_color text_color">
                <div class="text_color details-title">Total do Jogo</div>
            </div>
        </div>
        <div class="row">

            <x-config-card
                icon="{{ asset('svg/goal.svg') }}"
                text="Gols"
                minName="min_sum_goals"
                maxName="max_sum_goals"
            />

            <x-config-card
                icon="{{ asset('svg/shot.svg') }}"
                text="Chutes"
                minName="min_sum_shoots"
                maxName="max_sum_shoots"
            />

            <x-config-card
                icon="{{ asset('svg/corner.svg') }}"
                text="Escanteios"
                minName="min_sum_corners"
                maxName="max_sum_corners"
            />


        </div>

        {{--  segunda linha  --}}

        <div class="row">

            <x-config-card
                icon="{{ asset('svg/shot-on-target.svg') }}"
                text="Chutes a Gol"
                minName="min_sum_shoots_on_target"
                maxName="max_sum_shoots_on_target"
            />


            <x-config-card
                icon="{{ asset('svg/card.svg') }}"
                text="Cartões Vermelhos"
                minName="min_sum_red"
                maxName="max_sum_red"
            />

            <x-config-card
                icon="{{ asset('svg/scoreboard.svg') }}"
                text="Diferença de Gols"
                minName="min_diff_goals"
                maxName="max_diff_goals"
            />

        </div>

        {{--  terceira linha  --}}

        <div class="row">

            <x-config-card
                icon="{{ asset('svg/shot.svg') }}"
                text="Diferença de Chutes"
                minName="min_diff_shoots"
                maxName="max_diff_shoots"
            />

            <x-config-card
                icon="{{ asset('svg/card.svg') }}"
                text="Diferença Vermelhos"
                minName="min_diff_red"
                maxName="max_diff_red"
            />


        </div>

        {{--  Configs segundo tempo  --}}

        <div class="details_container secondary_bg_color text_color">
            <div class="details summary bg_color text_color">
                <div class="text_color details-title">↓ Exclusivamente Segundo Tempo ↓</div>
            </div>
            <div class="row">
                <x-config-card
                    icon="{{ asset('svg/goal.svg') }}"
                    text="Gols"
                    minName="second_half_min_sum_goals"
                    maxName="second_half_max_sum_goals"
                    bgColor="#90ee90"
                />
                <x-config-card
                    icon="{{ asset('svg/shot.svg') }}"
                    text="Chutes"
                    minName="second_half_min_sum_shoots"
                    maxName="second_half_max_sum_shoots"
                    bgColor="#90ee90"
                />
                <x-config-card
                    icon="{{ asset('svg/corner.svg') }}"
                    text="Escanteios"
                    minName="second_half_min_sum_corners"
                    maxName="second_half_max_sum_corners"
                    bgColor="#90ee90"
                />

            </div>
            <div class="row">
                <x-config-card
                    icon="{{ asset('svg/shot-on-target.svg') }}"
                    text="Chute a Gol"
                    minName="second_half_min_sum_shoots_on_target"
                    maxName="second_half_max_sum_shoots_on_target"
                    bgColor="#90ee90"
                />
                <x-config-card
                    icon="{{ asset('svg/card.svg') }}"
                    text="Cartões Vermelhos"
                    minName="second_half_min_sum_red"
                    maxName="second_half_max_sum_red"
                    bgColor="#90ee90"
                />
                <x-config-card
                    icon="{{ asset('svg/shot.svg') }}"
                    text="Diferença de Chutes"
                    minName="second_half_min_diff_shoots"
                    maxName="second_half_max_diff_shoots"
                    bgColor="#90ee90"
                />
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

        }


    }


</script>
</html>
