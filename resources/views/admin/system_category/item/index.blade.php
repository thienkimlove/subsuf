@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}
@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Quản lý Danh mục</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Sản phẩm</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\ItemController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm Sản phẩm
            </a>
        </div>
    </div>
@endsection

@section('pagetitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa fa-pied-piper font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách Sản phẩm</span>
                    </div>
                </div>

                <div class="portlet-body">
                    {{Form::open(['action' => 'Admin\ItemController@index', 'method' => 'GET', 'id' => 'item-search'])}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-sm" style="margin-bottom: 0">
                                <select name="category_id" id="category_id" class="form-control input-sm select2-auto">
                                    <option value="" selected>--- Nhóm hàng hóa ---</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->category_id}}"
                                                @if(old('category_id') == $category->category_id) selected @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group form-group-sm" style="margin-bottom: 0">
                                <select name="brand_id" id="brand_id" class="form-control input-sm select2-auto">
                                    <option value="" selected>--- Thương hiệu ---</option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->brand_id}}"
                                                @if(old('brand_id') == $brand->brand_id) selected @endif>{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fa fa-search" style="margin-top: 8px"></i>
                                    <input class="form-control input-sm clearable" type="text" name="name"
                                           id="name" value="{{old('name')}}" placeholder="Tìm kiếm Sản phẩm...">
                                </div>
                                <span class="input-group-btn">
                                    <a role="button" class="btn btn-sm default block-button" id="reset">
                                        <i class="fa fa-refresh"></i>
                                        Reset
                                    </a>
                                    <button id="search_location" class="btn btn-sm btn-success" type="submit">
                                        Tìm kiếm
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px">
                        <div class="col-md-4">
                            <div class="form-group form-group-sm">
                                <div class="mt-checkbox-list" style="padding: 0 !important">
                                    <label class="mt-checkbox"> Sản phẩm giảm giá
                                        <input type="checkbox" value="1" name="is_sale" id="is_sale"
                                               @if(old("is_sale")) checked @endif>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group form-group-sm">
                                <div class="mt-checkbox-list" style="padding: 0 !important">
                                    <label class="mt-checkbox"> Sản phẩm nổi bật
                                        <input type="checkbox" value="1" name="featured"
                                               id="featured" @if(old("featured")) checked @endif>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}

                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th width="1px">Ảnh</th>
                                    <th>Sản phẩm</th>
                                    <th class="fit">Giá</th>
                                    <th width="150px">Thương hiệu</th>
                                    <th width="100px">Nhóm hàng</th>
                                    <th width="100px">Ưu tiên</th>
                                    <th width="100px">Hiển thị</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $key => $item)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td align="center" height="40px">
                                            @if($item->image != '')
                                                <img src="{{$item->image}}" alt=""
                                                     style="max-width: 40px; max-height: 40px">
                                            @else
                                                <i class="fa fa fa-pied-piper"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{URL::action('Admin\ItemController@update', $item->item_id)}}">
                                                {{$item->name}}
                                            </a>

                                            @if($item->featured == 1)
                                                <strong class="font-red">(*)</strong>
                                            @endif

                                            @if($item->link != '')
                                                <a href="{{$item->link}}">
                                                    <i class="fa fa-link black tooltips m-r-0"
                                                       title="Đến trang {{$item->name}}"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td align="right">
                                            <span @if($item->is_sale) style="text-decoration: line-through"
                                                  @else class="bold" @endif>
                                                ${{number_format($item->price, 2)}}
                                            </span>
                                            @if($item->is_sale)
                                                <br>
                                                <span class="bold font-red">
                                                    ${{number_format($item->price_sale, 2)}}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{isset($item->brand) ? $item->brand->name : ''}}</td>
                                        <td>{{isset($item->category) ? $item->category->name : ''}}</td>
                                        <td align="center">{{$item->item_order}}</td>
                                        <td>
                                            @if($item->is_showed)
                                                Có
                                            @else
                                                Không
                                            @endif
                                        </td>
                                        <td class="action">
                                            {{--<a type="button" class="btn btn-xs btn-primary tooltips m-r-0" title="Xem"--}}
                                            {{--href="{{URL::action('Admin\ItemController@info', $item->item_id)}}">--}}
                                            {{--<i class="fa fa-eye"></i>--}}
                                            {{--</a>--}}

                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\ItemController@update', $item->item_id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa"
                                               onclick="return confirm('Xóa Sản phẩm {{$item->name}}?');"
                                               href="{{URL::action('Admin\ItemController@delete', $item->item_id)}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">{!!  $items->appends(Request::except('page'))->links() !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}

    <script>
        $("#reset").click(function () {
            window.location.href = "{{URL::current()}}";
        });
    </script>
@endsection