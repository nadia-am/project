@foreach( $comments  as $comment)
    <div class="{{ $attr }} mt-2">
        <div class="card ">
            <div class="card-header d-flex justify-content-between">
                <div class="commenter d-flex">
                    <span> {{ $comment->user->name }}</span>
                    &nbsp; - &nbsp;
                    <span class="text-muted">
                        {{ jdate($comment->created_at)->ago() }}
                    </span>
                </div>

                <button type="button" class="btn btn-primary btn-sm" style="float: left"  data-toggle="modal" data-target="#sendCommentModal" data-id = "{{ $comment->id }}">
                    پاسخ به نظر
                </button>
            </div>
            <div class="card-body">
                {{ $comment->comment }}
                @if($comment->childeren)
                    @include('layouts.comments',['comments' => $comment->childeren()->where('approved',1)->get() , 'attr'=>'col-md-12' ])
                @endif
            </div>

        </div>
    </div>
@endforeach
