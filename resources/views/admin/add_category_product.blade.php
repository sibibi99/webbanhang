@extends('admin_layout')
@section('admin_content')
<section class="panel">
  <header class="panel-heading">
      Thêm Danh Mục Sản Phẩm
  </header>

  <div class="panel-body">
      <div class="position-center">
          <form role="form" action="{{URL::to('/save-category-product')}}" method="post">
            {{csrf_field()}}
          <div class="form-group">
              <label for="exampleInputEmail1">Tên Danh Mục</label>
              <input type="text" name="category_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
          </div>
          <div class="form-group">
              <label for="exampleInputPassword1">Mô tả danh mục</label>
              <textarea style="resize: none" rows="6"  name="category_product_desc" class="form-control" id="exampleInputPassword1" value="Mô tả danh mục"></textarea>
          </div>

          <div class="checkbox">
            <label for="exampleInputPassword1">Hiển Thị</label>
            <select name="category_product_status" class="form-control input-sm m-bot15">
              <option value="1" selected >Ẩn</option>
              <option value="0">Hiển thị</option>
          </select>
          </div>
          <button type="submit" name="add_category_product" class="btn btn-info">Thêm Danh Mục</button>
      </form>
      </div>

  </div>
</section>
@endsection