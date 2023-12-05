@extends('auth.layouts')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($datas as $gallery)
                            <div class="col-sm-2">
                                <div>
                                    <a class="example-image-link" href="{{asset('storage/posts_image/'.$gallery->picture )}}" data-lightbox="roadtrip" data-title="{{$gallery->description}}">
                                        <img class="example-image img-fluid mb-2" src="{{asset('storage/posts_image/'.$gallery->picture )}}" alt="image-1" />
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <form action="{{ route('apiCreateGallery') }}" >
        <button type="submit" class="btn btn-warning mb-2 ">Tambah</button>
        </form>
            </div>
        </div>
    </div>
</div>

@endsection