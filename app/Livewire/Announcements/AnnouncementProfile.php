<?php

namespace App\Livewire\Announcements;

use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
    public $photoUrl;

    use WithFileUploads;

    public function mount($id)
    {
        $this->announcement = Announcement::find($id);

        if ($this->announcement)
        {
            $this->title = $this->announcement->title;
            $this->body = $this->announcement->body;
            $this->photoUrl = asset('storage/' . $this->announcement->photo);
        }
    }

    public function save()
    {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($this->announcement && $this->announcement->id)
        {
            if ($this->photo && !is_string($this->photo))
            {
                $data['photo'] = $this->photo->storePublicly('announcements/' . Auth::user()->barangay->id, 'public');
            }
            else
            {
                unset($data['photo']);
            }

            $this->announcement->update($data);
        }
        else
        {
            $data['photo'] = $this->photo->storePublicly('announcements/' . Auth::user()->barangay->id, 'public');
            $data['created_by_staff_id'] = Auth::user()->id;
            $data['barangay_id'] = Auth::user()->barangay->id;
            Announcement::create($data);
        }

        $this->redirectRoute('announcements');
    }

    public function delete()
    {
        $this->announcement->delete();
        $this->redirectRoute('announcements');
    }

    public function render()
    {
        return view('livewire.announcements.announcement-profile');
    }
}
