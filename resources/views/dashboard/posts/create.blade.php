@extends('layouts.createForm')

@section('title', 'Correo de Buenos Aires | Crear publicación')

@section('header')

    <input type="hidden" name="post_id" id="post_id" value="{{ $post->id }}">
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <a href="{{ route('posts.index') }}" class="flex ml-2 md:mr-24">
                        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="FlowBite Logo" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Correo
                            de Bs.As.</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ml-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full border"
                                    src="https://static.vecteezy.com/system/resources/previews/008/442/086/original/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg"
                                    alt="user photo">
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    {{ $user->name }} {{ $user->last_name }}
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    {{ $user->email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Perfil</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-start"
                                            role="menuitem">Salir</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <div class="w-full pt-10 mt-10 flex justify-start items-center max-w-7xl mx-auto gap-4">
        <a href="{{ route('dashboard.posts') }}" type="button"
            class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 shadow-lg shadow-red-500/50 font-medium rounded-lg text-sm px-5 py-2 text-center">Atrás</a>
        <h2 class="text-xl md:text-2xl font-bold text-gray-700">{{$type=='CREATE'?'Crear':'Editar'}} publicación</h2>
    </div>
    <div class="w-full max-w-7xl mt-4 mx-auto">
        <div id="container"
            class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 text-left min-h-screen">
            <div class="flex flex-col lg:grid grid-cols-12 w-full">
                <div class="lg:col-span-6">
                    <label for="title" class="block mb-2 text-base font-semibold text-gray-900">Título
                        <span id="error-title"
                            class="hidden text-xs md:text-sm font-semibold text-red-800 ml-2 bg-red-100 rounded-lg p-4 py-1 form-error"></span>
                    </label>
                    <input type="text" id="title" name="title"
                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-base focus:ring-blue-500 focus:border-blue-500"
                        value="{{ $post->title }}">
                </div>
                <div class="lg:col-start-10 lg:col-span-3 relative">
                    <label for="publication_date" class="block mb-2 text-base font-semibold text-gray-900">Fecha de
                        publicación <span id="error-publication_date"
                            class="hidden text-xs md:text-sm font-semibold absolute text-red-800 ml-2 bg-red-100 rounded-lg p-4 py-1 form-error"></span>
                    </label>
                    <div class="absolute bottom-3 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input datepicker type="text" id="publication_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                        placeholder="Fecha de publicación" datepicker-format="dd/mm/yyyy" value="{{ date('d-m-Y') }}">
                </div>
            </div>
            <div class="my-6">
                <label for="summary" class="block mb-2 text-base font-semibold text-gray-900 dark:text-white">Resumen<span
                        id="error-summary"
                        class="hidden text-xs md:text-sm font-semibold text-red-800 ml-2 bg-red-100 rounded-lg p-4 py-1 form-error"></span></label>
                <textarea id="summary" rows="4"
                    class="block p-2.5 w-full text-base text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none"
                    placeholder="Escriba aquí..." maxlength="255">{{$post->summary?$post->summary:''}}</textarea>
                <p class="ml-2 pt-1"><span id="summary_count">0</span>/255</p>
                <div class="hidden p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert"
                    id="summary_alert">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">Cuidado!</span> El resumen no debe superar los 255 caracteres.
                    </div>
                </div>
            </div>
            <div class="my-6 flex flex-col items-center md:flex-row gap-4 md:gap-8">
                <label
                    class="mb-2 text-base font-medium text-white hover:bg-blue-700 transition-colors bg-blue-600 w-max py-2 px-3 cursor-pointer rounded-lg flex items-center gap-2"
                    for="image">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3">
                        </path>
                    </svg>
                    <span>Subir portada</span>
                    <span id="error-image"
                        class="hidden text-xs md:text-sm font-semibold text-red-800 ml-2 bg-red-100 rounded-lg p-4 py-1 form-error"></span>
                </label>
                <input
                    class="hidden w-full mb-5 text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    id="image" type="file" accept="image/png, image/jpeg">
                <div class="w-[300px] md:w-[500px] min-h-[100px] border bg-gray-50 border-gray-500 border-dashed border-separate"
                    id="image_preview">
                </div>
                <div class="hidden p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                    role="alert" id="file_alert">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">Cuidado!</span> El archivo no es tipo JPG, JPEG o PNG.
                    </div>
                </div>
            </div>
            <div class="my-6">
                <label for="body" class="block mb-2 text-base font-semibold text-gray-900 dark:text-white">Cuerpo
                    <span id="error-body_content"
                        class="hidden text-xs md:text-sm font-semibold text-red-800 ml-2 bg-red-100 rounded-lg p-4 py-1 form-error"></span></label>
                <div id="body"
                    class="block p-2.5 w-full text-base text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                    style="height: 500px;">
                </div>
            </div>
            <div class="my-6">
                <label for="labels" class="block mb-2 text-base font-semibold text-gray-900 dark:text-white">Etiquetas
                    <span id="error-labels"
                        class="hidden text-xs md:text-sm font-semibold text-red-800 ml-2 bg-red-100 rounded-lg p-4 py-1 form-error"></span></label>
                <span class="text-gray-500 text-sm font-bold pb-2 block">Palabras claves relacionadas al tema central de la
                    publicación. Se sugiere un mínimo de 3 palabras y separadas por una coma. <span class="text-red-700">(
                        Ej: comida, actualidad, correo de buenos aires )</span></span>
                <input type="text" id="labels"
                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="my-6">
                <label for="author" class="block mb-2 text-base font-semibold text-gray-900 dark:text-white">Autor<span
                        id="error-owner_id"
                        class="hidden text-xs md:text-sm font-semibold text-red-800 ml-2 bg-red-100 rounded-lg p-4 py-1 form-error"></span></label>
                <input type="text" id="author" aria-label="disabled input"
                    class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ $user->name }} {{ $user->last_name }}" data-owner="{{ $user->id }}" disabled>
            </div>
            <div class="w-full flex items-center justify-end gap-4 flex-col md:flex-row mt-20">
                <button type="button"
                    class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2 text-center flex items-center gap-2">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
                        </path>
                    </svg>
                    <span>Vista previa</span>
                </button>
                <button type="button"
                    class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2 text-center flex items-center gap-2 submit"
                    data-type="DRAFT">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
                        </path>
                    </svg>
                    <span>Borrador</span>
                </button>
                <button type="button"
                    class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2 text-center flex items-center gap-2 submit"
                    data-type="PUBLISH">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12">
                        </path>
                    </svg>
                    <span>Publicar</span>
                </button>
            </div>
        </div>
    </div>

@endsection

<script src="{{ asset('js/posts/create.js') }}" type="module"></script>
