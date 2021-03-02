<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use App\Events\NewMessage;

class ContactsController extends Controller
{
    public function get(){
      $contacts = User::where('id','!=',auth()->user()->id)->get();

      // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();  

        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
        $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

        $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

        return $contact;
      });

      return response()->json($contacts);
    }

    public function getMessagesFor($id){

      // mark all messages with the selected contact as read
      Message::where('from', $id)->where('to', auth()->id())->update(['read' => true]);

      $messages = Message::where(function($query) use ($id){
        $query->where('from',auth()->id());
        $query->where('to',$id);
      })->orWhere(function($query) use ($id){
        $query->where('from',$id);
        $query->where('to',auth()->id());
      })->with('fromContact')->get();

      return response()->json($messages);
    }

    public function send(Request $request)
    {
      $message = Message::create([
          'from' => auth()->id(),
          'to' => $request->contact_id,
          'message' => $request->message
      ]);

      broadcast(new NewMessage($message));

      return response()->json($message);
    }
}
