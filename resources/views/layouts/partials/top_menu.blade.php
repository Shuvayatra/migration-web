<div class="top_nav">

    <div class="nav_menu">
        <nav class="" role="navigation">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>


            <ul class="nav navbar-nav pull pull-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        <img src="{{url()}}/images/user.png" alt="">{{Auth::user()->email}}
                        <span class=" fa fa-angle-down"></span>
                    </a>

                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="javascript:;"> Profile</a>
                        </li>
                        <li><a href="{{ url('/auth/logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav pull pull-right">
                <li class="">
                    <a href="{{route('tag.index')}}" class="user-profile dropdown-toggle">Tags</a>
                </li>
            </ul>
            <ul class="nav navbar-nav pull pull-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        Content
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="javascript:;"> Destination</a></li>
                        <li><a href="javascript:;"> Journey</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav pull pull-right">
                <li class="">
                    <a href="{{route('home')}}" class="user-profile dropdown-toggle">Dashboard</a>
                </li>
            </ul>
            <form class="navbar-form navbar-left" method="GET" role="search">
                <div class="form-group">
                    <input type="text" name="q" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
            </form>
        </nav>
    </div>

</div>