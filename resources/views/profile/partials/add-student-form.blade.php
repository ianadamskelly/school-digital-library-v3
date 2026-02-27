<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add New Student') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Quickly register a new student to the library system.') }}
        </p>
    </header>

    @if (session('status') === 'student-registered')
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 4000)"
            class="text-sm text-green-600 font-bold mt-2"
        >{{ __('Student registered successfully.') }}</p>
    @endif

    <form method="post" action="{{ route('teacher.students.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="student_name" :value="__('Full Name')" />
            <x-text-input id="student_name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="student_id" :value="__('Student ID')" />
            <x-text-input id="student_id" name="student_id" type="text" class="mt-1 block w-full" :value="old('student_id')" required />
            <x-input-error class="mt-2" :messages="$errors->get('student_id')" />
        </div>

        <div>
            <x-input-label for="grade_id" :value="__('Grade/Class')" />
            <select id="grade_id" name="grade_id" required
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">{{ __('Select Grade') }}</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('grade_id')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Add Student') }}</x-primary-button>
        </div>
    </form>
</section>
