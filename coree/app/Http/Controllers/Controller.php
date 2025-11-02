<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function getWelcomeViewData()
    {
        return [
            'activeTemplate' => getActiveTemplate(),
            'faqs' => \App\Models\Faq::all(),
            'paymentMethods' => \App\Models\WithdrawalCategory::pluck('cover'),
        ];
    }
}
