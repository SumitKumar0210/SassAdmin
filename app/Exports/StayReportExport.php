<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StayReportExport implements FromQuery, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = DB::table('reservation_rooms as rr')
            ->leftJoin('room_types as rt', 'rt.id', '=', 'rr.room_type_id')
            ->where('rr.status', '!=', 'Cancel')
            ->select(
                'rr.primary_name as guest_name',
                'rr.room_alloted as room_no',
                'rt.room_category as room_type',
                'rr.checkedin_at as checkin_date',
                'rr.checkedout_at as checkout_date',
                'rr.status'
            );

        // Apply search same as DataTable
        if ($search = $this->request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('rr.primary_name', 'like', "%{$search}%")
                  ->orWhere('rr.room_alloted', 'like', "%{$search}%")
                  ->orWhere('rt.room_category', 'like', "%{$search}%")
                  ->orWhere('rr.status', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Guest Name',
            'Room No',
            'Room Type',
            'Checkin Date',
            'Checkout Date',
            'Status',
        ];
    }
}

?>