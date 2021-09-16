<?php

namespace App\Actions;

use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class ContactActions
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create($input): Contact
    {
        $this->validate($input, 'createContact');

        return Contact::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'telephone' => $input['telephone'],
        ]);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Contact $contact, $input): Contact
    {
        $this->validate($input, 'updateContact');

        $contact->fill([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'telephone' => $input['telephone'],
        ])->save();

        return $contact;
    }

    public function delete(Contact $contact): bool
    {
        return $contact->delete();
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validate(array $input, string $errorBag)
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telephone' => ['required'],
        ])->validateWithBag($errorBag);
    }
}
