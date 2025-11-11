<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Logo;
use App\Models\Contact;
use App\Inquiry;
use DB;
use Auth;
use Hash;

class ContactController extends Controller
{

    public function index()
    {
        $contacts = Contact::all();
        return view('admin.contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'required|email',
            'subject' => 'nullable',
            'message' => 'required',
        ]);

        Contact::create($validatedData);

        return redirect()->route('contacts.index')->with('success', 'Message sent successfully');
    }

    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'required|email',
            'subject' => 'nullable',
            'message' => 'required',
        ]);

        $contact->update($validatedData);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully');
    }

    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            return response()->json(['success' => true, 'message' => 'Contact deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete Contact.'], 500);
        }
    }
}
