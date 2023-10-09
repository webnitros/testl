@extends('layout')
@section('title','404 страница')
@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">404 Error</h1>
        <p class="text-gray-600 mb-6">
        @if(empty($text))
                Упс! Страница, которую вы ищете, не существует.
        @else
            {{ $text }}
        @endif
            </p>
        <a href="/" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Вернуться на главную страницу</a>
    </div>
@endsection
