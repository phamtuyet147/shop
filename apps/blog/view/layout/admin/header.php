<nav class="navbar navbar-inverse navbar-fixed-side">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle"
                    data-target=".navbar-collapse"
                    data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin" title="{w:msg page.title}">
                <img class="img-responsive" src="/resources/images/logo.svg"
                     onerror="this.src='/resources/images/logo.png'"
                     alt="{w:msg page.title}"/>Admin Panel
            </a>
        </div>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <h2 class="dropdown-toggle text-center">Version: 1.0</h2>
            </li>
            <li class="">
                <a href="/admin/articles"><i class="fa fa-edit"></i>&nbsp;&nbsp;BÀI VIẾT</a>
            </li>
            <li class="">
                <a href="/admin/guest"><i class="fa fa-check"></i>&nbsp;&nbsp;DUYỆT THÔNG TIN</a>
            </li>
            <li class="">
                <a href="/admin/members"><i class="fa fa-user"></i>&nbsp;&nbsp;THÀNH VIÊN</a>
            </li>
        </ul>
    </div>
</nav>