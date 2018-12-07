@extends('layouts.order_list')

@section('approved_nav','active')

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
              <td><a href="" class="white-text templatemo-sort-by">名字<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">电话<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">微信名<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">注册时间<span class="caret"></span></a></td>
              <td><a href="" class="white-text templatemo-sort-by">操作<span class="caret"></span></a></td>
            </tr>
          </thead>
          <tbody>
            @foreach ($agents as $agent)
            <tr>
              <td>{{ $agent->name }}</td>
              <td>{{ $agent->tel }}</td>
              <td>{{ $agent->nickName }}</td>
              <td>{{ $agent->created_at }}</td>
              <td><a href="" class="templatemo-edit-btn" data-toggle="modal" data-target="#changeIdentityModal" data-identity="借贷人" data-name="{{ $agent->name }}" data-id="{{ $agent->id }}">删除该成员</a></td>
            </tr>
            @endforeach            
          </tbody>
          <tfoot>
            <tr id="paging-margin">
              <td colspan="5" class="text-center">{!! $agents->render() !!}</td>              
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


@endsection

@section('javascript')
<script type="text/javascript">
     
</script>
@endsection