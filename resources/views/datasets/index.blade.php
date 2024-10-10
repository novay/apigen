@extends('apigen::app')
@section('title', $title)

@section('content')
    <div class="flex flex-wrap">
        <div class="w-full px-2">
            <p class="text-xl pb-6 flex items-center font-bold tracking-tight">
                <i class="fas fa-list mr-3"></i>
                {{ $data->name }}
            </p>
            <div class="leading-loose">
                <div class="flex flex-col">
                    @foreach($data->endpoints as $endpoint)
                        <div class="flex items-center gap-3">
                            <div>
                                @if($endpoint->is_active == 1)
                                    <i class="fas fa-check text-green-500"></i>
                                @else
                                    <i class="fas fa-times text-red-500"></i>
                                @endif
                            </div>
                            <div>{{ $endpoint->name }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection