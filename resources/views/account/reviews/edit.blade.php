@extends('layout.app')

@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('layout.sidebar')               
            </div>
            <div class="col-md-9">
                
                <div class="card border-0 shadow">
                    <div class="card-header  text-white" style="background-color: #1e90ff;">
                       Edit Review
                    </div>
                    <div class="card-body pb-0">  
                        <form action="{{ route('account.reviews.updateReview',$reviews->id) }}" method="post" >
                            @csrf
                            <div class="mb-3">
                                <label for="review" class="form-label">Review</label>
                                <textarea name="review" class="form-control @error('review') is-invalid  @enderror" placeholder="Plese right your reviews"  value="{{ old('review',$reviews->review) }}" >{{ $reviews->review }}</textarea>
                                @error('review')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid  @enderror">
                                    <option value="1" {{ ($reviews->status == 1) ? 'Selected' : '' }}>Active</option>
                                    <option value="0" {{ ($reviews->status == 0) ? 'Selected' : '' }}>Block</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                               
                            <button class="btn btn-primary mt-2">Update</button>    
                        </form> 
                      
                    </div>
                    
                </div>                
            </div>
        </div>       
    </div>
@endsection