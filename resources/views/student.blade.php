@extends('layouts.app')

@section('content')

                  
             
<div class="container table-responsive py-5"> 
<div class="text-right">
    <a href="{{url('/')}}/create-student" class="btn btn-primary">add Student</a>
</div>
<br>
<table class="table table-bordered table-hover">
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    @if (Session::has('messages'))
        <div class="alert alert-danger">{{ Session::get('messages') }}</div>
    @endif 
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
      <th scope="col">University Name</th>
      <th scope="col">Created At</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  @if(count($students) > 0)
      
    @foreach($students as $value)
      <tr>
        <td>{{$value->id}}</td>
        <td>{{$value->firstname}}</td>
        <td>{{$value->lastname}}</td>
        <td>{{$value->email}}</td>
        <td>{{$value->phone}}</td>
        <td>
          <?php 
            echo $universities = DB::table('universities')->where('id',$value->university_id)->first()->name; 
          ?>
        </td>
         <td>{{$value->created_at}}</td>
         <td><a href="{{url('/')}}/edit/{{$value->id}}" class="btn btn-primary">update</a>
         <a href="{{url('/')}}/delete-student/{{$value->id}}" class="btn btn-danger">Delete</a>
         </td>
        
      </tr>
      @endforeach

      
    @endif
    
  </tbody>
  
</table>
{{ $students->links()}}
</div>





@endsection
