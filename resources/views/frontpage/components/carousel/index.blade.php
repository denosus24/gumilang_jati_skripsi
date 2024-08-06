@props([
    'items' => [],
    'height' => 48,
])

<div id="default-carousel" {{ $attributes->class(['relative w-full']) }} data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-full overflow-hidden rounded">
        <!-- Items -->
        @foreach ($items as $item)
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ $item }}"
                    class="absolute h-full w-full block -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover z-10"
                    alt="Carousel">
            </div>
        @endforeach
    </div>
    <!-- Slider controls -->
    <button type="button"
        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        data-carousel-prev>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-denim/75  group-hover:bg-denim-600 ">
            <x-tabler-chevron-left color="white"></x-tabler-chevron-left>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button"
        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        data-carousel-next>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-denim/75 group-hover:bg-denim-600 ">
            <x-tabler-chevron-right color="white"></x-tabler-chevron-right>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>
