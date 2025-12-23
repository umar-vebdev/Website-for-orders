@extends('layouts.admin')

@section('title', 'Регистрация админа')

@section('content')
<div class="max-w-md mx-auto p-6 bg-gray-900 rounded-xl shadow-md mt-6">


    <form action="{{ route('admin.register') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 text-gray-300">Имя</label>
            <input type="text" name="name" 
                   class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                   required>
        </div>

        <div>
            <label class="block mb-1 text-gray-300">Email</label>
            <input type="email" name="email" 
                   class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                   required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        

        <div>
            <label class="block mb-1 text-gray-300">Пароль</label>
            <input type="password" name="password" 
                   class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                   required>
        </div>

        <button type="submit" class="w-full py-2 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-500 hover:to-blue-700 text-white font-semibold rounded shadow-md transition">
            Зарегистрировать
        </button>
    </form>

</div>
@endsection
