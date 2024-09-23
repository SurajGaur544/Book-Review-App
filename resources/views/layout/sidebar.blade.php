<div class="card border-0 shadow-lg">
    <div class="card-header  text-white" style="background-color: #1e90ff;">
        Welcome, {{ Auth::user()->name }}                        
    </div>
    <div class="card-body">
        <div class="text-center mb-3">
            <img src="{{ asset('storage/'.Auth::user()->image) }}" class="img-fluid rounded-circle"  alt="{{ Auth::user()->name }}">                            
        </div>
        <div class="h5 text-center">
            <strong>{{ Auth::user()->name }}</strong>
            <p class="h6 mt-2 text-muted">5 Reviews</p>
        </div>
    </div>
</div>
<div class="card border-0 shadow-lg mt-3">
    <div class="card-header  text-white" style="background-color: #1e90ff;">
        Navigation
    </div>
    <div class="card-body sidebar">
        <ul class="nav flex-column">
            @if(Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('books.index') }}">Books</a>                               
                </li>
                <li class="nav-item">
                    <a href="{{ route('account.reviews.list') }}">Reviews</a>                               
                </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('account.profile') }}">Profile</a>                               
            </li>
            <li class="nav-item">
                <a href="{{ route('account.myReviews.myReview') }}">My Reviews</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('account.reviews.changePassPage') }}">Change Password</a>
            </li> 
            <li class="nav-item">
                <a href="{{ route('account.logout') }}">Logout</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('account.about') }}">More...</a>
            </li>                           
        </ul>
    </div>
</div> 