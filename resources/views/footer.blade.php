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
<footer style="background-color:#0d60dc;color: white;">
    <div class="row">
        <div class="col-md-3">
            <img src="{{ URL::to('img/line.jpg') }}"
                 width="100px"
                 class="img-rounded img-thumbnail img-responsive">
            <p>LINE</p>
            <p>FACEBOOK</p>
        </div>
        <div class="col-md-6">
            <p>Phone：08-7383017</p>
            <p>Fax：08-7383017</p>
            <p>Mobile Phone：0928-785456</p>
            <p>Address：屏東縣屏東市大連里興豐路74號</p>
            <p>Mail：gfun0928@gmail.com</p>
        </div>
        <div class="col-md-3">

        </div>
    </div>
    <div class="col-md-offset-4 col-md-5"><p>Copyright © 2018 Gfun Inc. All rights reserved</p></div>
</footer>