@extends('layouts.order_list')
@section('css')
<link href="../css/swipebox.css" rel="stylesheet">
<link href="../css/portfolio.css" rel="stylesheet">
@endsection


@section('content')      
<div class="templatemo-content-widget white-bg">
  <div id="successAlert" class="hidden alert alert-success" role="alert"></div>   
  <h2 class="margin-bottom-10 blue-text"><strong>订单详情</strong></h2>
  <p>业务员：<span class="blue-text">{{ $order->agent_name }}</span>&nbsp;|&nbsp;电话：<span class="blue-text">{{ $order->agent_tel }}</span></p>
  <div class="panel panel-default no-border">
    <div class="panel-heading border-radius-10">
      <h2>基本资料</h2>
      <input type="hidden" id="order_id" value="{{ $order->id }}">
    </div>
    <div class="panel-body">
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>借款金额：</label><span class="blue-text" id="prepare_amount">{{ $order->prepare_amount }}</span>&nbsp;<i data-key="prepare_amount" data-value="{{ $order->prepare_amount }}" data-keytext="借款金额：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-1"><label>业务类型：</label><span class="blue-text" id="service_type">{{ $order->service_type }}</span>&nbsp;<i data-key="service_type" data-value="{{ $order->service_type }}" data-keytext="业务类型：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div> 
      </div>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>收费：</label><span class="blue-text" id="charge">{{ $order->charge }}</span>&nbsp;<i data-key="charge" data-value="{{ $order->charge }}" data-keytext="收费：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-1"><label>返费：</label><span class="blue-text" id="returnfee">{{ $order->returnfee }}</span>&nbsp;<i data-key="returnfee" data-value="{{ $order->returnfee }}" data-keytext="返费：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div> 
      </div>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>评估来源：</label><span class="blue-text" id="assess_source">{{ $order->assess_source }}</span>&nbsp;<i data-key="assess_source" data-value="{{ $order->assess_source }}" data-keytext="评估来源：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-1"><label>评估单价：</label><span class="blue-text" id="assess_unit_price">{{ $order->assess_unit_price }}</span>&nbsp;<i data-key="assess_unit_price" data-value="{{ $order->assess_unit_price }}" data-keytext="评估单价：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-1"><label>评估总额：</label><span class="blue-text" id="assess_gross_amount">{{ $order->assess_gross_amount }}</span>&nbsp;<i data-key="assess_gross_amount" data-value="{{ $order->assess_gross_amount }}" data-keytext="评估总额：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div> 
      </div>
    </div> 
  </div>            
  <div class="panel panel-default no-border">
    <div class="panel-heading border-radius-10">
      <h2>个人信息</h2>
    </div>
    <div class="panel-body">
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>姓名：</label><span class="blue-text" id="name">{{ $order->name }}</span>&nbsp;<i data-key="name" data-value="{{ $order->name }}" data-keytext="姓名：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-1"><label>年龄：</label><span class="blue-text" id="age">{{ $order->age }}</span>&nbsp;<i data-key="age" data-value="{{ $order->age }}" data-keytext="年龄：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-1"><label>姓别：</label><span class="blue-text" id="gender">
          @if ($order->gender == 0)
              未知
            @elseif ($order->gender == 1)
              男
            @elseif ($order->gender == 2)
              女
            @else
              {{ $order->gender }}
            @endif
        </span>&nbsp;<i data-key="gender" data-value="{{ $order->gender }}" data-keytext="姓别：" class="fa fa-edit" data-toggle="modal" data-target="#changeSelectModal"></i></div>
      </div>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>身份证号：</label><span class="blue-text" id="idcard">{{ $order->idcard }}</span>&nbsp;<i data-key="idcard" data-value="{{ $order->idcard }}" data-keytext="身份证号：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-1"><label>联系电话：</label><span class="blue-text" id="tel">{{ $order->tel }}</span>&nbsp;<i data-key="tel" data-value="{{ $order->tel }}" data-keytext="联系电话：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-1"><label>婚姻状况：</label><span class="blue-text" id="marital_status">
          @if ($order->marital_status == 0)
              未婚
            @elseif ($order->marital_status == 1)
              已婚
            @elseif ($order->marital_status == 2)
              离异
            @else
              {{ $order->marital_status }}
            @endif
        </span>&nbsp;<i data-key="marital_status" data-value="{{ $order->marital_status }}" data-keytext="婚姻状况：" class="fa fa-edit" data-toggle="modal" data-target="#changeSelectModal"></i></div>
      </div><hr/>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>共借人关系：</label><span class="blue-text" id="coborrower_relation">{{ $order->coborrower_relation }}</span>&nbsp;<i data-key="coborrower_relation" data-value="{{ $order->coborrower_relation }}" data-keytext="共借人关系：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-1"><label>共借人姓名：</label><span class="blue-text" id="coborrower_name">{{ $order->coborrower_name }}</span>&nbsp;<i data-key="coborrower_name" data-value="{{ $order->coborrower_name }}" data-keytext="共借人姓名：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-1"><label>共借人姓别：</label><span class="blue-text" id="coborrower_gender">
           @if ($order->coborrower_gender == 0)
              未知
            @elseif ($order->coborrower_gender == 1)
              男
            @elseif ($order->coborrower_gender == 2)
              女
            @else
              {{ $order->coborrower_gender }}
            @endif
        </span>&nbsp;<i data-key="coborrower_gender" data-value="{{ $order->coborrower_gender }}" data-keytext="共借人姓别：" class="fa fa-edit" data-toggle="modal" data-target="#changeSelectModal"></i></div>
      </div>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>共借人身份证号：</label><span class="blue-text" id="coborrower_idcard">{{ $order->coborrower_idcard }}</span>&nbsp;<i data-key="coborrower_idcard" data-value="{{ $order->coborrower_idcard }}" data-keytext="共借人身份证号：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-1"><label>共借人联系电话：</label><span class="blue-text" id="coborrower_tel">{{ $order->coborrower_tel }}</span>&nbsp;<i data-key="coborrower_tel" data-value="{{ $order->coborrower_tel }}" data-keytext="共借人联系电话：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
      </div><hr/>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>信用记录是否空白：</label><span class="blue-text" id="credit_record">
           @if ($order->credit_record == 0)
              空白
            @elseif ($order->credit_record == 1)
              非空白
            @else
              {{ $order->credit_record }}
            @endif
        </span>&nbsp;<i data-key="credit_record" data-value="{{ $order->credit_record }}" data-keytext="信用记录是否空白：" class="fa fa-edit" data-toggle="modal" data-target="#changeSelectModal"></i></div>
        <div class="col-1"><label>止付，冻结，杂帐：</label><span class="blue-text" id="credit_record_status">
           @if ($order->credit_record_status == 0)
              止付
            @elseif ($order->credit_record_status == 1)
              冻结
            @elseif ($order->credit_record_status == 2)
              杂帐
            @else
              {{ $order->credit_record_status }}
            @endif
        </span>&nbsp;<i data-key="credit_record_status" data-value="{{ $order->credit_record_status }}" data-keytext="是否包含止付，冻结，杂帐：" class="fa fa-edit" data-toggle="modal" data-target="#changeSelectModal"></i></div>
        <div class="col-1"><label>当前是否逾期：</label><span class="blue-text" id="overdue">{{ $order->overdue }}</span>&nbsp;<i data-key="overdue" data-value="{{ $order->overdue }}" data-keytext="当前是否逾期：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
      </div>
    </div> 
  </div>
  <div class="panel panel-default no-border">
    <div class="panel-heading border-radius-10">
      <h2>资产信息</h2>
    </div>
    <div class="panel-body">
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>房产类型：</label><span class="blue-text" id="house_type">{{ $order->house_type }}</span>&nbsp;<i data-key="house_type" data-value="{{ $order->house_type }}" data-keytext="房产类型：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-2"><label>产权人：</label><span class="blue-text" id="house_owner">{{ $order->house_owner }}</span>&nbsp;<i data-key="house_owner" data-value="{{ $order->house_owner }}" data-keytext="产权人：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i>&nbsp;|&nbsp;<span class="blue-text" id="owner_type">{{ $order->owner_type }}</span>&nbsp;<i data-key="owner_type" data-value="{{ $order->owner_type }}" data-keytext="拥有类型：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
      </div>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1"><label>房产地址：</label><span class="blue-text" id="house_address">{{ $order->house_address }}</span>&nbsp;<i data-key="house_address" data-value="{{ $order->house_address }}" data-keytext="房产地址：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
        <div class="col-1"><label>权属证明：</label><span class="blue-text" id="house_owner_certificate">{{ $order->house_owner_certificate }}</span>&nbsp;<i data-key="house_owner_certificate" data-value="{{ $order->house_owner_certificate }}" data-keytext="权属证明：" class="fa fa-edit" data-toggle="modal" data-target="#changeModal"></i></div>
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
      <input type="hidden" name="order_id" value="{{ $order->id }}">
      <div class="row form-group margin-bottom-0">
        <div class="col-lg-12">
          <label class="control-label templatemo-block">上传新附件</label>           
          <input type="file" name="fileToUpload" id="fileToUpload" class="filestyle" data-buttonName="btn-primary" data-buttonBefore="true" data-icon="false" required>
        </div>
      </div>
      <div class="row form-group margin-bottom-0">
        <div class="col-lg-12 form-group margin-bottom-0"> 
           <label class="control-label templatemo-block">附件类型</label>                   
            <div class="margin-right-15 templatemo-inline-block">
              <input type="radio" class="hidden" name="file_type" id="r1" value="0">
              <label for="r1" class="font-weight-400"><span></span>身份证</label>
            </div>
            <div class="margin-right-15 templatemo-inline-block">
              <input type="radio" class="hidden" name="file_type" id="r2" value="1">
              <label for="r2" class="font-weight-400"><span></span>户口本</label>
            </div>
            <div class="margin-right-15 templatemo-inline-block">
              <input type="radio" class="hidden" name="file_type" id="r3" value="2">
              <label for="r3" class="font-weight-400"><span></span>婚姻证明</label>
            </div>
            <div class="margin-right-15 templatemo-inline-block">
              <input type="radio" class="hidden" name="file_type" id="r4" value="3">
              <label for="r4" class="font-weight-400"><span></span>征信记录</label>
            </div>
            <div class="margin-right-15 templatemo-inline-block">
              <input type="radio" class="hidden" name="file_type" id="r5" value="4">
              <label for="r5" class="font-weight-400"><span></span>房产证图片</label>
            </div>
            <div class="margin-right-15 templatemo-inline-block">
              <input type="radio" class="hidden" name="file_type" id="r6" value="5">
              <label for="r6" class="font-weight-400"><span></span>营业执照或工作证明</label>
            </div>
            <div class="margin-right-15 templatemo-inline-block">
              <input type="radio" class="hidden" name="file_type" id="r7" value="6">
              <label for="r7" class="font-weight-400"><span></span>流水私发</label>
            </div>
            <div class="margin-right-15 templatemo-inline-block">
              <input type="radio" class="hidden" name="file_type" id="r8" value="7">
              <label for="r8" class="font-weight-400"><span></span>评估截图</label>
            </div>
            <div class="margin-right-15 templatemo-inline-block">
              <input type="radio" class="hidden" name="file_type" id="r9" value="8" checked>
              <label for="r9" class="font-weight-400"><span></span>其它补充材料</label>
            </div>
        </div>
      </div>
      <div class="row form-group text-center margin-bottom-0">
        <a class="templatemo-blue-button" onclick="doUpload()">上传</a>
      </div> 
      </form>
      <hr/>

      @foreach ($attachments as $attachment)
      <div class="col-md-4 col-sm-4 col-xs-6 padding-10">
        <div class="agileinfo-effect wow fadeInUp animated" data-wow-delay=".3s">
          <a href="{{ $attachment->original_url }}" class="swipebox" title="{{ $attachment->file_desc }}">
            <img src="{{ $attachment->url }}" alt="{{ $attachment->file_desc }}" class="img-responsive" />
            <div class="figcaption">
              <p>{{ $attachment->file_desc }}</p>
            </div>
          </a>  
        </div>
        <p>&nbsp;<i class="fa fa-trash" data-id="{{ $attachment->id }}" data-toggle="modal" data-target="#submitDeleteModal" style="font-size:20px;color:red"></i></p>
      </div>
      @endforeach
      <div class="clearfix"> </div>
    </div> 
  </div>
</div>
@endsection

@section('otherModel')
<div class="modal fade" id="changeModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">修改信息</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="key" value="">
        <form class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-12">
              <p class="blue-text" id="keytext"></p>
              <input type="text" id="value" class="form-control">
            </div> 
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
        <button type="button" id="submitChange" class="btn btn-primary">确定</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="changeSelectModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">修改信息</h4>
      </div> 
      <div class="modal-body">
        <input type="hidden" id="changeType" value="">
        <form class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-12">
              <p class="blue-text" id="description"></p>
              <div id="gender-radio" class="blue-text hidden">
                  <input type="radio" name="gender" value="0" data-label="未知"><label>未知</label>&nbsp;&nbsp;
                  <input type="radio" name="gender" value="1" data-label="男"><label>男</label>&nbsp;&nbsp;
                  <input type="radio" name="gender" value="2" data-label="女"><label>女</label>
              </div>
              <div id="marital_status-radio" class="blue-text hidden">
                  <input type="radio" name="marital_status" value="0" data-label="未婚"><label>未婚</label>&nbsp;&nbsp;
                  <input type="radio" name="marital_status" value="1" data-label="已婚"><label>已婚</label>&nbsp;&nbsp;
                  <input type="radio" name="marital_status" value="2" data-label="离异"><label>离异</label>
              </div>
              <div id="coborrower_gender-radio" class="blue-text hidden">
                  <input type="radio" name="coborrower_gender" value="0" data-label="未知"><label>未知</label>&nbsp;&nbsp;
                  <input type="radio" name="coborrower_gender" value="1" data-label="男"><label>男</label>&nbsp;&nbsp;
                  <input type="radio" name="coborrower_gender" value="2" data-label="女"><label>女</label>
              </div>
              <div id="credit_record-radio" class="blue-text hidden">
                  <input type="radio" name="credit_record" value="0" data-label="空白"><label>空白</label>&nbsp;&nbsp;
                  <input type="radio" name="credit_record" value="1" data-label="非空白"><label>非空白</label>
              </div>
              <div id="credit_record_status-radio" class="blue-text hidden">
                  <input type="radio" name="credit_record_status" value="0" data-label="止付"><label>止付</label>&nbsp;&nbsp;
                  <input type="radio" name="credit_record_status" value="1" data-label="冻结"><label>冻结</label>&nbsp;&nbsp;
                  <input type="radio" name="credit_record_status" value="2" data-label="杂帐"><label>杂帐</label>
              </div>
            </div> 
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
        <button type="button" id="submitSelectChange" class="btn btn-primary">确定</button>
      </div>
    </div>
  </div>
</div>

<!-- 不受理订单模态框 -->
<div class="modal fade" id="submitDeleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">操作提示</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="attachmentId" value="">
        <p><strong class="blue-text" id="comfirm_name">确认要将该附件资料删除吗？</strong></p> 
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

//更改信息-》获取数据
$('#changeModal').on('show.bs.modal', function (event) {
  var btnThis = $(event.relatedTarget); //触发事件的按钮
  $('#key').val(btnThis.attr('data-key'));
  $('#value').val(btnThis.attr('data-value'));
  $('#keytext').text(btnThis.attr('data-keytext'));
});

//更改信息-》提交数据
$('#submitChange').on('click', function () {
  var id = $('#order_id').val();
  var key = $('#key').val();
  var value = $('#value').val();
  $('#key').val('');
  $('#value').val('');
  $('#changeModal').modal('hide');
  $.ajax({
    type:'post',
    url:'/sumbit_change_order',
    data: {id : id, key : key, value : value, _token:"{{csrf_token()}}"},
    success:function(data){
     $("#"+key+"").text(value);
    }
  });
});

//更改信息-》获取数据
$('#changeSelectModal').on('show.bs.modal', function (event) {
  var btnThis = $(event.relatedTarget); //触发事件的按钮
  var key = btnThis.attr('data-key');
  var value = btnThis.attr('data-value');
  $("#"+key+"-radio").removeClass("hidden");
  $("#"+key+"-radio input[type='radio'][name='"+key+"'][value='"+value+"']").prop("checked", true);
  $('#description').text(btnThis.attr('data-keytext'));
  $('#changeType').val(key);
});

//更改信息-》提交数据
$('#submitSelectChange').on('click', function () {
  var id = $('#order_id').val();
  var key = $('#changeType').val();
  var value = $("#"+key+"-radio input[type='radio'][name='"+key+"']:checked").val();
  var label = $("#"+key+"-radio input[type='radio'][name='"+key+"']:checked").attr('data-label');
  $('#changeType').val('');
  $("#"+key+"-radio").addClass("hidden");
  $('#description').text('');
  $('#changeSelectModal').modal('hide');
  $.ajax({
    type:'post',
    url:'/sumbit_change_order',
    data: {id : id, key : key, value : value, _token:"{{csrf_token()}}"},
    success:function(data){
     $("#"+key+"").text(label);
    }
  });
});






//删除附件-》获取数据
$('#submitDeleteModal').on('show.bs.modal', function (event) {
  var btnThis = $(event.relatedTarget); //触发事件的按钮
  $('#attachmentId').val(btnThis.attr('data-id')); 
});

//删除附件-》提交数据
$('#submitDelete').on('click', function () {
  var id = $('#attachmentId').val();
  $('#attachmentId').val('');
  $('#submitDeleteModal').modal('hide');
  $.ajax({
    type:'post',
    url:'/delete_attachment_order',
    data: {id : id, _token:"{{csrf_token()}}"},
    success:function(data){
      $('#successAlert').html("该附件资料已经被删除");
      $('#successAlert').removeClass("hidden");
     setTimeout(function() { $("#successAlert").addClass("hidden"); location.reload();}, 2000);
    }
  });
});


function doUpload() {
    var formData = new FormData($("#photoForm")[0]);
    console.log(formData);
    $.ajax({
        url: '/upload_attachment',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            setTimeout(function(){location.reload();}, 1000);
        }
    });
}


</script>
@endsection