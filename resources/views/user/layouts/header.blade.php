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
                <img src="/images/logo.png" class="img-fluid" alt="Logo">
            </a>
        </div>
        <div class="main-menu-wrapper">
            <div class="menu-header">
                <a href="{{route('user.home')}}" class="menu-logo">
                    <img src="/images/logo.png" class="img-fluid" alt="Logo">
                </a>
                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                    <i class="fas fa-times"></i>
                </a>
            </div>

            @php
            $leftPart = [];
            $mobilePart = $list_ctdt;
            if (count($list_ctdt) > 7){
            $leftPart = $list_ctdt->slice(6);
            $list_ctdt = $list_ctdt->slice(0, 6);
            }
            @endphp
            <ul class="main-nav white-font position-relative d-none d-lg-flex">
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

                @if(Auth::user() != null && Auth::user()->role==0)
                <li class="nav-item">
                    <a href="{{route('user.yeuCau')}}">Phản hồi</a>
                </li>
                @endif

                @if(count($leftPart) > 0)
                <li class="watch-more">
                    <a href=""><i class="fas fa-bars" style="font-size: 18px"></i></a>
                    <div class="my-dropdown position-absolute bg-white flex-wrap p-4" style="border-radius: 8px; gap: 16px; top: 100%; left: 0; right: 0">
                        @foreach($leftPart as $ctdt)
                        <div class="px-2 position-relative my-hover-button">
                            <a href=""> {{$ctdt->ten}} <i class="fas fa-chevron-down"></i></a>
                            <ul class="position-absolute my-sub-menu">
                                @foreach($data['ds_mon_hoc'] as $mon)
                                @php
                                $string = $mon->ctdt_id;
                                $array = stringToArray($string);
                                if(in_array($ctdt->id, $array))
                                {
                                echo ('<li class="py-2 px-4 border-bottom"><a href="'.route('user.taiLieuTheoMon').'?monHocId='.$mon->id.'">'.$mon->ten_mon.'</a></li>');
                                }
                                @endphp
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </li>
                @endif

            </ul>


            <!-- Mobile nav view  -->
            <ul class="main-nav white-font position-relative d-flex d-lg-none">
                @foreach($mobilePart as $ctdt)
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
                    <a href="{{route('user.thayDoiMatKhau')}}">Đổi mật khẩu</a>
                </li>

                @endif

                <li class="login-link">
                    <a onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" href="{{route('login')}}">Đăng Xuất
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <ul class="nav header-navbar-rht right-menu d-flex align-items-center">
            {{-- <li class="nav-item">--}}
            {{-- <a class="nav-link header-login white-bg"--}}
            {{-- onclick="event.preventDefault();--}}
            {{-- document.getElementById('logout-form').submit();"--}}
            {{-- href="{{route('login')}}"><i--}} {{--                            class="fas fa-user-circle me-2"></i>Đăng xuất</a>--}} {{--                </li>--}} @if (Auth::guest()) <li class="nav-item">
                <a class="nav-link header-login white-bg" href="{{route('login')}}"><i class="fas fa-user-circle me-2"></i>Đăng nhập</a>
                </li>
                @else
                {{-- @if(Auth::user()->role==1)--}}
                {{-- <li class="nav-item">--}}
                {{-- <a class="nav-link header-login white-bg" href="{{route('admin.home')}}"> Quản lý</a>--}}
                {{-- </li>--}}
                {{-- @else--}}
                {{-- <li class="nav-item">--}}
                {{-- <a class="nav-link header-login white-bg" href="{{route('user.thayDoiMatKhau')}}">Đổi Mk</a>--}}
                {{-- </li>--}}
                {{-- @endif--}}
                @if(Auth::user() != null && Auth::user()->role == 1)
                <li class="nav-item">
                    <a style="cursor: pointer" href="{{route('admin.yeuCau')}}">
                        <i class="feather-bell" style="font-size: 20px; color: white" data-bs-toggle="tooltip" data-bs-placement="bottom" title=""></i>
                    </a>
                </li>
                @endif

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
                        <a class="dropdown-item" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();" href="{{route('login')}}"><span class="me-2">
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