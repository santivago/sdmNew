<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use DB;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
  
    public function index()
    {
         $users = User::all();
         $roles = Role::all();
         return Inertia::render('Users/Index', ['users'=> $users, 'roles'=> $roles]);
          
}


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        User::create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => bcrypt($request->get('password'))
        ]);

        return redirect('users');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {   
        
    echo "<script>console.log('Console: " . $user . "' );</script>";
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        
        ]);
        //var_dump( $roles );
       
        //s$user->roles()->sync($roles);
           
        // Actualizar los datos del usuario
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

     
        
    
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('users');
    }
}
