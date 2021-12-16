<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\University;
use DB;
use Validator;
use Session;
use Redirect;
use App\Jobs\SendEmail;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $universities = University::paginate(5);
        return view('/home',['universities'=>$universities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id=0;
        return view('/updateUniversity',['id'=>$id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [ 	
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255','unique:universities'],
            'website' => ['required'],
            "logo" => ['required'],
        ]);	
        if($validator->fails())
        {
                // $errormessage = $validator->errors();
            return redirect('create')
            ->withErrors($validator)
            ->withInput();
        }
        else
        {
            $fname = $request->input('name');
            $email =$request->input('email');
            $website =$request->input('website');
           
            if ($request->hasFile('logo')) 
            {
                $logo = $request->file('logo');
                $name = time().'.'.$logo->getClientOriginalExtension();
                $destinationPath = public_path('/storage/logo');
                $logo->move($destinationPath, $name);
            }
            else{
                $name="";
            }
            $university = new University;               
            $university->name = $fname;
            $university->email = $email;
            $university->website = $website;
            $university->logo = $name;
            $university->save();   
            if($university)
            {
                // $emailJob = new SendEmail();
                // dispatch($email);

                Session::flash('message', "Added Successfully");
                return redirect('home');
            }       
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $universities = University::where('id',$id)->first();
        return view('/updateUniversity',['id'=>$id, 'universities'=>$universities]);
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
        $validator = Validator::make($request->all(), [ 	
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'website' => ['required'],
            "logo" => ['required'],
        ]);	
        if($validator->fails())
        {
                // $errormessage = $validator->errors();
            return redirect('update/'.$id)
            ->withErrors($validator)
            ->withInput();
        }
        else
        {
            $fname = $request->input('name');
            $email =$request->input('email');
            $website =$request->input('website');
           
            if ($request->hasFile('logo')) 
            {
                $removeimg = University::where('id',$id)->first();
                if ($removeimg->logo != '') {
                    $image_path = public_path().'/storage/logo/'.$removeimg->logo;
                    unlink($image_path);
                }
                $logo = $request->file('logo');
                $name = time().'.'.$logo->getClientOriginalExtension();
                $destinationPath = public_path('/storage/logo');
                $logo->move($destinationPath, $name);
            }
            else{
                $name="";
            }
            $university = University::find($id);               
            $university->name = $fname;
            $university->email = $email;
            $university->website = $website;
            $university->logo = $name;
            $university->save();   
            if($university)
            {
                Session::flash('message', "Updated Successfully");
                return redirect('home');
            }       
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $removeimg = University::where('id',$id)->first();
        if ($removeimg->logo != '') {
            $image_path = public_path().'/storage/logo/'.$removeimg->logo;
            unlink($image_path);
        }
        $deleteuni= University::find($id);
        $deleteuni->delete();

        Session::flash('messages', "Deleted Successfully");
        return Redirect('/home');
    }
}
