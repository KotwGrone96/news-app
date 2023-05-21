<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __("Task Edit: $task->task_name") }}
      </h2>
  </x-slot>
      <main class="px-4">
          @if ($error)
          <h1 class="text-4xl italic font-bold text-center py-5">La tarea no existe</h1>
          @else
          <h1 class="text-4xl italic font-bold text-center py-5">EDIT TASK</h1>
          <form data-edit='true' class="w-full max-w-2xl m-auto border shadow-xl p-4" id="taskForm" action="{{ route('tasks.update',['id'=>$task->id]) }}" method="POST">
              @csrf
              @method('POST')
                <div class="mb-6">
                  <label for="taskName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de tarea</label>
                  <input value="{{$task->task_name}}" type="text" id="taskName" name='taskName' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tarea 1" required>
                </div>
                <div class="mb-6">
                  <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                  <textarea name="description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Hacer las compras...">{{$task->description}}</textarea>
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Modificar</button>
          </form>
          @endif
      </main>
</x-app-layout>

<script src="{{ asset('js/taskForm/taskForm.js') }}"></script>