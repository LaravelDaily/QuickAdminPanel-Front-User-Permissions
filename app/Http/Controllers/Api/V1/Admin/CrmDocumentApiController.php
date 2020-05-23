<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\CrmDocument;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCrmDocumentRequest;
use App\Http\Requests\UpdateCrmDocumentRequest;
use App\Http\Resources\Admin\CrmDocumentResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CrmDocumentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('crm_document_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmDocumentResource(CrmDocument::with(['customer'])->get());
    }

    public function store(StoreCrmDocumentRequest $request)
    {
        $crmDocument = CrmDocument::create($request->all());

        if ($request->input('document_file', false)) {
            $crmDocument->addMedia(storage_path('tmp/uploads/' . $request->input('document_file')))->toMediaCollection('document_file');
        }

        return (new CrmDocumentResource($crmDocument))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CrmDocument $crmDocument)
    {
        abort_if(Gate::denies('crm_document_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmDocumentResource($crmDocument->load(['customer']));
    }

    public function update(UpdateCrmDocumentRequest $request, CrmDocument $crmDocument)
    {
        $crmDocument->update($request->all());

        if ($request->input('document_file', false)) {
            if (!$crmDocument->document_file || $request->input('document_file') !== $crmDocument->document_file->file_name) {
                $crmDocument->addMedia(storage_path('tmp/uploads/' . $request->input('document_file')))->toMediaCollection('document_file');
            }
        } elseif ($crmDocument->document_file) {
            $crmDocument->document_file->delete();
        }

        return (new CrmDocumentResource($crmDocument))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CrmDocument $crmDocument)
    {
        abort_if(Gate::denies('crm_document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmDocument->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
