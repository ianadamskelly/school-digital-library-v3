<div class="space-y-6">
    <div class="rounded-[28px] border border-slate-200 bg-gradient-to-br from-white via-slate-50 to-blue-50 p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-xl space-y-3">
                <span class="inline-flex w-fit items-center rounded-full bg-blue-100 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.24em] text-blue-700">
                    Library Intake
                </span>
                <div class="space-y-2">
                    <h2 class="text-2xl font-black tracking-tight text-slate-900">Add books faster, with fewer mistakes</h2>
                    <p class="text-sm leading-6 text-slate-600">
                        Upload the PDF, attach a cover image, then assign the right category and learning level so students can find it easily.
                    </p>
                </div>
            </div>

            <div class="grid gap-3 sm:grid-cols-3 lg:w-[360px] lg:grid-cols-1 xl:grid-cols-3">
                <div class="rounded-2xl border border-white/70 bg-white/80 p-4 backdrop-blur">
                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">PDF Size</p>
                    <p class="mt-2 text-sm font-semibold text-slate-800">Up to 10 MB</p>
                    <p class="mt-1 text-xs text-slate-500">Compressed files load better on slow connections.</p>
                </div>
                <div class="rounded-2xl border border-white/70 bg-white/80 p-4 backdrop-blur">
                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">Cover Image</p>
                    <p class="mt-2 text-sm font-semibold text-slate-800">Optional</p>
                    <p class="mt-1 text-xs text-slate-500">Adds visual context on the student dashboard.</p>
                </div>
                <div class="rounded-2xl border border-white/70 bg-white/80 p-4 backdrop-blur">
                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">Tagging</p>
                    <p class="mt-2 text-sm font-semibold text-slate-800">Category + Grades</p>
                    <p class="mt-1 text-xs text-slate-500">Makes recommendations and filtering more accurate.</p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" id="upload-form" class="space-y-6">
        @csrf

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1.25fr)_minmax(320px,0.75fr)]">
            <section class="space-y-6 rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-slate-400">Step 1</p>
                        <h3 class="mt-1 text-lg font-bold text-slate-900">Book details</h3>
                    </div>
                    <div class="hidden rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 sm:block">
                        Required fields first
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Book title</label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="For example: The Lion and the Jewel"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-blue-500 @error('title') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                        >
                        @error('title')
                            <p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Author name</label>
                        <input
                            type="text"
                            name="author"
                            value="{{ old('author') }}"
                            placeholder="For example: Chinua Achebe"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-blue-500 @error('author') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                        >
                        @error('author')
                            <p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Category</label>
                        <select
                            name="category_id"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:ring-blue-500 @error('category_id') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                        >
                            <option value="">Choose a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-slate-500">Examples include Story Books, Textbooks, Science &amp; Nature, and Life Skills.</p>
                        @error('category_id')
                            <p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Target grades</label>
                        <div class="relative" data-grade-picker>
                            <select name="grades[]" multiple class="hidden" id="grades-select">
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}" {{ (is_array(old('grades')) && in_array($grade->id, old('grades'))) ? 'selected' : '' }}>
                                        {{ $grade->name }}
                                    </option>
                                @endforeach
                            </select>

                            <button
                                type="button"
                                id="grades-toggle"
                                class="flex min-h-[52px] w-full items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-left text-sm text-slate-700 transition hover:border-blue-300 hover:bg-white focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                            >
                                <span class="flex flex-wrap items-center gap-2" id="selected-grades-container">
                                    <span id="grades-placeholder" class="text-slate-400">Choose one or more grade groups</span>
                                </span>
                                <svg class="h-4 w-4 shrink-0 text-slate-400 transition" id="grades-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div
                                id="grades-dropdown"
                                class="absolute z-20 mt-2 hidden w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-200/70"
                            >
                                <div class="border-b border-slate-100 px-4 py-3">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Grade groups</p>
                                    <p class="mt-1 text-xs text-slate-500">Examples: Pre-School, Lower Primary, High School, College, Other.</p>
                                </div>
                                <div class="max-h-64 overflow-y-auto py-2">
                                    @foreach($grades as $grade)
                                        <label class="flex cursor-pointer items-center gap-3 px-4 py-3 transition hover:bg-blue-50">
                                            <input
                                                type="checkbox"
                                                value="{{ $grade->id }}"
                                                class="grade-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                                data-name="{{ $grade->name }}"
                                                {{ (is_array(old('grades')) && in_array($grade->id, old('grades'))) ? 'checked' : '' }}
                                            >
                                            <span class="text-sm font-medium text-slate-700">{{ $grade->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @error('grades')
                            <p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <aside class="space-y-6">
                <section class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-slate-400">Step 2</p>
                        <h3 class="mt-1 text-lg font-bold text-slate-900">Files</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Keep file names clear and compress large PDFs before upload for better reader performance.
                        </p>
                    </div>

                    <div class="mt-5 space-y-5">
                        <div class="rounded-3xl border border-dashed border-blue-200 bg-blue-50/70 p-4">
                            <label class="mb-3 block text-sm font-semibold text-slate-700">Upload PDF</label>
                            <input
                                type="file"
                                name="pdf_file"
                                accept="application/pdf"
                                class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-blue-600 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-700 @error('pdf_file') border-red-500 @enderror"
                            >
                            <p class="mt-3 text-xs text-slate-500">Recommended: compressed PDF, readable text, under 10 MB.</p>
                            @error('pdf_file')
                                <p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-4">
                            <label class="mb-3 block text-sm font-semibold text-slate-700">Cover image</label>
                            <input
                                type="file"
                                name="cover_image"
                                accept="image/*"
                                class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-slate-800 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-900"
                            >
                            <p class="mt-3 text-xs text-slate-500">Optional, but helpful for visual browsing on dashboards.</p>
                        </div>
                    </div>
                </section>

                <section class="rounded-[28px] border border-amber-200 bg-amber-50 p-6 shadow-sm">
                    <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-amber-700">Before you upload</p>
                    <ul class="mt-3 space-y-2 text-sm leading-6 text-amber-900">
                        <li>Confirm the PDF opens correctly.</li>
                        <li>Use the closest category and broad learning level.</li>
                        <li>Prefer clear cover images with readable titles.</li>
                    </ul>
                </section>
            </aside>
        </div>

        <div class="flex flex-col gap-3 rounded-[28px] border border-slate-200 bg-slate-950 p-5 text-white shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.24em] text-blue-200">Ready to publish</p>
                <p class="mt-2 text-sm text-slate-300">The book will be added to the local library and become available for student reading.</p>
            </div>
            <button
                type="submit"
                id="submit-btn"
                class="inline-flex items-center justify-center gap-3 rounded-full bg-blue-500 px-6 py-3 text-sm font-bold text-white transition hover:bg-blue-400 disabled:cursor-not-allowed disabled:opacity-70"
            >
                <span id="btn-text">Add to Library</span>
                <span id="btn-spinner" class="hidden">
                    <svg class="h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </div>
    </form>

    <script>
        const form = document.getElementById('upload-form');
        const checkboxes = document.querySelectorAll('.grade-checkbox');
        const select = document.getElementById('grades-select');
        const container = document.getElementById('selected-grades-container');
        const placeholder = document.getElementById('grades-placeholder');
        const dropdown = document.getElementById('grades-dropdown');
        const toggle = document.getElementById('grades-toggle');
        const chevron = document.getElementById('grades-chevron');

        function updateGrades() {
            const selected = [];

            container.querySelectorAll('[data-grade-tag]').forEach((tag) => tag.remove());

            checkboxes.forEach(cb => {
                const option = select.querySelector(`option[value="${cb.value}"]`);

                if (cb.checked) {
                    option.selected = true;
                    selected.push(cb.getAttribute('data-name'));

                    const tag = document.createElement('span');
                    tag.dataset.gradeTag = 'true';
                    tag.className = 'inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-[11px] font-bold text-blue-700';
                    tag.textContent = cb.getAttribute('data-name');
                    container.appendChild(tag);
                } else {
                    option.selected = false;
                }
            });

            placeholder.classList.toggle('hidden', selected.length > 0);
        }

        function toggleDropdown(forceOpen = null) {
            const shouldOpen = forceOpen ?? dropdown.classList.contains('hidden');

            dropdown.classList.toggle('hidden', !shouldOpen);
            chevron.classList.toggle('rotate-180', shouldOpen);
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateGrades));
        toggle.addEventListener('click', () => toggleDropdown());

        document.addEventListener('click', function (event) {
            if (!event.target.closest('[data-grade-picker]')) {
                toggleDropdown(false);
            }
        });

        updateGrades();

        form.addEventListener('submit', function () {
            const button = document.getElementById('submit-btn');
            const text = document.getElementById('btn-text');
            const spinner = document.getElementById('btn-spinner');

            button.disabled = true;
            text.classList.add('hidden');
            spinner.classList.remove('hidden');
        });
    </script>
