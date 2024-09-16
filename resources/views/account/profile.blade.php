@extends('layout.app')

@section('main')
<div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('layout/sidebar')
            </div>
           
            <div class="col-md-9">
                @include('layout.message')
                <div class="card border-0 shadow">
                    <div class="card-header  text-white" style="background-color: #1e90ff;">
                        Profile
                    </div>
                    <div class="card-body">
                        <form action="{{ route('account.updateprofile') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" value="{{ old('name',$user->name) }}" class="form-control @error('name') is-invalid  @enderror" placeholder="Name" name="name" id="name" />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Email</label>
                                <input type="text" value="{{ old('name',$user->email) }}" class="form-control @error('email') is-invalid  @enderror" placeholder="Email"  name="email" id="email"/>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Image</label>
                                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid  @enderror">
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <img style="width:100px" src="{{url('storage/'. Auth::user()->image )}}" class="img-fluid mt-4" alt="{{ Auth::user()->name }}" >
                            </div>   
                            <button class="btn btn-primary mt-2">Update</button>    
                        </form>                 
                    </div>
                </div>                
            </div>
        </div>       
    </div>
@endsection