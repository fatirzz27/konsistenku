@props(['url'])

@php
    $brandName = trim(strip_tags((string) $slot));

    if ($brandName === '' || strtolower($brandName) === 'laravel') {
        $brandName = 'KonsistenKu';
    }
@endphp

<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
<span class="brand-mark">K</span>
<span class="brand-text">{{ $brandName }}</span>
</a>
</td>
</tr>