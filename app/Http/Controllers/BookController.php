<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Gender;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class BookController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['book'=>Book::all()]);   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        if(!JWTAuth::user()->hasPermission('addBooks')){
            return response()->json(['message'=>'you are not allowed to do this operation']); 
        }

        $book = Book::create($request->only([
            'title',
            'author',
            'collection',
            'isbn',
            'publication_date',
            'page_count',
            'location',
            'status_id',
            'content',
        ]));
        $genders = $request->input('genders');
        foreach ($genders as $gender) {
            $book->genders()->attach($gender);
        }
        if($request->input('new_genders')){
            $new_genders = $request->input('new_genders');
            foreach ($new_genders as $new_gender) {
                $gender = Gender::create([
                    'name' => $new_gender
                ]);

                $book->genders()->attach($gender);
            }
        }

        return response()->json([
            'message' => 'Book added successfully',
            'book' => $book->genders
            // 'request' => $request->input('genders')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        if (!Book::find($id)) {
            return response()->json([
                'error' => 'Book not found.'
            ], 404);
        }

        return response()->json(Book::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBookRequest $request, int $id)
    {
        if(!JWTAuth::user()->hasPermission('updateBooks')){
            return response()->json(['message'=>'you are not allowed to do this operation']); 
        }

        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'error' => 'Book not found.'
            ], 404);
        }

        $book->update($request->only([
            'title',
            'author',
            'collection',
            'isbn',
            'publication_date',
            'page_count',
            'location',
            'status_id',
            'content',
        ]));

        $book->genders()->detach();

        $genders = $request->input('genders');
        foreach ($genders as $gender) {
            $book->genders()->attach($gender);
        }
        if($request->input('new_genders')){
            $new_genders = $request->input('new_genders');
            foreach ($new_genders as $new_gender) {
                $gender = Gender::create([
                    'name' => $new_gender
                ]);

                $book->genders()->attach($gender);
            }
        }

        return response()->json([
            'message' => 'Book updated successfully',
            'book' => $book
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if(!JWTAuth::user()->hasPermission('deleteBooks')){
            return response()->json(['message'=>'you are not allowed to do this operation']); 
        }

        $book = Book::find($id);
        
        if (!$book) {
            return response()->json([
                'error' => 'Book not found.'
            ], 404);
        }
    
        $book->delete();
    
        return response()->json([
            'message' => 'Book deleted successfully.'
        ], 200);
    }
}
