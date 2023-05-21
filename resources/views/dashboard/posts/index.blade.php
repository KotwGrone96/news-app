@extends('layouts.dashboard')

@section('title', 'Correo de Buenos Aires | Publicaciones')

@section('header')
    <div>
        @include('components.aside-nav')
    </div>
@endsection

@section('content')
    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
    <div class="w-full flex justify-between items-center">
        <h2 class="text-xl md:text-2xl font-bold text-gray-700">Publicaciones</h2>
        <button id="create-post" type="button"
            class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 shadow-lg shadow-green-500/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex justify-center items-center">
            <span>Crear</span>
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"></path>
            </svg>
        </button>
    </div>
    <div class="py-4">
        <form class="flex items-end gap-2 flex-col lg:flex-row justify-start">
            <div class="relative w-full lg:max-w-xs">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="simple-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Buscar publicación" required>
            </div>
            <select id="countries"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full lg:max-w-[200px] p-2.5">
                <option selected value="ALL">Año</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            <select id="countries"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 lg:max-w-[200px]">
                <option selected value="ALL">Mes</option>
                @foreach ($months as $index => $month)
                    <option value="{{ $index }}">{{ $month }}</option>
                @endforeach
            </select>
            <button type="submit"
                class="p-2.5 mr-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 hidden lg:block">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span class="sr-only">Search</span>
            </button>
            <button type="submit"
                class="px-2.5 py-1.5 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 lg:hidden">
                Buscar
            </button>
        </form>
    </div>

    <div class="w-full flex justify-center items-center flex-wrap gap-4">
        @if (count($posts) == 0)
            <p class="text-center pt-4 text-lg font-semibold">No hay publicaciones creadas</p>
        @endif
        @foreach ($posts as $post)
            <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow" id="post_card_{{ $post->id }}">
                @if ($post->image)
                    <img class="rounded-t-lg h-[200px] w-full object-cover" src="{{ asset('images/noticia.jpg') }}"
                        alt="{{ $post->title }}" />
                @else
                    <div class="bg-gray-200 rounded-t-lg h-[200px] w-full min-w-[320px] text-center">
                        <span class="pt-16 block uppercase font-semibold">Sin imagen de portada</span>
                    </div>
                @endif
                <div class="pt-5 pb-3 px-5">
                    <h5 class="mb-2 text-xl font-bold tracking-wide text-gray-900 text-center">{{ $post->title }}</h5>
                </div>
                @php
                    $color = '';
                    $badge_text = '';
                    $is_visible_text = $post->is_visible == 'Y' ? 'Visible' : 'Oculto';
                    if ($post->state == 'DRAFT') {
                        $color = 'bg-blue-200 text-blue-900 border-blue-500';
                        $badge_text = 'Borrador';
                    }
                    if ($post->state == 'PUBLISHED') {
                        $color = 'bg-green-200 text-green-900 border-green-500';
                        $badge_text = 'Publicado';
                    }
                    
                @endphp
                <div class="flex w-full justify-start items-center flex-wrap px-6 pb-6">
                    <span title="Guardado como borrador"
                        class="{{ $color }} text-sm font-medium mr-2 px-2.5 py-0.5 rounded border">{{ $badge_text }}</span>
                    <div class="flex items-center" id="visible_post_{{$post->id}}">
                        <span
                            title="{{ $post->is_visible == 'Y' ? 'La publicación es visible' : 'La publicación está oculta' }}"
                            class="bg-purple-100 text-purple-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded border border-purple-400">{{ $is_visible_text }}</span>
                        @if ($post->is_visible == 'Y')
                            <div title="Ocultar publicación" class="show_post" data-state="{{ $post->state }}"
                                data-post_id="{{ $post->id }}">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-6 cursor-pointer">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                    </path>
                                </svg>
                            </div>
                        @else
                            <div title="Hacer visible publicación" class="show_post" data-state="{{ $post->state }}"
                                data-post_id="{{ $post->id }}">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-6 cursor-pointer">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="w-full flex justify-center items-center gap-4 pb-4">
                    <button type="button"
                        class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 shadow-lg shadow-blue-500/50 font-medium rounded-lg text-sm px-4 py-2 text-center mr-2 mb-2 flex items-center justify-center btn-action"
                        data-post_id="{{ $post->id }}" data-action="EDIT">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10">
                            </path>
                        </svg>
                        <span>Editar</span>
                    </button>
                    <button type="button"
                        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 shadow-lg shadow-red-500/50 font-medium rounded-lg text-sm px-4 py-2 text-center mr-2 mb-2 flex items-center justify-center btn-action"
                        data-post_id="{{ $post->id }}" data-action="DELETE">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0">
                            </path>
                        </svg>
                        <span>Eliminar</span>
                    </button>
                </div>
                @php
                    $date = strtotime($post->publication_date);
                @endphp
                <div class="flex justify-between items-center">
                    <p class="text-gray-500 text-right text-xs font-bold pl-2 pb-2">Autor: <span
                            class="text-gray-700">{{ $post->user->name }} {{ $post->user->last_name }}</span></p>
                    <p class="text-gray-500 text-right text-xs font-bold pr-2 pb-2">{{ date('d-m-Y', $date) }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
@endsection
<script src="{{ asset('js/dashboard/postUI.js') }}" type="module"></script>
