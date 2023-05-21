<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>
    <main class="px-4">
        {{-- <h1 class="text-4xl italic font-bold text-center py-5">TASKS</h1> --}}
        <div class="w-full p-4 py-5 flex justify-center items-start flex-wrap gap-4">
            @if (count($tasks)==0)
                <h1 class="text-4xl italic font-bold text-center py-5">NO HAY TAREAS</h1>
            @else
                @foreach ($tasks as $item)
                <a href="{{ route('tasks.show', ['id'=>$item->id]) }}" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{$item->task_name}}</h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{$item->description}}</p>
                </a>
                @endforeach
            @endif 
        </div>
    </main>
</x-app-layout>



