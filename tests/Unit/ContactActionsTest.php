<?php

namespace Tests\Unit;

use App\Actions\ContactActions;
use App\Models\Contact;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ContactActionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_throws_validation_errors_when_values_are_missing()
    {
        $this->expectValidationException([
            'first_name' => ['The first name field is required.'],
            'last_name' => ['The last name field is required.'],
            'email' => ['The email field is required.'],
            'telephone' => ['The telephone field is required.'],
        ], 'createContact');
        (new ContactActions())->create([
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'telephone' => '',
        ]);
    }

    /** @test */
    public function it_fails_validation_if_email_invalid()
    {
        $this->expectValidationException([
            'email' => ['The email must be a valid email address.'],
        ], 'createContact');
        (new ContactActions())->create([
            'first_name' => 'Mat',
            'last_name' => 'Chapman',
            'email' => 'blahblahblah',
            'telephone' => '01423415656',
        ]);
    }

    /** @test */
    public function it_creates_a_new_contact()
    {
        $contact = (new ContactActions())->create([
            'first_name' => 'Mat',
            'last_name' => 'Chapman',
            'email' => 'mat@example.com',
            'telephone' => '01423415656',
        ]);
        $this->assertModelExists($contact);
    }

    /** @test */
    public function it_throws_the_right_error_bag_when_updating()
    {
        $contact = Contact::factory()->create();

        $this->expectValidationException([
            'first_name' => ['The first name field is required.'],
        ], 'updateContact');
        (new ContactActions())->update($contact, [
            'first_name' => '',
            'last_name' => 'Chapman',
            'email' => 'mat@example.com',
            'telephone' => '01423415656',
        ]);
    }

    /** @test */
    public function it_updates_a_contact()
    {
        $contact = Contact::factory()->create();
        $this->assertModelExists($contact);

        (new ContactActions())->update(Contact::find($contact->id), [
            'first_name' => 'Mat',
            'last_name' => 'Chapman',
            'email' => 'mat@example.com',
            'telephone' => '01423415656',
        ]);

        $this->assertDatabaseMissing('contacts', [
            'first_name' => $contact->first_name,
            'last_name' => $contact->last_name,
            'email' => $contact->email,
            'telephone' => $contact->telephone,
        ]);

        $updatedContact = Contact::find($contact->id);
        $this->assertEquals('Mat', $updatedContact->first_name);
        $this->assertEquals('Chapman', $updatedContact->last_name);
        $this->assertEquals('mat@example.com', $updatedContact->email);
        $this->assertEquals('01423415656', $updatedContact->telephone);
    }

    /** @test */
    public function it_deletes_the_contact()
    {
        $contact = Contact::factory()->create();
        $this->assertModelExists($contact);

        (new ContactActions())->delete(Contact::find($contact->id));

        $this->assertSoftDeleted('contacts', [
            'first_name' => $contact->first_name,
            'last_name' => $contact->last_name,
            'email' => $contact->email,
            'telephone' => $contact->telephone,
        ]);
    }
}
