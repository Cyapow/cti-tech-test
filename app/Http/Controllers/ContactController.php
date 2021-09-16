<?php

namespace App\Http\Controllers;

use App\Actions\ContactActions;
use App\Filters\ContactFilters;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * @var ContactActions
     */
    private $actions;

    public function __construct(ContactActions $actions)
    {
        $this->actions = $actions;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ContactFilters $filters
     * @return \Inertia\Response
     */
    public function index(ContactFilters $filters): \Inertia\Response
    {
        $contacts = Contact::filter($filters)
            ->paginate(5)
            ->appends($filters->filters());

        return Inertia::render(
            'Contacts/Index',
            [
                'contacts' => $contacts,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Contacts/Add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->actions->create($request->all());

        return redirect()
            ->route('contacts.index')
            ->withFlash('Created', 'Contact has been created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contact $contact
     * @return \Inertia\Response
     */
    public function edit(Contact $contact): \Inertia\Response
    {
        return Inertia::render(
            'Contacts/Edit',
            [
                'contact' => $contact,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Contact $contact
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $this->actions->update($contact, $request->all());

        return redirect()
            ->back()
            ->withFlash('Updated', 'Contact '.$contact->first_name.' has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function destroy(Request $request, Contact $contact): RedirectResponse
    {
        $this->actions->delete($contact);

        $route = redirect()->back();
        if ($request->redirectIndex) {
            $route = redirect()->route('contacts.index');
        }

        return $route->withFlash('Deleted', 'Contact '.$contact->first_name.' has been deleted');
    }
}
