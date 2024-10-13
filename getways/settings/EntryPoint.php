<?php

namespace getways\settings;

use getways\settings\logic\Branch;
use getways\settings\logic\Question;
use getways\settings\logic\Setting;
use getways\settings\repositories\BranchRepository;
use getways\settings\repositories\QuestionRepository;
use getways\settings\repositories\SettingRepository;

class EntryPoint
{
    public function setting()
    {
        $setting_obj = new Setting(new SettingRepository());
        return $setting_obj->setting();
    }
    public function updateSetting($request)
    {
        $setting_obj = new Setting(new SettingRepository());
        return $setting_obj->updateSetting($request);
    }
    public function questionIndex($request)
    {
        $index_obj = new Question(new QuestionRepository());
        return $index_obj->index($request);
    }
    public function questionStore($request)
    {
        $store_obj = new Question(new QuestionRepository());
        return $store_obj->store($request);
    }
    public function questionShow($request,$id)
    {
        $show_obj = new Question(new QuestionRepository());
        return $show_obj->show($request,$id);
    }
    public function questionUpdate($request,$id)
    {
        $update_obj = new Question(new QuestionRepository());
        return $update_obj->update($request,$id);
    }
    public function questionDestroy($id)
    {
        $destroy_obj = new Question(new QuestionRepository());
        return $destroy_obj->delete($id);
    }
    public function questionAnswerDestroy($id)
    {
        $destroy_obj = new Question(new QuestionRepository());
        return $destroy_obj->deleteAnswer($id);
    }
    public function questionChangeStatus($request,$id)
    {
        $change_status_obj = new Question(new QuestionRepository());
        return $change_status_obj->changeStatus($id);
    }
    public function branchIndex($request)
    {
        $index_obj = new Branch(new BranchRepository());
        return $index_obj->index($request);
    }
    public function branchStore($request)
    {
        $store_obj = new Branch(new BranchRepository());
        return $store_obj->store($request);
    }
    public function branchShow($request,$id)
    {
        $show_obj = new Branch(new BranchRepository());
        return $show_obj->show($request,$id);
    }
    public function branchUpdate($request,$id)
    {
        $update_obj = new Branch(new BranchRepository());
        return $update_obj->update($request,$id);
    }
    public function branchDestroy($id)
    {
        $destroy_obj = new Branch(new BranchRepository());
        return $destroy_obj->delete($id);
    }
    public function branchChangeStatus($request,$id)
    {
        $change_status_obj = new Branch(new BranchRepository());
        return $change_status_obj->changeStatus($id);
    }

}
