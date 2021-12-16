@extends('layouts.app')

@section('content')

                  
             
<div class="container table-responsive py-5"> 
<div class="text-right">
    <a href="{{url('/')}}/create" class="btn btn-primary">add university</a>
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
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Logo</th>
      <th scope="col">Website</th>
      <th scope="col">Created At</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  @if(count($universities) > 0)
      
        @foreach($universities as $value)
      <tr>
        <td>{{$value->id}}</td>
        <td>{{$value->name}}</td>
        <td>{{$value->email}}</td>
        <td>
          @if($value->logo != '')
            <img src="{{ asset('storage/logo/' . $value->logo) }}" style="width:50px" />
          @else
            {{$value->logo}}
          @endif    
        </td>
        <td>{{$value->website}}</td>
         <td>{{$value->created_at}}</td>
         <td><a href="{{url('/')}}/update/{{$value->id}}" class="btn btn-primary">update</a>
         <a href="{{url('/')}}/delete-uni/{{$value->id}}" class="btn btn-danger">Delete</a>
         </td>
        
      </tr>
      @endforeach
    @endif
    
  </tbody>
</table>
{{ $universities->links()}}
</div>





@endsection
