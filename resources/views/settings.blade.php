@extends('apigen::app')
@section('title', $title)

@section('content')
    <div class="flex flex-wrap">
        <div class="w-full lg:w-1/2 my-6 pr-0 lg:pr-2">
            <p class="text-xl pb-6 flex items-center font-bold tracking-tight">
                <i class="fas fa-list mr-3"></i>
                DB Settings
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
                <form action="{{ route($prefix.'.store') }}" method="POST" class="p-10 bg-white rounded shadow-xl space-y-3" autocomplete="off">
                    @csrf

                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-8">
                            <div class="space-y-2">
                                <label class="block text-sm text-gray-600" for="host">
                                    Host <span class="text-red-500">*</span>
                                </label>
                                <input name="host" type="text" required value="{{ $data ? $data->host : '127.0.0.1' }}" placeholder="127.0.0.1" class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded">
                            </div>
                        </div>
                        <div class="col-span-4">
                            <div class="space-y-2">
                                <label class="block text-sm text-gray-600" for="port">
                                    Port <span class="text-red-500">*</span>
                                </label>
                                <input name="port" type="text" required value="{{ $data ? $data->port : '3306' }}" placeholder="3306" class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded">
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-600" for="database">
                            Database <span class="text-red-500">*</span>
                        </label>
                        <input name="database" type="text" required value="{{ $data ? $data->database : '' }}" placeholder="dbname" class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded">
                    </div>

                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-6">
                            <div class="space-y-2">
                                <label class="block text-sm text-gray-600" for="username">
                                    Username <span class="text-red-500">*</span>
                                </label>
                                <input name="username" type="text" required placeholder="root" value="{{ $data ? $data->username : '' }}" class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded">
                            </div>
                        </div>
                        <div class="col-span-6">
                            <div class="space-y-2">
                                <label class="block text-sm text-gray-600" for="password">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input name="password" type="password" placeholder="*****" class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded">
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-6">
                        <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" type="submit">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route($prefix.'.index') }}?purpose=test-connection" class="ms-3">
                            Test Connection
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection