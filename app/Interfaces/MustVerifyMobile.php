<?php

namespace App\Interfaces;

interface MustVerifyMobile
{
    public function hasVerifiedMobile();
    public function verifyMobileCode();

    public function markMobileAsVerified();

    public function sendMobileVerificationNotification();
}
