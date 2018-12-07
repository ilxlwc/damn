@extends('layouts.member_list')
@section('member_nav','active')
@section('client_top','active')

@section('content')
<div class="templatemo-flex-row flex-content-row">
  <div class="col-1">
    <!-- //////////////////////////////////////////// -->
    <!-- 客户列表 -->
    <div class="templatemo-content-widget no-padding">
      <div id="successAlert" class="hidden alert alert-success" role="alert"></div>                
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
              <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#changeIdentityModal" data-identity="业务员" data-name="{{ $client->name }}" data-id="{{ $client->id }}">变更为业务员</a></td>
              <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#changeIdentityModal" data-identity="资金方" data-name="{{ $client->name }}" data-id="{{ $client->id }}">变更为资金方</a></td>
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
        <input type="hidden" id="clientId" value="">
        <input type="hidden" id="clientName" value="">
        <input type="hidden" id="memberIdentity" value="">
        <p>确认要将用户<strong class="blue-text" id="comfirm_name"></strong>变成<strong class="blue-text" id="comfirm_type"></strong>吗？</p>
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
//删除用户-》获取数据
$('#changeIdentityModal').on('show.bs.modal', function (event) {
  var btnThis = $(event.relatedTarget); //触发事件的按钮
  var modal = $(this);  //当前模态框
  $('#clientId').val(btnThis.attr('data-id'));
  $('#clientName').val(btnThis.attr('data-name'));
  var identity=0;
  if(btnThis.attr('data-identity') == '业务员')
    identity = 1;
  else if(btnThis.attr('data-identity') == '资金方')
    identity = 2;
  $('#memberIdentity').val(identity);
  $('#comfirm_name').text(btnThis.attr('data-name'));
  $('#comfirm_type').text(btnThis.attr('data-identity'));
});
//删除用户-》提交数据
$('#submitChangeIdentity').on('click', function () {
  var id = $('#clientId').val();
  var name = $('#clientName').val();
  var identity = $('#memberIdentity').val();
  $('#clientId').val('');
  $('#clientName').val('');
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
</script>
@endsection