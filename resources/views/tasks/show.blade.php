<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Task: $task->task_name") }}
        </h2>
    </x-slot>
    <main class="px-4">
        <h1 class="text-4xl italic font-bold text-center py-5">{{$task->task_name}}</h1>
        @csrf
        <p class="text-center text-2xl font-medium">{{$task->description}}</p>
        <div class="max-w-xs flex justify-evenly items-center mx-auto mt-5">
            <a href="{{ route('tasks.edit', ['id'=>$task->id]) }}" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Editar</a>
            <button data-url="{{ route('tasks.destroy', ['id'=>$task->id]) }}" id="btnDelete" data-taskid="{{$task->id}}" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Eliminar</button>
        </div>
    </main>
</x-app-layout>

<script type="module">
    const btnDelete = document.getElementById('btnDelete');
    const _token = document.querySelector('input[name="_token"]').value;
    const id = btnDelete.dataset.taskid
    btnDelete.addEventListener('click',async ()=>{
        if(window.confirm('¿Desea eliminar la tarea?')){
            const url = btnDelete.dataset.url
            const params = {id,_token}
            const res = await fetch(url,{
                method:'POST',
                body:JSON.stringify(params),
                headers: {
                'Content-Type': 'application/json'
                }                
            })
            const data = await res.json();
            console.log(data);
            const alertSuccess = document.getElementById('alertSuccess')
            alertSuccess.style.display = 'block';
            setTimeout(() => {
                window.location.href = '/'
            }, 1500);
        }
    })
 

</script>