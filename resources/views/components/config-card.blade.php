<div class="block_container">
    <div class="img_container bg_color">
        @if ( !$bgColor )
        <div class="img_bg">
        @else
        <div style="background-color: {{$bgColor}}"  class="img_bg">
        @endif
            <img class="img_icon" src="{{ $icon }}" alt="My SVG Icon">
        </div>
        <div class="img_text text_color">{{ $text }}</div>
    </div>
    <div class="inputs_container">
        @if($inputType == 'number')
            <div class="input_group">
                <input type="{{ $inputType }}" class="text_color bg_color" id="{{ $minName }}"
                       name="{{ $minName }}" placeholder="{{ $minPlaceholder }}"/>
            </div>
            <div class="input_group">
                <input type="number" class="text_color bg_color" id={{ $maxName }}
                   name="{{ $maxName }}" placeholder="{{ $maxPlaceholder }}"/>
            </div>
        @elseif ($inputType == 'text')
            <div class="input_group">
                <input type="text" class="text_color bg_color text_double" id="{{ $minName }}" name="{{ $minName }}" placeholder="{{ $minPlaceholder }}"/>
            </div>
        @endif
    </div>
</div>
