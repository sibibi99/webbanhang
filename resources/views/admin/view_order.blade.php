@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông Tin Khách Hàng
    </div>

    <div class="table-responsive">
      <?php
      $message = Session::get('message');
      if($message){
          echo '<p class="text-danger ">'.$message.'</p>';
          Session::put('message',null);
      }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên Khách hàng</th>
            <th>Địa chỉ</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
          <td>{{ $order_by_id->customer_name }}</td>
            <td>{{ $order_by_id->customer_phone }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div> 
<br> <br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông Tin Vận Chuyển
    </div>

    <div class="table-responsive">
      <?php
      $message = Session::get('message');
      if($message){
          echo '<p class="text-danger ">'.$message.'</p>';
          Session::put('message',null);
      }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên Người Nhận</th>
            <th>Số Điện Thoại</th>
            <th>Địa chỉ</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $order_by_id->shipping_name }}</td>
            <td>{{ $order_by_id->shipping_phone }}</td>
            <td>{{ $order_by_id->shipping_address }}</td>

          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div> 
<br> <br>

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt Kê Chi Tiết Đơn Hàng
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên Sản phẩm</th>
            <th>Số Lượng</th>
            <th>Giá</th>
            <th>Tổng Tiền</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $order_by_id->product_name }}</td>
            <td>{{ $order_by_id->product_sales_quantity }}</td>
            <td>{{ $order_by_id->product_price }}</td>
            <td>{{ $order_by_id->product_price*$order_by_id->product_sales_quantity }}</td>

          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection