<?php

namespace App\Interfaces;

interface DocumentRequestProfileComponentInterface
{
    public function pay($amount);
    public function refund($transactionId, $amount);
}
