<?php

namespace App\Traits;

trait HasPrettyStatus
{
    public function getPrettyStatus()
    {
        if ($this->is_present == 0) {
            return '';
        } elseif ($this->is_present == 1) {
            return 'Time in only';
        } elseif ($this->is_present == 2) {
            return 'Present';
        }

        return 'Absent';
    }

    public function getPrettyStatus2()
    {
        if ($this->is_present == 0) {
            return 'X';
        } elseif ($this->is_present == 1) {
            return 'H';
        } elseif ($this->is_present == 2) {
            return 'P';
        }

        return 'Absent';
    }
}
