<ul class="nav" id="side-menu">

    {{-- CATEGORY --}}
    <li>
        <a href="#">
            <i class="fa fa-folder-open fa-fw"></i>
            Category
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li>
                <a href="{{ route('admin.category.index') }}">
                    <i class="fa fa-list"></i> List Categories
                </a>
            </li>
            <li>
                <a href="{{ route('admin.category.create') }}">
                    <i class="fa fa-plus-circle"></i> Add Category
                </a>
            </li>
        </ul>
    </li>

    {{-- POST --}}
    <li>
        <a href="#">
            <i class="fa fa-file-text fa-fw"></i>
            Post
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li>
                <a href="{{ route('admin.post.index') }}">
                    <i class="fa fa-list"></i> List Posts
                </a>
            </li>
            <li>
                <a href="{{ route('admin.post.create') }}">
                    <i class="fa fa-plus-circle"></i> Add Post
                </a>
            </li>
        </ul>
    </li>

    {{-- USER --}}
    <li>
        <a href="#">
            <i class="fa fa-users fa-fw"></i>
            User
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li>
                <a href="{{ route('admin.user.index') }}">
                    <i class="fa fa-list"></i> List Users
                </a>
            </li>
            <li>
                <a href="{{ route('admin.user.create') }}">
                    <i class="fa fa-user-plus"></i> Add User
                </a>
            </li>
        </ul>
    </li>

    {{-- CONTACT --}}
    <li>
        <a href="{{ route('admin.contact.index') }}">
            <i class="fa fa-envelope fa-fw"></i>
            Contact
        </a>
    </li>

</ul>
