@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
                        
    @foreach($category_name as $key => $name)
    
    <h2 class="title text-center">{{$name->category_name}}</h2>

    @endforeach
    <div class="row" style="padding: 17px ; margin-bottom: 20px" >    
        <div class="col-md-4">
            <label for="amount">Sắp xếp theo</label>
            <form>
                @csrf
                <select name="sort" id="sort" class="form-control">
                    <option value="{{Request::url()}}?sort_by=none">--lọc--</option>
                    <option value="{{Request::url()}}?sort_by=tang_dan">Theo Giá tăng dần</option>
                    <option value="{{Request::url()}}?sort_by=giam_dan">Theo Giá giảm dần</option>
                    <option value="{{Request::url()}}?sort_by=kytu_az">Theo tên từ A đến Z</option>
                    <option value="{{Request::url()}}?sort_by=kytu_za">Theo tên từ Z đến A</option>
                </select>
            </form>
        </div>
    </div>
    @foreach($category_by_id as $key => $product)
    {{-- click hiển thị thông tin chi tiết --}}
    <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_slug)}}">
    <div class="col-sm-4">
        <div class="product-image-wrapper">

            <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                        <h2>{{$product->product_name}}</h2>
                        <h5>{{number_format($product->product_price,0,',','.').' '.'VNĐ'}}</h5>
                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                    </div>
                    
            </div>

            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích1</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>So sánh1</a></li>
                </ul>
            </div>
        </div>
    </div>
    </a>
    @endforeach
</div><!--features_items-->
        <!--/recommended_items-->
@endsection