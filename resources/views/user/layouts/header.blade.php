<header class="header header-trans custom">
    <nav class="navbar navbar-expand-lg header-nav no-border" style="background: rgb(43, 108, 203) !important;">
        <div class="navbar-header">
            <a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
            </a>
            <a href="{{route('user.home')}}" class="navbar-brand logo">
                <img src="/images/logo2.jpg" class="img-fluid" alt="Logo">
            </a>
        </div>
        <div class="main-menu-wrapper">
            <div class="menu-header">
                <a href="{{route('user.home')}}" class="menu-logo">
                    <img src="/images/logo2.jpg" class="img-fluid" alt="Logo">
                </a>
                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                    <i class="fas fa-times"></i>
                </a>
            </div>

            <ul class="main-nav white-font">
                @foreach($list_ctdt as $ctdt)
                    <li class="has-submenu">
                        <a href=""> {{$ctdt->ten}} <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            @foreach($data['ds_mon_hoc'] as $mon)
                                @php
                                    $string = $mon->ctdt_id;
                                    $array = stringToArray($string);
                                    if(in_array($ctdt->id, $array))
                                    {
                                        echo ('<li><a href="'.route('user.taiLieuTheoMon').'?monHocId='.$mon->id.'">'.$mon->ten_mon.'</a></li>');
                                    }
                                @endphp
                            @endforeach
                        </ul>
                    </li>
                @endforeach
                @if (Auth::guest())
                    <li class="login-link">
                        <a href="{{route('login')}}">Đăng nhập</a>
                    </li>
                @else

                    @if(Auth::user()->role==1)
                    @else
                    <li class="nav-item">
                        <a href="{{route('user.yeuCau')}}">Phản hồi</a>
                    </li>
                    @endif

                    @if(Auth::user()->role==1)
                        <li class="login-link">
                            <a href="{{route('admin.home')}}">Quản lý</a>
                        </li>
                    @else
                        <li class="login-link">
                            <a href="{{route('user.thayDoiMatKhau')}}">Đổi Mk</a>
                        </li>

                    @endif

                    <li class="login-link">
                        <a
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                            href="{{route('login')}}">Đăng Xuất
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <ul class="nav header-navbar-rht right-menu">
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link header-login white-bg"--}}
{{--                       onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();"--}}
{{--                       href="{{route('login')}}"><i--}}
{{--                            class="fas fa-user-circle me-2"></i>Đăng xuất</a>--}}
{{--                </li>--}}
            @if (Auth::guest())
                <li class="nav-item">
                    <a class="nav-link header-login white-bg" href="{{route('login')}}"><i
                            class="fas fa-user-circle me-2"></i>Đăng nhập</a>
                </li>
            @else
{{--                @if(Auth::user()->role==1)--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link header-login white-bg" href="{{route('admin.home')}}"> Quản lý</a>--}}
{{--                    </li>--}}
{{--                @else--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link header-login white-bg" href="{{route('user.thayDoiMatKhau')}}">Đổi Mk</a>--}}
{{--                    </li>--}}
{{--                @endif--}}
                <li class="nav-item dropdown" style="height: 50px">
                    <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar avatar-sm border border-2 border-white rounded-circle">
                            <img src="/assets/img/avatar.png" alt="User Image" class="avatar-img rounded-circle">
                        </div>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                        @if(Auth::user()->role==1)
                            <a class="dropdown-item" href="{{route('admin.home')}}">
                                 <span class="me-2">
                                    <i class="fas fa-user-edit"></i>
                                </span>
                                Quản lý
                            </a>
                        @else
                            <a class="dropdown-item" href="{{route('user.thayDoiMatKhau')}}">
                                <span class="me-2">
                                    <i class="fas fa-redo"></i>
                                </span>
                                Đổi mật khẩu
                            </a>
                        @endif
                            <a class="dropdown-item"
                               onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                               href="{{route('login')}}"><span class="me-2">
                                    <i class="fas fa-arrow-right"></i>
                                </span>Đăng xuất</a>
                    </div>
                </li>
            @endif
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>
</header>
@php
    function stringToArray($string, $delimiter = ',')
    {
        return explode($delimiter, $string);
    }
@endphp
