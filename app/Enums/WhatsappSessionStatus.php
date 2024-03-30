<?php

namespace App\Enums;

// https://waha.devlike.pro/docs/how-to/sessions/#sessionstatus
enum WhatsappSessionStatus: string
{
    case PENDING = 'PENDING';
    case STOPPED = 'STOPPED';
    case STARTING  = 'STARTING';
    case SCAN_QR_CODE = 'SCAN_QR_CODE';
    case WORKING = 'WORKING';
    case FAILED = 'FAILED';

    public function title()
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::STOPPED => 'Stopped',
            self::STARTING => 'Starting',
            self::SCAN_QR_CODE => 'Scan QR Code',
            self::WORKING => 'Working',
            self::FAILED => 'Failed',
            default => 'Unknown',
        };
    }

    // get description
    public function getDescriptionForAdmin(): string
    {
        return match ($this) {
            self::PENDING => 'session is panding',
            self::STOPPED => 'session is stopped',
            self::STARTING => 'session is starting',
            self::SCAN_QR_CODE => 'session is required to scan QR code or login via phone number',
            self::WORKING => 'session is working and ready to use',
            self::FAILED => 'session is failed due to some error. It’s likely that authorization is required again or device has been disconnected from that account. Try to restart the session and if it doesn’t help - logout and start the session again.',
            default => 'Unknown',
        };
    }

    // get description
    public function getDescriptionForUser(): string
    {
        return match ($this) {
            self::PENDING => 'session is panding',
            self::STOPPED => 'session is stopped',
            self::STARTING => 'session is starting',
            self::SCAN_QR_CODE => 'session is required to scan QR code or login via phone number',
            self::WORKING => 'session is working and ready to use',
            self::FAILED => 'session is failed due to some error.',
            default => 'Unknown',
        };
    }
}
