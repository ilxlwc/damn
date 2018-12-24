@extends('layouts.order_list')

@section('finding_nav','active')
@section('finding_order_top','active')

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
              <td><a href="/order_detail/{{ $order->id }}?status=0" class="templatemo-edit-btn">详情</a></td>
              <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#allotCapitalModal" data-prepare_amount="{{ $order->prepare_amount }}" data-name="{{ $order->name }}" data-id="{{ $order->id }}">批款</a></td>
              <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#intentionOrderModal" data-name="{{ $order->name }}" data-id="{{ $order->id }}">意向资金方</a></td>
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
<!-- 批款模态框 -->
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
        <!--
        <div id="agentInfo" class="alert alert-info" role="alert">
          客户&nbsp;&nbsp;<span id="agent_name"></span>&nbsp;&nbsp;申请金额&nbsp;&nbsp;<span id="prepare_amount"></span>
        </div> -->
        <div id="allotAlert" class="hidden alert alert-success" role="alert"></div>
        <div id="approve_amount_warning" class="hidden alert alert-danger" role="alert">请输入正确的批款金额、还款期数 并 选定一个资金方</div>
        <form class="form-horizontal">
          <div class="form-group">
            <label for="approve_amount" class="col-sm-2 control-label">批款金额：</label>
            <div class="col-sm-3">
              <input type="text" id="approve_amount" class="form-control" >
            </div>
            <label class="col-sm-1"></label>
            <label for="repay_count" class="col-sm-2 control-label">还款期数：</label>
            <div class="col-sm-2">
              <input type="number" id="repay_count" class="form-control">
            </div> 
            <div class="col-sm-2">
              <a id="set_repay_count" class="templatemo-edit-btn">确定</a>
            </div>          
          </div>
        </form>
        <hr/> 
        <div id="repay_count_container">
        </div>

        <table class="table table-striped table-bordered templatemo-user-table">
          <thead>
            <tr>             
              <td><a href="" class="white-text templatemo-sort-by">资金方<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">电话<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">操作<span class="caret"></span></a></td>
            </tr>
          </thead>
          <tbody>
            @foreach ($capitals as $capital)
            <tr>              
              <td>{{ $capital->name }}</td>
              <td>{{ $capital->tel }}</td>
              <td>
                <input class="allotSelected" type="radio" id="{{ $capital->id }}" data-name="{{ $capital->name }}" data-tel="{{ $capital->tel }}" name="capital_id" value="{{ $capital->id }}" >
              </td>
            </tr>
            @endforeach            
          </tbody>
          <tfoot>
            <tr id="paging-margin">
              <td colspan="4" class="text-center">{!! $capitals->render() !!}</td>
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


<!-- 对订单有意向的资金方模态框 -->
<div class="modal fade" id="intentionOrderModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">意向资金方</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="orderId" value="">
        <input type="hidden" id="orderName" value="">

        <table class="table table-striped table-bordered templatemo-user-table">
          <thead>
            <tr>             
              <td><a href="" class="white-text templatemo-sort-by">资金方<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">电话<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">邮箱<span class="caret"></span></a></td>
              <!--
              <td><a href="" class="white-text templatemo-sort-by">其它信息<span class="caret"></span></a></td> -->
            </tr>
          </thead>
          <tbody id="intention_info_lists"> 
                  
          </tbody>         
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">关 闭</button>
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

//批款-》获取数据
$('#allotCapitalModal').on('show.bs.modal', function (event) {
  $(".allotSelected").removeAttr("checked");
  $('#allotAlert').addClass("hidden");
  $('#approve_amount_warning').addClass("hidden");
  $('#allotAlert').html('');
  $('#allot_orderId').val('');
  $('#allot_orderName').val('');
  $('#allot_capitalId').val('');
  $('#allot_capitalName').val('');
  $('#allot_capitalTel').val('');

  $('#approve_amount').val('');
  $('#repay_count').val('');
  $('#repay_count_container').html('');

  $('#agent_name').html('');
  $('#prepare_amount').html('');

  var btnThis = $(event.relatedTarget); //触发事件的按钮
  var modal = $(this);  //当前模态框
  $('#allot_orderId').val(btnThis.attr('data-id'));
  $('#allot_orderName').val(btnThis.attr('data-name'));  
  $('#agent_name').html(btnThis.attr('data-name'));
  $('#prepare_amount').html(btnThis.attr('data-prepare_amount')); 
});

$('.allotSelected').on('click', function (event) {
  var order_name = $('#allot_orderName').val();  
  var capital_id = $(this).val();
  var capital_name = $(this).attr('data-name');
  var capital_tel = $(this).attr('data-tel');
  $('#allotAlert').html("为用户 <strong >"+order_name+"</strong> 的选定资金方为：<strong class='blue-text'>"+capital_name+"</strong>");
  $('#allotAlert').removeClass("hidden");
  $('#allot_capitalId').val(capital_id);
  $('#allot_capitalName').val(capital_name);
  $('#allot_capitalTel').val(capital_tel);
});

$('#set_repay_count').on('click', function (event) {
   var repay_count = $('#repay_count').val();
   //alert(repay_count);
   var html='';
   for(var i=0;i<repay_count; i++){
    html += '<form class="form-horizontal"><div class="form-group">';
    html += '<label class="col-sm-2 control-label">每期还款金额：</label>';
    html += '<div class="col-sm-3"><input type="text" class="repay_num form-control"></div>';
    html += '<label class="col-sm-2 control-label">还款时间：</label>';
    html += '<div class="col-sm-3"><input type="date" class="repay_date form-control"></div>';
    html += '</div></form>';
   }
   $('#repay_count_container').html(html);
   return null;
});

//批款-》提交数据
$('#submitAllot').on('click', function () {
  var order_id = $('#allot_orderId').val();
  var order_name = $('#allot_orderName').val();  
  var capital_name = $('#allot_capitalName').val(); 
  var capital_tel = $('#allot_capitalTel').val(); 
  var approve_amount = $('#approve_amount').val();
  var capital_id = $('#allot_capitalId').val(); 
  var repay_count = $('#repay_count').val();
  if(approve_amount.length == 0 || capital_id.length == 0 || repay_count.length == 0){
    $('#approve_amount_warning').removeClass("hidden");
    return null;
  }
  //获取每一条分期还款记录
  var repaymentsArray=[];
  var forms = $('#repay_count_container form').each(function(){
    var repay_num = $(this).find("input:eq(0)").val();
    var repay_date = $(this).find("input:eq(1)").val();
    if(repay_num.length == 0 || repay_date.length == 0){
      $('#approve_amount_warning').removeClass("hidden");
      return null;
    }
    var repay = {};
    repay["order_id"]=order_id;
    repay["repay_num"]=repay_num;
    repay["repay_date"]=repay_date;
    repaymentsArray.push(repay);
  });
  var repayments = JSON.stringify(repaymentsArray);  
  
  //////////////////////  
  $('#allotCapitalModal').modal('hide');
  $.ajax({
    type:'post',
    url:'/allot_capital_order',
    data: {order_id : order_id, order_name : order_name, capital_id : capital_id, capital_name : capital_name, capital_tel : capital_tel, approve_amount : approve_amount,repayments : repayments, _token:"{{csrf_token()}}"},
    success:function(data){
      $('#successAlert').html("已成功的为用户 <strong >"+data.order_name+"</strong> 分配了资金方： <strong class='blue-text'>"+data.capital_name+"</strong>" );
      $('#successAlert').removeClass("hidden");
      setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 2000);
    }
  });
});

//有意见向资金方-》获取数据
$('#intentionOrderModal').on('show.bs.modal', function (event) {
  $('#intention_info_lists').html("");
  var btnThis = $(event.relatedTarget); //触发事件的按钮
  var id = btnThis.attr('data-id');
  var name = btnThis.attr('data-name');

  $.ajax({
    type:'post',
    url:'/get_order_intention',
    data: {order_id : id, _token:"{{csrf_token()}}"},
    success:function(data){
      var jsonarray = eval(data); 
      var html = "";     
      $.each(jsonarray, function (i, n) {
          html += "<tr><td>"+n.name+"</td><td>"+n.tel+"</td>";
          html += "<td>"+n.email+"</td></tr>";
          //html += "<td>"+n.email+"</td><td>"+n.other_info+"</td></tr>";
      });
      $('#intention_info_lists').html(html);
    }
    });
});
</script>
@endsection