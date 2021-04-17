<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        try {
            $subject = $request->query('subject', null);
            $query = Post::query();
            if ($subject) {
                $query->where('subject', $subject);
            }
            $posts = $query->paginate(2);
            $posts->appends([
                'subject' => $subject
            ]);
            return BlogResource::collection($posts);
        } catch (\Exception $e) {
            $data = [
                'title' => 'Error',
                'message' => 'Listing post gagal, coba beberapa saat lagi'
            ];
            return response()->json($data, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->validate([
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            Post::create([
                'subject' => $input['subject'],
                'body' => $input['body']
            ]);
            DB::commit();
            $data = [
                'title' => 'Success',
                'message' => 'Simpan post berhasil'
            ];
            return response()->json($data, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            $data = [
                'title' => 'Error',
                'message' => 'Simpan post gagal, coba beberapa saat lagi'
            ];
            return response()->json($data, 500);
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $post = Post::find($id);
            if ($post) {
                $post->delete();
            }
            $data = [
                'title' => 'Success',
                'message' => 'Post berhasil dihapus'
            ];
            return response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $data = [
                'title' => 'Error',
                'message' => 'Delete post gagal, coba beberapa saat lagi'
            ];
            return response()->json($data, 500);
        }
    }
}
