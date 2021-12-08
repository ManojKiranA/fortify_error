@extends('layouts.backend')

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection

@section('js_after')
    <!-- jQuery (required for DataTables plugin) -->
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('js/pages/tables_datatables.js') }}"></script>


    <script>
        initTags()


        function initTags() {
            var url = "{!!route('TagsGetFilter')!!}";
            oTable = $('.js-dataTable-full').dataTable({
                "language": {
                    "emptyTable": "No tags found"
                },
                "bServerSide": true,
                "sAjaxSource": url,
                "bProcessing": true,
                "aoColumns": [
                    {
                        "mData": 'id'
                    },
                    {
                        "sWidth": "30%",
                        "mData": 'title'
                    },
                    {
                        "sWidth": "20%",
                        "mData": 'active_label'
                    },
                    {
                        "sWidth": "20%",
                        "mData": 'created_at_formatted'
                    },

                    {
                    "mData": null,
                    "bSortable": false,
                    "mRender": function (data, type, full) {
                        console.log('data::')
                        console.log(data)

                        return '<div>\n\
        <a class="btn btn-sm btn-success btn-icon m-2" href="' + data['edit_url'] + '"  title="Edit tag"><i class="fas fa-edit icon-nm"></i></a>\n\
        <a data-id="' + data[0] + '" class="btn btn-sm btn-danger btn-icon delete_this m-2" href="javascript:;"  title="Delete tag"><i class="fas fa-trash-alt icon-nm mb-1 "></i></a>\n\
    </div>';
                    }
                }]
            });
        } // function initTags() {

        function loadTags() {
            $('.js-dataTable-full').DataTable().clear();
            $('.js-dataTable-full').DataTable().ajax.reload();
        }
    </script>


@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        {{ __('Список ярлыков') }}
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        {{ __('Используются для детализации загруженных фотографий') }}
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('home') }}">{{ __('Домой') }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{ __('Список ярлыков') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- TAGS LISTING -->
    <div class="content">

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <small>{{ __('Вы можете искать, создавать, редактировать, удалять ярлыки') }}</small>
                </h3>
                <div class="d-flex justify-content-end">
                    <a href="{!!route('tags.create')!!}" class="btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add
                    </a>
                </div>
            </div>


            <div class="block-content block-content-full">

                <table class="table table-bordered table-striped table-vcenter js-dataTable-full fs-sm">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">#</th>
                        <th>{{ __('Наименование') }}</th>
                        <th>{{ __('Активен') }}</th>
                        <th>{{ __('Создан') }}</th>
                        <th>{{ __('Операции') }}</th>
                    </tr>
                    </thead>

                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>

    </div>

    <!-- END TAGS LISTING -->

@endsection
