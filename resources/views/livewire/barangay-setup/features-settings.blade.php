<form wire:submit="save">
    <x-title spaced>Features Settings</x-title>
    <div class='d-flex flex-wrap'>
        @foreach ($this->featuresByCategory as $category => $features)
            <div class="col-4 mb-3">
                <x-subtitle>{{ __('featuressettings.' . $category) }}</x-subtitle>
                <div class="form-group">
                    @foreach ($features as $feature)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="feature-{{ $feature->id }}"
                                wire:model="selectedFeatures" value="{{ $feature->id }}">
                            <label class="form-check-label" for="feature-{{ $feature->id }}">
                                {{ __('featuressettings.' . $feature->name) }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    {{-- <div class="row">
        <div class="col">
            <div class="mb-2">
                <x-subtitle>System Customizability Access:</x-subtitle>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Select All
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Barangay Officials
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Barangay Staff
                    </label>
                </div>
            </div>
            <div>
                <x-subtitle>Additional Features:</x-subtitle>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Reports
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Announcements
                    </label>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="mb-2">
                <x-subtitle>Statistics and Demographics:</x-subtitle>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Select All
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        No. of Residents
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        No. of Households
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Gender
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Age Demographic
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        No. of PWD
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        No. of Single Parents
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        No. of Voters
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        No. of Employment
                    </label>
                </div>
            </div>
        </div>
        <div class="col">
            <x-subtitle>List of Documents:</x-subtitle>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                    Select All
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                    Business Clearance/Permit
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                    Certificate of Death
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                    Certificate of Indigency
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                    Certificate of Residency
                </label>
            </div>
            
        </div>
    </div> --}}
    <x-hr />
    <div class="d-flex justify-content-around">
        <button class="btn {{ $is_wizard_step ? 'btn-primary-brown' : 'btn-secondary-brgy' }} ms-auto" type="submit">
            Save
        </button>
    </div>
    @csrf
</form>
