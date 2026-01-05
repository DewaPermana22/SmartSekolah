@extends('_admin._layout.app')

@section('title', 'Materi Belajar')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
    <x-page-title
        title="{{ $page['title'] }}"
        description="Buat materi belajar dengan bantuan AI" />
    <div>
        <div class="inline-flex gap-x-2">
            <x-add-button :href="route('teacher.ai.materi_ajar.add')" label="Buat Materi"></x-add-button>
        </div>
    </div>
</div>
@endsection
