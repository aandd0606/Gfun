<style>
    .navbar-custom {
        background-color: #0d60dc ;
        color:#ffffff;
        border-radius:0;
    }

    .navbar-custom .navbar-nav > li > a {
        color:#fff;
        padding-left:20px;
        padding-right:20px;
    }
    .navbar-custom .navbar-nav > .active > a, .navbar-nav > .active > a:hover, .navbar-nav > .active > a:focus {
        background-color:  #3385ff ;
    }

    .navbar-custom .navbar-nav > li > a:hover, .nav > li > a:focus, .navbar-custom .navbar-nav .open>a  {
        background-color:  #3385ff ;
    }


    /* dropdown */
    .navbar-custom .navbar-nav .dropdown-menu  {
        background-color:  #3385ff ;
    }
    .navbar-custom .navbar-nav .dropdown-menu>li>a  {
        color: #fff;
    }
    .navbar-custom .navbar-nav .dropdown-menu>li>a:hover,.navbar-custom .navbar-nav .dropdown-menu>li>a:focus  {
        color:  #3385ff ;
    }

    .navbar-custom .navbar-brand {
        color:#eeeeee;
    }
    .navbar-custom .navbar-toggle {
        background-color:#eeeeee;
    }
    .navbar-custom .icon-bar {
        background-color: #3385ff ;
    }
</style>
<nav class="navbar navbar-custom" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://web.sisps.ptc.edu.tw/index.php" style="color:#FFFFFF">聚豐企業社</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <a accesskey="U" href="#xoops_theme_nav_key" title="上方導覽工具列" id="xoops_theme_nav_key" style="color: transparent; font-size: 10px;">:::</a>
            <ul class="nav navbar-nav" id="main-menu-left">

                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown"  href="" target="_self">
                        <i class="fa fa-align-justify"></i> 公司簡介  <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a  href="" target="_blank"><i class="fa fa-book"></i>聯絡資訊</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown"  href="" target="_self">
                        <i class="fa fa-institution"></i>產品與服務<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a  href="" target="_blank"><i class="fa fa-search"></i> 校長室                 </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right" id="main-menu-right">

                <li><a rel="tooltip" href="http://web.sisps.ptc.edu.tw/modules/tad_themes/admin/dropdown.php" title="選單設定"><i class="fa fa-plus-circle"></i></a></li>

                <li><a rel="tooltip" href="http://web.sisps.ptc.edu.tw/admin.php" title="模組管理區"><span class="fa fa-th-large"></span></a></li>

                <li id="preview-menu">
                    <a rel="tooltip" title="管理區" class="dropdown-toggle" data-toggle="dropdown" href="#">
                        管理區 <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ url("customer") }}"><span class="fa fa-lock"></span>顧客管理</a>
                            <a href="{{ url("company") }}"><span class="fa fa-lock"></span>協作廠商管理</a>
                            <a href="{{ url("project") }}"><span class="fa fa-lock"></span>案件管理</a>

                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
