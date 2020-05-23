@extends('layouts.admin')
@section('content')
@can('crm_note_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.crm-notes.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.crmNote.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.crmNote.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CrmNote">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.crmNote.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmNote.fields.customer') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmNote.fields.note') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($crmNotes as $key => $crmNote)
                        <tr data-entry-id="{{ $crmNote->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $crmNote->id ?? '' }}
                            </td>
                            <td>
                                {{ $crmNote->customer->first_name ?? '' }}
                            </td>
                            <td>
                                {{ $crmNote->note ?? '' }}
                            </td>
                            <td>
                                @can('crm_note_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.crm-notes.show', $crmNote->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('crm_note_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.crm-notes.edit', $crmNote->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('crm_note_delete')
                                    <form action="{{ route('admin.crm-notes.destroy', $crmNote->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('crm_note_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.crm-notes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-CrmNote:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection