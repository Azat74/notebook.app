<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Notebook;
use Illuminate\Support\Facades\Auth;

class NotebooksController extends Controller
{
    public function index(){
        $user = Auth::user();
        $notebooks = $user->notebooks;

        return view('notebooks.index',compact('notebooks'));
    }

    public function create(){
        return view('notebooks.create');
    }

    public function show($id)
    {
        $notebook = Notebook::FindOrFail($id);

        $notes=$notebook->notes;

        return view('notes.index',compact('notes','notebook'));
    }


    public function store(Request $request){

        $dataInput = $request->all();
        $user = Auth::user();
        $user->notebooks()->create($dataInput);
        //Notebook::create($dataInput);

        return redirect('/notebooks');
    }

    public function edit($id){

        $user = Auth::user();
        $notebook = $user->notebooks()->find($id);

        //$notebook = Notebook::where('id', $id)->first();

        return view('notebooks.edit')->with('notebook', $notebook);
    }


    public function update(Request $request, $id)
    {
        //$notebook = Notebook::where('id', $id)->first();
        $user = Auth::user();
        $notebook = $user->notebooks()->find($id);

        $notebook->update($request->all());

        return redirect('/notebooks');
    }

    public function destroy($id){

        $user = Auth::user();
        $notebook = $user->notebooks()->find($id);
        //$notebook = Notebook::where('id', $id)->first();
        $notebook->delete();
        return redirect('/notebooks');

    }
}
