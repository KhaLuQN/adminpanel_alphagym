<?php

namespace App\Services;

use App\Models\EmailTemplate;

class EmailTemplateService
{
    public function getTemplatesForIndex()
    {
        return EmailTemplate::latest()->paginate(10);
    }

    public function createEmailTemplate(array $validatedData): EmailTemplate
    {
        return EmailTemplate::create($validatedData);
    }

    public function updateEmailTemplate(EmailTemplate $emailTemplate, array $validatedData): EmailTemplate
    {
        $emailTemplate->update($validatedData);
        return $emailTemplate;
    }

    public function deleteEmailTemplate(EmailTemplate $emailTemplate): void
    {
        $emailTemplate->delete();
    }
}
