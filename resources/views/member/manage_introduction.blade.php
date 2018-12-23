@extends('layouts.member_list')
@section('css')
<link href="../css/swipebox.css" rel="stylesheet">
<link href="../css/portfolio.css" rel="stylesheet">
@endsection

@section('member_nav','active')
@section('manage_introduction','active')

@section('content')
<!-- ////////////////////////////////////////////// -->
<div id="successAlert" class="hidden alert alert-success" role="alert"></div>  
<div class="templatemo-flex-row flex-content-row">
	<div class="col-1">
	  <div class="panel panel-default margin-10">
	    <div class="panel-heading"><h2 class="text-uppercase">公司简介</h2></div>
	    <div class="panel-body">
          <div class="row form-group">
            <div class="col-lg-12 form-group"> 
                <textarea class="form-control" id="desc" name="desc" rows="7">{{ $introduction->desc }}</textarea>
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
                <input type="text" class="form-control" name="tel" id="tel" value="{{ $introduction->tel }}" >    
            </div>
          </div>
          <div class="form-group">
            <label for="addr" class="col-sm-3 control-label">公司地址：</label>
            <div class="col-sm-9"> 
              <input type="text" class="form-control" name="addr" id="addr" value="{{ $introduction->addr }}" >    
            </div>
          </div>
          <div class="form-group">
            <label for="linkman" class="col-sm-3 control-label">联系人：</label>
            <div class="col-sm-9"> 
              <input type="text" class="form-control" name="linkman" id="linkman" value="{{ $introduction->linkman }}" >    
            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label">联系邮箱：</label>
            <div class="col-sm-9"> 
              <input type="text" class="form-control" name="email" id="email" value="{{ $introduction->email }}" >    
            </div>
          </div>
          <div class="form-group text-center">
            <a id="submitOtherInfo" class="templatemo-blue-button">提交</a>
          </div>
          </form>
      </div>
    </div>
  </div> 
</div>

  <div class="panel panel-default no-border">
    <div class="panel-heading border-radius-10">
      <h2>附件资料</h2>
    </div>
    <div class="panel-body">
      <form class="templatemo-login-form" id="photoForm">
      {{ csrf_field() }}
      <div class="row form-group margin-bottom-0">
        <div class="col-lg-12">
          <label class="control-label templatemo-block">上传新图片</label>           
          <input type="file" name="fileToUpload" id="fileToUpload" class="filestyle" data-buttonName="btn-primary" data-buttonBefore="true" data-icon="false" required>
        </div>
      </div>
      <div class="row form-group text-center margin-bottom-0">
        <a class="templatemo-blue-button" onclick="doUpload()">上传</a>
      </div> 
      </form>
      <hr/>

      @foreach ($pics as $pic)
      <div class="col-md-4 col-sm-4 col-xs-6 padding-10">
        <div class="agileinfo-effect wow fadeInUp animated" data-wow-delay=".3s">
          <a href="{{ $pic->pic }}" class="swipebox" title="轮播图">
            <img src="{{ $pic->pic }}" alt="轮播图" class="img-responsive" />
            <div class="figcaption">
              <p>轮播图</p>
            </div>
          </a>  
        </div>
        <p>&nbsp;<i class="fa fa-trash" data-id="{{ $pic->id }}" data-toggle="modal" data-target="#submitDeleteModal" style="font-size:20px;color:red"></i></p>
      </div>
      @endforeach
      <div class="clearfix"> </div>
    </div> 
  </div>
<!--end 管理员登录 -->
<!-- ////////////////////////////////////////////// -->
@endsection

@section('otherModel')
<!-- 不受理订单模态框 -->
<div class="modal fade" id="submitDeleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">操作提示</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="introId" value="">
        <p><strong class="blue-text" id="comfirm_name">确认要将该轮播图删除吗？</strong></p> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
        <button type="button" id="submitDelete" class="btn btn-primary">确定</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="../js/bootstrap-filestyle.min.js"></script>
<!-- swipe box js -->
<script src="../js/jquery.swipebox.min.js"></script> 
<script type="text/javascript">
$(document).ready(function($){$(".swipebox").swipebox();});

//更改公司简介
$('#submitDesc').on('click', function() {
  var desc = $('#desc').val();
  $.ajax({
    type:'post',
    url:'/update_intro_desc',         
    data: {desc : desc, _token:"{{csrf_token()}}"},
    success:function(data){ 
      $('#successAlert').html("信息更新成功！");
      $('#successAlert').removeClass("hidden");
      setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 2000);
    }
  });
});

//基本信息
$('#submitOtherInfo').on('click', function() {
  var tel = $('#tel').val();
  var addr = $('#addr').val();
  var linkman = $('#linkman').val();
  var email = $('#email').val();
  $.ajax({
    type:'post',
    url:'/update_intro_others',         
    data: {tel : tel, addr : addr, linkman : linkman, email : email, _token:"{{csrf_token()}}"},
    success:function(data){ 
      $('#successAlert').html("信息更新成功！");
      $('#successAlert').removeClass("hidden");
      setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 2000);
    }
  });
});

$('#submitDeleteModal').on('show.bs.modal', function (event) {
  var btnThis = $(event.relatedTarget); //触发事件的按钮
  $('#introId').val(btnThis.attr('data-id')); 
});

//删除附件-》提交数据
$('#submitDelete').on('click', function () {
  var id = $('#introId').val();
  $('#introId').val('');
  $('#submitDeleteModal').modal('hide');
  $.ajax({
    type:'post',
    url:'/delete_intro_pic',
    data: {id : id, _token:"{{csrf_token()}}"},
    success:function(data){
      $('#successAlert').html("该轮播图已经被删除");
      $('#successAlert').removeClass("hidden");
     setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 2000);
    }
  });
});

function doUpload() {
    var formData = new FormData($("#photoForm")[0]);
    console.log(formData);
    $.ajax({
        url: '/upload_intro_pic',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            $('#successAlert').html("图片上传成功！");
            $('#successAlert').removeClass("hidden");
            setTimeout(function(){ $("#successAlert").addClass("hidden"); location.reload();}, 1000);
        }
    });
}
</script>
@endsection