<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Header Section Begin -->
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="./">
                        <img src="{{ asset('img/logo.png') }}" alt="">
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="header__nav">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="active"><a href="./index.html">Homepage</a></li>
                            <li>
                                <a href="#">Categories <span class="arrow_carrot-down"></span></a>
                                <ul class="dropdown">
                                    @foreach ($genres as $genre)
                                    <li>
                                        <a href="{{ route('genres.show', $genre->id) }}">{{ $genre->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="./blog.html">Our Blog</a></li>
                            <li><a href="#">Contacts</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="header__right">
                    <div class="d-flex align-items-center">
                        <a href="#" class="search-switch"><span class="icon_search"></span></a>
                        <div class="menu">
                            @guest
                            <a href="{{ route('login') }}"><span class="icon_profile"></span></a>
                            @else
                            <div class="dropdown">
                                <a id="profileIcon" class="dropdown-toggle" role="button">
                                    <span class="icon_profile"></span>
                                </a>
                                <div id="profileDropdown" class="dropdown-menu" aria-labelledby="profileIcon">
                                    <a href="{{ route('user.profile') }}" class="dropdown-item">Thông tin tài khoản</a>
                                    <button id="vipMenu" class="dropdown-item">Nạp VIP</button>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Đăng xuất</button>
                                    </form>
                                </div>
                            </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>

<!-- Header End -->