<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Welcome back, {{ auth()->user()->name }}!</h1>

        <!-- Stats Card -->
        <div class="bg-blue-600 p-6 lg:p-8 rounded-3xl mb-8 flex flex-col sm:flex-row justify-between items-center text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10 text-center sm:text-left">
                <h2 class="text-base lg:text-lg font-semibold opacity-90">Your Reading Journey ({{ now()->year }})</h2>
                <p class="text-2xl lg:text-3xl font-bold mt-1">You've finished {{ $completedBooksCount }} books! 🏆</p>
                <p class="text-xs lg:text-sm opacity-80 mt-2">Keep it up, you're doing great!</p>
            </div>
            <div class="text-5xl lg:text-6xl font-bold opacity-20 mt-4 sm:mt-0">📚</div>
        </div>

        <!-- Teacher's Picks / Recommendations -->
        @if($recommendations->count() > 0)
            <section class="mb-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg lg:text-xl font-bold text-gray-800 flex items-center">
                        Teacher's Picks <span class="ml-2 text-xl lg:text-2xl">🌟</span>
                    </h3>
                    <span
                        class="bg-yellow-400 text-yellow-900 text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-tighter">New</span>
                </div>

                <div class="flex space-x-6 overflow-x-auto pb-6 -mx-2 px-2 scrollbar-hide">
                    @foreach($recommendations as $rec)
                        <div
                            class="min-w-[280px] bg-yellow-50 border-2 border-yellow-100 p-6 rounded-3xl relative shadow-sm hover:shadow-md transition group">
                            <p class="text-[10px] font-bold text-yellow-600 uppercase tracking-widest mb-2">Recommended by
                                {{ $rec->teacher->name }}</p>

                            <div class="flex space-x-4">
                                <div class="w-16 h-24 bg-gray-200 rounded-lg shadow-sm flex-shrink-0 overflow-hidden">
                                    <img src="{{ $rec->book->cover_url }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 h-10 overflow-hidden leading-tight mb-2">
                                        {{ $rec->book->title }}</h4>
                                    @if($rec->note)
                                        <div class="relative">
                                            <svg class="absolute -left-2 -top-1 w-4 h-4 text-yellow-300 opacity-50"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C20.1216 16 21.017 16.8954 21.017 18V21C21.017 22.1046 20.1216 23 19.017 23H16.017C14.9124 23 14.017 22.1046 14.017 21ZM5.017 21L5.017 18C5.017 16.8954 5.91243 16 7.017 16H10.017C11.1216 16 12.017 16.8954 12.017 18V21C12.017 22.1046 11.1216 23 10.017 23H7.017C5.91243 23 5.017 22.1046 5.017 21Z">
                                                </path>
                                            </svg>
                                            <p class="text-xs italic text-gray-600 line-clamp-2 pl-2">{{ $rec->note }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('reader', $rec->book_id) }}"
                                class="mt-4 block text-center bg-yellow-400 hover:bg-yellow-500 text-yellow-900 py-3 rounded-2xl text-sm font-black transition shadow-sm">
                                Start Reading
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Continue Reading -->
        @if($inProgressBooks->count() > 0)
            <h3 class="text-xl font-bold mb-4 text-gray-800">Continue Reading</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                @foreach($inProgressBooks as $progress)
                    <a href="{{ route('reader', $progress->book_id) }}"
                        class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 hover:border-blue-200 transition flex items-center space-x-4">
                        <div class="w-12 h-16 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden shadow-inner">
                            <img src="{{ $progress->book->cover_url }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-gray-900 truncate max-w-[150px]">{{ $progress->book->title }}</span>
                                <span class="text-xs font-bold text-blue-600">{{ round($progress->percentage) }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $progress->percentage }}%"></div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Library Exploration -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <h3 class="text-xl font-bold text-gray-800">Explore the Library</h3>
            
            <!-- Filters Form -->
            <form action="{{ route('student.dashboard') }}" method="GET" class="w-full sm:flex sm:items-center gap-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search titles or authors..." 
                        class="w-full pl-12 pr-4 py-3 rounded-2xl border-none bg-white shadow-sm focus:ring-2 focus:ring-blue-500 transition-all text-sm"
                    >
                </div>

                <select name="category_id" onchange="this.form.submit()"
                    class="w-full sm:w-auto mt-2 sm:mt-0 rounded-2xl border-none bg-white shadow-sm focus:ring-2 focus:ring-blue-500 text-sm py-3 px-4">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select name="grade_id" onchange="this.form.submit()"
                    class="w-full sm:w-auto mt-2 sm:mt-0 rounded-2xl border-none bg-white shadow-sm focus:ring-2 focus:ring-blue-500 text-sm py-3 px-4">
                    <option value="">All Grades</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                            {{ $grade->name }}
                        </option>
                    @endforeach
                </select>

                @if(request()->anyFilled(['search', 'category_id', 'grade_id']))
                    <a href="{{ route('student.dashboard') }}" class="text-sm text-blue-600 font-bold hover:underline whitespace-nowrap mt-2 sm:mt-0 px-2">
                        Clear
                    </a>
                @endif
            </form>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 lg:gap-6">
            @foreach($recommendedBooks as $book)
                <div
                    class="bg-white rounded-3xl shadow-sm border border-gray-50 hover:shadow-lg transition p-3 flex flex-col items-center group">
                    <div
                        class="w-full aspect-[2/3] bg-gray-100 rounded-2xl mb-3 overflow-hidden shadow-sm group-hover:scale-105 transition duration-300">
                        <img src="{{ $book->cover_url }}" class="w-full h-full object-cover">
                    </div>
                    <h4 class="font-bold text-[10px] lg:text-sm text-center text-gray-800 h-8 lg:h-10 overflow-hidden line-clamp-2 mb-1 px-1">
                        {{ $book->title }}</h4>
                    <div class="flex flex-wrap justify-center gap-1 mb-3">
                        @if($book->category)
                            <span class="bg-blue-50 text-blue-600 text-[8px] lg:text-[10px] font-bold px-1.5 py-0.5 rounded uppercase">{{ $book->category->name }}</span>
                        @endif
                        @foreach($book->grades as $grade)
                            <span class="bg-gray-100 text-gray-600 text-[8px] lg:text-[10px] font-bold px-1.5 py-0.5 rounded uppercase">{{ $grade->name }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('reader', $book->id) }}"
                        class="w-full bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white text-[10px] lg:text-xs font-black py-2 rounded-xl transition text-center uppercase tracking-tighter">
                        Open Book
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>