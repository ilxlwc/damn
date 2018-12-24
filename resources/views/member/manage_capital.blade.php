@extends('layouts.member_list')
@section('member_nav','active')
@section('capital_top','active')

@section('content')
<div class="templatemo-flex-row flex-content-row">
  <div class="col-1">
    <!-- //////////////////////////////////////////// -->
    <!-- 资金方列表 -->
    <div class="templatemo-content-widget no-padding">
      <div id="successAlert" class="hidden alert alert-success" role="alert"></div>                
      <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
          <thead>
            <tr>
              <td><a href="" class="white-text templatemo-sort-by">名字<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">电话<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">微信名<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">注册时间<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">操作<span class="caret"></span></a></td>
            </tr>
          </thead>
          <tbody>
            @foreach ($capitals as $capital)
            <tr>
              <td>{{ $capital->name }}</td>
              <td>{{ $capital->tel }}</td>
              <td>{{ $capital->nickName }}</td>
              <td>{{ $capital->created_at }}</td>
              <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#changeIdentityModal" data-name="{{ $capital->name }}" data-id="{{ $capital->id }}">删除该用户</a></td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr id="paging-margin">
              <td colspan="5" class="text-center">{!! $capitals->render() !!}</td>
            </tr>
          </tfoot>
        </table>    
      </div>                          
    </div>
    <!--end 资金方列表 -->
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
        <input type="hidden" id="capitalId" value="">
        <input type="hidden" id="capitalName" value="">
        <p>确认要将用户<strong class="blue-text" id="comfirm_name"></strong>删除吗？</p>        
        <p>删除后，该用户的身份将变更成<strong class="blue-text">"借贷人"</strong></p>
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
  $('#capitalId').val(btnThis.attr('data-id'));
  $('#capitalName').val(btnThis.attr('data-name'));  
  $('#comfirm_name').text(btnThis.attr('data-name'));
});
//删除用户-》提交数据
$('#submitChangeIdentity').on('click', function () {
  var id = $('#capitalId').val();
  var name = $('#capitalName').val();
  $('#capitalId').val('');
  $('#capitalName').val('');
  $('#changeIdentityModal').modal('hide');
  $.ajax({
    type:'post',
    url:'/delete_capital_identity',
    data: {id : id, name : name, _token:"{{csrf_token()}}"},
    success:function(data){
      $('#successAlert').html("用户<strong>"+data.msg+"</strong>已删除");
      $('#successAlert').removeClass("hidden");
      setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 2000);
    }
  });
});
</script>
@endsection