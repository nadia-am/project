@extends('layouts.app')

@section('script')
    <script>
        document.querySelector('#sendCommentForm').addEventListener('submit', function ($event) {
            $event.preventDefault();
            let target = $event.target;
            let data = {
                'commentable_id' : target.querySelector('input[name="commentable_id"]').value,
                'commentable_type' : target.querySelector('input[name="commentable_type"]').value,
                'parent_id' : target.querySelector('input[name="parent_id"]').value,
                'comment' : target.querySelector('textarea[name="comment"]').value,
            }
            let token = document.head.querySelector('meta[name="csrf-token"]').content
            $.ajax({
                url : '/send/comment',
                type : 'post',
                data : JSON.stringify(data),
                headers: {
                    'X-CSRF-TOKEN':token,
                    'Content-Type':'application/json'
                },
                success : function (response) {
                    location.reload()
                }
            })
        });

        $('#sendCommentModal').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            let parent_id = button.data('id');

            console.log(parent_id);
            // $("#parent_id").val(parent_id);
            var modal = $(this);
            modal.find('input[name="parent_id"]').val(parent_id);
        });
    </script>

@endsection

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header d-flex justify-content-between">
                        {{ $product->title }}
                        @php
                        if (\App\Helpers\Cart\Cart::has($product)){
                            $list = \App\Helpers\Cart\Cart::get($product);
                            $quantity = $list['quantity'];
                        }else{
                            $quantity = 0;
                        }
                        @endphp
                        @if($product->inventory > $quantity)
                            <form action="{{ route('cart.add' ,$product->id) }}" method="post" id="add-to-shoppingcart">
                                @csrf
                            </form>
                            <span onclick="document.getElementById('add-to-shoppingcart').submit()" class="btn btn-info">افزودن به سبد خرید</span>
                        @else
                            <span>ناموجود</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ $product->image }}" alt="{{ $product->title }}" width="400" class="img-fluid">
                        </div>
                        <div class="text-center galleries">

                                @foreach($product->galleries as $img)
                                    <span>
                                        <img src="{{ $img->image }}" alt="{{ $img->alt }}" class="img-fluid" width="100">
                                    </span>
                                @endforeach


                        </div>
                        <p class="card-text">
                            {!!  $product->description !!}
                        </p>
                        <h5 class="card-title">
                            <span class="text-danger text-sm">{{ $product->price }}  تومان</span>
                        </h5>
                        <p class="card-text">
                            تعداد موجودی
                            {{ $product->inventory }}
                        </p>
                    </div>
                    <div class="card-footer text-muted">
                        تعداد بازدید
                        {{ $product->viewCount }}
                    </div>
                </div>
            </div>
        </div>

        <div class="comments mt-5" id="sendComment">
            <!-- submit comment modal -->
            @auth()
                <div class="modal-comments my-1">
                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#sendCommentModal" data-id = "0">
                   ارسال نظر
                </button>
                <!-- Modal -->
                <div class="modal fade" id="sendCommentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <form action=" " method="post" id="sendCommentForm">
                        @csrf
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">ارسال نظر</h5>
                                    <p align="left">
                                        <button type="button" id="closeComment" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </p>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="commentable_id" value="{{ $product->id }}">
                                    <input type="hidden" name="commentable_type" value="{{ get_class($product) }}" >
                                    <input type="hidden" name="parent_id" id="parent_id" value="0" >
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">پیام دیدگاه:</label>
                                        <textarea name="comment" class="form-control" id="comment"> {{ old('comment') }} </textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" >ارسال </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endauth

            @guest()
                <div class="alert alert-warning">برای ثبت نظر لطفا وراد سایت شوید</div>
            @endguest
            <!-- end modal -->
            {{--    show comments        --}}
            <div class="row ">
                @include('layouts.comments',['comments' => $product->comments()->where('parent_id',0)->where('approved',1)->get(),'attr'=>'col-md-8' ])

            </div>
        </div>
    </div>

@endsection
