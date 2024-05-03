@extends("user.layouts.app")
@section("title")
    <title>{{$post->ten_tai_lieu}}</title>
@endsection
@section("content")
    <div class="content" style="padding-top: 120px">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="blog-view">
                        <div class="blog blog-single-post">
                            @if(substr($post->link_file, -4) === ".pdf"||substr($post->link_file, -4) === ".doc"||substr($post->link_file, -4) === ".docx")
                            @else
                                <div class="blog-image">
                                    <a href="">
                                        <img alt="" style="width: 200px;height: 300px;border-radius: 5px"
                                             src="{{$post->hinh_anh?$post->hinh_anh:'assets/img/blog/blog-01.jpg'}}"
                                             class="img-fluid"></a>
                                </div>
                            @endif
                            <h3 class="blog-title">{{$post->ten_tai_lieu}}</h3>
                            <div class="blog-info">
                                @if(substr($post->link_file, -4) === ".pdf"||substr($post->link_file, -4) === ".doc"||substr($post->link_file, -4) === ".docx")
                                    @if(substr($post->link_file, -4) === ".pdf")
                                        <iframe style="width: 100%; height: 70vh; min-height: 300px;"
                                                src="{{$post->link_file}}"></iframe>
                                    @else
                                        <iframe style="width: 100%; height: 70vh; min-height: 300px;"
                                                src="{{'https://view.officeapps.live.com/op/view.aspx?src='.$post->link_file}}}"></iframe>
                                    @endif
                                @else
{{--                                    <div class="blog-image">--}}
{{--                                        <a href="">--}}
{{--                                            <img alt="" style="width: 200px;height: 300px;border-radius: 5px"--}}
{{--                                                 src="{{$post->hinh_anh?$post->hinh_anh:'assets/img/blog/blog-01.jpg'}}"--}}
{{--                                                 class="img-fluid"></a>--}}
{{--                                    </div>--}}
                                @endif
                            </div>
                            @if(substr($post->link_file, -4) === ".pdf"||substr($post->link_file, -4) === ".doc"||substr($post->link_file, -4) === ".docx")
                            @else
                                <div class="blog-info clearfix">
                                    @if($post->trang_thai==1)
                                        <a href="{{$post->link_file}}" target="_blank"
                                           class="btn btn-outline-success book-btn">Xem
                                            ngay/Tải
                                            xuống</a>
                                    @else
                                        <a disabled="disabled" style="cursor: not-allowed" class="btn btn-warning">Tài
                                            liệu
                                            ngừng hoạt động</a>
                                    @endif
                                </div>
                            @endif
                            @if(!Auth::guest())
                                <form action="{{ url('/dat-truoc-sach') }}" method="POST" class="blog-info w-100">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $post->id }}"></input>
                                    <button class="btn btn-outline-success book-btn w-100">Đặt trước tài liệu</button>
                                </form>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            @endif
                            <div class="blog-info clearfix">
                                <div class="post-left">
                                    <ul>
                                        <li>
                                            <div class="post-author">
                                                Tác giả: <span>{{$post->tac_gia}}</span>
                                            </div>
                                        </li>
                                        <li>Ngày đăng: {{$post->created_at}}</li>
                                        <li>Lượt xem: {{$post->luot_xem}}</li>
                                        <li>Loại: {{$post->loai==1?'Đọc tại chỗ':'Mang về'}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="blog-content">
                                <p>{!!$post->noi_dung!!}</p>
                            </div>
                        </div>
                        <div class="card blog-share clearfix">
                            <div class="card-header">
                                <h4 class="card-title">Tags</h4>
                            </div>
                            <div class="card-body">
                                <ul class="tags">
                                    @foreach(explode(',', $post->tag) as $tag)
                                        <li><a href="#" class="tag">{{$tag}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog Sidebar -->
                @include('user.layouts.menu-right')
                <!-- /Blog Sidebar -->
            </div>
        </div>
    </div>
    @include('user.layouts.tai-lieu-lien-quan')
@endsection
@section("js_location")
@endsection
