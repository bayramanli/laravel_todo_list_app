<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $id = Auth::id();
        $todos = DB::table('todos')->where("users_id", $id)->get();
        return view('home', ['todos' => $todos]);
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
        // validate the form
        $request->validate(['task' =>'required|max:200']);

        $id = Auth::id();
        //store the data
        DB::table('todos')->insert([
            'task' => $request->task,
            'users_id' => $id
        ]);

        return redirect('/')->with('status', 'Task added!!!');
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
        // validate the form
        $request->validate([
            'task' => 'required|max:200'
        ]);

        // update the data
        $message = "";
        if($request->status == 0) {
            DB::table('todos')->where('id', $id)->update([
                'task' => $request->task,
                'status' => $request->status
            ]);
            $message = "Task Updated!";
        } else {
            DB::table('todos')->where('id', $id)->update([
                'status' => $request->status
            ]);
            $message = "Task Completed!";
        }

        // redirect
        return redirect('/')->with('status', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete the todo
        DB::table('todos')->where('id', $id)->delete();

        // redirect
        return redirect('/')->with('status', 'Task removed!');
    }
}
