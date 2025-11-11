<?php

namespace App\Repositories\App\Cms;

use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Models\App\Cms\ContactUsQuery;
use Illuminate\Database\Eloquent\Model;

class ContactUsQueryRepository extends Repository
{
    public function all()
    {
        return ContactUsQuery::withTrashed()
        ->where('message_form', 'ContactForm')
        ->orderBy('created_at', 'desc')
        ->get();
    }
    public function getBookedQueries()
    {
        return ContactUsQuery::withTrashed()
            ->where('message_form', 'BookingForm')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create(Request $request)
    {
        $query = new ContactUsQuery();

        $query->name = $request->name;
        $query->message_form = 'ContactForm';
        $query->email = $request->email;
        $query->mobile = $request->mobile;
        $query->subject = $request->subject;
        $query->query_message = $request->query_message;
        $query->is_read = 0;

        $query->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Your message has been sent successfully!'
        ]);
    }

    public function update(Request $request, Model $model)
    {
        $statusButtonKey = config('app-view.statusButton.name');

        if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
            return $this->changeStatus($model, 'is_read');
        }

        $model->name = $request->name ?? $model->name;
        $model->email = $request->email ?? $model->email;
        $model->subject = $request->subject ?? $model->subject;
        $model->query_message = $request->query_message ?? $model->query_message;
        $model->query_notes = $request->query_notes ?? $model->query_notes;

        $model->update();
    }

    public function findById($id)
    {
        $query = ContactUsQuery::findOrFail($id);

        return $query;
    }
}
