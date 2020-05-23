<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\CrmNote;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrmNoteRequest;
use App\Http\Requests\UpdateCrmNoteRequest;
use App\Http\Resources\Admin\CrmNoteResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CrmNoteApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('crm_note_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmNoteResource(CrmNote::with(['customer'])->get());
    }

    public function store(StoreCrmNoteRequest $request)
    {
        $crmNote = CrmNote::create($request->all());

        return (new CrmNoteResource($crmNote))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CrmNote $crmNote)
    {
        abort_if(Gate::denies('crm_note_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmNoteResource($crmNote->load(['customer']));
    }

    public function update(UpdateCrmNoteRequest $request, CrmNote $crmNote)
    {
        $crmNote->update($request->all());

        return (new CrmNoteResource($crmNote))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CrmNote $crmNote)
    {
        abort_if(Gate::denies('crm_note_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmNote->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
