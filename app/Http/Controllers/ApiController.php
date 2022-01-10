<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Todo;
use Symfony\Component\Console\Input\Input;

class ApiController extends Controller
{
    public function createTodo(Request $request){
        $array = ['error'=>''];

        $rules= [
            'title'=>'required|min:3'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $array['error'] = $validator->messages();
            return $array;
        }

        $title = $request->Input('title');

        $todo = new Todo();
        $todo->title = $title;
        $todo->save();

        return $array;
    }

    public function getAllTodos(){
        $array = ['error'=>''];

        $todos = Todo::simplePaginate(10);

        $array['list'] = $todos->items();
        $array['current_page'] = $todos->currentPage();

        return $array;
    }

    public function getTodo($id){
        $array = ['error'=>''];

        $todo = Todo::find($id);

        if($todo){
            $array['todo'] = $todo;
        } else {
            $array['error'] = 'Tarefa '.$id.' nao encontrada!';
        }
        

        return $array;
    }

    public function updateTodo($id, Request $request){
        $array = ['error'=>''];

        $rules= [
            'title'=>'min:3',
            'done'=> 'boolean'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $array['error'] = $validator->messages();
            return $array;
        }

        $title = $request->Input('title');
        $done = $request->Input('done');


        $todo = Todo::find($id);
        if($todo){

            if($title){
                $todo->title = $title;
            }
            if($done!== NULL){
                $todo->done = $done;
            }
            
            $todo->save();

        } else {
            $array['error'] = 'Tarefa '.$id.' nao encontrada!';
        }

        return $array;
    }

    public function deleteTodo($id){
        $array = ['error'=>''];

        $todo = Todo::find($id);
        $todo->delete();

        return $array;
    }
}