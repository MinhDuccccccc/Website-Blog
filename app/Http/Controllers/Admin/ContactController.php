<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::paginate(20);

       return view('admin.contact.list', compact("contacts"));
    }

    public function delete($id)
    {
        Contact::find($id)->delete();
        return redirect()->route('admin.contact.index')->with('success', 'Deleted successfully');
    }
}
