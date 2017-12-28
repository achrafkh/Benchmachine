<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitationRequest;
use App\Invitation;
use App\Mail\InvitationEmail;
use Illuminate\Http\Request;
use Mail;

class InvitationsController extends Controller
{
    public function index()
    {
        return view('admin.invitations.index');
    }

    public function generate(InvitationRequest $request)
    {
        $invitation = new Invitation;
        $invitation->user_id = $request->user_id;
        if ($request->has('email')) {
            $invitation->invited_email = $request->email;
        }
        if ($request->has('max')) {
            $invitation->max = $request->max;
        }
        $invitation->type = $request->type;

        $invitation->id = str_random(15) . '|' . time();
        $invitation->save();

        if ($request->has('email')) {
            Mail::to($invitation->invited_email)->send(new InvitationEmail(['invitation' => $invitation->toarray()]));
        }

        return response()->json(['status' => 1, 'invitation' => $invitation]);
    }

    public function getInvitations(Request $request)
    {
        return datatables()->eloquent(Invitation::with('sender', 'reciever'))
            ->addColumn('senderName', function (Invitation $ivt) {

                return $ivt->sender->name;
            })
            ->addColumn('recieverName', function (Invitation $ivt) {
                if (isset($ivt->reciever)) {
                    return $ivt->reciever->name;
                }
                return '';
            })

            ->toJson();
    }

    public function delete($id)
    {
        $invite = Invitation::find($id);

        if (is_null($invite)) {
            return response()->json(['status' => 1]);
        }

        return response()->json(['status' => $invite->delete()]);
    }
}
