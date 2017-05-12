@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}

    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}

    {{Html::style('assets/global/plugins/bootstrap-summernote/summernote.css')}}
@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i> </a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Quản lý Danh mục</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{URL::action('Admin\ItemController@index')}}">Sản phẩm</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thêm Sản phẩm</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')

@endsection

@section('pagetitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa fa-pied-piper font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Thêm Sản phẩm</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => 'Admin\ItemController@insert', 'method' => 'POST', 'files' => true,
                    'id' => 'insert-item', 'data-toggle'=>'validator'])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Nhóm hàng hóa
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <select name="category_id" id="category_id" required
                                            class="form-control input-sm select2-auto">
                                        <option value="" selected>--- Chọn nhóm hàng hóa ---</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->category_id}}"
                                                    @if(old('category_id') == $category->category_id) selected @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Thương hiệu
                                    </label>
                                    <select name="brand_id" id="brand_id" class="form-control input-sm select2-auto">
                                        <option value="0" selected>--- Chọn thương hiệu ---</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->brand_id}}"
                                                    @if(old('brand_id') == $brand->brand_id) selected @endif>{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên Sản phẩm Tiếng Việt
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="name_vi" id="name_vi" class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên Sản phẩm Tiếng Anh
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="name_en" id="name_en" class="form-control">
                                </div>



                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Giá tiền ($)
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="number" step="any" name="price" id="price"
                                           class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Nhãn
                                    </label>
                                    <input type="text" name="label" id="label" class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Link web
                                    </label>
                                    <input type="text" name="link" id="link" class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Sản phẩm nổi bật
                                    </label>
                                    <div class="mt-checkbox-list" style="padding: 0 !important">
                                        <label class="mt-checkbox"> Nổi bật
                                            <input type="checkbox" value="1" name="featured">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Ưu tiên
                                    </label>
                                    <input required type="text" name="item_order" id="item_order"
                                           class="form-control" value="1">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Giảm giá
                                    </label>
                                    <div class="mt-checkbox-list" style="padding: 0 !important">
                                        <label class="mt-checkbox"> Giảm giá
                                            <input type="checkbox" value="1" name="is_sale" id="is_sale">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm" id="div_sale" hidden>
                                    <label class="control-label">
                                        Giá sale ($)
                                    </label>
                                    <input type="number" step="any" name="price_sale" id="price_sale" value="0"
                                           class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">Hiển thị</label>
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="is_showed" value="1">
                                            Có
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="is_showed" value="0" checked>
                                            Không
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="control-label">Ảnh</label>
                                <div class="form-group form-group-sm">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                            <img src="http://www.placehold.it/200x200/EFEFEF/AAAAAA&amp;text=no+image"/>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                             style="max-width: 200px; max-height: 200px;">
                                        </div>

                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Chọn ảnh </span>
                                                <span class="fileinput-exists"> Đổi ảnh </span>
                                                <input class="form-control" type="file" name="image" id="image">
                                            </span>
                                            <a href="javascript:;" class="btn default fileinput-exists"
                                               data-dismiss="fileinput"> Xóa ảnh </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">
                                        Mô tả Tiếng Việt
                                    </label>
                                    <textarea class="form-control summernote" rows="5" name="description_vi"></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">
                                        Mô tả Tiếng Anh
                                    </label>
                                    <textarea class="form-control summernote" rows="5" name="description_en"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <button type="submit" class="btn btn-sm green uppercase">
                            Lưu
                        </button>
                        <a role="button" class="btn btn-sm btn-default uppercase"
                           href="{{URL::action('Admin\ItemController@index')}}">
                            Hủy
                        </a>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('assets/pages/scripts/validator.min.js')}}
    {{Html::script('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}
    {{Html::script('assets/global/plugins/bootstrap-summernote/summernote.min.js')}}

    <script>
        $("#is_sale").change(function () {
            if ($("#is_sale").is(':checked')) {
                $("#div_sale").prop("hidden", false);
            } else {
                $("#div_sale").prop("hidden", true);
            }
        })
    </script>
@endsection