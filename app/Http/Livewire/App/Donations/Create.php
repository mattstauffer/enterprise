<?php

namespace App\Http\Livewire\App\Donations;

use App\Models\Donation;
use App\Models\DonationPlan as Plan;
use App\Models\DonationPrice as Price;
use Livewire\Component;
use NumberFormatter;

class Create extends Component
{
    public $donation;
    public $form = [
        'name' => '',
        'email' => '',
        'is_anonymous' => false,
        'is_company' => false,
        'company_name' => '',
        'tax_id' => '',
        'type' => '',
        'amount' => '',
    ];

    public $rules = [
        'form.name' => 'required',
        'form.email' => 'required|email',
        'form.type' => 'required',
        'form.amount' => 'required',
        'form.is_anonymous' => 'boolean',
        'form.is_company' => 'boolean',
        'form.company_name' => 'required_if:form.is_company,true',
        'form.tax_id' => 'required_if:form.is_company,true',
    ];

    public function mount()
    {
        if(auth()->check()) {
            $this->form['name'] = auth()->user()->name;
            $this->form['email'] = auth()->user()->email;
        }
    }

    public function updating($field, $value)
    {
        if($field === 'form.type') {
            if($value === 'monthly') {
                $this->form['amount'] = 'monthly-25';
            } else {
                $this->form['amount'] = '25.00';
            }
        }
    }

    public function render()
    {
        return view('livewire.app.donations.create')
            ->with([
                'checkoutButton' => $this->checkoutButton,
                'prices' => $this->prices,
            ]);
    }

    // Properties

    public function getCheckoutButtonProperty()
    {
        if($this->donation !== null && $this->donation->type === 'one-time') {
            return auth()->user()->checkoutCharge($this->donation->amount, 'One Time Donation', 1, [
                'success_url' => route('app.donations.show', ['donation' => $this->donation, 'success']),
                'cancel_url' => route('app.donations.create', ['donation' => $this->donation, 'canceled']),
                'billing_address_collection' => 'required',
                'metadata' => [
                    'user_id' => auth()->id(),
                    'donation_id' => $this->donation->id,
                ]
            ]);
        } elseif($this->donation !== null && $this->donation->type === 'monthly') {
            return auth()->user()
                ->newSubscription('recurring-monthly', 'monthly-25')
                ->checkout([
                    'success_url' => route('app.dashboard'),
                    'cancel_url' => route('app.dashboard'),
                    'billing_address_collection' => 'required',
                    'metadata' => [
                        'user_id' => auth()->id(),
                        'donation_id' => $this->donation->id,
                    ]
                ]);
        }
    }

    public function getPlanProperty()
    {
        return Plan::find(1);
    }

    public function getPricesProperty()
    {
        return Price::where('plan_id', 1)->get();
    }

    // Methods

    public function pay()
    {
        $data = $this->validate()['form'];

        $data['user_id'] = auth()->id();
        $data['amount'] = (int) $data['amount'] * 100;

        $this->donation = Donation::create($data);
    }
}
