@extends('_admin._layout.app')

@section('title', 'Edit Siswa')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white shadow-lg rounded-2xl border p-6">

            <h2 class="text-xl font-semibold mb-4">
                Edit {{ $page['title'] }}
            </h2>

            <form navigate-form action="{{ route('admin.teachers.do_update', $data->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="block text-sm font-medium">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $data->name) }}"
                        class="w-full rounded-lg border px-3 py-2" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email', $data->email) }}"
                        class="w-full rounded-lg border px-3 py-2" required>
                </div>

               

                <div class="flex gap-2 mt-4">
                    <a navigate href="{{ route('admin.students.index') }}" class="px-3 py-2 border rounded-lg">Batal</a>
                    <button class="px-3 py-2 bg-blue-600 text-white rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection