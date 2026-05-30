<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class EmailSettings extends Component
{
    public $mail_mailer = 'smtp';
    public $mail_host = '';
    public $mail_port = '2525';
    public $mail_username = '';
    public $mail_password = '';
    public $mail_encryption = 'tls';
    public $mail_from_address = '';
    public $mail_from_name = '';

    public function mount()
    {
        $this->mail_mailer = Setting::get('mail_mailer', env('MAIL_MAILER', 'smtp'));
        $this->mail_host = Setting::get('mail_host', env('MAIL_HOST', 'sandbox.smtp.mailtrap.io'));
        $this->mail_port = Setting::get('mail_port', env('MAIL_PORT', '2525'));
        $this->mail_username = Setting::get('mail_username', env('MAIL_USERNAME', ''));
        $this->mail_password = Setting::get('mail_password', env('MAIL_PASSWORD', ''));
        $this->mail_encryption = Setting::get('mail_encryption', env('MAIL_ENCRYPTION', 'tls'));
        $this->mail_from_address = Setting::get('mail_from_address', env('MAIL_FROM_ADDRESS', 'hello@example.com'));
        $this->mail_from_name = Setting::get('mail_from_name', env('MAIL_FROM_NAME', 'Laravel Admin'));
    }

    protected function rules()
    {
        return [
            'mail_mailer' => 'required|string|max:20',
            'mail_host' => 'required|string|max:100',
            'mail_port' => 'required|integer',
            'mail_username' => 'nullable|string|max:100',
            'mail_password' => 'nullable|string|max:100',
            'mail_encryption' => 'nullable|string|max:20',
            'mail_from_address' => 'required|email|max:100',
            'mail_from_name' => 'required|string|max:100',
        ];
    }

    public function save()
    {
        $this->validate();

        Setting::set('mail_mailer', $this->mail_mailer);
        Setting::set('mail_host', $this->mail_host);
        Setting::set('mail_port', $this->mail_port);
        Setting::set('mail_username', $this->mail_username);
        Setting::set('mail_password', $this->mail_password);
        Setting::set('mail_encryption', $this->mail_encryption);
        Setting::set('mail_from_address', $this->mail_from_address);
        Setting::set('mail_from_name', $this->mail_from_name);

        session()->flash('message', 'Email settings updated successfully.');
        session()->flash('alert-type', 'success');
    }

    public function render()
    {
        return view('livewire.settings.email-settings');
    }
}
