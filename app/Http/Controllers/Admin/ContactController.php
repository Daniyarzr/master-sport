<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('admin.contacts.index', [
            'contacts' => Contact::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
            'types' => $this->types(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9_]+$/', 'unique:contacts,key'],
            'type' => ['required', Rule::in(array_keys($this->types()))],
            'label' => ['required', 'string', 'max:120'],
            'value' => ['required', 'string', 'max:255'],
            'href' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        Contact::query()->create([
            'key' => $validated['key'],
            'type' => $validated['type'],
            'label' => $validated['label'],
            'value' => $validated['value'],
            'href' => $this->normalizeHref($validated['href'] ?? null),
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return back()->with('status', 'Контакт создан.');
    }

    public function edit(Contact $contact): View
    {
        return view('admin.contacts.edit', [
            'contact' => $contact,
            'types' => $this->types(),
        ]);
    }

    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9_]+$/', Rule::unique('contacts', 'key')->ignore($contact->id)],
            'type' => ['required', Rule::in(array_keys($this->types()))],
            'label' => ['required', 'string', 'max:120'],
            'value' => ['required', 'string', 'max:255'],
            'href' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $contact->update([
            'key' => $validated['key'],
            'type' => $validated['type'],
            'label' => $validated['label'],
            'value' => $validated['value'],
            'href' => $this->normalizeHref($validated['href'] ?? null),
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return back()->with('status', 'Контакт обновлен.');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return back()->with('status', 'Контакт удален.');
    }

    /**
     * @return array<string, string>
     */
    private function types(): array
    {
        return [
            'phone' => 'Телефон',
            'email' => 'Email',
            'address' => 'Адрес',
            'hours' => 'Режим работы',
            'city' => 'Город',
            'link' => 'Ссылка',
            'other' => 'Другое',
        ];
    }

    private function normalizeHref(?string $href): ?string
    {
        $href = trim((string) $href);

        return $href !== '' ? $href : null;
    }
}