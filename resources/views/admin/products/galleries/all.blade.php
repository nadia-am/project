<x-admin.content >
    <x-slot name="script"></x-slot>
    <x-slot name="title">
        لیست تصاویر
    </x-slot>
    <x-slot name="breadcrums">
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">خانه</a></li>
        <li class="breadcrumb-item "><a href="{{ route('admin.products.index') }}"> لیست محصولات</a></li>
        <li class="breadcrumb-item active"> گالری تصاویر</li>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">گالری تصاویر</h3>

                    <div class="card-tools d-flex">
                        <div class="btn-group-sm mr-2">
                            <a href="{{ route('admin.products.galleries.create' , $product->id) }}" class="btn btn-info">افزودن تصویر جدید</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <div class="row">
                        @foreach($galleries as $gallery )
                            <div class="col-sm-2">
                                <a href="{{ url($gallery->image) }}">
                                    <img src="{{ url($gallery->image) }}" alt="{{ $gallery->alt }}" class="img-fluid mb-2">
                                </a>
                                <form action="{{ route('admin.products.galleries.destroy' , ['product'=>$product->id , 'gallery'=>$gallery->id]) }}" method="post" id="delete-gallery-{{ $gallery->id }}">
                                    @csrf
                                    @method('delete')
                                </form>
                                <a href="{{ route('admin.products.galleries.edit', ['product'=>$product->id , 'gallery'=>$gallery->id]) }}" class="btn btn-info btn-sm">ویرایش</a>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-gallery-{{ $gallery->id }}').submit()" class="btn btn-danger btn-sm">حذف</a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex">
                    {{ $galleries->appends(['search'=>request('search')])->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</x-admin.content>
