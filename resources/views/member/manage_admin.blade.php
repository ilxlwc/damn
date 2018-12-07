@extends('layouts.member_list')

@section('member_nav','active')
@section('admin_top','active')

@section('content')
<!-- ////////////////////////////////////////////// -->
<!-- 添加管理员 -->
<div class="templatemo-flex-row flex-content-row">
	<div class="col-2">
	  <!-- //////////////////////////////////////////// -->
	  <!-- 管理员列表 -->
	  <div class="templatemo-content-widget no-padding">
	    <div id="successAlert" class="hidden alert alert-success" role="alert"></div>                
	    <div class="panel panel-default table-responsive">
	      <table class="table table-striped table-bordered templatemo-user-table">
	        <thead>
	          <tr>
	            <td><a href="" class="white-text templatemo-sort-by">#<span class="caret"></span></a></td>
	            <td><a href="" class="white-text templatemo-sort-by">用户名<span class="caret"></span></a></td>
	            <td><a href="" class="white-text templatemo-sort-by">更改密码<span class="caret"></span></a></td>
	            <td><a href="" class="white-text templatemo-sort-by">删除用户<span class="caret"></span></a></td>
	          </tr>
	        </thead>
	        <tbody>
	          @foreach ($users as $user)
	          <tr>
	            <td>{{ $user->id }}</td>
	            <td>{{ $user->name }}</td>
	            <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#changePasswordModal" data-name="{{ $user->name }}" data-id="{{ $user->id }}">更改密码</a></td>
	            <td><a href="" id="deleteAdmin" class="templatemo-edit-btn" data-toggle="modal" data-target="#deleteAdminModal" data-name="{{ $user->name }}" data-id="{{ $user->id }}">删除</a></td>
	          </tr>
	          @endforeach
	        </tbody>
          <tfoot>
            <tr id="paging-margin">
              <td colspan="4" class="text-center">{!! $users->render() !!}</td>              
            </tr>
          </tfoot>
	      </table>    
	    </div>                          
	  </div>
	  <!--end 管理员列表 -->
	  <!-- //////////////////////////////////////////// -->
	</div>
	<div class="col-1">
	  <div class="panel panel-default margin-10">
	    <div class="panel-heading"><h2 class="text-uppercase">添加管理员</h2></div>
	    <div class="panel-body">
	      <form id="addAdmin" class="templatemo-login-form">
	        <div class="form-group">
	          <label for="inputEmail">用户名：</label>
	          <input type="text" name="name" id="addAdminName" class="form-control" placeholder="用户名">
	        </div>
	        <div class="form-group">                      
	          <label for="inputEmail">密 码：</label>
	          <input type="password" id="addAdminPassword" name="password" class="form-control" placeholder="密 码">
	        </div>  
	        <div class="form-group">                      
	          <label for="inputEmail">确认密码：</label>
	          <input type="password" id="addAdminPassword_confirmation" name="password_confirmation" class="form-control" placeholder="确认密码">
	        </div>
	        <div class="form-group">
	          <button type="submit" class="templatemo-blue-button">提交</button>
	          <label id="addAdminMsg" class="blue-text invisible"></label>
	        </div>
	      </form>
	    </div>
	  </div>
	</div> 
 
</div>
<!--end 管理员登录 -->
<!-- ////////////////////////////////////////////// -->
@endsection

@section('otherModel')

 <!-- 更改用户密码模态框 -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">更改用户密码</h4>
      </div>
      <div class="modal-body">
        <!-- //////////////////////////////////////// -->
        <input type="hidden" id="changeId" value="">
        <div class="form-group">
          <label for="inputEmail">用户名：</label>
          <input type="text" name="name" id="changeAdminName" class="form-control" value="" disabled="disabled">
        </div>
        <div class="form-group">                      
          <label for="inputEmail">新的密码：</label>
          <input type="password" id="changeAdminPassword" name="password" class="form-control" placeholder="密 码">
        </div>  
        <div class="form-group">                      
          <label for="inputEmail">确认密码：</label>
          <input type="password" id="changeAdminPassword_confirmation" name="password_confirmation" class="form-control" placeholder="确认密码">
        </div> 
        <!-- //////////////////////////////////////// -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
        <button type="button" id="submitChangePassword" class="btn btn-primary">提交更改</button>
      </div>
    </div>
  </div>
</div>

<!-- 删除用户模态框 -->
<div class="modal fade" id="deleteAdminModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">操作提示</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="deleteAdminId" value="">
        <input type="hidden" id="deleteAdminName" value="">
        <p>确认要删除用户<strong class="blue-text" id="comfirm_name"></strong>吗？</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
        <button type="button" id="submitDeleteAdmin" class="btn btn-primary">确定</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
      //添加管理员
      $('#addAdmin').submit(function() {
        var name = $('#addAdminName').val();
        var password = $('#addAdminPassword').val();
        var password_confirmation = $('#addAdminPassword_confirmation').val();
        $('#addAdminName').val('');
        $('#addAdminPassword').val('');
        $('#addAdminPassword_confirmation').val('');
        $.ajax({
          type:'post',
          url:'/add_admin',         
          data: { name : name, password : password, password_confirmation : password_confirmation, _token:"{{csrf_token()}}"},
          success:function(data){
            $("#addAdminMsg").html("管理员<strong>"+data.msg+"</strong>创建成功！");
            $("#addAdminMsg").removeClass("invisible");
            setTimeout(function() {location.reload();}, 3000);
          },  
          error: function(data){
            $("#addAdminMsg").html("<strong>&nbsp;&nbsp;该用户已存在!&nbsp;&nbsp;</strong>");
            $("#addAdminMsg").removeClass("invisible").addClass("orange-bg");
          },
        });
        
        return false;
      });
      //更改用户名密码-》获取数据
      $('#changePasswordModal').on('show.bs.modal', function (event) {
        var btnThis = $(event.relatedTarget); //触发事件的按钮
        var modal = $(this);  //当前模态框
        $('#changeId').val(btnThis.attr('data-id'));
        $('#changeAdminName').val(btnThis.attr('data-name'));
        $('#changeAdminPassword').val('');
        $('#changeAdminPassword_confirmation').val('');
      });
      //更改用户名密码-》提交数据
      $('#submitChangePassword').on('click', function () {
        var id = $('#changeId').val();
        var name = $('#changeAdminName').val();
        var password = $('#changeAdminPassword').val();
        var password_confirmation = $('#changeAdminPassword_confirmation').val();
        $('#changeId').val('');
        $('#changeAdminName').val('');
        $('#changeAdminPassword').val('');
        $('#changeAdminPassword_confirmation').val('');
        $('#changePasswordModal').modal('hide');
        $.ajax({
          type:'post',
          url:'/change_adminPassword',         
          data: {id : id, name : name, password : password, password_confirmation : password_confirmation, _token:"{{csrf_token()}}"},
          success:function(data){
            $('#successAlert').html("用户<strong>"+data.msg+"</strong>更新密码成功");
            $('#successAlert').removeClass("hidden");
            setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 3000);
          }
        });
      });
      //删除用户-》获取数据
      $('#deleteAdminModal').on('show.bs.modal', function (event) {
        var btnThis = $(event.relatedTarget); //触发事件的按钮
        var modal = $(this);  //当前模态框
        $('#deleteAdminId').val(btnThis.attr('data-id'));
        $('#deleteAdminName').val(btnThis.attr('data-name'));
        $('#comfirm_name').text(btnThis.attr('data-name'));
      });
      //删除用户-》提交数据
      $('#submitDeleteAdmin').on('click', function () {
        var id = $('#deleteAdminId').val();
        var name = $('#deleteAdminName').val();
        $('#deleteAdminId').val('');
        $('#deleteAdminName').val('');
        $('#deleteAdminModal').modal('hide');
        $.ajax({
          type:'post',
          url:'/delete_admin',
          data: {id : id, name : name, _token:"{{csrf_token()}}"},
          success:function(data){
            $('#successAlert').html("用户<strong>"+data.msg+"</strong>已删除");
            $('#successAlert').removeClass("hidden");
            setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 3000);
          }
        });
      });
</script>
@endsection