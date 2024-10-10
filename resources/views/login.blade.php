@extends('apigen::app')
@section('content')
    <div class="w-1/2 mx-auto mt-7 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-4 sm:p-7">
            <div class="text-center">
                <div class="flex lg:justify-center lg:col-start-2 items-center px-4 mb-6">
                    <img src="https://api.kaltimprov.go.id/images/favicon.png" alt="" class="h-16 w-auto">
                    <img src="https://api.kaltimprov.go.id/images/logo.png" alt="" class="h-14 w-auto">
                </div>
                <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">
                    Connect to API Kaltim
                </h1>
            </div>
            <div class="mt-6">
                <form action="{{route('apigen::login')}}" method="POST" onsubmit="showLoading()" class="mb-3">
                    @csrf
                    <div class="grid gap-y-4">
                        <div class="flex flex-col">
                            <label for="token" class="mb-2 ps-1">
                                Masukkan API Keys dari akun OPD Anda di sini
                            </label>
                            <textarea name="token" id="token" rows="10" class="px-3 py-2 border rounded-lg" placeholder="eg. eyJ0eXA"></textarea>
                            {!! $errors->first('token', '<span class="mt-1 text-sm text-red-600">:message</span>') !!}
                        </div>

                        {{-- 
                        eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5Y2QzNzUwMi00NWMwLTRiMGEtYjRhYy1lNGNlYjk4ZWU1MTkiLCJqdGkiOiI4ODkzMTdlZjZlY2MwY2Q0MDc1N2FiNDQ2M2E3OWQxZDgxMzZmNzIxNDE1NTYwNDk5MGQxYWUxNTg2MjkxOGVkY2RlYjQzNTA4Mzc5ZWY1NiIsImlhdCI6MTcyNzI3OTI4NC45Nzc2MjcsIm5iZiI6MTcyNzI3OTI4NC45Nzc2MjksImV4cCI6NDg4Mjk1Mjg4NC45NzQ1MjMsInN1YiI6IjIxOTM3NzQ2Iiwic2NvcGVzIjpbImRpc2tvbWluZm8iXX0.x_9oqd-LAxXp6lNFRh6CGbHxJJy2fHEHv-xnBBdO_XVgofNNxYbaCZ74k6e7Inum9Ew2mEq0kVOTLrBWm6VTiLlGAxMq9e_GpvqEjg-A3xwgcZ3lFC5kuxDEDPgQJL782O3_zUu4_LzChkp9O2KVrGNQn6Ka5RONVWw-0hFeFwMElyLeeoXDxUUSfNv8-e-sXsulcOlVoiB88xp4l9OAIkbc2QWXaLjraQX6x44SEqGHRrCHS9BgNI6w-dD4qTWUdPpOYodm3bN48T3Fjl9pGDQ2ujNags3XRetmN3894MXnSrDx21Q5asnr2LBZFBSOAxTT9HjF7mv2Y-p-mxV-KOeDAmnL1G7HEyivPPlSk14vQVbQVk7Y4WmHcwPPQpMz4eDNZC9QGQjCM832NypOdqhCX3OTdxg79OaUcrGYMMFyMdwqb3YoitwtyTurk6k-CeRrJ-5Slc3uZtrTK0E3UvK2ikDPkiWq2b3xb6B5diwRk8QfA3BqjP4dW-vNzeSBtWPArqUft6OLr08yIcElq9lXQSCuYgidZ3QRH2hHph0pvf1SUmHSxoEBuI5jzoewsdxRhgI86pGBV032VaW_5n7vtnp7WyGgNyHa_-7v-a9aRLCYGHkxpifc0_jq1BvvInK-Ls9lZq9xHKTfpqcFHHvvprnB2sXCW31PfjQi-30
                        --}}
                        @if(session()->has('error'))
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <button type="submit" class="w-full py-2.5 px-4 inline-flex justify-center items-center gap-x-2 font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Submit
                        </button>
                    </div>
                </form>
                <div id="loading" style="display: none;">
                    <h3>Proses login...</h3>
                    <progress id="progress" value="0" max="100"></progress>
                    <span id="percentage">0%</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showLoading() {
            document.getElementById('loading').style.display = 'block';
            let progress = document.getElementById('progress');
            let percentage = document.getElementById('percentage');
            let value = 0;

            // Update persentase setiap 100ms
            let interval = setInterval(() => {
                if (value >= 100) {
                    clearInterval(interval);
                } else {
                    value += 10; // Tambahkan sesuai kebutuhan
                    progress.value = value;
                    percentage.innerText = value + '%';
                }
            }, 50);
        }
    </script>
@endsection