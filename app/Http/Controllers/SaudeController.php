<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Validator;

class SaudeController extends Controller
{

	public function index(){
		$daten = \App\Saude::whereNotNull('id');

		//if(request()->has('title'))
		//	$tasks->where('title','like','%'.request('title').'%');

        //if(request()->has('status'))
        //    $tasks->whereStatus(request('status'));

        $daten->orderBy(request('sortBy'),request('order'));

		return $daten->paginate(request('pageLength'));
	}

    public function store(Request $request){

        $validation = Validator::make($request->all(), [
            //'title' => 'required|unique:tasks',
            //'description' => 'required',
            //'start_date' => 'required|date_format:Y-m-d',
            //'due_date' => 'required|date_format:Y-m-d|after:start_date'
        ]);

        if($validation->fails())
        	return response()->json(['message' => $validation->messages()->first()],422);

        $user = \JWTAuth::parseToken()->authenticate();
        $task = new \App\Saude;
        $task->fill(request()->all());
        $task->uuid = generateUuid();
        $task->user_id = $user->id;
        $task->save();

        // funktioniert!!
        // Log::info('SaudeController->store');

        return response()->json(['message' => 'Daten hinzugefügt!', 'data' => $task]);
    }

     public function destroy(Request $request, $id){
        $task = \App\Saude::find($id);

        if(!$task)
            return response()->json(['message' => 'Couldnot find Data!'],422);

        $task->delete();

        return response()->json(['message' => 'Data deleted!']);
    }

     public function show($id){
        $task = \App\Saude::whereUuid($id)->first();

        if(!$task)
            return response()->json(['message' => 'Couldnot find Data!'],422);

        return $task;
    }

    public function update(Request $request, $id){

        $task = \App\Saude::whereUuid($id)->first();

        if(!$task)
            return response()->json(['message' => 'Couldnot find data!']);

        $validation = Validator::make($request->all(), [
            //'title' => 'required|unique:tasks,title,'.$task->id.',id',
            //'description' => 'required',
            //'start_date' => 'required|date_format:Y-m-d',
            //'due_date' => 'required|date_format:Y-m-d|after:start_date'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first()],422);

        Log::debug('SaudeController->update:Gewicht='.request('gewicht'));
        Log::debug('SaudeController->update:Uhrzeit='.request('uhrzeit'));
        $task->datum    = request('datum');
        $task->uhrzeit  = request('uhrzeit');
        $task->gewicht  = request('gewicht');
        $task->diastole = request('diastole');
        $task->systole  = request('systole');
		$task->puls     = request('puls');
		$task->description     = request('description');
        $task->save();

        return response()->json(['message' => 'Daten geändert!', 'data' => $task]);
    }


}
