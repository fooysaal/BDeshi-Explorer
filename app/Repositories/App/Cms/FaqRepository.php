<?php

namespace App\Repositories\App\Cms;

use App\Models\App\Cms\Faq;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class FaqRepository extends Repository
{
    public function all()
    {
        return Faq::withTrashed()->orderBy('created_at', 'desc')->get();
    }

    public function create(Request $request)
    {
        $faq = new Faq();
        $faq->faq_category_id = $request->faq_category_id;
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->is_active = 1;

        $faq->save();
    }

    public function update(Request $request, Model $model)
    {
        $statusButtonKey = config('app-view.statusButton.name');

        if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
            return $this->changeStatus($model);
        }

        $model->faq_category_id = $request->faq_category_id;
        $model->question = $request->question;
        $model->answer = $request->answer;
        $model->is_active = 1;

        $model->update();
    }

    public function findById($id)
    {
    }
}
