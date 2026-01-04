@extends('_teacher._layout.app')

@section('title', 'Ilustrasi')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">
            {{ $page['title'] }}
        </h1>
        <p class="text-md text-gray-400 dark:text-neutral-400">
            Buat ilustrasi dengan bantuan AI
        </p>
    </div>

    <div>
        <div class="inline-flex gap-x-2">
            <a navigate
                class="py-3 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-blue-700 transition-all shadow-md shadow-blue-500/20 active:scale-95 cursor-pointer"
                href="{{ route('teacher.ai.ilustrasi.add') }}">
                @include('_admin._layout.icons.add')
                Generate Ilustrasi
            </a>
        </div>
    </div>
</div>
@endsection
