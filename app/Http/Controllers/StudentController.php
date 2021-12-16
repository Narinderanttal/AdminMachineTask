<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\University;
use DB;
use Validator;
use Session;
use Redirect;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::paginate(5);
        return view('/student',['students'=>$students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id=0;
        $universities = University::all();
        return view('/updateStudent',['id'=>$id, 'universities'=>$universities]);
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
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255','unique:students'],
            'phone' => ['required'],
            'university_id' => ['required'],
        ]);	
        if($validator->fails())
        {
                // $errormessage = $validator->errors();
            return redirect('create-student')
            ->withErrors($validator)
            ->withInput();
        }
        else
        {
            $firstname = $request->input('firstname');
            $lastname = $request->input('lastname');
            $email =$request->input('email');
            $phone =$request->input('phone');
            $university_id =$request->input('university_id');
           
            $students = new Student;               
            $students->firstname = $firstname;
            $students->lastname = $lastname;
            $students->email = $email;
            $students->phone = $phone;
            $students->university_id = $university_id;
            $students->save();   
            if($students)
            {
                Session::flash('message', "Added Successfully");
                return redirect('student');
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
        $students = Student::where('id',$id)->first();
        $universities = University::all();
        return view('/updateStudent',['id'=>$id, 'students'=>$students, 'universities'=>$universities]);
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
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required'],
            'university_id' => ['required'],
        ]);	
        if($validator->fails())
        {
                // $errormessage = $validator->errors();
            return redirect('edit/'.$id)
            ->withErrors($validator)
            ->withInput();
        }
        else
        {
            $firstname = $request->input('firstname');
            $lastname = $request->input('lastname');
            $email =$request->input('email');
            $phone =$request->input('phone');
            $university_id =$request->input('university_id');
          
            $students = Student::find($id);               
            $students->firstname = $firstname;
            $students->lastname = $lastname;
            $students->email = $email;
            $students->phone = $phone;
            $students->university_id = $university_id;
            $students->save();   
            if($students)
            {
                Session::flash('message', "Updated Successfully");
                return redirect('student');
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
        $deletestudent= Student::find($id);
        $deletestudent->delete();

        Session::flash('messages', "Deleted Successfully");
        return Redirect('/student');
    }
}
