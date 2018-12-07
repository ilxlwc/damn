@extends('layouts.order_list')
@section('css')
<link href="../css/swipebox.css" rel="stylesheet">
<link href="../css/portfolio.css" rel="stylesheet">
@endsection
@section('checking_nav','active')

@section('content')      
<div class="templatemo-content-widget white-bg">
  <h2 class="margin-bottom-10 blue-text"><strong>订单详情</strong></h2>
  <p>业务员：<span class="blue-text">{{ $order->agent_name }}</span>&nbsp;|&nbsp;电话：<span class="blue-text">{{ $order->agent_tel }}</span></p>
  <div class="panel panel-default no-border">
    <div class="panel-heading border-radius-10">
      <h2>基本资料</h2>
    </div>
    <div class="panel-body">
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>借款金额：</label><span class="blue-text">{{ $order->prepare_amount }}</span></div>
        <div class="col-1"><label>业务类型：</label><span class="blue-text">{{ $order->service_type }}</span></div> 
      </div>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>收费：</label><span class="blue-text">{{ $order->charge }}</span></div>
        <div class="col-1"><label>返费：</label><span class="blue-text">{{ $order->returnfee }}</span></div> 
      </div>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>评估来源：</label><span class="blue-text">{{ $order->assess_source }}</span></div>
        <div class="col-1"><label>评估单价：</label><span class="blue-text">{{ $order->assess_unit_price }}</span></div>
        <div class="col-1"><label>评估总额：</label><span class="blue-text">{{ $order->assess_gross_amount }}</span></div> 
      </div>
    </div> 
  </div>            
  <div class="panel panel-default no-border">
    <div class="panel-heading border-radius-10">
      <h2>个人信息</h2>
    </div>
    <div class="panel-body">
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>姓名：</label><span class="blue-text">{{ $order->name }}</span></div>
        <div class="col-1"><label>年龄：</label><span class="blue-text">{{ $order->age }}</span></div>
        <div class="col-1"><label>姓别：</label><span class="blue-text">{{ $order->gender }}</span></div>
      </div>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>身份证号：</label><span class="blue-text">{{ $order->idcard }}</span></div>
        <div class="col-1"><label>联系电话：</label><span class="blue-text">{{ $order->tel }}</span></div>
        <div class="col-1"><label>婚姻状况：</label><span class="blue-text">{{ $order->marital_status }}</span></div>
      </div><hr/>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>共借人关系：</label><span class="blue-text">{{ $order->coborrower_relation }}</span></div>
        <div class="col-1"><label>共借人姓名：</label><span class="blue-text">{{ $order->coborrower_name }}</span></div>
        <div class="col-1"><label>共借人姓别：</label><span class="blue-text">{{ $order->coborrower_gender }}</span></div>
      </div>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>共借人身份证号：</label><span class="blue-text">{{ $order->coborrower_idcard }}</span></div>
        <div class="col-1"><label>共借人联系电话：</label><span class="blue-text">{{ $order->coborrower_tel }}</span></div>
      </div><hr/>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>信用记录是否空白：</label><span class="blue-text">{{ $order->credit_record }}</span></div>
        <div class="col-1"><label>是否包含止付，冻结，杂帐：</label><span class="blue-text">{{ $order->credit_record_status }}</span></div>
        <div class="col-1"><label>当前是否逾期：</label><span class="blue-text">{{ $order->overdue }}</span></div>
      </div>
    </div> 
  </div>
  <div class="panel panel-default no-border">
    <div class="panel-heading border-radius-10">
      <h2>资产信息</h2>
    </div>
    <div class="panel-body">
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>房产类型：</label><span class="blue-text">{{ $order->house_type }}</span></div>
        <div class="col-2"><label>产权人：</label><span class="blue-text">{{ $order->house_owner }}</span>&nbsp;|&nbsp;<span class="blue-text">{{ $order->owner_type }}</span></div>
      </div>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>房产地址：</label><span class="blue-text">{{ $order->house_address }}</span></div>
        <div class="col-1"><label>权属证明：</label><span class="blue-text">{{ $order->house_owner_certificate }}</span></div>
      </div>
    </div>  
  </div>
  <div class="panel panel-default no-border">
    <div class="panel-heading border-radius-10">
      <h2>附件资料</h2>
    </div>
    <div class="panel-body">
      @foreach ($attachments as $attachment)
      <div class="col-md-4 col-sm-4 col-xs-6 padding-10">
        <div class="agileinfo-effect wow fadeInUp animated" data-wow-delay=".3s">
          <a href="{{ $attachment->url }}" class="swipebox" title="{{ $attachment->file_desc }}">
            <img src="{{ $attachment->url }}" alt="{{ $attachment->file_desc }}" class="img-responsive" />
            <div class="figcaption">
              <p>{{ $attachment->file_desc }}</p>
            </div>
          </a>  
        </div>
      </div>
      @endforeach
      <div class="clearfix"> </div>
    </div> 
    <div class="text-center">
      <button type="button" data-id="{{ $order->id }}" id="submitToFindingOrder" class="btn btn-success btn-lg">资料验证通过，进行寻款</button>
    </div>
  </div>
</div>
@endsection

@section('otherModel')


@endsection

@section('javascript')
<!-- swipe box js -->
<script src="../js/jquery.swipebox.min.js"></script> 
<script type="text/javascript">
$(document).ready(function($){$(".swipebox").swipebox();});

//资料验证通过，进行寻款
$('#submitToFindingOrder').on('click', function () {
  var id = $(this).attr("data-id");
  $.ajax({
    type:'post',
    url:'/to_finding_order',
    data: {id : id, _token:"{{csrf_token()}}"},
    success:function(data){
      window.location.href = "/checking_order";
    }
  });
}); 

</script>
@endsection