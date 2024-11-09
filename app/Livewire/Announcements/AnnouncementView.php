<?php

namespace App\Livewire\Announcements;

use App\Models\Announcement;
use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Component;

class AnnouncementView extends Component
{
    #[Locked]
    public $announcement;

    #[Locked]
    public $userDetails;

    public function mount($id)
    {
        $this->announcement = Announcement::findOrFail($id);

        $userAuthor = User::findOrFail($this->announcement->created_by_staff_id)->staff;

        $this->userDetails =
            [
                'name' => $userAuthor->first_name . ' ' . $userAuthor->last_name,
                'title' => $userAuthor->position ?? $userAuthor->title
            ];
    }

    public function editAnnouncement()
    {
        $this->redirectRoute('announcements.profile', ['id' => $this->announcement->id]);
    }

    public function render()
    {
        return view('livewire.announcements.announcement-view');
    }
}
