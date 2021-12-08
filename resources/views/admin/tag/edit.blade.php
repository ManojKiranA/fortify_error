@extends('layouts.backend')



@section('js_after')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\TagRequest') !!}

    <script>
        console.log('INIT::')
    </script>


@endsection


@section('content')

    <!-- TAG EDITOR TITLE BLOCK-->
    <div class="bg-body-light">
        $errors::{{ var_dump($errors) }}<br>
        $is_insert::{{ var_dump($is_insert) }}<br>
        $tagData::{{ var_dump($tagData) }}
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        {{ __('Редактор ярлыка') }}
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        {{ __($is_insert ? 'Создание нового ярлыка' : 'Изменение ярлыка') }}
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('home') }}">{{ __('Домой') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('tags.index') }}">{{ __('Список ярлыков') }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{ __('Редактор ярлыка') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END TAG EDITOR TITLE BLOCK-->

    <!-- TAG EDITOR BLOCK -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Заполните все поля ярлыка') }}</h3>
            </div>
            <div class="block-content block-content-full">


                <form action="{{ route(  'tags.' . ( $is_insert ? 'store' : 'update' ) , $tagData->id ?? null ) }}" method="POST" enctype="multipart/form-data" id="form_tag_edit">
                    @csrf
                    @if(!$is_insert)
                    @method('PUT')
                    @endif

                    <div class="row">

                        @if(!$is_insert)
                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="tag_id">{{ __('ID ярлыка') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control text-end" id="tag_id" name="id"
                                       readonly value="{{ $tagData->id ?? ''}}">
                            </div>
                        </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="tag_title">
                                    {{ __('Наименование ярлыка') }}
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control mb-2" id="tag_title" name="title"
                                       value="{{ old('title', $tagData->title ?? '') }}"
                                       placeholder="{{ __('Введите строку описание ярлыка') }}">
                                @error('title')
                                <p class="validation_error">{{ $message }}</p>
                                @enderror

                            </div>
                        </div>

                        @if(!$is_insert)
                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="tag_slug">{{ __('Slug') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="tag_slug" name="slug"
                                       readonly value="{{ $tagData->slug ?? '' }}">
                            </div>
                        </div>
                        @endif


                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="tag_active">{{ __('Активен') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input class="form-check-input" type="checkbox" value="1" @if($tagData->active ?? '') checked @endif
                                       id="tag_active" name="active">
                                <label class="form-check-label" for="tag_active"></label>
                            </div>
                        </div>

                        @if(!$is_insert)
                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="tag_created_at">{{ __('Создан') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="tag_created_at" name="created_at"
                                       readonly value="{{ getFormattedDateTime($tagData->created_at ?? '') }}">
                            </div>
                        </div>
                        @endif

                        @if(!$is_insert && $tagData->updated_at)
                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="tag_updated_at">{{ __('Изменен') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="tag_updated_at" name="updated_at"
                                       readonly value="{{ getFormattedDateTime($tagData->updated_at ?? '') }}">
                            </div>
                        </div>
                        @endif


                        <div class="d-flex justify-content-end">
                            <div class="mr-auto">&nbsp;</div>
                            <div class="m-2" >
                                <a type="button" href="{{ route('tags.index') }}" class="btn btn-secondary">
                                    {{ __('Отмена') }}
                                </a>
                            </div>
                            <div class="m-2">
                                <button type="submit" class="btn btn-primary mx-4 ">
                                    {{ __($is_insert ? 'Создать' : 'Изменить') }}
                                </button>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>

    </div>
    <!-- END TAG EDITOR BLOCK -->

@endsection
