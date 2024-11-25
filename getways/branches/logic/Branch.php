<?php

namespace getways\settings\logic;

use Exception;
use getways\settings\repositories\BranchRepository;
use getways\settings\resources\BranchResource;
use Illuminate\Support\Facades\Log;

class Branch
{
    public function __construct(private readonly BranchRepository $branchRepository)
    {
    }

    public function index($request)
    {
        try {
            $criteria = $this->branchRepository->index($request);

            return sendListResponse(true, __('All branches'), $criteria['count'], $criteria['total'], $criteria['last_page'], BranchResource::collection($criteria['list']));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('all branches exception'), null, $em, 500);
        }
    }

    public function store($request)
    {
        try {
            $store_data = $request->validated();
            $response_data =   new BranchResource($this->branchRepository->storeBranch($store_data));
            return sendResponse(true, __('A branch is created successfully'), $response_data);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('create branch exception'), null, $em, 500);
        }
    }
    public function show($request,$id)
    {
        try {
            $branch = $this->branchRepository->branchDetails($id);
            if ($branch['status']){
                $response_data =   new BranchResource($branch['data']);
                return sendResponse(true, __('Branch data'), $response_data);
            }
            return sendResponse(true, $branch['message'], []);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('show branch exception'), null, $em, 500);
        }
    }

    public function update($request, $id)
    {
        try {
            $branch = $this->branchRepository->branchDetails($id);
            if ($branch['status']){
                $update_data = $request->validated();
                $this->branchRepository->updateBranch($update_data,$branch['data']);
                $newBranch = $this->branchRepository->branchDetails($id);
                $response_data =   new BranchResource($newBranch['data']);
                return sendResponse(true, __('Branch data'), $response_data);
            }
            return sendResponse(true, $branch['message'], []);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('create branch exception'), null, $em, 500);
        }
    }

    public function changeStatus($id)
    {
        try {
            $branch = $this->branchRepository->branchDetails($id);
            if ($branch['status']){
                $this->branchRepository->branchChangeStatus($branch['data']);
                $newBranch = $this->branchRepository->branchDetails($id);
                $response_data =   new BranchResource($newBranch['data']);
                return sendResponse(true, __('Status changed successfully'), $response_data);
            }
            return sendResponse(true, $branch['message'], []);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('create branch exception'), null, $em, 500);
        }
    }

    public function delete($id)
    {
        try {
            $branch = $this->branchRepository->branchDetails($id);
            if ($branch['status']){
                $branch['data']->delete();
                return sendResponse(true, __('Branch deleted successfully'), []);
            }
            return sendResponse(true, $branch['message'], []);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('create branch exception'), null, $em, 500);
        }
    }

}
