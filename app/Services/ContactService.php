<?php
namespace App\Services;

use App\Mail\AdminReplyToContact;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactService
{
    public function getContactsForIndex()
    {
        return Contact::latest()->paginate(15)->withQueryString();
    }

    public function resolveContact(Contact $contact)
    {
        $contact->is_resolved = true;
        $contact->save();
    }

    public function unresolveContact(Contact $contact)
    {
        $contact->is_resolved = false;
        $contact->save();
    }

    public function deleteContact(Contact $contact)
    {
        $contact->delete();
    }

    public function createContact(array $validatedData): Contact
    {
        return Contact::create($validatedData);
    }

    /**
     * Gửi email phản hồi từ admin tới khách hàng
     *
     * @param array $data
     *      - contact_id (nullable)
     *      - to_email
     *      - subject
     *      - message
     *
     * @return bool true nếu gửi thành công, false nếu có lỗi
     */
    public function sendReplyEmail(array $data): bool
    {
        $to      = $data['to_email'] ?? null;
        $subject = $data['subject'] ?? 'Phản hồi từ GymTech';
        $message = $data['message'] ?? '';

        if (empty($to) || empty($message)) {
            Log::warning('ContactService::sendReplyEmail missing to_email or message', $data);
            return false;
        }

        // Cập nhật replied_at (nếu có contact_id)
        if (! empty($data['contact_id'])) {
            try {
                $contact = Contact::find($data['contact_id']);
                if ($contact) {
                    // Lưu thời gian đã phản hồi
                    $contact->replied_at = now();

                    $contact->save();
                }
            } catch (Throwable $e) {

                Log::error('Failed to update contact replied_at', [
                    'contact_id' => $data['contact_id'] ?? null,
                    'error'      => $e->getMessage(),
                ]);
            }
        }

        // Tạo Mailable
        $mailable = new AdminReplyToContact($subject, $message);

        try {
            // Nếu bạn muốn queue mail (khuyến nghị cho production), uncomment dòng queue và đảm bảo queue worker chạy
            // Mail::to($to)->queue($mailable);

            // Mặc định dùng send (đơn giản, đảm bảo hoạt động nếu chưa cấu hình queue)
            Mail::to($to)->send($mailable);

            return true;
        } catch (Throwable $e) {
            Log::error('ContactService::sendReplyEmail failed to send mail', [
                'to'      => $to,
                'subject' => $subject,
                'error'   => $e->getMessage(),
            ]);

            return false;
        }
    }
}
