/**
 * Created by truongdt on 10/17/2016.
 */
// CLEARABLE INPUT
function tog(v) {
    return v ? 'addClass' : 'removeClass';
}
$(document).on('input', '.clearable', function () {
    $(this)[tog(this.value)]('x');
}).on('mousemove', '.x', function (e) {
    $(this)[tog(this.offsetWidth - 18 < e.clientX - this.getBoundingClientRect().left)]('onX');
}).on('touchstart click', '.onX', function (ev) {
    ev.preventDefault();
    $(this).val('').change();
}).on('ready', function () {
    $(this).find('input.clearable').each(function () {
        if ($(this).val() != '') {
            $(this).addClass('x');
        }
    });

});

$(document).ready(function () {
    if ($('.select2-auto').length) {
        $('.select2-auto').select2({
            // allowClear: true,
            closeOnSelect: true,
            language: {
                noResults: function () {
                    return "Không tìm thấy dữ liệu";
                }
            }
        });
    }

    if ($('.select2-multiple-auto').length) {
        $('.select2-multiple-auto').select2({
            // allowClear: true,
            closeOnSelect: true,
            language: {
                noResults: function () {
                    return "Không tìm thấy dữ liệu";
                }
            }
        });
    }


    if ($('.date-picker').length) {
        $(".date-picker").datepicker(
            {
                format: 'yyyy-mm-dd',
                endDate: new Date()
            }
        );
    }

    if ($('.sorted-table').length) {
        var t = $('.sorted-table').DataTable({
            "columnDefs": [{
                "orderable": false,
                "lengthChange": false,
                "targets": 0

            }],
            "pageLength": -1,
            "bFilter": false,
            "bLengthChange": false,
            "searchable": false,
            "bInfo": false,
            "oLanguage": {
                "sZeroRecords": "Không có dữ liệu"
            }
        });
        t.on('order.dt search.dt', function () {

        }).draw();
    }

    if ($("#role-form").length) {
        $('#role-form').find('.module-box').find('.cb-module').change(function () {
            if ($(this).is(':checked')) {
                $(this).closest('.module-box').find('.function-box').removeClass('display-hide');
            } else {
                $(this).closest('.module-box').find('.function-box').addClass('display-hide');
                $(this).closest('.module-box').find('.cb-function').prop('checked', false);
                $(this).closest('.module-box').find('.cb-right').prop('checked', false);
            }
        });
        $('#role-form').find('.function-box').find('.cb-function').change(function () {
            if ($(this).is(':checked')) {
                $(this).closest('.function-box').find('.right-box').removeClass('display-hide');
                $(this).closest('.function-box').find('.cb-right').prop('checked', true);
            } else {
                $(this).closest('.function-box').find('.right-box').addClass('display-hide');
                $(this).closest('.function-box').find('.cb-right').prop('checked', false);
            }
        });
    }
});

var TableDatatablesManaged = function () {
    var e = function () {
        if ($('.sorted-table-paginate').length) {
            var e = $(".sorted-table-paginate");
            e.dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "Không tìm thấy dữ liệu",
                    info: "Bản ghi: _START_ - _END_ trên _TOTAL_ ",
                    infoEmpty: "Không tìm thấy dữ liệu",
                    infoFiltered: "",
                    lengthMenu: "Hiển thị _MENU_",
                    search: "Tìm kiếm",
                    zeroRecords: "Không tìm thấy dữ liệu",
                    paginate: {previous: "Trang trước", next: "Trang sau", last: "Trang cuối", first: "Trang đầu"}
                },
                lengthMenu: [[10, 20, 30, -1], [10, 20, 30, "Tất cả"]],
                pageLength: 10,
                pagingType: "bootstrap_full_number",
                columnDefs: [{orderable: !1, targets: [0]}, {searchable: !1, targets: [0]}, {className: "dt-right"}],
            });
        }
    };

    return {
        init: function () {
            jQuery().dataTable && (e())
        }
    }
}();
App.isAngularJsApp() === !1 && jQuery(document).ready(function () {
    TableDatatablesManaged.init()
});


var UIBlockUI = function () {

    var handle = function () {
        if ($('.block-button').length) {
            $('.block-button').click(function () {
                App.blockUI({
                    target: 'body',
                    animate: true
                });

                $(window).load(function () {
                    App.unblockUI('body');
                });
            });
        }

        $(document).ready(function () {
            App.blockUI({
                target: 'body',
                animate: true
            });

            $(window).load(function () {
                App.unblockUI('body');
            });
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            handle();
        }
    };
}();

jQuery(document).ready(function () {
    UIBlockUI.init();
});

var ComponentsEditors = function () {
    var handleSummernote = function () {

        if ($('.summernote').length) {
            $('.summernote').summernote({height: 300});
            //API:
            //var sHTML = $('#summernote_1').code(); // get code
            //$('#summernote_1').destroy(); // destroy
        }
    };

    return {
        //main function to initiate the module
        init: function () {
            handleSummernote();
        }
    };

}();

jQuery(document).ready(function () {
    ComponentsEditors.init();
});

function convertToSlug(str) {
    // Chuyển hết sang chữ thường
    str = str.toLowerCase();

    // xóa dấu
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');

    // Xóa ký tự đặc biệt
    str = str.replace(/([^0-9a-z-\s])/g, '');

    // Xóa khoảng trắng thay bằng ký tự -
    str = str.replace(/(\s+)/g, '-');

    // xóa phần dự - ở đầu
    str = str.replace(/^-+/g, '');

    // xóa phần dư - ở cuối
    str = str.replace(/-+$/g, '');

    // return
    return str;
}