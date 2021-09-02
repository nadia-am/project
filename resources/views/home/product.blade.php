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
                    var button = document.getElementById("closeComment");
                    button.click();
                    console.log(response)
                }
            })

        });

        $('#sendCommentModal').on('shown.bs.modal', function ($event) {
            var button = $event.relatedTarget
            var parent_id = button.data('id');
            var modal = $(this);
            modal.find('input[name="parent_id"]').val(parent_id);
        });
    </script>

@endsection

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card text-center">
                    <div class="card-header">
                        {{ $product->title }}
                    </div>
                    <div class="card-body">

                        <p class="card-text">
                            {{ $product->description }}
                        </p>
                        <h5 class="card-title">
                            قیمت
                            {{ $product->price }}
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
                    <form action="" id="sendCommentForm">
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
                                    <input type="hidden" name="parent_id" value="0" >
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">پیام دیدگاه:</label>
                                        <textarea name="comment" class="form-control" id="comment"> {{ old('comment') }} </textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
{{--                                    <button type="submit" class="btn btn-primary" data-dismiss="modal">ارسال </button>--}}
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
                @foreach( $product->comments()->where('parent_id',0)->get()  as $comment)
                    <div class="col-md-8 mt-2">
                        <div class="card ">
                            <div class="card-header">
                                {{ $comment->user->name }}
                                -
                                <span class="text-muted"> دو دقیقه قبل</span>
                                <button type="button" class="btn btn-primary btn-sm" style="float: left"  data-toggle="modal" data-target="#sendCommentModal" data-id = "{{ $comment->id }}">
                                    پاسخ به نظر
                                </button>
                            </div>
                            <div class="card-body">
                                {{ $comment->comment }}
                                @if($comment->childeren)
                                    @foreach($comment->childeren as $child)
                                        <div class="card my-3">
                                        <div class="card-header">
                                            {{ $child->user->name }}
                                            -
                                            <span class="text-muted"> دو دقیقه قبل</span>
{{--                                            <button type="button" class="btn btn-primary btn-sm" style="float: left"  data-toggle="modal" data-target="#sendCommentModal" data-id = "{{ $child->id }}">--}}
{{--                                                پاسخ به نظر--}}
{{--                                            </button>--}}
                                        </div>
                                        <div class="card-body">
                                            {{ $child->comment }}
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

@endsection
