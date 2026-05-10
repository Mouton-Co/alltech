<div class="grid grid-cols-1 gap-3">
    <x-form.field
        type="text"
        wire:model='form.contactName'
        placeholder="Name"
        required
        icon='name'
    />
    <x-form.field
        type="email"
        wire:model='form.contactEmail'
        placeholder="Email"
        required
        icon='email'
    />
    <x-form.field
        type="text"
        wire:model='form.contactPhone'
        placeholder="Phone"
        icon='phone'
    />
    <div class="flex flex-col gap-1">
        <div class="flex items-center gap-2">
            <input
                class="cursor-pointer"
                type="radio"
                value="existing"
                wire:model="form.companyMode"
            >
            <span>Existing company</span>
        </div>
        <div class="flex items-center gap-2">
            <input
                class="cursor-pointer"
                type="radio"
                value="new"
                wire:model="form.companyMode"
            >
            <span>New company</span>
        </div>
    </div>
    <div
        wire:show="form.companyMode === 'existing'"
        wire:cloak
    >
        <livewire:form.select
            icon='company'
            wire:model='form.contactCompanyId'
            field='form.contactCompanyId'
            placeholder='Company'
            :options="$this->companies"
        />
        @error('form.contactCompanyId')
            <span class="text-red-600">{{ $message }}</span>
        @enderror
    </div>
    <div
        class="grid grid-cols-1 gap-3"
        wire:show="form.companyMode === 'new'"
        wire:cloak
    >
        <x-form.field
            type="text"
            wire:model='form.companyName'
            placeholder="Company Name"
            required
            icon='company'
        />
        <x-form.field
            type="text"
            wire:model='form.companyLocation'
            placeholder="Company Location"
            required
            icon='location'
        />
        <x-form.field
            type="text"
            wire:model='form.companyRegion'
            placeholder="Company Region"
            required
            icon='coordinates'
        />
        <div>
            <livewire:form.select
                icon='company-type'
                wire:model='form.companyTypeId'
                field='form.companyTypeId'
                placeholder='Company Type'
                :options="$this->companyTypes"
            />
            @error('form.companyTypeId')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
