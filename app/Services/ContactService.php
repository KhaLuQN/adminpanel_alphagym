<?php

namespace App\Services;

use App\Models\Contact;

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
}
