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
                        Change Password
                    </div>
                    <div class="card-body">
                        <form action="{{ route('account.reviews.updatepassword') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="oldpass" class="form-label">Old Password</label>
                                <input type="text"  class="form-control @error('old') is-invalid  @enderror" placeholder="Enter old password" name="oldpass" id="oldpass" />
                                @error('oldpass')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="newpass" class="form-label">New Password</label>
                                <input type="text"  class="form-control @error('newpass') is-invalid  @enderror" placeholder="Enter New password"  name="newpass" id="newpass"/>
                                @error('newpass')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="conpass" class="form-label">Conformed Password</label>
                                <input type="text" placeholder="Enter conform password" name="conpass" id="conpass" class="form-control @error('conpass') is-invalid  @enderror">
                                @error('conpass')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <!-- <img style="width:100px" src="{{url('storage/'. Auth::user()->image )}}" class="img-fluid mt-4" alt="{{ Auth::user()->name }}" > -->
                            </div>   
                            <button class="btn btn-primary mt-2">Update</button>    
                        </form>                 
                    </div>
                </div>                
            </div>
        </div>       
    </div>
@endsection