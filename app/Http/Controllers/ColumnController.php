<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get cards
        $columns = Column::with(['cards'])->get();

        // return a json response to api
        return response()->json([
            'columns' => $columns
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function() use($request) {
            Column::create([
                'title' => $request->title
            ]);
        });

        return response()->json([
            'message' => "Column Created Successfully"
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function show(Column $column)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function edit(Column $column)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Column $column)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $column = Column::where('id', $id)->first();

        DB::transaction(function() use($column) {
            //  Delete the column cards
            $column->cards()->delete();
    
            // Delete the main columns
            $column->delete();
        });

        // Return response message
        return response()->json([
            'message' => 'Card deleted successfully!'
        ], Response::HTTP_OK);
    }
}
