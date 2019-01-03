@extends('layouts.member_list')
@section('member_nav','active')
@section('client_top','active')

@section('content')
<div class="templatemo-flex-row flex-content-row">
  <div class="col-1">
    <div id="successAlert" class="hidden alert alert-success" role="alert"></div>

    @foreach ($applys as $apply)
    <div class="alert alert-warning alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <p>微信用户<strong class="blue-text">{{ $apply->nickName }}</strong>（用户名:{{ $apply->name }}；电话:{{ $apply->tel }}）申请成为
        <strong class="blue-text">
           @if ($apply->apply_identity == 1)
              业务员
            @elseif ($apply->apply_identity == 2)
              资金方
            @else
              {{ $apply->apply_identity }}
            @endif
        </strong>。&nbsp;&nbsp;&nbsp;
        <button type="button" class="btn btn-info" data-identity="{{ $apply->apply_identity }}" data-name="{{ $apply->name }}" data-id="{{ $apply->id }}" onclick="agreeApply(this)">同意</button>
        <button type="button" class="btn btn-default" data-id="{{ $apply->id }}" onclick="disagreeApply(this)">不同意</button>
      </p>
    </div>
    @endforeach

    <!-- //////////////////////////////////////////// -->
    <!-- 客户列表 -->
    <div class="templatemo-content-widget no-padding">
                      
      <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
          <thead>
            <tr>
              <td><a href="" class="white-text templatemo-sort-by">名字<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">电话<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">微信名<span class="caret"></span></a></td>              
              <td><a href="" class="white-text templatemo-sort-by">操作<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">操作<span class="caret"></span></a></td>
            </tr>
          </thead>
          <tbody>
            @foreach ($clients as $client)
            <tr>
              <td>{{ $client->name }}</td>
              <td>{{ $client->tel }}</td>
              <td>{{ $client->nickName }}</td>
              <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#changeIdentityModal" data-identity="业务员" data-name="{{ $client->name }}" data-tel="{{ $client->tel }}" data-nickName="{{ $client->nickName }}" data-id="{{ $client->id }}">变更为业务员</a></td>
              <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#changeIdentityModal" data-identity="资金方" data-name="{{ $client->name }}" data-tel="{{ $client->tel }}" data-nickName="{{ $client->nickName }}" data-id="{{ $client->id }}">变更为资金方</a></td>
            </tr>
            @endforeach           
          </tbody>
          <tfoot>
            <tr id="paging-margin">
              <td colspan="6" class="text-center">{!! $clients->render() !!}</td>
            </tr>
          </tfoot>
        </table>    
      </div>                          
    </div>
    <!--end 客户列表 -->
    <!-- //////////////////////////////////////////// -->
  </div> 
</div>
@endsection

@section('otherModel')
<!-- 删除用户模态框 -->
<div class="modal fade" id="changeIdentityModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">操作提示</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">将用户<strong class="blue-text" id="comfirm_name"></strong>变成<strong class="blue-text" id="comfirm_type"></strong></div>
        <input type="hidden" id="clientId" value="">
        <input type="hidden" id="name" value="">
        <input type="hidden" id="memberIdentity" value="">
       <!--
        <div id="approve_warning" class="hidden alert alert-danger" role="alert">请输入名字、 电话</div>
        <input type="hidden" id="clientId" value="">
        <input type="hidden" id="nickName" value="">
        <input type="hidden" id="memberIdentity" value="">
        <form class="form-horizontal">
          <div class="form-group">
            <label for="name" class="col-sm-1 control-label">名字：</label>
            <div class="col-sm-3">
              <input type="text" id="name" class="form-control" >
            </div>
            <label class="col-sm-1"></label>
            <label for="tel" class="col-sm-1 control-label">电话：</label>
            <div class="col-sm-3">
              <input type="text" id="tel" class="form-control">
            </div>         
          </div>
        </form> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
        <button type="button" id="submitChangeIdentity" class="btn btn-primary">确定</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
//更改用户信息-》获取数据
$('#changeIdentityModal').on('show.bs.modal', function (event) {
  var btnThis = $(event.relatedTarget); //触发事件的按钮
  var name = btnThis.attr('data-name');
  var nickName = btnThis.attr('data-nickName');
  $('#clientId').val(btnThis.attr('data-id'));
  $('#name').val(name);
  var identity=0;
  if(btnThis.attr('data-identity') == '业务员')
    identity = 1;
  else if(btnThis.attr('data-identity') == '资金方')
    identity = 2;
  $('#memberIdentity').val(identity);

  $('#comfirm_name').text(name);
  if(name.length == 0){
    $('#comfirm_name').text(nickName);
  }
  $('#comfirm_type').text(btnThis.attr('data-identity'));
});

$('#submitChangeIdentity').on('click', function () {
  var id = $('#clientId').val();
  var name = $('#name').val();
  var identity = $('#memberIdentity').val();
  $('#clientId').val('');
  $('#name').val('');
  $('#memberIdentity').val('');
  $('#changeIdentityModal').modal('hide');
  $.ajax({
    type:'post',
    url:'/change_client_identity',
    data: {id : id, name : name, identity : identity, _token:"{{csrf_token()}}"},
    success:function(data){
      $('#successAlert').html("用户<strong>"+data.msg+"</strong>的身份已变更完成");
      $('#successAlert').removeClass("hidden");
      setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 2000);
    }
  });
});

function agreeApply(event) {
  var id = $(event).attr('data-id');
  var name = $(event).attr('data-name');
  var identity = $(event).attr('data-identity');
  $.ajax({
    type:'post',
    url:'/change_client_identity',
    data: {id : id, name : name, identity : identity, _token:"{{csrf_token()}}"},
    success:function(data){
      location.reload();  
      //setTimeout(function() { location.reload();}, 500);
    }
  });
}

//不同意用户变更身份申请
function disagreeApply(event) {
  var id = $(event).attr('data-id');
  $.ajax({
    type:'post',
    url:'/disagree_apply_identity',
    data: {id : id, _token:"{{csrf_token()}}"},
    success:function(data){
      location.reload();  
      //setTimeout(function() { location.reload();}, 500);
    }
  });
}


//更改用户信息-》获取数据
/*
$('#changeIdentityModal').on('show.bs.modal', function (event) {
  var btnThis = $(event.relatedTarget); //触发事件的按钮
  var name = btnThis.attr('data-name');
  var nickName = btnThis.attr('data-nickName');
  $('#clientId').val(btnThis.attr('data-id'));
  $('#nickName').val(nickName);
  $('#name').val(name);
  $('#tel').val(btnThis.attr('data-tel'));
  var identity=0;
  if(btnThis.attr('data-identity') == '业务员')
    identity = 1;
  else if(btnThis.attr('data-identity') == '资金方')
    identity = 2;
  $('#memberIdentity').val(identity);

  $('#comfirm_name').text(name);
  if(name.length == 0){
    $('#comfirm_name').text(nickName);
  }
  $('#comfirm_type').text(btnThis.attr('data-identity'));
});
//更改用户信息-》提交数据
$('#submitChangeIdentity').on('click', function () {
  var id = $('#clientId').val();
  var name = $('#name').val();
  var tel = $('#tel').val();
  var identity = $('#memberIdentity').val();
  if(name.length == 0 || tel.length == 0){
      $('#approve_warning').removeClass("hidden");
      return null;
  }
  $('#clientId').val('');
  $('#name').val('');
  $('#tel').val('');
  $('#memberIdentity').val('');
  $('#changeIdentityModal').modal('hide');
  $.ajax({
    type:'post',
    url:'/change_client_identity',
    data: {id : id, name : name, tel : tel, identity : identity, _token:"{{csrf_token()}}"},
    success:function(data){
      $('#successAlert').html("用户<strong>"+data.msg+"</strong>的身份已变更完成");
      $('#successAlert').removeClass("hidden");
      setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 2000);
    }
  });
});
*/
</script>
@endsection