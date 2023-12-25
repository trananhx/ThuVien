@extends("admin.layout.app")
@section("title")
    <title>Thăm dò</title>
@endsection
@section("content")
    <div id="app">
        <admin-quan-ly-tham-do/>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/admin-quan-ly-tham-do.js?t='.Carbon\Carbon::now()->timestamp)}}"></script>
@endsection
