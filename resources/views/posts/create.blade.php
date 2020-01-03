@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/p" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
            <div class="col-8 offset-2">
                <div class="row pb-3">
                   <h2>Add new post</h2> 
                </div>
                <div class="form-group row">
                    <label for="caption" class="col-md-4 col-form-label">Post Caption</label>
        
                        <input id="captiaon" 
                        type="text"
                        class="form-control"
                        name="caption"
                        @error('caption') is-invalid @enderror 
                         value="{{ old('caption') }}" 
                        required autocomplete="caption" autofocus>
        
                        @error('caption')
                                <strong>{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="row">
                            <label for="image" class="col-md-4 col-form-label">Post image</label>
                            @error('image')
                                <strong>{{ $message }}</strong>
                            @enderror
                            <input type="file", class="form-control-file" id="image" name="image">
                    </div>

                    <div class="row pt-4">
                        <button class="btn btn-primary">Add new post</button>
                    </div>

                </div>

            </div>
        </div>

      
    </form>
</div>
@endsection
