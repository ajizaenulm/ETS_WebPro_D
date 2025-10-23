<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __("Add a New Task") }}
                    </h3>

                    <form method="POST" action="{{ route('tasks.store') }}" class="space-y-4">
                        @csrf

                        <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input 
                                    id="title"
                                    name="title" 
                                    class="w-full mt-1" 
                                    placeholder="What do you need to do?"
                                    required 
                                />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description (Optional)')" />
                            <textarea 
                                id="description"
                                name="description" 
                                placeholder="Add a description..."
                                class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                rows="3"
                            ></textarea>
                        </div>

                        <div>
                            <x-input-label for="deadline_at" :value="__('Deadline (Optional)')" />
                            <x-text-input 
                                id="deadline_at"
                                name="deadline_at"
                                type="date"
                                class="w-full mt-1" 
                            />
                        </div>

                        <div class="flex justify-end">
                            </div>

                        <div class="flex justify-end">
                            <x-primary-button>
                                {{ __('Add Task') }}
                            </x-primary-button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-baseline justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ __("Your Tasks") }}
                        </h3>

                        <div class="text-sm">
                            <span class="font-medium">Sort by:</span>

                            <a href="{{ route('dashboard', ['sort' => 'created_at']) }}" 
                            class="ml-2 {{ $currentSort === 'created_at' ? 'font-bold text-indigo-600' : 'text-gray-500 hover:text-gray-800' }}">
                                Newest
                            </a>

                            <span class="text-gray-300 mx-1">|</span>

                            <a href="{{ route('dashboard', ['sort' => 'deadline']) }}" 
                            class="{{ $currentSort === 'deadline' ? 'font-bold text-indigo-600' : 'text-gray-500 hover:text-gray-800' }}">
                                Deadline
                            </a>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse ($tasks as $task)
                            <div class="flex justify-between items-start p-4 border-b border-gray-200 last:border-b-0">

                                <div class="flex-1"> 
                                    <span class="font-semibold text-lg {{ $task->is_completed ? 'line-through text-gray-400' : 'text-gray-800' }}">
                                        {{ $task->title }}
                                    </span>

                                    @if ($task->description)
                                        <p class="text-sm text-gray-600 mt-1 whitespace-pre-wrap"><span class="{{ $task->is_completed ? 'line-through text-gray-400' : '' }}">{{ trim($task->description) }}</span> </p>
                                    @endif

                                    @if ($task->deadline_at)
                                        <span class="font-semibold text-lg {{ $task->is_completed ? 'line-through text-gray-400' : 'text-gray-800' }}">
                                            <p class="text-sm text-red-600 mt-1 font-semibold">
                                                Deadline: {{ $task->deadline_at->format('M d, Y') }}
                                            </p>
                                        </span>
                                    @endif
                                    <!-- literally does not look pretty at all -->
                                </div>

                                <div class="flex flex-col sm:flex-row gap-2 ml-4">
                                    
                                    <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        
                                        @if ($task->is_completed)
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-yellow-600">
                                                {{ __('Undo') }}
                                            </button>
                                        @else
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 text-white border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-green-600">
                                                {{ __('Complete') }}
                                            </button>
                                        @endif
                                    </form>

                                    <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-blue-600">
                                        {{ __('Edit') }}
                                    </a>

                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline"> @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit" onclick="return confirm('Are you sure you want to delete this task?')">
                                            {{ __('Delete') }}
                                        </x-danger-button>
                                    </form>
                                </div>

                            </div>
                        @empty
                            <p class="text-gray-500">You have no tasks yet!</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>