<ul class="list-group mt-1">
    @foreach($categories as $category)
        <li class="list-group-item">
            <div class="d-flex">
                <span> {{ $category->name }} </span>
                <div class="action mr-2 d-flex"  >
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post"  class="d-flex">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-sm btn-danger">حذف</button>
                    </form>
                    <a href="{{ route('admin.categories.edit' , $category->id) }}" class="badge badge-info mr-2 text-center">ویرایش</a>
                </div>
            </div>
            @if( $category->childeren->count() )
                @include('layouts.category-group', ['categories' => $category->childeren])
            @endif
        </li>
    @endforeach
</ul>
