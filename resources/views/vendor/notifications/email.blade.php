@component('mail::message')
{{-- Greeting --}}

Thư viện trường Đại học Buôn Ma Thuột

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
Xin cảm ơn !

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Trong trường hợp không nhấn vào nút \":actionText\", hãy copy và paste link ở dưới\n".
    'vào trình duyệt của bạn: [:actionURL](:actionURL)',
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl,
    ]
)
@endslot
@endisset
@endcomponent
