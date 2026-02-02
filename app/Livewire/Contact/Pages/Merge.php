<?php

namespace App\Livewire\Contact\Pages;

use App\Models\Contact;
use Livewire\Component;

class Merge extends Component
{
    /**
     * Properties
     */
    public array $targetContact = []; // Details of the main contact
    public array $contacts = []; // All contacts available for merging
    public ?string $search = ''; // Search term for filtering contacts
    public bool $confirm = false; // Flag to confirm merge action

    /**
     * Mount the component with the target contact ID.
     */
    public function mount(int $targetContactId): void
    {
        if (auth()->user()->role->name !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $contact = Contact::with(['company', 'meetings'])->findOrFail($targetContactId);
        $this->targetContact = [
            'id' => $contact->id,
            'name' => $contact->name ?? '',
            'email' => $contact->email ?? '',
            'phone' => $contact->phone ?? '',
            'company' => $contact->company?->name ?? '',
            'meetings_count' => $contact->meetings->count(),
        ];

        $this->contacts = Contact::with(['company', 'meetings'])
            ->where('id', '!=', $targetContactId)
            ->orderBy('name')
            ->get()
            ->keyBy('id')
            ->map(function ($contact) {
                return [
                    'name' => $contact->name ?? '',
                    'email' => $contact->email ?? '',
                    'phone' => $contact->phone ?? '',
                    'company' => $contact->company?->name ?? '',
                    'meetings_count' => $contact->meetings->count(),
                    'selected' => false,
                ];
            })
            ->toArray();
    }

    /**
     * Render the Livewire component view.
     */
    public function render(): \Illuminate\View\View
    {
        return view('livewire.contact.pages.merge');
    }

    /**
     * Get the filtered list of contacts based on the search term.
     */
    public function filteredContacts(): array
    {
        if (empty($this->search)) {
            return $this->contacts;
        }

        $searchTerm = strtolower($this->search);

        return array_filter($this->contacts, function ($contact) use ($searchTerm) {
            return str_contains(strtolower($contact['name']), $searchTerm) ||
                str_contains(strtolower($contact['email']), $searchTerm) ||
                str_contains(strtolower($contact['phone']), $searchTerm) ||
                str_contains(strtolower($contact['company']), $searchTerm);
        });
    }

    /**
     * Calculate the new total meetings after merging.
     */
    public function newMeetingCount(): int
    {
        return collect($this->contacts)
            ->where('selected', true)
            ->sum('meetings_count') + $this->targetContact['meetings_count'];
    }

    /**
     * Execute the merge operation.
     */
    public function merge(): void
    {
        if (auth()->user()->role->name !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        // Get all the selected contact IDs to merge
        $idsToMerge = collect($this->contacts)
            ->where('selected', true)
            ->keys()
            ->toArray();

        // Load the contacts to be merged
        $contactsToMerge = Contact::with(['company', 'meetings'])
            ->whereIn('id', $idsToMerge)
            ->get();

        // Update all related contacts and meetings to point to the target contact and then delete the merged contacts
        foreach ($contactsToMerge as $contact) {
            $contact->meetings()->update(['contact_id' => $this->targetContact['id']]);
            $contact->delete();
        }

        session()->flash('success', 'Contacts merged successfully.');
        $this->redirectRoute(
            name: 'contact.index',
        );
    }
}
