<?php

namespace App\Exports;

use App\Constants\GeneralStatus;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    /**
     * Map counter.
     */
    private int $counter;

    /**
     * Initiate starter value.
     */
    public function __construct()
    {
        $this->counter = 1;
    }

    /**
     * Get all exportable data.
     */
    public function collection(): Collection
    {
        return (new UserService)->all(100);
    }

    /**
     * Map each data on collection.
     */
    public function map($user): array
    {
        return [
            $this->counter++,
            $user->username,
            $user->name,
            $user->email,
            $user->phone,
            $user->role->name,
            GeneralStatus::label($user->status),
            human_datetime($user->created_at),
            human_datetime($user->updated_at),
        ];
    }

    /**
     * Define export heading.
     */
    public function headings(): array
    {
        return [
            'No',
            'Username',
            'Name',
            'Email',
            'Phone',
            'Role',
            'Status',
            'Created Date',
            'Updated Date',
        ];
    }

    /**
     * Define export column width.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 15,
            'C' => 25,
            'D' => 25,
            'E' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 35,
            'H' => 35,
        ];
    }
}
