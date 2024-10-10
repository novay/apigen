@extends('apigen::app')
@section('title', $title)

@section('content')
    <div class="flex flex-wrap">
        <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
            <p class="text-xl pb-6 flex items-center font-bold tracking-tight">
                <i class="fas fa-list mr-3"></i>
                Tambah {{ $title }}
            </p>
            <div class="leading-loose">
                @if(session()->has('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <form action="{{ route($prefix.'.store') }}" method="POST" class="p-10 bg-white rounded-lg shadow-sm space-y-3" autocomplete="off">
                    @csrf
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-600 font-medium tracking-tight" for="name">
                            Nama Dataset <span class="text-red-500">*</span>
                        </label>
                        <input name="name" type="text" placeholder="Nama Dataset" class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" />
                        {!! $errors->first('name', '<span class="text-sm text-red-600">:message</span>') !!}
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-600 font-medium tracking-tight" for="description">
                            Deskripsi <span class="text-gray-400">(Opsional)</span>
                        </label>
                        <textarea name="description" rows="3" class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded"></textarea>
                    </div>
                    <div class="pt-3">
                        <button type="submit" class="px-4 py-1 text-white bg-gray-900 rounded-md font-semibold shadow-md hover:shadow-none">
                            {{ isset($edit) ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection