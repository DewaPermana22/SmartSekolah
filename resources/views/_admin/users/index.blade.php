@extends('_admin._layout.app')

@section('title', 'Data Pengguna')

@php
    use App\Constants\UserConst;
@endphp

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">
                Data {{ $page['title'] }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-neutral-400">
                Kelola data pengguna aplikasi sekolah Anda.
            </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a navigate
                class="py-3 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-blue-700 transition-all shadow-md shadow-blue-500/20 active:scale-95 cursor-pointer"
                href="{{ route('admin.users.add') }}">
                @include('_admin._layout.icons.add')
                Tambah Pengguna
            </a>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700 mb-6">
                    <div class="p-4 sm:p-6">
                        <form navigate-form method="GET" action="{{ route('admin.users.index') }}">
                            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="lg:col-span-2">
                                    <label for="keywords" class="block text-sm font-medium mb-2 text-gray-700 dark:text-neutral-300">
                                        Cari
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="keywords" name="keywords" value="{{ $keywords ?? '' }}"
                                            placeholder="Ketik nama atau email..."
                                            class="py-3 px-4 ps-11 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                            <svg class="flex-shrink-0 size-4 text-gray-400 dark:text-neutral-500"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <circle cx="11" cy="11" r="8" />
                                                <path d="m21 21-4.3-4.3" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="access_type" class="block text-sm font-medium mb-2 text-gray-700 dark:text-neutral-300">
                                        Hak Akses
                                    </label>
                                    <select id="access_type" name="access_type" data-hs-select='{
                                        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400",
                                        "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 size-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"flex-shrink-0 size-3.5 text-gray-500 dark:text-neutral-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                    }' class="hidden">
                                        <option value="all" {{ ($access_type ?? 'all') == 'all' ? 'selected' : '' }}>
                                            Semua Hak Akses
                                        </option>
                                        <option value="1" {{ ($access_type ?? '') == '1' ? 'selected' : '' }}>
                                            Admin
                                        </option>
                                        <option value="2" {{ ($access_type ?? '') == '2' ? 'selected' : '' }}>
                                            User
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-5 flex gap-x-2">
                                <button type="submit"
                                    class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none transition-all">
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                    Cari
                                </button>
                                @if (!empty($keywords) || ($access_type ?? 'all') !== 'all')
                                    <a navigate-form href="{{ route('admin.users.index') }}"
                                        class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <div class="overflow-hidden">
                    <div class="mx-0 my-4 overflow-x-auto border border-gray-200 rounded-lg dark:border-neutral-700">
                        <table class="w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead class=" dark:bg-neutral-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                Nama
                                            </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                Hak Akses
                                            </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-end"></th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                @forelse($data as $d)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <div class="flex items-center gap-x-3">
                                                    <span
                                                        class="inline-flex items-center justify-center size-9.5 rounded-full bg-white border border-gray-300 dark:bg-neutral-800 dark:border-neutral-700">
                                                        <span
                                                            class="font-medium text-sm text-gray-800 dark:text-neutral-200">
                                                            {{ strtoupper(substr($d->name, 0, 1)) }}
                                                        </span>
                                                    </span>
                                                    <div class="grow">
                                                        <span
                                                            class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $d->name }}</span>
                                                        <span
                                                            class="block text-sm text-gray-500 dark:text-neutral-500">{{ $d->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="h-px w-72 whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span
                                                    class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                                    {{ UserConst::getAccessTypes()[$d->access_type] ?? '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-1.5 flex items-center gap-x-1">
                                                <a navigate
                                                    class="inline-flex items-center justify-center size-8 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:bg-neutral-800 dark:text-white dark:hover:bg-neutral-700"
                                                    href="{{ route('admin.users.detail', $d->id) }}" title="View">
                                                    @include('_admin._layout.icons.view_detail')
                                                </a>
                                                <a navigate
                                                    class="inline-flex items-center justify-center size-8 text-sm font-semibold rounded-lg border border-blue-200 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:border-blue-300 focus:outline-none focus:bg-blue-100 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-800 dark:bg-blue-900/20 dark:text-blue-500 dark:hover:bg-blue-800/30 dark:hover:border-blue-700"
                                                    href="{{ route('admin.users.update', $d->id) }}" title="Edit">
                                                    @include('_admin._layout.icons.pencil')
                                                </a>
                                                <button type="button"
                                                    class="inline-flex items-center justify-center size-8 text-sm font-semibold rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 hover:border-red-300 focus:outline-none focus:bg-red-100 disabled:opacity-50 disabled:pointer-events-none dark:border-red-800 dark:bg-red-900/20 dark:text-red-500 dark:hover:bg-red-800/30 dark:hover:border-red-700 cursor-pointer"
                                                    title="Delete" data-hs-overlay="#delete-modal"
                                                    onclick="setDeleteData('{{ $d->id }}', '{{ $d->name }}')">
                                                    @include('_admin._layout.icons.trash')
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-4 text-center text-sm text-gray-500 dark:text-neutral-500">
                                            <x-admin.empty-state />
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if (count($data) > 0 && $data->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-neutral-700">
                            <div class="flex justify-end">
                                {{ $data->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div>
                
                @if (!empty($keywords))
                    <a class="py-1 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-50 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:bg-blue-500/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer"
                        href="{{ route('admin.users.index') }}">
                        @include('_admin._layout.icons.reset')
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    
    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto"
        role="dialog" tabindex="-1">
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div
                class="relative flex flex-col bg-white border border-gray-100 shadow-2xl rounded-2xl dark:bg-neutral-800 dark:border-neutral-700">
                <div class="absolute top-4 end-4">
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400"
                        data-hs-overlay="#delete-modal">
                        <span class="sr-only">Close</span>
                        @include('_admin._layout.icons.close_modal')
                    </button>
                </div>

                <div class="p-4 sm:p-10 text-center overflow-y-auto">
                    <span
                        class="mb-4 inline-flex justify-center items-center size-[62px] rounded-full border-4 border-red-50 bg-red-100 text-red-500 dark:bg-red-700/10 dark:border-red-900/20 dark:text-red-600">
                        @include('_admin._layout.icons.warning_modal', ['class' => 'size-6'])
                    </span>

                    <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-neutral-200">
                        Hapus Pengguna
                    </h3>
                    <p class="text-gray-500 dark:text-neutral-400">
                        Apakah Anda yakin ingin menghapus <span id="delete-user-name"
                            class="font-semibold text-gray-900 dark:text-white"></span>? Data yang dihapus tidak dapat
                        dikembalikan.
                    </p>

                    <div class="mt-8 flex justify-center gap-x-2">
                        <button type="button"
                            class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800"
                            data-hs-overlay="#delete-modal">
                            Batal
                        </button>
                        <form id="delete-form" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-hidden transition-all shadow-md shadow-red-500/20 active:scale-95">
                                Ya, Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setDeleteData(id, name) {
            document.getElementById('delete-user-name').textContent = name;
            document.getElementById('delete-form').action = '{{ url('admin/user/delete') }}/' + id;
        }
    </script>
@endsection