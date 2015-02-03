<aside>
    <div id="sidebar"  class="nav-collapse ">
        <ul class="sidebar-menu" id="nav-accordion">
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
            <li class="sub-menu">
                <a href="javascript:;" class="{{($item->module == \Request::segment(1) ? 'active' : '')}}">
                    <i class="{{$item->icon}}"></i>
                    <span>{{$item->title}}</span>
                </a>
                <ul class="sub">
                    @foreach(\DB::table('menu')
                    ->join('menu_role', 'menu_role.menu_id', '=', 'menu.id')
                    ->where('menu_role.role_id', '=', $item->role_id)
                    ->where('menu.sub_id', '!=', 0)
                    ->where('menu.sub_id', '=', $item->id)
                    ->select('menu.id', 'menu.title', 'menu.url', 'menu.icon', 'menu.module')
                    ->orderBy('menu.rank', 'asc')
                    ->get() as $item2)
                    <li class="{{($item2->url == \Request::path() ? 'active' : '')}}"><a  href="{{URL::to($item2->url)}}">{{$item2->title}}</a></li>
                    @endforeach
                </ul>
            </li>
            @else
            <li>
                <a href="{{$item->url}}">
                    <i class="{{$item->icon}}"></i>
                    <span>{{$item->title}}</span>
                </a>
            </li>
            @endif
            @endforeach
        </ul>
    </div>
</aside>