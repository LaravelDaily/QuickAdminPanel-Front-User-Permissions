<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\CrmCustomer;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrmCustomerRequest;
use App\Http\Requests\UpdateCrmCustomerRequest;
use App\Http\Resources\Admin\CrmCustomerResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CrmCustomerApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('crm_customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmCustomerResource(CrmCustomer::with(['status'])->get());
    }

    public function store(StoreCrmCustomerRequest $request)
    {
        $crmCustomer = CrmCustomer::create($request->all());

        return (new CrmCustomerResource($crmCustomer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CrmCustomer $crmCustomer)
    {
        abort_if(Gate::denies('crm_customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmCustomerResource($crmCustomer->load(['status']));
    }

    public function update(UpdateCrmCustomerRequest $request, CrmCustomer $crmCustomer)
    {
        $crmCustomer->update($request->all());

        return (new CrmCustomerResource($crmCustomer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CrmCustomer $crmCustomer)
    {
        abort_if(Gate::denies('crm_customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmCustomer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
