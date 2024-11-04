<?php

namespace App\Livewire\Announcements;

use App\Models\Announcement;
use Livewire\Component;

class Announcements extends Component
{
    public function addAnnouncement()
    {
        $this->redirectRoute('announcements.profile');
    }

    public function viewAnnouncement($id)
    {
        $this->redirectRoute('announcements.view', ['id' => $id]);
    }

    public function render()
    {
        $latestAnnouncement = Announcement::latest()->first();

        $oldAnnouncements = [];

        if (isset($latestAnnouncement))
        {
            $oldAnnouncements = Announcement::where('created_at', '<', $latestAnnouncement->created_at)
                ->latest()
                ->take(4)
                ->get();
        }

        return view('livewire.announcements.announcements', compact('latestAnnouncement', 'oldAnnouncements'));
    }
}
