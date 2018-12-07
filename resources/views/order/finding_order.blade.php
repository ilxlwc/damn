@extends('layouts.order_list')

@section('finding_nav','active')

@section('content')
<!-- ////////////////////////////////////////////// -->
<div class="templatemo-flex-row flex-content-row">
  <div class="col-1">
    <!-- //////////////////////////////////////////// -->
    <!-- 业务员列表 -->
    <div class="templatemo-content-widget no-padding">
      <div id="successAlert" class="hidden alert alert-success" role="alert"></div>                
      <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
          <thead>
            <tr>
              <td><a href="" class="white-text templatemo-sort-by">客户<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">申请金额<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">业务员<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">借款金额<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">操作<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">操作<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">操作<span class="caret"></span></a></td>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
            <tr>
              <td>{{ $order->name }}</td>
              <td>{{ $order->apply_amount }}</td>
              <td>{{ $order->agent_name }}</td>
              <td>{{ $order->prepare_amount }}</td>
              <td><a href="/order_detail/{{ $order->id }}" class="templatemo-edit-btn">详情</a></td>
              <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#allotCapitalModal" data-name="{{ $order->name }}" data-id="{{ $order->id }}">批款</a></td>
              <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#ignoreOrderModal" data-name="{{ $order->name }}" data-id="{{ $order->id }}">不受理</a></td>
            </tr>
            @endforeach            
          </tbody>
          <tfoot>
            <tr id="paging-margin">
              <td colspan="7" class="text-center">{!! $orders->render() !!}</td>
            </tr>
          </tfoot>
        </table>    
      </div>                          
    </div>
    <!--end 业务员列表 -->
    <!-- //////////////////////////////////////////// -->
  </div> 
</div>
@endsection

@section('otherModel')
<!-- 更改业务员模态框 -->
<div class="modal fade" id="allotCapitalModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">批款</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="allot_orderId" value="">
        <input type="hidden" id="allot_orderName" value="">
        <input type="hidden" id="allot_capitalId" value="">
        <input type="hidden" id="allot_capitalName" value="">
        <input type="hidden" id="allot_capitalTel" value="">
        <div id="allotAlert" class="hidden alert alert-success" role="alert"></div>
        <form class="form-horizontal">
          <div class="form-group">
            <label for="approve_amount" class="col-sm-2 control-label">批款金额：</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="approve_amount">
            </div>
          </div>
        </form>
        <table class="table table-striped table-bordered templatemo-user-table">
          <thead>
            <tr>             
              <td><a href="" class="white-text templatemo-sort-by">名字<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">电话<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">注册时间<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">操作<span class="caret"></span></a></td>
            </tr>
          </thead>
          <tbody>
            @foreach ($capitals as $capital)
            <tr>              
              <td>{{ $capital->name }}</td>
              <td>{{ $capital->tel }}</td>
              <td>{{ $capital->created_at }}</td>
              <td>
                <input class="allotSelected" type="radio" id="r{{ $capital->id }}" data-name="{{ $capital->name }}" data-tel="{{ $capital->tel }}" name="capital_id" value="{{ $capital->id }}" >
              </td>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
        <button type="button" id="submitAllot" class="btn btn-primary">确定</button>
      </div>
    </div>
  </div>
</div>


<!-- 不受理订单模态框 -->
<div class="modal fade" id="ignoreOrderModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">操作提示</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="orderId" value="">
        <input type="hidden" id="orderName" value="">
        <p>确认要将用户 <strong class="blue-text" id="comfirm_name"></strong> 的申请置为<strong class="blue-text">“不受理”</strong>吗？</p> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
        <button type="button" id="submitIgnore" class="btn btn-primary">确定</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
$('#approve_amount').on('blur',function(event){
  $('#allotAlert').html("用户 <strong >"+order_name+"</strong> 的申请的资金方为：<strong class='blue-text'>"+capital_name+"</strong>");
});

//指定业务员-》获取数据
$('#allotCapitalModal').on('show.bs.modal', function (event) {
  $(".allotSelected").removeAttr("checked");
  $('#allotAlert').addClass("hidden");
  $('#allotAlert').html('');
  $('#allot_orderId').val('');
  $('#allot_orderName').val('');
  $('#allot_capitalId').val('');
  $('#allot_capitalName').val('');
  $('#allot_capitalTel').val('');

  var btnThis = $(event.relatedTarget); //触发事件的按钮
  var modal = $(this);  //当前模态框
  $('#allot_orderId').val(btnThis.attr('data-id'));
  $('#allot_orderName').val(btnThis.attr('data-name'));  
});

$('.allotSelected').on('click', function (event) {
  var order_name = $('#allot_orderName').val();  
  var capital_id = $(this).val();
  var capital_name = $(this).attr('data-name');
  var capital_tel = $(this).attr('data-tel');
  $('#allotAlert').html("用户 <strong >"+order_name+"</strong> 的申请的资金方为：<strong class='blue-text'>"+capital_name+"</strong>");
  $('#allotAlert').removeClass("hidden");
  $('#allot_capitalId').val(capital_id);
  $('#allot_capitalName').val(capital_name);
  $('#allot_capitalTel').val(capital_tel);
});

//指定业务员-》提交数据
$('#submitAllot').on('click', function () {
  var order_id = $('#allot_orderId').val();
  var order_name = $('#allot_orderName').val();
  var capital_id = $('#allot_capitalId').val();
  var capital_name = $('#allot_capitalName').val(); 
  var capital_tel = $('#allot_capitalTel').val(); 
  $('#allotCapitalModal').modal('hide');
  $.ajax({
    type:'post',
    url:'/allot_agent_order',
    data: {order_id : order_id, order_name : order_name, capital_id : capital_id, capital_name : capital_name, capital_tel : capital_tel, _token:"{{csrf_token()}}"},
    success:function(data){
      $('#successAlert').html("已成功的为用户 <strong >"+data.order_name+"</strong> 分配了资金方： <strong class='blue-text'>"+data.capital_name+"</strong>" );
      $('#successAlert').removeClass("hidden");
      setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 2000);
    }
  });
});

//不受理订单-》获取数据
$('#ignoreOrderModal').on('show.bs.modal', function (event) {
  var btnThis = $(event.relatedTarget); //触发事件的按钮
  var modal = $(this);  //当前模态框
  $('#orderId').val(btnThis.attr('data-id'));
  $('#orderName').val(btnThis.attr('data-name'));  
  $('#comfirm_name').text(btnThis.attr('data-name'));
});
//不受理订单-》提交数据
$('#submitIgnore').on('click', function () {
  var id = $('#orderId').val();
  var name = $('#orderName').val();
  $('#ignoreOrderModal').modal('hide');
  $.ajax({
    type:'post',
    url:'/ignore_order',
    data: {id : id, name : name, _token:"{{csrf_token()}}"},
    success:function(data){
      $('#successAlert').html("用户 <strong>"+data.msg+"</strong> 的申请已置为不受理");
      $('#successAlert').removeClass("hidden");
      setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 2000);
    }
  });
}); 
</script>
@endsection