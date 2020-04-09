<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Auth;

class TodoController extends Controller
{
    private $todo;

    public function __construct(Todo $instanceClass)
    {   
        $this->todo = $instanceClass;
        // dd($this->middleware('auth'));
        $this->middleware('auth');
        // dd($this->todo, 1, 'todo', ['hoge' => 'HOGE'], 'true', false);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('layouts.app');
        $todos = $this->todo->getByUserId(Auth::id()); 
        $users = \Auth::user();
        // dd($this->todo->all());
        // dd(compact('todos'), $todos);
        // ['todos' => $todos];
        return view('todo.index', compact('todos','users'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $input['user_id'] = Auth::id(); 
        // INSERT INTO todos (title) VALUSE ($title);
        $this->todo->fill($input)->save();
        // return redirect()->to('todo');
        return redirect()->route('todo.index');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = $this->todo->find($id);
        // dd($this->todo->all());
        
        return view('todo.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //fillableを設定するとfillでプロパティを更新できる
    public function update(Request $request, $id)
    {
        $input = $request->all();
        // dd($input);
        //UPDATE todos set title = "" where id = id;
        // dd($this->todo->find($id)->fill($input)->save());
        $this->todo->find($id)->fill($input)->save();
        // return redirect()->to('todo');
        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //DELETE from todos where id = $id;
        $this->todo->find($id)->delete();
        // return redirect()->to('todo');
        return redirect()->route('todo.index');
    }
}
