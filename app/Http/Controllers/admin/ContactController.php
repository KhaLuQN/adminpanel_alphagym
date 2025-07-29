<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.pages.contacts.index', [
            'contacts' => Contact::latest()->paginate(15)->withQueryString(),
        ]);
    }

    // Đánh dấu là đã xử lý
    public function resolve(Contact $contact)
    {
        $contact->is_resolved = true;
        $contact->save();

        return redirect()->back()->with('success', 'Liên hệ đã được đánh dấu là đã xử lý.');
    }

    // Bỏ đánh dấu xử lý
    public function unresolve(Contact $contact)
    {
        $contact->is_resolved = false;
        $contact->save();

        return redirect()->back()->with('success', 'Liên hệ đã được bỏ đánh dấu xử lý.');
    }

    // Xóa liên hệ
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->back()->with('success', 'Liên hệ đã được xóa.');

    }
}
