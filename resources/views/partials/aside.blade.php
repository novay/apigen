<aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
    <div class="p-3 bg-white">
        <a href="{{ route('apigen::index') }}" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">
            <div class="flex lg:justify-center lg:col-start-2 items-center px-4">
                <img src="https://api.kaltimprov.go.id/images/favicon.png" alt="" class="h-12 w-auto">
                <img src="https://api.kaltimprov.go.id/images/logo.png" alt="" class="h-10 w-auto">
                {{-- <img src="https://api.kaltimprov.go.id/images/logo-putih.png" alt="" class="h-14 dark:inline hidden"> --}}
            </div>
        </a>
        <a href="{{ route('apigen::generate.create') }}" class="w-full bg-gray-100 cta-btn font-semibold py-2 mt-5 rounded-lg hover:bg-gray-300 flex items-center justify-center">
            <i class="fa fa-plus mr-2"></i> Generate API
        </a>
    </div>
    <nav class="text-white text-base font-semibold pt-3">
        <a href="{{ route('apigen::index') }}" class="flex items-center {{ request()->routeIs('apigen::index') ? 'active-nav-link text-white' : 'text-white opacity-75 hover:opacity-100' }} py-3 pl-4 nav-item">
            <i class="fas fa-tachometer-alt mr-2"></i>
            Dashboard
        </a>
        
        <div class="pt-4 pb-2 px-4 flex items-center justify-between text-sm tracking-tight">
            <div>Dataset</div>
            {{-- <a href="{{ route('apigen::datasets.create') }}" class="text-xs text-gray-200 hover:text-gray-100">
                + Tambah
            </a> --}}
        </div>
        
        @foreach(\Novay\Apigen\Models\Dataset::withCount(['endpoints'])->get() as $dataset)
            <a href="{{ route('apigen::datasets.show', $dataset->slug) }}" class="flex items-center justify-between {{ request()->segment(2) == $dataset->slug ? 'active-nav-link text-white' : 'text-white opacity-75 hover:opacity-100' }} py-3 px-4 nav-item">
                <div class="flex items-center">
                    <i class="fas fa-folder mr-2"></i>
                    {{ $dataset->name }}
                </div>
                <span>
                    {{ $dataset->endpoints_count }}
                </span>
            </a>
        @endforeach
    </nav>
    {{-- <a href="{{ route('apigen::settings.index') }}" class="absolute w-full upgrade-btn bottom-0 active-nav-link text-white flex items-center px-4 py-3 font-semibold">
        <i class="fas fa-cog mr-2"></i>
        Pengaturan
    </a> --}}
</aside>