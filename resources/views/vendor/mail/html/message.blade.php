<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} @lang('(RE)SOURCES RELATIONNELLES - Tous droits réservés.')
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
