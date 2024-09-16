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
                        <div class="mb-3">
                            <label for="review" class="form-label">Book</label>
                            <div>
                                <!-- ->book() -->
                            </div>
                        </div>
                        <form action="{{ route('account.myReviews.updateProcess',$reviews->id) }}" method="post" >
                            @csrf
                            <div class="mb-3">
                                <label for="review" class="form-label">Review</label>
                                <textarea name="review" class="form-control @error('review') is-invalid  @enderror" placeholder="Plese right your reviews"  value="{{ old('review',$reviews->review) }}" >{{ $reviews->review }}</textarea>
                                @error('review')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Rating</label>
                                <select name="rating" id="rating" class="form-control @error('rating') is-invalid  @enderror">
                                    <option value="1" {{ ($reviews->rating == 1) ? 'Selected' : '' }}>1</option>
                                    <option value="2" {{ ($reviews->rating == 2) ? 'Selected' : '' }}>2</option>
                                    <option value="3" {{ ($reviews->rating == 3) ? 'Selected' : '' }}>3</option>
                                    <option value="4" {{ ($reviews->rating == 4) ? 'Selected' : '' }}>4</option>
                                    <option value="5" {{ ($reviews->rating == 5) ? 'Selected' : '' }}>5</option>
                                </select>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                               
                            <button class="btn btn-primary mt-2">Update</button>    
                        </form> 
                      
                    </div>
                    
                </div>                
            </div>
        </div>       
    </div>>
@endsection