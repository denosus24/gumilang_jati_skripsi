import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './vendor/filament/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
        './vendor/awcodes/filament-table-repeater/resources/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                crimson: {
                    DEFAULT: '#E42128',
                    50: '#F8C5C7',
                    100: '#F6B3B5',
                    200: '#F18E92',
                    300: '#ED6A6E',
                    400: '#E8454B',
                    500: '#E42128',
                    600: '#B7161C',
                    700: '#851014',
                    800: '#530A0D',
                    900: '#210405',
                    950: '#080101'
                },
                denim: {
                    DEFAULT: '#3a76bd',
                    '50': '#f3f6fc',
                    '100': '#e6edf8',
                    '200': '#c8d9ef',
                    '300': '#97b9e2',
                    '400': '#5f94d1',
                    '500': '#3a76bd',
                    '600': '#2e66af',
                    '700': '#234b81',
                    '800': '#20406c',
                    '900': '#20385a',
                    '950': '#15233c',
                },
            },
        }
    },
    plugins: [
        require('flowbite/plugin'),
    ],
}