<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        if (!$user) {
            return redirect('login');
        }
        $data['user'] = $user;
        return view('dashboard.index', $data);
    }

    public function posts()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        if (!$user) {
            return redirect('login');
        }

        $posts = Post::whereNull('deleted_at')
            ->where('owner_id', $user->id)
            ->with('user')
            ->orderByDesc('publication_date')
            ->get();

        $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $years = ['2020', '2021', '2022', '2023'];

        $data['posts'] = $posts;
        $data['user'] = $user;
        $data['months'] = $months;
        $data['years'] = $years;
        return view('dashboard.posts.index', $data);
    }

    public function users()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        if (!$user) {
            return redirect('login');
        }
        $data['user'] = $user;
        return view('dashboard.users.index', $data);
    }

    public function createPost($id, Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        if (!$user) {
            return redirect('login');
        }

        $post = Post::whereNull('deleted_at')
            ->where('id', $id)
            ->first();
        if (!$post) {
            return redirect('dashboard.posts');
        }

        $data['user'] = $user;
        $data['post'] = $post;
        $data['type'] = $request->type;
        return view('dashboard.posts.create', $data);
    }

    public function storePost(Request $request)
    {
        $user_id = $request->user_id;
        $title = $request->title;

        $user = User::find($user_id);
        if (!$user) {
            return response()->json([
                'ok' => false,
                'message' => 'El usuario no existe'
            ]);
        }

        $post_already_exist = Post::whereNull('deleted_at')
            ->where('title', $title)
            ->first();
        if ($post_already_exist) {
            return response()->json([
                'ok' => false,
                'message' => 'Este título ya existe'
            ]);
        }
        $post = new Post();
        $post->title = $title;
        $post->state = 'DRAFT';
        $post->owner_id = $user->id;
        $post->is_visible = 'N';
        $post->save();

        return response()->json([
            'ok' => true,
            'message' => 'Creado correctamente',
            'id' => $post->id
        ]);
    }

    public function updatePost(Request $request)
    {
        $title = $request->title;
        $summary = $request->summary;
        $body = $request->body;
        $body_content = $request->body_content;
        $owner_id = $request->owner_id;
        $labels = $request->labels;
        $image = $request->file('image');
        $publication_date = $request->publication_date;
        $type = $request->type;
        $post_id = $request->post_id;
        $visible = $request->visible;

        $user = User::whereNull('deleted_at')
            ->where('id', $owner_id)
            ->first();

        if (!$user) {
            return response()->json([
                'ok' => false,
                'message' => 'El usuario no existe'
            ]);
        }
        $post = Post::where('id', $post_id)
            ->whereNull('deleted_at')
            ->first();
        if (!$post) {
            return response()->json([
                'ok' => false,
                'message' => 'La publicación no existe'
            ]);
        }

        if ($visible) {
            if ($post->state == 'DRAFT') {
                return response()->json([
                    'ok' => false,
                    'message' => 'Publicación guardada como borrador, no puede ser visible'
                ]);
            }
            $post->is_visible = $post->is_visible == 'Y' ? 'N' : 'Y';
            $post->save();
            $msg = $post->is_visible == 'Y' ? 'Publicación visible' : 'Publicación ocultada';
            $data['post'] = $post;
            return response()->json([
                'ok' => true,
                'message' => $msg,
                'html' => View::make('components.icon-visible', $data)->render()
            ]);
        }

        if ($type != 'DRAFT') {
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:posts',
                'summary' => 'required|max:255',
                'publication_date' => 'required',
                'image' => 'image',
                'body' => 'required',
                'labels' => 'required',
                'body_content' => 'required'
            ], [
                'required' => 'Campo requerido',
                'image' => 'El archivo no es una imagen',
                'unique' => 'El título ya existe'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Hay campos sin completar',
                    'validation_errors' => $validator->errors(),
                ]);
            }
        }

        if ($type == 'DRAFT' && ($title == '' || !$title)) {
            return response()->json([
                'ok' => false,
                'message' => 'El título es requerido para guardar el borrador',
            ]);
        }

        if ($image) {
            $mime = $image->getMimeType();
            if ($mime != 'image/png' && $mime != 'image/jpeg') {
                return response()->json([
                    'ok' => false,
                    'message' => 'La imagen debe ser de tipo JPG, JPEG o PNG'
                ]);
            }
        }

        $img_name = !$image ? null : date('YmdHis') . '_' . pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $image->getClientOriginalExtension();


        try {
            $post->title = $title;
            $post->summary = $summary;
            $post->body = strlen($body_content) > 0 ? $body : null;
            $post->image = $img_name;
            $post->state = $type == 'DRAFT' ? 'DRAFT' : 'PUBLISHED';
            $post->owner_id = $owner_id;
            $post->labels = $labels;
            $post->is_visible = $type == 'DRAFT' ? 'N' : 'Y';
            $post->publication_date = Carbon::createFromFormat('d/m/Y', $publication_date);
            $post->save();

            $type != 'DRAFT' ? $image->storeAs('images', $img_name, 'public') : '';

            return response()->json([
                'ok' => true,
                'message' => $type == 'DRAFT' ? 'Guardado cómo borrador' : 'Publicado correctamente',
                'post_id' => $post->id
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'ok' => false,
                'message' => 'Ha ocurrido un error: ' . $th->getMessage(),
            ]);
        }
    }

    public function deletePost(Request $request)
    {
        $user_id = $request->user_id;
        $post_id = $request->post_id;

        $user = User::whereNull('deleted_at')
            ->where('id', $user_id)
            ->first();

        if (!$user) {
            return response()->json([
                'ok' => false,
                'message' => 'El usuario no existe'
            ]);
        }
        $post = Post::where('id', $post_id)
            ->whereNull('deleted_at')
            ->first();
        if (!$post) {
            return response()->json([
                'ok' => false,
                'message' => 'La publicación no existe o fue eliminada'
            ]);
        }
        $post->delete();
        return response()->json([
            'ok' => true,
            'message' => 'La publicación fue eliminada'
        ]);
    }
}
