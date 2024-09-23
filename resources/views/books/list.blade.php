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
                    <div class="card-header  text-white  bold " style="background-color: #1e90ff;">
                        Books
                    </div>
                    <div class="card-body pb-0">      
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a> 
                            
                            <form action="" method="get">
                                
                                <div class="d-flex">
                                    <input type="text" class="form-control" value="{{ Request::get('keyword') }}" name="keyword" placeholder="Keyword" />
                                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                                    <a href="{{ route('books.index') }}" class="btn btn-secondary ms-2">clear</a>
                                </div>
                            </form>
                           
                        </div>      
                                   
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                                <tbody>
                                    @if($books->isNotEmpty())
                                       @foreach($books as $book)
                                            <tr>
                                                <td>{{ $book->title }}</td>
                                                <td>{{ $book->author }}</td>
                                               
                                               
                                               
                                                <td>
                                                    @if($book->status == 1)
                                                        <span class="text-success">Active</span>
                                                    @else
                                                        <span class="text-danger">Block</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-success btn-sm"><i class="fa-regular fa-star"></i></a>
                                                    <a href="{{ route('books.edit',$book->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="{{ route('books.destroy',$book->id) }}"  class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">Books not found</td>
                                        </tr>
                                    @endif
                                    
                                </tbody>
                            </thead>
                        </table>   
                        @if($books->isNotEmpty())
                            {{ $books->links() }}
                        @endif
                    </div>
                    
                </div>
                               
            </div>
        </div>       
    </div>
@endsection

@section('script')
<script>
    function deleteBook(id){

    }
</script>
@endsection