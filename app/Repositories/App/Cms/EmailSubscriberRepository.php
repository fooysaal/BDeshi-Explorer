<?php

namespace App\Repositories\App\Cms;

use Illuminate\Http\Request;
use Illuminate\Config\Repository;
use App\Models\App\Cms\EmailSubscriber;
use Illuminate\Database\Eloquent\Model;

class EmailSubscriberRepository extends Repository
{
    public function all()
    {
        return EmailSubscriber::withTrashed()->orderBy('created_at', 'desc')->get();
    }

    public function create(Request $request)
    {
        $query = new EmailSubscriber();
        $query->email = $request->email;
        $query->is_active = 1;
        $query->save();
    }

    public function update(Request $request, Model $model)
    {
        $statusButtonKey = config('app-view.statusButton.name');

        if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
            return $this->changeStatus($model, 'is_active');       }


        $model->update();
    }

    public function findById($id)
    {
        $query = EmailSubscriber::findOrFail($id);

        return $query;
    }
}
