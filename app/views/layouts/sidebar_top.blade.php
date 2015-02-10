<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="fa fa-bar"></span>
        <span class="fa fa-bar"></span>
        <span class="fa fa-bar"></span>
    </button>

    <!--logo start-->
    <a href="{{URL::to('/')}}" class="logo" >MIS <span>OFFICE 1.0</span></a>
    <!--logo end-->
    <div class="horizontal-menu navbar-collapse collapse ">
        <ul class="nav navbar-nav">            
            @foreach(\DB::table('menu')
            ->select('menu.id', 'menu.title', 'menu.url', 'menu.icon', 'menu.module', 'menu_role.role_id')
            ->join('menu_role', 'menu_role.menu_id', '=', 'menu.id')
            ->join('role_user', 'role_user.role_id', '=', 'menu_role.role_id')
            ->where('role_user.user_id', \Auth::user()->id)
            ->where('menu.sub_id', 0)
            ->orderBy('menu.rank', 'asc')
            ->groupBy('menu.id')
            ->get() as $item)
            @if (\Menu::where('sub_id', $item->id)->count() > 0)
            <li class="dropdown">
                <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">{{$item->title}} <b class=" fa fa-angle-down"></b></a>
                <ul class="dropdown-menu">
                    @foreach(\DB::table('menu')
                    ->join('menu_role', 'menu_role.menu_id', '=', 'menu.id')
                    ->where('menu_role.role_id', '=', $item->role_id)
                    ->where('menu.sub_id', '!=', 0)
                    ->where('menu.sub_id', '=', $item->id)
                    ->select('menu.id', 'menu.title', 'menu.url', 'menu.icon', 'menu.module')
                    ->orderBy('menu.rank', 'asc')
                    ->get() as $item2)
                    <li><a  href="{{URL::to($item2->url)}}">{{$item2->title}}</a></li>
                    @endforeach
                </ul>
            </li>
            @else
            <li class="{{($item->module == \Request::segment(1) ? 'active' : '')}}"><a href="{{URL::to($item->url)}}">{{$item->title}}</a></li>
            @endif
            @endforeach
        </ul>

    </div>
    <div class="top-nav ">
        <ul class="nav pull-right top-menu">
            <li>
                <input type="text" class="form-control search" placeholder=" Search">
            </li>
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    {{HTML::image('img/avatar1_small.jpg')}}
                    <span class="username">{{\Auth::user()->firstname}} {{\Auth::user()->lastname}}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>
                    <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
                    <li><a href="{{URL::to('logout')}}"><i class="fa fa-key"></i> ออกจากระบบ</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->
        </ul>
    </div>

</div>