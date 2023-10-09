<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use DB;

class ClientController extends Controller
{

    public function index()
    {
        $users = User::all();
        return Inertia::render('Clients/Index',['users'=> $users]);
    }


    public function create()
    {
        return Inertia::render('Client/Create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|email|max:80',
            'phone' => 'required|max:15']);
        $client = new Client($request->input());
        $client->save();
        return redirect('clients');
    }

    
    public function show(Client $client)
    {
        //
    }

   
    public function edit(Client $client)
    {
        return Inertia::render('Client/Edit',['client'=>'$client']);
    }

    
    public function update(Request $request, Client $client)
    {
        $request->validate([
        'name' => 'required|string|min:1|max:100',
        'email' => 'required|email|max:80',
        'phone' => 'required|max:15']);
        $client->update($request->all());
        return redirect('client');
    }

    
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect('client');
    }
}
