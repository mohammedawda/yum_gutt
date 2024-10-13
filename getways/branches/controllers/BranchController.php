<?php

namespace getways\settings\controllers;

use App\Http\Controllers\Controller;
use getways\settings\requests\BranchStoreRequest;
use getways\settings\requests\BranchUpdateRequest;
use getways\settings\requests\QuestionStoreRequest;
use getways\settings\requests\QuestionUpdateRequest;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        return loadGetway('settings')->branchIndex($request);
    }
    public function store(BranchStoreRequest $request)
    {
        return loadGetway('settings')->branchStore($request);
    }
    public function show(Request $request,$id)
    {
        return loadGetway('settings')->branchShow($request,$id);
    }
    public function update(BranchUpdateRequest $request,$id)
    {
        return loadGetway('settings')->branchUpdate($request,$id);
    }
    public function destroy(Request $request,$id)
    {
        return loadGetway('settings')->branchDestroy($id);
    }
    public function change_status(Request $request,$id)
    {
        return loadGetway('settings')->branchChangeStatus($request,$id);
    }

}
