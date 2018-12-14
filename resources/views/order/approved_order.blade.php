@extends('layouts.order_list')
@section('approved_nav','active')
@section('approved_order_top','active')

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
              <td><a href="" class="white-text templatemo-sort-by">借款人<span class="caret"></span></a></td>             
              <td><a href="" class="white-text templatemo-sort-by">业务员<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">资金方<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">批款金额<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">状态<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">操作<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">操作<span class="caret"></span></a></td>
               <td><a href="" class="white-text templatemo-sort-by">操作<span class="caret"></span></a></td>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
            <tr>
              <td>{{ $order->name }}</td>
              <td>{{ $order->agent_name }}</td>
              <td>{{ $order->capital_name }}</td>
              <td>{{ $order->approve_amount }}</td>
              <td>
                  @if ($order->repay_status == 1)
                    已完成还款
                  @else
                    正在还款
                  @endif
              </td>
              <td><a href="/order_detail/{{ $order->id }}?status=0" class="templatemo-edit-btn">详情</a></td>
              <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#repayModal" data-name="{{ $order->name }}"  data-capital_name="{{ $order->capital_name }}"  data-id="{{ $order->id }}" data-approve_amount="{{ $order->approve_amount }}" >还款</a></td>
              <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#setRepayStatusModal" data-name="{{ $order->name }}" data-id="{{ $order->id }}" data-approve_amount="{{ $order->approve_amount }}" >完成还款</a></td>
            </tr>
            @endforeach    
          </tbody>
          <tfoot>
            <tr id="paging-margin">
              <td colspan="8" class="text-center">{!! $orders->render() !!}</td>              
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
<!-- 还款模态框 -->
<div class="modal fade" id="repayModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">还款</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="allot_orderId" value="">
        <input type="hidden" id="allot_orderName" value=""> 
        <div id="allotAlert" class="hidden alert alert-success" role="alert"></div>
        <div id="repay_num_warning" class="hidden alert alert-danger" role="alert">请输入还款金额 及 还款时间</div>
        <form class="form-horizontal">
          <div class="form-group">
            <label for="repay_num" class="col-sm-2 control-label">还款金额：</label>
            <div class="col-sm-4">
              <input type="text" id="repay_num" class="form-control" >
            </div> 
            <label for="repay_date" class="col-sm-2 control-label">还款时间：</label>
            <div class="col-sm-4">
              <input type="date" id="repay_date" class="form-control" >
            </div>         
          </div>
        </form>
        <table class="table table-striped table-bordered templatemo-user-table">
          <thead>
            <tr>             
              <td><a href="" class="white-text templatemo-sort-by">借款人<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">资金方<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">借款金额<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">还款金额<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">还款日期<span class="caret"></span></a></td>
            </tr>
          </thead>
          <tbody id="repayments_detail">
          
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
        <button type="button" id="submitAllot" class="btn btn-primary">确定</button>
      </div>
    </div>
  </div>
</div>


<!-- 完成还款模态框 -->
<div class="modal fade" id="setRepayStatusModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">操作提示</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="orderId" value="">
        <input type="hidden" id="orderName" value="">
        <p>确认要将用户 <strong class="blue-text" id="comfirm_name"></strong>&nbsp;|&nbsp;借款金额 <strong class="blue-text" id="comfirm_approve_amount"></strong>的置为<strong class="blue-text">“已完成还款”</strong>吗？</p> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
        <button type="button" id="submitRepayStatus" class="btn btn-primary">确定</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
//还款-》已还金额
$('#repayModal').on('show.bs.modal', function (event) {
  $('#allotAlert').addClass("hidden");
  $('#repay_num_warning').addClass("hidden");
  $('#allotAlert').html('');
  $('#allot_orderId').val('');
  $('#allot_orderName').val('');
  $('#repay_num').val('');
  $('#repay_date').val('');

  var btnThis = $(event.relatedTarget); //触发事件的按钮
  var modal = $(this);  //当前模态框
  var order_id = btnThis.attr('data-id');
  var order_name = btnThis.attr('data-name');
  $('#allot_orderId').val(order_id);
  $('#allot_orderName').val(order_name); 
  var capital_name = btnThis.attr('data-capital_name');
  var approve_amount = btnThis.attr('data-approve_amount');

  $.ajax({
    type:'post',
    url:'/repayments_detail',
    data: {order_id : order_id, _token:"{{csrf_token()}}"},
    success:function(data){
      var jsonarray = eval(data); 
      var html = "";     
      $.each(jsonarray, function (i, n) {
          //alert(n.repay_num);
          html += "<tr><td>"+order_name+"</td><td>"+capital_name+"</td><td>"+approve_amount+"</td><td>"+n.repay_num+"</td><td>"+n.repay_date+"</td></tr>";
      });
      $('#repayments_detail').html(html);
    }
  });

});

//还款-》提交还款金额
$('#submitAllot').on('click', function () {
  var repay_num = $('#repay_num').val();
  var repay_date = $('#repay_date').val();
  if(repay_num.length == 0 || repay_date.length == 0){
    $('#repay_num_warning').removeClass("hidden");
    return null;
  }
  var order_id = $('#allot_orderId').val();
  var order_name = $('#allot_orderName').val(); 
  $('#repayModal').modal('hide');
  $.ajax({
    type:'post',
    url:'/submit_repayment',
    data: {order_id : order_id, order_name : order_name, repay_num : repay_num, repay_date : repay_date, _token:"{{csrf_token()}}"},
    success:function(data){
      $('#successAlert').html("用户 <strong >"+data.order_name+"</strong> 已成功还款： <strong class='blue-text'>"+data.repay_num+"</strong>" );
      $('#successAlert').removeClass("hidden");
      setTimeout(function() { $("#successAlert").addClass("hidden");}, 2000);
    }
  });

});

//完成还款模态框-》获取数据
$('#setRepayStatusModal').on('show.bs.modal', function (event) {
  var btnThis = $(event.relatedTarget); //触发事件的按钮
  var modal = $(this);  //当前模态框
  $('#orderId').val(btnThis.attr('data-id'));
  $('#orderName').val(btnThis.attr('data-name'));  
  $('#comfirm_name').text(btnThis.attr('data-name'));
  $('#comfirm_approve_amount').text(btnThis.attr('data-approve_amount'));
});
//完成还款模态框-》提交数据
$('#submitRepayStatus').on('click', function () {
  var id = $('#orderId').val();
  var name = $('#orderName').val();
  $('#setRepayStatusModal').modal('hide');
  $.ajax({
    type:'post',
    url:'/set_repay_status',
    data: {id : id, name : name, _token:"{{csrf_token()}}"},
    success:function(data){
      $('#successAlert').html("用户 <strong>"+data.msg+"</strong> 的借款已置为已完成还款");
      $('#successAlert').removeClass("hidden");
      setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 2000);
    }
  });
}); 
</script>
@endsection