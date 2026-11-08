<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Table;
use App\Models\Section;
use App\Http\Requests\SaveLatoutRequest;


class layoutController extends Controller
{
    public function saveLayout(SaveLatoutRequest $request){
        try{

            $validated=$request->validated();

            $tablesToInsert=[];

            DB::transaction(function () use($validated){
                foreach($validated['sections'] ?? [] as $section){
                    $section=Section::create([
                        'name' => $section['name'],
                        'image' => $section['number']
                    ]);

                    foreach($section['tables'] ?? [] as $table){
                        
                    }
                }

                if(!empty($tablesToInsert)){
                    Table::insert($tablesToInsert);
                }

                return response()->json([
                    'message' => 'layout saved successfully'
                ]);

            });

        }catch(Throwable $e){
            return response()->json([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }

    }
}
