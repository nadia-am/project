@extends('admin.master')

@section('script')
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
        // CKEDITOR.replace( 'description' );
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('button-image').addEventListener('click', (event) => {
                event.preventDefault();

                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });
        });
        // set file link
        function fmSetLink($url) {
            document.getElementById('image_label').value = $url;
        }
    </script>
    {{ $script }}
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        {{ $breadcrums }}

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            {{ $slot }}
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection
