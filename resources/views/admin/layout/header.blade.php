<div class="header">

    <!-- Logo -->
    <div class="header-left">
        <a href="{{route('user.home')}}" class="logo">
            <img src="https://bmtu.edu.vn/images/logo.png" style="width: 140px" alt="Logo">
        </a>
        <a href="{{route('user.home')}}" class="logo logo-small">
            <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="圖層_1"
                 x="0px" y="0px" width="40px" height="40px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;"
                 xml:space="preserve">
                <style type="text/css">
                    .st0 {
                        fill: #399FD8;
                    }

                    .st1 {
                        fill: #FFA71A;
                    }
                </style>
                <g>
                    <path class="st0"
                          d="M24.2,13.3c-2.4,0-3.8,0.1-4,0.1c-0.7,0-2.2,0-4.2-0.1l-0.9,1.4l-7.1,7l0.5-8.4c-1.9,0-3.1,0.1-3.6,0.1   c-0.7,0-2,0-3.8-0.1v1.4c0,1.2-0.1,3.3-0.2,6.2c-0.2,4.3-0.3,7.6-0.5,10c-0.1,1.4-0.2,3.6-0.4,5.7c2-0.1,3.3-0.1,3.8-0.1l3.6,0.1   l0.2-6.9L24.2,13.3z"/>
                    <path class="st0"
                          d="M16.1,24c0,0,0.5,0.8,1.3,2c4.2,6.8,8.2,10.1,9.8,10.6c-3.6,0-8.6,0.1-10.9-1.4c-2.3-1.5-3.5-4.6-4.7-6.4   L16.1,24z"/>
                    <g>
                        <path class="st1"
                              d="M46.6,13.3c-1,0-2.3,0-4,0c-0.1,0-0.1,0.9-0.2,2.7c-0.1,1.8-0.2,3.9-0.3,6c-0.2,2.6-0.3,4.3-0.4,4.9    c-0.1,0.7-0.2,1.3-0.4,1.8c-0.2,0.5-0.4,0.9-0.6,1.2c-0.2,0.3-0.4,0.5-0.7,0.7c-0.3,0.2-0.6,0.4-1,0.5c-0.5,0.2-1,0.2-1.5,0.2    c-0.6,0-1.2-0.1-1.8-0.3c-0.6-0.2-1-0.5-1.4-0.9c-0.2-0.2-0.3-0.5-0.5-0.9c1.4,6.2,6,7.1,8.9,6.5c0.8-0.2,1.5-0.5,2.3-0.9    c1.1-0.6,1.9-1.2,2.4-1.9s1-1.5,1.2-2.5c0.2-1,0.4-2.6,0.4-4.9c0-0.2,0-0.3,0-0.6L50,13.3H46.6z"/>
                        <path class="st1"
                              d="M33.6,31.7c-0.1-2.3,0-5,0-5c0-0.5,0-1.3,0.1-2.4c0.1-1.2,0.1-2.4,0.2-3.8l0.5-7.1c-1.5,0-2.7,0.1-3.5,0.1    c-0.7,0-1.9,0-3.7-0.1l-0.3,6.6c-0.1,1.4-0.1,2.4-0.2,3.1l-0.2,2.7c-0.1,1-0.1,1.8-0.2,2.3c0,0.5-0.1,1-0.1,1.2    c0,0.8,0.1,1.5,0.3,2.2c0.2,0.6,0.4,1.1,0.7,1.6c0.3,0.5,0.7,0.9,1.3,1.3c0.6,0.5,1.4,0.9,2.2,1.2c0.9,0.3,1.8,0.6,2.9,0.8    c1,0.2,2,0.2,3,0.3C35.3,36.1,33.7,34.1,33.6,31.7z"/>
                    </g>
                </g>
</svg> -->
        </a>
        <a id="toggle_btn">
            <i class="feather-chevrons-left"></i>
        </a>
    </div>
    <!-- /Logo -->


    <!-- Mobile Menu Toggle -->
    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>
    <!-- /Mobile Menu Toggle -->

    <!-- Header Menu -->
    <ul class="nav nav-tabs user-menu">
        <li class="nav-item">
            <a style="cursor: pointer" id="dark-mode-toggle" class="dark-mode-toggle">
                <i class="feather-sun light-mode"></i><i class="feather-moon dark-mode"></i>
            </a>
        </li>
        <li class="nav-item">
            <a style="cursor: pointer" href="{{route('admin.yeuCau')}}">
                <i class="feather-bell" data-bs-toggle="tooltip" data-bs-placement="bottom" title=""></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar avatar-sm border border-2 border-white rounded-circle">
                    <img src="/assets/img/avatar.png" alt="User Image" class="avatar-img rounded-circle">
                </div>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                <div class="dropdown-item">
                    Xin chào, {{ Auth::user()->name }}
                </div>
                <a class="dropdown-item" href="{{route('admin.home')}}">
                                 <span class="me-2">
                                    <i class="fas fa-user-edit"></i>
                                </span>
                    Quản lý
                </a>
                <a class="dropdown-item" href="{{route('user.thayDoiMatKhau')}}">
                                 <span class="me-2">
                                    <i class="fas fa-key"></i>
                                </span>
                    Đổi mật khẩu
                </a>
                <a class="dropdown-item"
                   onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                   href="{{route('login')}}"><span class="me-2">
                                    <i class="fas fa-arrow-right"></i>
                                </span>Đăng xuất</a>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

</div>
