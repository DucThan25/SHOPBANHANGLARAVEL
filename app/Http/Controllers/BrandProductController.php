<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class BrandProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add(){
        $this->AuthLogin();
    	return view('admin.add_brand_product');
    }
    //hien thi 
    public function index(){
        $this->AuthLogin();
    	//$all_brand_product = DB::table('tbl_brand')->get();
        $all_brand_product = Brand::orderBy('brand_id','DESC')->get();
    	$manager_brand_product  = view('admin.all_brand_product')->with('all_brand_product',$all_brand_product);
    	return view('admin_layout')->with('admin.all_brand_product', $manager_brand_product);


    }
    public function save(Request $request){
        $this->AuthLogin();
    	// $data = array();
    	// $data['brand_name'] = $request->brand_product_name;
        // $data['brand_slug'] = $request->brand_slug;
    	// $data['brand_desc'] = $request->brand_product_desc;
    	// $data['brand_status'] = $request->brand_product_status;

    	// DB::table('tbl_brand')->insert($data);
        $data = $request ->all();
        $brand = new Brand();
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_slug = $data['brand_slug'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->save();
    	Session::put('message','Thêm thương hiệu sản phẩm thành công');
    	return redirect()->route('admin.brand.add');
    }
    public function unactive($brand_product_id){
        $this->AuthLogin();
        // DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        Brand::where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        Session::put('message','Không kích hoạt thương hiệu sản phẩm thành công');
        return redirect()->route('admin.brand.index');

    }
    public function active($brand_product_id){
        $this->AuthLogin();
        // DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        Brand::where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        Session::put('message','Kích hoạt thương hiệu sản phẩm thành công');
        return redirect()->route('admin.brand.index');

    }
    public function edit($brand_product_id){
        $this->AuthLogin();
        // $edit_brand_product = DB::table('tbl_brand')->where('brand_id',$brand_product_id)->get();
        $edit_brand_product = Brand::where('brand_id',$brand_product_id)->get();
        $manager_brand_product  = view('admin.edit_brand_product')->with('edit_brand_product',$edit_brand_product);

        return view('admin_layout')->with('admin.edit_brand_product', $manager_brand_product);
    }
    public function update(Request $request,$brand_product_id){
        $this->AuthLogin();
        //khong model
        // $data = array();
        // $data['brand_name'] = $request->brand_product_name;
        // $data['brand_slug'] = $request->brand_slug;
        // $data['brand_desc'] = $request->brand_product_desc;
        // DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update($data);

        //co model
        $data = $request ->all();
        $brand = Brand::find($brand_product_id);
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_slug = $data['brand_slug'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->save();
        Session::put('message','Cập nhật thương hiệu sản phẩm thành công');
        return redirect()->route('admin.brand.index');
    }
    public function delete($brand_product_id){
        $this->AuthLogin();
        //DB::table('tbl_brand')->where('brand_id',$brand_product_id)->delete();
        Brand::where('brand_id',$brand_product_id)->delete();
        Session::put('message','Xóa thương hiệu sản phẩm thành công');
        return redirect()->route('admin.brand.index');
    }

    //End Function Admin Page
     //hiển thị sản phâm trên trang người dùng theo từng thương hiệu
     public function show_brand_home($brand_slug){
        $cate_product = Category::where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = Brand::where('brand_status','0')->orderby('brand_id','desc')->get(); 

        $brand_by_slug = Brand::where('brand_slug',$brand_slug)->get();
        
        foreach($brand_by_slug as $key => $brand){
            $brand_id = $brand->brand_id;
        }
        if(isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];
            if($sort_by == 'giam_dan'){
                $brand_by_id = Product::with('brand')->where('brand_id',$brand_id)->orderBy('product_price','DESC')->paginate(6)->appends(request()->query());
            }elseif($sort_by == 'tang_dan'){
                $brand_by_id = Product::with('brand')->where('brand_id',$brand_id)->orderBy('product_price','ASC')->paginate(6)->appends(request()->query());
            }elseif($sort_by == 'kytu_za'){
                $brand_by_id = Product::with('brand')->where('brand_id',$brand_id)->orderBy('product_name','DESC')->paginate(6)->appends(request()->query());
            }elseif($sort_by == 'kytu_az'){
                $brand_by_id = Product::with('brand')->where('brand_id',$brand_id)->orderBy('product_name','ASC')->paginate(6)->appends(request()->query());
            };
        }else{
            $brand_by_id = Product::with('brand')->where('brand_id',$brand_id)->orderBy('product_id','DESC')->paginate(6);
           
        };

        //$brand_by_id = DB::table('tbl_product')->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')->where('tbl_brand.brand_slug',$brand_slug)->get();

        $brand_name = Brand::where('tbl_brand.brand_slug',$brand_slug)->limit(1)->get();

        return view('pages.brand.show_brand')
            ->with('category',$cate_product)
            ->with('brand',$brand_product)
            ->with('brand_by_id',$brand_by_id)
            ->with('brand_name',$brand_name);
    }
}
