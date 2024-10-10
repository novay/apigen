@extends('apigen::app')
@section('content')
    <div class="flex flex-wrap">
        <div class="w-full lg:w-2/3 pr-0 lg:pr-2">
            <p class="text-xl pb-3 flex items-center">
                <i class="fas fa-plug mr-2"></i> Koneksi
            </p>
            @if(!$setting)
                <div class="p-6 bg-white text-gray-500 text-center">
                    Lengkapi data koneksi database Anda di samping.
                </div>
            @else
                @if($setting->status == 1)
                    <div class="py-4 bg-green-600 flex items-center rounded gap-2 justify-center">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                        <p class="text-white">Terhubung</p>
                    </div>
                @else 
                    <div class="py-4 bg-red-600 flex items-center rounded gap-2 justify-center">
                        <i class="fas fa-times text-white text-xl"></i>
                        <p class="text-white">Disconnected</p>
                    </div>
                @endif
            @endif

            <div class="w-full mt-6">
                <p class="text-xl pb-3 flex items-center">
                    <i class="fas fa-list mr-2"></i> List API
                </p>
                <div class="bg-white overflow-auto rounded-md shadow-sm">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">
                                    Nama Modul
                                </th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">
                                    Tabel
                                </th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">
                                    Method
                                </th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">
                                    Kolom
                                </th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse(Novay\Apigen\Models\Generate::get() as $temp)
                                <tr>
                                    <td class="text-left py-3 px-4 align-top">
                                        {{ $temp->module }}
                                    </td>
                                    <td class="text-left py-3 px-4 align-top">
                                        {{ $temp->table_name }}
                                    </td>
                                    <td class="text-left py-3 px-4 align-top">
                                        <div class="flex flex-col">
                                            @foreach(json_decode($temp->methods) as $side)
                                                <a href="{{ route('apigen::api.'.$side, $temp->table_name) }}" class="hover:text-blue-500" target="_blank">
                                                    <i class="fas fa-link mr-1"></i>
                                                    {{ $side }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-left py-3 px-4 align-top">
                                        <ol>
                                            @foreach(json_decode($temp->columns) as $side)
                                                <li>- {{ $side }}</li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td class="text-left py-3 px-4 align-top">
                                        @if($temp->status == 0)
                                            <form action="{{ route('apigen::generate.update', $temp->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button type="submit" class="text-sm">
                                                    Kirim API
                                                </button>
                                            </form>
                                        @else 
                                            <span class="text-green-500 text-sm">Terkirim</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty 
                                <tr>
                                    <td colspan="5" class="py-3 px-4 text-center text-gray-500">
                                        Belum ada API yang di Generate.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-1/3 pl-0 lg:pl-2 mt-12 lg:mt-0">
            <p class="text-xl pb-3 flex items-center">
                <i class="fas fa-cog mr-2"></i> 
                Database Settings
            </p>
            <div class="leading-loose">
                @if(session()->has('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                        {{ session()->get('error') }}
                    </div>
                @endif
                <form action="{{ route('apigen::settings.store') }}" method="POST" class="p-6 bg-white rounded-lg shadow-sm space-y-3" autocomplete="off">
                    @csrf
                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-8">
                            <div class="space-y-2">
                                <label class="block text-sm text-gray-600" for="host">
                                    Host <span class="text-red-500">*</span>
                                </label>
                                <input name="host" type="text" required value="{{ $setting ? $setting->host : '127.0.0.1' }}" placeholder="127.0.0.1" class="w-full px-3 py-1.5 text-gray-700 bg-gray-200 rounded">
                            </div>
                        </div>
                        <div class="col-span-4">
                            <div class="space-y-2">
                                <label class="block text-sm text-gray-600" for="port">
                                    Port <span class="text-red-500">*</span>
                                </label>
                                <input name="port" type="text" required value="{{ $setting ? $setting->port : '3306' }}" placeholder="3306" class="w-full px-3 py-1.5 text-gray-700 bg-gray-200 rounded">
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-600" for="database">
                            Database <span class="text-red-500">*</span>
                        </label>
                        <input name="database" type="text" required value="{{ $setting ? $setting->database : '' }}" placeholder="dbname" class="w-full px-3 py-1.5 text-gray-700 bg-gray-200 rounded">
                    </div>

                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-6">
                            <div class="space-y-2">
                                <label class="block text-sm text-gray-600" for="username">
                                    Username <span class="text-red-500">*</span>
                                </label>
                                <input name="username" type="text" required placeholder="root" value="{{ $setting ? $setting->username : '' }}" class="w-full px-3 py-1.5 text-gray-700 bg-gray-200 rounded">
                            </div>
                        </div>
                        <div class="col-span-6">
                            <div class="space-y-2">
                                <label class="block text-sm text-gray-600" for="password">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input name="password" type="password" placeholder="*****" class="w-full px-3 py-1.5 text-gray-700 bg-gray-200 rounded">
                            </div>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button class="px-3 py-1 text-white font-medium bg-gray-900 rounded" type="submit">
                            Simpan
                        </button>
                        <a href="{{ route('apigen::index') }}?purpose=test-connection" class="ms-5">
                            Test Connection
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection