@extends('_admin._layout.app')

@section('title', 'Tambah Siswa')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white shadow-lg rounded-2xl dark:bg-neutral-800 border border-gray-100">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h2 class="text-xl font-semibold">
                    Tambah {{ $page['title'] }}
                </h2>
                <a navigate href="{{ route('admin.students.index') }}"
                    class="py-1 px-2 text-xs rounded-lg bg-yellow-500 text-white">
                    Kembali
                </a>
            </div>

            <form class="p-6" navigate-form action="{{ route('admin.students.create') }}" method="POST">
                @csrf

                <div class="space-y-4">

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Siswa *</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border px-3 py-2"
                            required>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full rounded-lg border px-3 py-2" required>
                    </div>

                    {{-- Kelas --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Kelas *</label>
                        <select name="classroom_id" class="w-full rounded-lg border px-3 py-2" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($classrooms as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->class_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="mt-4 flex gap-2">
                    <a navigate href="{{ route('admin.students.index') }}" class="px-3 py-2 border rounded-lg">Batal</a>
                    <button class="px-3 py-2 bg-blue-600 text-white rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection