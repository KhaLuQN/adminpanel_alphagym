<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các mẫu email.
     */
    public function index()
    {
        $templates = EmailTemplate::latest()->paginate(10);
        return view('admin.pages.emails.email-templates.index', compact('templates'));
    }

    /**
     * Hiển thị form để tạo mẫu email mới.
     */
    public function create()
    {
        return view('admin.pages.emails.email-templates.create');
    }

    /**
     * Lưu một mẫu email mới vào database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        EmailTemplate::create($validatedData);

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Đã tạo mẫu email thành công!');
    }

    /**
     * Hiển thị form để chỉnh sửa một mẫu email.
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.pages.emails.email-templates.create', ['template' => $emailTemplate]);
    }

    /**
     * Cập nhật một mẫu email trong database.
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        $emailTemplate->update($validatedData);

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Đã cập nhật mẫu email thành công!');
    }

    /**
     * Xóa một mẫu email.
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Đã xóa mẫu email thành công!');
    }
}
