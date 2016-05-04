<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('home')}}" class="site_title"><i class="fa fa-paw"></i> <span>Shuvayatra</span></a>
        </div>

        <div class="clearfix"></div>
        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Content</h3>
                <ul class="nav side-menu">
                    <?php
                    $sections = \App\Category::roots()->get();
                    ?>
                    @foreach($sections as $section)
                        <li class="active"><a>{{$section->title}}</a>
                            <ul class="nav child_menu">
                                <li><a>Create</a></li>
                                <li>Category<a class="" href="">edit</a></li>
                                <li>Category<a class="" href="">edit</a></li>
                                <li>Category<a class="" href="">edit</a></li>
                                <li>Category<a class="" href="">edit</a></li>
                                <li>Category<a class="" href="">edit</a></li>
                                <li>Category<a class="" href="">edit</a></li>
                                <li>Category<a class="" href="">edit</a></li>
                            </ul>
                        </li>
                    @endforeach

                </ul>
            </div>
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    @role('admin')
                    <li><a><i class="fa fa-user"></i> User <span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">
                            <li><a href="{{route('user.index')}}">Users</a></li>
                            <li><a href="{{route('user.create')}}">Create</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-edit"></i> Sections <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('section.index')}}">Section</a></li>
                            <li><a href="{{route('section.create')}}">Create</a></li>
                        </ul>
                    </li>
                    @endrole
                    <li><a><i class="fa fa-edit"></i> Posts <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('post.index')}}">Posts</a></li>
                            <li><a href="{{route('post.create')}}">Create</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->
        <!-- /menu footer buttons -->
    </div>
</div>
