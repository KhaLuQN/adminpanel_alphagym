<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\ContactService;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index()
    {
        return view('admin.pages.contacts.index', [
            'contacts' => $this->contactService->getContactsForIndex(),
        ]);
    }

    public function resolve(Contact $contact)
    {
        $this->contactService->resolveContact($contact);
        return redirect()->back()->with('success', 'Liên hệ đã được đánh dấu là đã xử lý.');
    }

    public function unresolve(Contact $contact)
    {
        $this->contactService->unresolveContact($contact);
        return redirect()->back()->with('success', 'Liên hệ đã được bỏ đánh dấu xử lý.');
    }

    // Xóa liên hệ
    public function destroy(Contact $contact)
    {
        $this->contactService->deleteContact($contact);
        return redirect()->back()->with('success', 'Liên hệ đã được xóa thành công.');
    }
}
