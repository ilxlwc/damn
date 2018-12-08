<div class="templatemo-sidebar">
  <header class="templatemo-site-header">
    <div class="square"></div>
    <h1>@yield('title','双盈信息科技')</h1>
  </header>
  <div class="profile-photo-container">
    <img src="../images/profile-photo.jpg" alt="Profile Photo" class="img-responsive">  
    <div class="profile-photo-overlay"></div>
  </div>
  <div class="mobile-menu-icon">
      <i class="fa fa-bars"></i>
  </div>
  <nav class="templatemo-left-nav">
    <ul>
      <li><a href="/new_order" class="@yield('neworder_nav','')"><i class="fa fa-home fa-fw"></i>新订单</a></li>
      <li><a href="/checking_order" class="@yield('checking_nav','')"><i class="fa fa-home fa-fw"></i>待审核订单</a></li>
      <li><a href="/finding_order" class="@yield('finding_nav','')"><i class="fa fa-database fa-fw"></i>待匹配订单</a></li>
      <li><a href="/approved_order" class="@yield('approved_nav','')"><i class="fa fa-map-marker fa-fw"></i>已批款订单</a></li>
      <li><a href="/member" class="@yield('member_nav','')"><i class="fa fa-users fa-fw"></i>用户管理</a></li>
      <li><a href="/logout" class="@yield('logout_nav','')"><i class="fa fa-eject fa-fw"></i>退 出</a></li>
    </ul>  
  </nav>
</div>