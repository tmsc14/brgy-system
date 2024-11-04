<?php

namespace App\Livewire\Announcements;

use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AnnouncementProfile extends Component
{
    #[Locked]
    public $announcement;

    public $title;
    public $body;
    public $photo;

    use WithFileUploads;

    public function save()
    {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data['photo'] = $this->photo->storePublicly('announcements/' . Auth::user()->barangay->id, 'public');
        
        if ($this->announcement && $this->announcement->id)
        {
            $this->announcement->update($data);
        }
        else
        {
            $data['created_by_staff_id'] = Auth::user()->id;
            $data['barangay_id'] = Auth::user()->barangay->id;
            Announcement::create($data);
        }

        $this->redirectRoute('announcements');
    }

    public function render()
    {
        return view('livewire.announcements.announcement-profile');
    }
}
