<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class CompanyProfile extends Component
{
    public $company_name = '';
    public $company_email = '';
    public $company_phone = '';
    public $company_address = '';
    public $company_website = '';
    public $currency = 'USD';
    public $timezone = 'UTC';

    public function mount()
    {
        $this->company_name = Setting::get('company_name', 'My Laravel Admin');
        $this->company_email = Setting::get('company_email', 'admin@example.com');
        $this->company_phone = Setting::get('company_phone', '+1 (555) 123-4567');
        $this->company_address = Setting::get('company_address', '123 Main St, City, Country');
        $this->company_website = Setting::get('company_website', 'https://example.com');
        $this->currency = Setting::get('currency', 'USD');
        $this->timezone = Setting::get('timezone', 'UTC');
    }

    protected function rules()
    {
        return [
            'company_name' => 'required|string|max:100',
            'company_email' => 'required|email|max:100',
            'company_phone' => 'nullable|string|max:30',
            'company_address' => 'nullable|string|max:255',
            'company_website' => 'nullable|url|max:100',
            'currency' => 'required|string|max:10',
            'timezone' => 'required|string|max:50',
        ];
    }

    public function save()
    {
        $this->validate();

        Setting::set('company_name', $this->company_name);
        Setting::set('company_email', $this->company_email);
        Setting::set('company_phone', $this->company_phone);
        Setting::set('company_address', $this->company_address);
        Setting::set('company_website', $this->company_website);
        Setting::set('currency', $this->currency);
        Setting::set('timezone', $this->timezone);

        session()->flash('message', 'Company Profile updated successfully.');
        session()->flash('alert-type', 'success');
    }

    public function render()
    {
        return view('livewire.settings.company-profile');
    }
}
