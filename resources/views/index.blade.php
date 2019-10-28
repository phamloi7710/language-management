@extends('woo-commerce::admin.general.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('language::language.language_management')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('woo.admin.index')}}">@lang('language::language.dashboard')</a></li>
                            <li class="breadcrumb-item"><a href="#">@lang('language::language.management')</a></li>
                            <li class="breadcrumb-item active">@lang('language::language.language_management')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5 load-animation">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ request()->has('locale') ? __('language::language.edit_language') : __('language::language.add_new_language') }}</h3>
                            </div>
                            <form action="{{request()->has('locale') ? route('language.update', ['locale' => $lang->locale]) : route('language.store')}}" method="POST" role="form">
                                @if(request()->has('locale'))
                                    @method('patch')
                                @endif
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="sltLocale">@lang('language::language.select_language')</label>
                                        <input type="hidden" id="language_flag_path" value="/app-assets/language/flags/">
                                        <select name="sltLocale" class="form-control select-locale">
                                            <option value="">@lang('language::language.select_language')</option>
                                            @foreach ($languages as $key => $language)
                                                <option value="{{ $key }}" {{request()->has('locale') && $key === $lang->locale ? 'selected' : ''}}> {{ $language[2] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtDisplayName">@lang('language::language.display_name')</label>
                                        <input value="{{request()->has('locale') ? $lang->name : old('txtDisplayName')}}" name="txtDisplayName" type="text" class="form-control {{$errors->has('txtDisplayName') ? 'is-invalid' : ''}}" placeholder="@lang('language::language.display_name')">
                                        @if($errors->has('txtDisplayName'))
                                            <div class="invalid-feedback">{{$errors->first('txtDisplayName')}}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="status">@lang('language::language.status')</label>
                                        <div class="icheck-success">
                                            <input value="true" type="radio" id="true" name="status" {!! request()->has('locale') && $lang->status == 'true' ? 'checked' : '' !!}{!! !request()->has('locale') ? 'checked' : '' !!}>
                                            <label for="true" class="text-success">
                                                @lang('language::language.active')
                                            </label>
                                        </div>
                                        <div class="icheck-danger">
                                            <input value="false" type="radio" id="false" name="status" {!! request()->has('locale') && $lang->status == 'false' ? 'checked' : '' !!}>
                                            <label for="false" class="text-danger">
                                                @lang('language::language.inactive')
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    @if(request()->has('locale'))
                                        <button type="submit" class="btn btn-primary float-right">@lang('language::language.update_changes')</button>
                                    @else
                                        <button type="submit" class="btn btn-primary float-right">@lang('language::language.save_changes')</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">@lang('language::language.list_language')</h5>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm">
                                        <li class="page-item"><a href="#" class="page-link text-primary">«</a></li>
                                        <li class="page-item"><a href="#" class="page-link text-primary">1</a></li>
                                        <li class="page-item"><a href="#" class="page-link text-primary">2</a></li>
                                        <li class="page-item"><a href="#" class="page-link text-primary">3</a></li>
                                        <li class="page-item"><a href="#" class="page-link text-primary">»</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center">@lang('language::language.display_name')</th>
                                            <th class="text-center">@lang('language::language.flag')</th>
                                            <th class="text-center">@lang('language::language.status')</th>
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($languageData as $language)
                                        <tr class="lang-row-{{$language->id}}">
                                            <td class="text-center"> {{$language->name}}</td>
                                            <td class="text-center"><img src="{{asset('app-assets/language/flags/'.$language->locale).'.png'}}" alt=""></td>
                                            <td class="text-center">{!! $language->status == 'true' ? '<span class="badge bg-success">'.__('language::language.active').'</span>' : '<span class="badge bg-danger">'.__('language::language.inactive').'</span>' !!}</td>
                                            <td class="text-center">
                                                <a href="{{route('language.index', ['locale' =>$language->locale])}}"><i class="fas fa-edit"></i></a>
                                                <a href="javascript:;" class="delete-language" data-id="{{$language->id}}"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    @translations('language')
@stop
@section('script')
<script>

</script>
@stop
