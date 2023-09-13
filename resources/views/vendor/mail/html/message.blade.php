<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{--{{ config('app.name') }}--}}
</x-mail::header>
</x-slot:header>
<body>
{{-- Body --}}
<img src="https://polandstudy.com/site/assets/images/12144109981689673876.png" id="logo" alt="{{ config('app.name') }}">

{{ $slot }}
</body>
{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} @lang('Poland Study'). @lang('All rights reserved.')
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
