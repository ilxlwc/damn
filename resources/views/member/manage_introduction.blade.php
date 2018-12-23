@extends('layouts.member_list')

@section('member_nav','active')
@section('manage_introduction','active')

@section('content')
<!-- ////////////////////////////////////////////// -->
<!-- 添加管理员 -->
<div class="templatemo-flex-row flex-content-row">
	<div class="col-1">
	  <div class="panel panel-default margin-10">
	    <div class="panel-heading"><h2 class="text-uppercase">公司简介</h2></div>
	    <div class="panel-body">
          <div class="row form-group">
            <div class="col-lg-12 form-group"> 
                <textarea class="form-control" id="desc" name="desc" rows="7"></textarea>
            </div>
          </div>
	        <div class="form-group">
	          <button type="submit" id="submitDesc" class="templatemo-blue-button">提交</button>
	        </div>
	    </div>
	  </div>
	</div> 
  <div class="col-1">
    <div class="panel panel-default margin-10">
      <div class="panel-heading"><h2 class="text-uppercase">基本信息</h2></div>
      <div class="panel-body">
          <form class="form-horizontal">
          <div class="form-group">
            <label for="tel" class="col-sm-3 control-label">联系电话：</label>
            <div class="col-sm-9"> 
                <input type="text" class="form-control" name="tel" id="tel">    
            </div>
          </div>
          <div class="form-group">
            <label for="addr" class="col-sm-3 control-label">公司地址：</label>
            <div class="col-sm-9"> 
              <input type="text" class="form-control" name="addr" id="addr">    
            </div>
          </div>
          <div class="form-group">
            <label for="linkman" class="col-sm-3 control-label">联系人：</label>
            <div class="col-sm-9"> 
              <input type="text" class="form-control" name="linkman" id="linkman">    
            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label">联系邮箱：</label>
            <div class="col-sm-9"> 
              <input type="text" class="form-control" name="email" id="email">    
            </div>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="templatemo-blue-button">提交</button>
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
@endsection

@section('javascript')
<script type="text/javascript">
//添加管理员
$('#submitDesc').submit(function() {
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
</script>
@endsection