@extends('_admin._layout.app')

@section('title', 'Ilustrasi')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
    <x-page-title
        title="{{ $page['title'] }}"
        description="Buat ilustrasi dengan bantuan AI" />
    <div>
        <div class="inline-flex gap-x-2">
            <x-add-button :href="route('teacher.ai.ilustrasi.add')" label="Buat Ilustrasi" />
        </div>
    </div>
</div>
@endsection
