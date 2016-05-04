<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('home')}}" class="site_title"><i class="fa fa-paw"></i> <span>Shuvayatra</span></a>
        </div>

        <div class="clearfix"></div>
        <br/>

        <div class="menu_section">
            <h3>Content</h3>
            <ul class="">
                <?php
                $sections = \App\Nrna\Models\Category::all()->toHierarchy();
                ?>
                @foreach($sections as $section)
                    <li class="active">
                        <span class="">{{$section->title}}</span> <a class=""
                                                                     href="{{route('category.create')}}?section_id={{$section->id}}">Add</a>
                        <ul class="child_menu">
                            @foreach($section->children as $child)
                                <li>{{$child->title}} <a class="sidebar-edit"
                                                         href="{{route('category.edit',$child->id)}}?section_id={{$section->id}}"
                                                         href="">edit</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach

            </ul>
        </div>
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

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
