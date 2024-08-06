@props([
    'useTheme' => 'light',
])

@php
    $brandName = filament()->getBrandName();
    $brandLogo = filament()->getBrandLogo();
    $brandLogoHeight = filament()->getBrandLogoHeight() ?? '1.5rem';
    $darkModeBrandLogo = filament()->getDarkModeBrandLogo();
    $hasDarkModeBrandLogo = filled($darkModeBrandLogo);
    
    $isDarkMode = $useTheme === 'dark';
    $logo = $useTheme === 'dark' ? ($hasDarkModeBrandLogo ? $darkModeBrandLogo : $brandLogo) : $brandLogo;

    $getLogoClasses = fn (): string => \Illuminate\Support\Arr::toCssClasses([
        'fi-logo',
        'flex' => ! $hasDarkModeBrandLogo,
    ]);
    
    $logoStyles = "height: {$brandLogoHeight}";
@endphp


@if ($logo instanceof \Illuminate\Contracts\Support\Htmlable)
<div
    {{
        $attributes
            ->class([$getLogoClasses()])
            ->style([$logoStyles])
    }}
>
    {{ $logo }}
</div>
@elseif (filled($logo))
<img
    alt="{{ __('filament-panels::layout.logo.alt', ['name' => $brandName]) }}"
    src="{{ $logo }}"
    {{
        $attributes
            ->class([$getLogoClasses()])
            ->style([$logoStyles])
    }}
/>
@else
<div
    {{
        $attributes->class([
            $getLogoClasses(),
            'text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white',
        ])
    }}
>
    {{ $brandName }}
</div>
@endif