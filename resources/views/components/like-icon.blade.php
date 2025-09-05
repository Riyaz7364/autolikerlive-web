@if ($size == '32')
    <img src="https://www.autolikerlive.com/images/credits/like-32.webp"
        {{ $attributes->merge(['style' => 'display: inline-block; width: 25px; vertical-align: top;']) }}
        alt="like credit icon">
@elseif ($size == '64')
    <img src="https://www.autolikerlive.com/images/credits/like-64.webp"
        {{ $attributes->merge(['style' => 'display: inline-block;']) }} alt="like credit icon">
@elseif ($size == '128')
    <img src="https://www.autolikerlive.com/images/credits/like-128.webp" alt="like credit icon">
@elseif ($size == '25')
    <img src="https://www.autolikerlive.com/images/credits/like-btn.webp"
        style="
    display: inline-block;
    vertical-align: top;
" alt="like credit icon">
@endif
