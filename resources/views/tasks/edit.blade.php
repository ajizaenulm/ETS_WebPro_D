<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __("Editing Task: ") }} {{ $task->title }}
                    </h3>

                    <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-4">
                        @csrf
                        @method('PATCH') <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input 
                                id="title"
                                name="title" 
                                class="w-full mt-1" 
                                :value="old('title', $task->title)"
                                required 
                            />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description (Optional)')" />
                            <textarea 
                                id="description"
                                name="description" 
                                class="block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                rows="3"
                            >{{ old('description', $task->description) }}</textarea>
                        </div>
                        
                        <div>
                            <x-input-label for="deadline_at" :value="__('Deadline (Optional)')" />
                            <x-text-input 
                                id="deadline_at"
                                name="deadline_at"
                                type="date"
                                class="w-full mt-1"
                                :value="old('deadline_at', $task->deadline_at ? $task->deadline_at->format('Y-m-d') : '')"
                            />
                        </div>

                        <div class="flex justify-end gap-4">
                            </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                {{ __('Cancel') }}
                            </a>

                            <x-primary-button>
                                {{ __('Save Changes') }}
                            </x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>