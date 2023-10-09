<?php

namespace App\Http\Controllers;

use App\Models\Bking;
use App\Models\Client;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;

class BkingController extends Controller
{
    
    public function index()
    {
        $bkings = Bking::select('clients.id','clients.name as client','courses.id','courses.name as course');
        
        return Inertia::render('Bkings/Index',['bkings'=> $bkings]);
    }

   
    public function create()
    {
       
    }

   
    public function store(Request $request)
    {
       $request->validate([
        'course_id' => 'required|numeric',
        'client_id' => 'required|numeric'
       ]);
       $bking = new Bking($request->input());
       $bking->save();
       return redirect('bkings');
    }

   
    public function show(Bking $bking)
    {
       
    }

    
    public function edit(Bking $bking)
    {
      
    }

   
    public function update(Request $request, Bking $bking)
    {
        $request->validate([
            'course_id' => 'required|numeric',
            'client_id' => 'required|numeric'
           ]);
           $bking->update($request->all());
        return redirect('bking');
    }

   
    public function destroy(Bking $bking)
    {
        $bking->delete();
        return redirect('bking');
    }
}
