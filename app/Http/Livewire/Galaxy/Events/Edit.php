<?php

namespace App\Http\Livewire\Galaxy\Events;

use App\Models\Event;
use Livewire\Component;

class Edit extends Component
{
    public $page;
    public Event $event;

    public function mount($page = 'details')
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit')
            ->layout('layouts.galaxy', ['title' => 'Configure ' . $this->event->name])
            ->with([
                'pages' => $this->pages,
            ]);
    }

    public function getPagesProperty()
    {
        if($this->event->settings->add_ons) {
            return [
                ['value' => 'details', 'label' => 'Details', 'href' => route('galaxy.events.edit', ['event' => $this->event, 'page' => 'details']), 'icon' => 'heroicon-o-paper-clip', 'active' => $this->page === 'details'],
                ['value' => 'media', 'label' => 'Media', 'href' => route('galaxy.events.edit', ['event' => $this->event, 'page' => 'media']), 'icon' => 'heroicon-o-camera', 'active' => $this->page === 'media'],
                ['value' => 'tickets', 'label' => 'Ticket Types', 'href' => route('galaxy.events.edit', ['event' => $this->event, 'page' => 'tickets']), 'icon' => 'heroicon-o-ticket', 'active' => $this->page === 'tickets'],
                ['value' => 'addons', 'label' => 'Add-ons', 'href' => route('galaxy.events.edit', ['event' => $this->event, 'page' => 'addons']), 'icon' => 'heroicon-o-shopping-bag', 'active' => $this->page === 'addons'],
                ['value' => 'settings', 'label' => 'Settings', 'href' => route('galaxy.events.edit', ['event' => $this->event, 'page' => 'settings']), 'icon' => 'heroicon-o-cog', 'active' => $this->page === 'settings'],
            ];
        } else {
            return [
                ['value' => 'details', 'label' => 'Details', 'href' => route('galaxy.events.show', ['event' => $this->event, 'page' => 'details']), 'icon' => 'heroicon-o-paper-clip', 'active' => $this->page === 'details'],
                ['value' => 'media', 'label' => 'Media', 'href' => route('galaxy.events.show', ['event' => $this->event, 'page' => 'media']), 'icon' => 'heroicon-o-camera', 'active' => $this->page === 'media'],
                ['value' => 'tickets', 'label' => 'Ticket Types', 'href' => route('galaxy.events.show', ['event' => $this->event, 'page' => 'tickets']), 'icon' => 'heroicon-o-ticket', 'active' => $this->page === 'tickets'],
                ['value' => 'settings', 'label' => 'Settings', 'href' => route('galaxy.events.show', ['event' => $this->event, 'page' => 'settings']), 'icon' => 'heroicon-o-cog', 'active' => $this->page === 'settings'],
            ];
        }
    }
}
