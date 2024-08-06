<div class="flex min-h-screen flex-col items-center my-16">
    <div class="flex w-full flex-grow items-center justify-center">
        <main
            class=
                "my-16 w-full sm:max-w-md bg-white px-6 py-12 shadow-sm border border-gray-200 dark:bg-gray-900 dark:ring-white/10 rounded sm:px-12">

            <h1 class="text-center text-xl font-medium mb-8">Masuk Akun Gumilang Jati</h1>

            <div class="text-sm text-center mb-8">
                <p>Belum punya akun? {{ $this->registerAction }}</p>
            </div>

            <x-filament-panels::form wire:submit="authenticateWithRedirection">
                {{ $this->form }}

                <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
            </x-filament-panels::form>
        </main>
    </div>
</div>
