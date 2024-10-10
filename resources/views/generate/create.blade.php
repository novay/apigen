@extends('apigen::app')
@section('title', $title)

@section('content')
    <div class="flex flex-wrap">
        <div class="w-full pr-0 lg:pr-2">
            <p class="text-xl pb-6 flex items-center font-bold tracking-tight">
                <i class="fas fa-list mr-3"></i>
                Tambah {{ $title }}
            </p>

            <div class="grid grid-cols-3 gap-3">
                <form method="GET">
                    @csrf
                    <div class="bg-white overflow-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-3 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Pilih Tabel
                                    </th>
                                    <th class="px-3 py-2 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tableList as $i => $temp)
                                    <tr>
                                        <td class="px-3 py-1 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex">
                                                <input type="radio" value="{{ $temp }}" name="table" id="table-{{ $i }}" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                                    @isset($columns)
                                                        @if(request('table') == $temp)
                                                            checked
                                                        @endif
                                                    @endisset
                                                onchange="this.form.submit()">
                                                <label for="table-{{ $i }}" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">
                                                    {{ $temp }}
                                                </label>
                                            </div>
                                        </td>
                                        <td class="px-3 py-1 border-b border-gray-200 bg-white text-sm text-right">
                                            <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                <span aria-hidden="" class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Active</span>
                                            </span>
                                        </td>
                                    </tr>
                                @empty 
                                    <tr>
                                        <td class="px-3 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                            Tidak ada tabel
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>
                @isset($columns)
                    <div class="col-span-2">
                        <div class="bg-white rounded-lg p-5 shadow-sm">
                            <form action="{{ route($prefix.'.store') }}" method="POST">
                                @csrf

                                <div class="space-y-2 mb-3">
                                    <label class="block text-gray-600 font-bold text-base tracking-tight" for="table">
                                        Nama Endpoint <span class="text-red-500">*</span>
                                    </label>
                                    <input name="module" type="text" required value="{{ ucwords(request('table')) }}" placeholder="Nama Endpoint" class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded">
                                    <input name="table" type="hidden" value="{{ request('table') }}">
                                </div>
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="col-span-3">
                                        <h4 class="mb-2 font-bold text-base tracking-tight">
                                            Kolom
                                        </h4>
                                        <div class="bg-white overflow-auto">
                                            <table class="min-w-full bg-white text-xs">
                                                <thead class="bg-gray-800 text-white">
                                                    <tr>
                                                        <th class="text-left py-2 px-3 uppercase font-semibold">
                                                            Pilih Kolom
                                                        </th>
                                                        <th class="text-left py-2 px-3 uppercase font-semibold">
                                                            Tipe
                                                        </th>
                                                        <th class="text-center py-2 px-3 uppercase font-semibold">
                                                            Key
                                                        </th>
                                                        <th class="text-center py-2 px-3 uppercase font-semibold">
                                                            Null
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-700">
                                                    @foreach($columns as $i => $column)
                                                        <tr class="even:bg-gray-100">
                                                            <td class="text-left py-1 px-2">
                                                                <div class="flex">
                                                                    <input type="checkbox" value="{{ $column->Field }}" name="column[]" id="column-{{ $i }}" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                                                    <label for="column-{{ $i }}" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">
                                                                        {{ $column->Field }}
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td class="text-left py-1 px-2">
                                                                {{ $column->Type }}
                                                            </td>
                                                            <td class="text-center py-1 px-2">
                                                                {{ $column->Key }}
                                                            </td>
                                                            <td class="text-center py-1 px-2">
                                                                @if($column->Null == 'YES')
                                                                    <i class="fas fa-check text-green-500"></i>
                                                                @else 
                                                                    <i class="fas fa-times text-red-500"></i>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {!! $errors->first('column', '<span class="text-sm text-red-600">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <h4 class="mt-3 mb-2 font-bold text-base tracking-tight">
                                            Detail API
                                        </h4>
                                        <div class="bg-white overflow-auto">
                                            <table class="min-w-full bg-white text-xs">
                                                <thead class="bg-gray-800 text-white">
                                                    <tr>
                                                        <th class="text-left py-2 px-3 uppercase font-semibold">Method</th>
                                                        <th class="text-left py-2 px-3 uppercase font-semibold">Endpoint</th>
                                                        <th class="text-left py-2 px-3 uppercase font-semibold">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-700">
                                                    <tr>
                                                        <td class="text-left py-1.5 px-2">
                                                            <div class="flex">
                                                                <input type="checkbox" value="index" name="method[]" id="method-get" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                                                <label for="method-get" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">
                                                                    GET
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="text-left py-1.5 px-2">
                                                            <code class="border rounded py-0.5 px-1 border-gray-100">/{{ request('table') }}</code>
                                                        </td>
                                                        <td class="text-left py-1.5 px-2">
                                                            List Resources
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-gray-200">
                                                        <td class="text-left py-1.5 px-2">
                                                            <div class="flex">
                                                                <input type="checkbox" value="store" name="method[]" id="method-post" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                                                <label for="method-post" class="text-gray-500 ms-2 dark:text-neutral-400">
                                                                    POST
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="text-left py-1.5 px-2">
                                                            <code class="border rounded py-0.5 px-1 border-gray-50">/{{ request('table') }}</code>
                                                        </td>
                                                        <td class="text-left py-1.5 px-2">
                                                            Buat Resource
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left py-1.5 px-2">
                                                            <div class="flex">
                                                                <input type="checkbox" value="show" name="method[]" id="method-show" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                                                <label for="method-show" class="text-gray-500 ms-2 dark:text-neutral-400">
                                                                    GET
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="text-left py-1.5 px-2 tracking-tighter">
                                                            <code class="border rounded py-0.5 px-1 border-gray-100">/{{ request('table') }}/<span class="text-gray-400">{{ '{'.request('table').'}' }}</span></code>
                                                        </td>
                                                        <td class="text-left py-1.5 px-2">
                                                            Show Resource
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-gray-200">
                                                        <td class="text-left py-1.5 px-2">
                                                            <div class="flex">
                                                                <input type="checkbox" value="update" name="method[]" id="method-put" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                                                <label for="method-put" class="text-gray-500 ms-2 dark:text-neutral-400">
                                                                    PUT/PATCH
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="text-left py-1.5 px-2 tracking-tighter">
                                                            <code class="border rounded py-0.5 px-1 border-gray-50">/{{ request('table') }}/<span class="text-gray-400">{{ '{'.request('table').'}' }}</span></code>
                                                        </td>
                                                        <td class="text-left py-1.5 px-2">
                                                            Sunting Resource
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left py-1.5 px-2">
                                                            <div class="flex">
                                                                <input type="checkbox" value="destroy" name="method[]" id="method-delete" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                                                <label for="method-delete" class="text-gray-500 ms-2 dark:text-neutral-400">
                                                                    DELETE
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="text-left py-1.5 px-2 tracking-tighter">
                                                            <code class="border rounded py-0.5 px-1 border-gray-100">/{{ request('table') }}/<span class="text-gray-400">{{ '{'.request('table').'}' }}</span></code>
                                                        </td>
                                                        <td class="text-left py-1.5 px-2">
                                                            Hapus Resource
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            {!! $errors->first('method', '<span class="text-sm text-red-600">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <button type="submit" class="px-4 py-2 text-white bg-gray-900 rounded-md font-semibold shadow-md hover:shadow-none">
                                        Generate API
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>
@endsection