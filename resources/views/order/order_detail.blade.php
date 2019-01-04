@extends('layouts.order_list')
@section('css')
<link href="../css/swipebox.css" rel="stylesheet">
<link href="../css/portfolio.css" rel="stylesheet">
@endsection


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
        <div class="col-1">
          <label>年龄：</label><span class="blue-text">{{ $order->age }}</span>
        </div>
        <div class="col-1"><label>姓别：</label><span class="blue-text">
            @if ($order->gender == 0)
              未知
            @elseif ($order->gender == 1)
              男
            @elseif ($order->gender == 2)
              女
            @else
              {{ $order->gender }}
            @endif
        </span></div>
      </div>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>身份证号：</label><span class="blue-text">{{ $order->idcard }}</span></div>
        <div class="col-1"><label>联系电话：</label><span class="blue-text">{{ $order->tel }}</span></div>
        <div class="col-1"><label>婚姻状况：</label><span class="blue-text">
           @if ($order->marital_status == 0)
              未婚
            @elseif ($order->marital_status == 1)
              已婚
            @elseif ($order->marital_status == 2)
              离异
            @else
              {{ $order->marital_status }}
            @endif
        </span></div>
      </div><hr/>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>共借人关系：</label><span class="blue-text">{{ $order->coborrower_relation }}</span></div>
        <div class="col-1"><label>共借人姓名：</label><span class="blue-text">{{ $order->coborrower_name }}</span></div>
        <div class="col-1"><label>共借人姓别：</label><span class="blue-text">
           @if ($order->coborrower_gender == 0)
              未知
            @elseif ($order->coborrower_gender == 1)
              男
            @elseif ($order->coborrower_gender == 2)
              女
            @else
              {{ $order->coborrower_gender }}
            @endif
        </span></div>
      </div>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>共借人身份证号：</label><span class="blue-text">{{ $order->coborrower_idcard }}</span></div>
        <div class="col-1"><label>共借人联系电话：</label><span class="blue-text">{{ $order->coborrower_tel }}</span></div>
      </div><hr/>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>信用记录是否空白：</label><span class="blue-text">
            @if ($order->credit_record == 0)
              空白
            @elseif ($order->credit_record == 1)
              非空白
            @else
              {{ $order->credit_record }}
            @endif
          </span></div>
        <div class="col-1"><label>是否包含止付，冻结，呆帐：</label><span class="blue-text">
          @if ($order->credit_record_status == 0)
              止付
            @elseif ($order->credit_record_status == 1)
              冻结
            @elseif ($order->credit_record_status == 2)
              杂帐
            @else
              {{ $order->credit_record_status }}
            @endif
        </span></div>
        <div class="col-1"><label>逾期记录：</label><span class="blue-text">{{ $order->overdue }}</span></div>
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
    @if (Request::get('status') == 1)
    <div class="text-center">
      <button type="button" data-agent_id="{{ $order->agent_id }}" data-name="{{ $order->name }}" data-tel="{{ $order->tel }}" data-id="{{ $order->id }}" id="submitToFindingOrder" class="btn btn-success btn-lg">资料验证通过，进行寻款</button>
    </div>
    @endif
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
  var agent_id = $(this).attr("data-agent_id");
  var name = $(this).attr("data-name");
  var tel = $(this).attr("data-tel");
  $.ajax({
    type:'post',
    url:'/to_finding_order',
    data: {id : id, agent_id : agent_id, name : name, tel : tel, _token:"{{csrf_token()}}"},
    success:function(data){
      window.location.href = "/checking_order";
    }
  });
}); 

</script>
@endsection