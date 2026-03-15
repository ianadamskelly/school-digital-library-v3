<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-blue-600">Teacher Tools</p>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Add a New Book
                </h2>
            </div>
            <a href="{{ route('teacher.dashboard') }}"
                class="inline-flex items-center justify-center rounded-full border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-blue-200 hover:text-blue-700">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 p-5 text-red-800 shadow-sm">
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-red-600">Please fix these issues</p>
                    <ul class="mt-3 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @include('teacher.upload')
        </div>
    </div>
</x-app-layout>
