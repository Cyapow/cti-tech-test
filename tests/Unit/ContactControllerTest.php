<?php

namespace Tests\Unit;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_a_list_of_contacts()
    {
        Contact::factory(18)->create();
        $this->get(route('contacts.index'))
            ->assertInertia(
                fn (Assert $page) => $page
                ->component('Contacts/Index')
                ->has(
                    'contacts',
                    fn (Assert $page) => $page
                        ->has('current_page')
                        ->has('first_page_url')
                        ->has('from')
                        ->has('last_page')
                        ->has('last_page_url')
                        ->has('data', 5)
                        ->etc()
                )
            );
    }

    /** @test */
    public function it_shows_a_create_contact_form()
    {
        $this->get(route('contacts.create'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Contacts/Add')
            );
    }

    /** @test */
    public function it_shows_a_edit_contact_form()
    {
        $contact = Contact::factory()->create();
        $this->get(route('contacts.edit', ['contact' => $contact]))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Contacts/Edit')
                    ->has(
                        'contact',
                        fn (Assert $page) => $page
                            ->where('id', $contact->id)
                            ->where('first_name', $contact->first_name)
                            ->where('last_name', $contact->last_name)
                            ->where('email', $contact->email)
                            ->where('telephone', $contact->telephone)
                            ->etc()
                    )
            );
    }

    /** @test */
    public function it_stores_the_new_contact_and_shows_message()
    {
        $this->post(route('contacts.store'), [
            'first_name' => 'Mat',
            'last_name' => 'Chapman',
            'email' => 'mat@example.com',
            'telephone' => '01423415656',
        ])
            ->assertStatus(302)
            ->assertLocation(route('contacts.index'))
            ->assertSessionHas('flash-notification', [
                'title' => 'Created',
                'message' => 'Contact has been created',
                'style' => 'success',
                'time' => time(),
            ]);

        $this->assertDatabaseHas('contacts', [
            'first_name' => 'Mat',
            'last_name' => 'Chapman',
            'email' => 'mat@example.com',
            'telephone' => '01423415656',
        ]);
    }

    /** @test */
    public function it_updates_the_contact_and_shows_message()
    {
        $contact = Contact::factory()->create();
        $response = $this->put(route('contacts.update', ['contact' => $contact]), [
            'first_name' => 'Mat',
            'last_name' => 'Chapman',
            'email' => 'mat@example.com',
            'telephone' => '01423415656',
        ])
            ->assertStatus(302)
            ->assertSessionHas('flash-notification', [
                'title' => 'Updated',
                'message' => 'Contact Mat has been updated',
                'style' => 'success',
                'time' => time(),
            ]);

        $this->assertDatabaseHas('contacts', [
            'first_name' => 'Mat',
            'last_name' => 'Chapman',
            'email' => 'mat@example.com',
            'telephone' => '01423415656',
        ]);
    }

    /** @test */
    public function it_deletes_the_contact_and_shows_message()
    {
        $contact = Contact::factory()->create([
            'first_name' => 'Mat'
        ]);
        $response = $this->delete(route('contacts.destroy', ['contact' => $contact]))
            ->assertStatus(302)
            ->assertSessionHas('flash-notification', [
                'title' => 'Deleted',
                'message' => 'Contact Mat has been deleted',
                'style' => 'success',
                'time' => time(),
            ]);

        $this->assertSoftDeleted('contacts', [
            'id' => $contact->id,
        ]);
    }
}
