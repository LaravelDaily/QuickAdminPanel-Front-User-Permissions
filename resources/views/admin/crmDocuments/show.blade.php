@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.crmDocument.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crm-documents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.crmDocument.fields.id') }}
                        </th>
                        <td>
                            {{ $crmDocument->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmDocument.fields.customer') }}
                        </th>
                        <td>
                            {{ $crmDocument->customer->first_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmDocument.fields.document_file') }}
                        </th>
                        <td>
                            @if($crmDocument->document_file)
                                <a href="{{ $crmDocument->document_file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmDocument.fields.name') }}
                        </th>
                        <td>
                            {{ $crmDocument->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.crmDocument.fields.description') }}
                        </th>
                        <td>
                            {{ $crmDocument->description }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.crm-documents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection