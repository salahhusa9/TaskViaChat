<?php

namespace App\Enums;

// https://waha.devlike.pro/docs/how-to/sessions/#sessionstatus
enum NumberStatus: string
{
    case PANDING = 'Panding';
    case STOPPED = 'Stopped';
    case STARTING  = 'Starting';
    case SCAN_QR_CODE = 'Scan QR Code';
    case WORKING = 'Working';
    case FAILED = 'Failed';

    // get description
    public function getDescriptionForAdmin(): string
    {
        return match ($this) {
            self::PANDING => 'session is panding',
            self::STOPPED => 'session is stopped',
            self::STARTING => 'session is starting',
            self::SCAN_QR_CODE => 'session is required to scan QR code or login via phone number',
            self::WORKING => 'session is working and ready to use',
            self::FAILED => 'session is failed due to some error. It’s likely that authorization is required again or device has been disconnected from that account. Try to restart the session and if it doesn’t help - logout and start the session again.',
            default => 'Unknown',
        };
    }

    // get description
    public function getDescriptionForUser(string $value): string
    {
        return match ($this) {
            self::PANDING => 'session is panding',
            self::STOPPED => 'session is stopped',
            self::STARTING => 'session is starting',
            self::SCAN_QR_CODE => 'session is required to scan QR code or login via phone number',
            self::WORKING => 'session is working and ready to use',
            self::FAILED => 'session is failed due to some error.',
            default => 'Unknown',
        };
    }
}
