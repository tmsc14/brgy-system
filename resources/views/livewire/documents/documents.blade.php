<div>
    <x-icon-header text="Documents" iconName="description" />
    <x-icon-long-button text="{{ $userType == 'staff' ? 'BARANGAY' : 'YOUR' }} DOCUMENT REQUESTS" iconName='description' wire:click="goToRequestList" />
    <x-icon-long-button text="REQUEST A DOCUMENT" iconName='description' wire:click="goToRequestDocument" />
</div>
