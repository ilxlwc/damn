<div class="templatemo-top-nav-container">
  <div class="row">
    <nav class="templatemo-top-nav col-lg-12 col-md-12">
      <ul class="text-uppercase">
        <li><a href="/manage_client" class="@yield('client_top','')">借贷人</a></li>
        <li><a href="/manage_agent" class="@yield('agent_top','')">业务员</a></li>
        <li><a href="/manage_capital" class="@yield('capital_top','')">资金方</a></li>
        @if (Auth::check() && Auth::user()->name == 'admin')
        <li><a href="/manage_admin" class="@yield('admin_top','')">管理员</a></li>
        @endif
        <li><a href="/logout">退 出</a></li>
      </ul>  
    </nav> 
  </div>
</div>