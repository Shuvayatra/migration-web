<nav class="navbar navbar-default menu">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url()}}">Shuvayatra</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse">

            <form action="{{route('search')}}" class="navbar-form navbar-left" method="GET" role="search">
                <div class="input-group add-on">
                    <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                    <input type="text"  name="q" class="form-control" placeholder="Search content, keywords, tags">
                </div>

            </form>

            <ul class="nav navbar-nav navbar-right navbar-list">
                @role('admin')
                <li><a href="{{route('pushnotification.index')}}">Notification</a></li>

                <li>
                    <a href="{{route('user.index')}}">Users</a>
                </li>

                <li>
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Rss <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('rss.index')}}">Rss</a></li>
                        <li><a href="{{route('rssnewsfeeds.index')}}">News Feeds</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('apilogs.index')}}">Api Log</a>
                </li>

                <li>
                    <a href="{{route('tag.index')}}" class="user-profile dropdown-toggle">Tags</a>
                </li>


                <li>
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Content <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php
                        $sections = \App\Nrna\Models\Category::roots()->get();
                        ?>
                        @foreach($sections as $section)
                        <li><a href="{{route('post.index')}}?category={{$section->id}}"> {{$section->title}}</a>
                        </li>
                        @endforeach
                        <li><a href="{{route('category.index')}}"> Manage <i class="glyphicon glyphicon-cog pull-right"></i> </a>
                        </li>
                    </ul>
                </li>
                @endrole


                <li>
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <!-- <img class="img-responsive admin-image" src="{{url()}}/images/user.png" alt=""> -->
                    {{Auth::user()->email}}<span class="caret"></span>
                </a>

                <ul class="dropdown-menu">
                    <li><a href="{{route('user.edit', auth()->user()->id)}}"> Profile</a>
                    </li>
                    <li><a href="{{ url('/auth/logout') }}"><i class="glyphicon glyphicon-log-out pull-right"></i> Log
                        Out</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
