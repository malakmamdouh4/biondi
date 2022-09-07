<?php

namespace App\Imports;

use App\Clients;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ClientsImport implements ToModel ,WithHeadingRow
{
    private $users;
    private $branch_id;
    private $user_id;

    public function __construct($branch_id,$user_id) {
        $this->users = User::select('id','name','email','phone')->get();
        $this->branch_id = request()->branch_id;
        $this->user_id = $user_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = $this->users->where('phone',$row['employee'])->first();
        $agent = $this->user_id;
        if ($this->user_id == 'file') {
            $agent = $row['id'];
        }
        return new Clients([
            //
            'branch_id' => $this->branch_id,
            'Name' => $row['name'],
            'phone' => $row['phone'],
            'cellphone' => $row['cellphone'],
            'whatsapp' => $row['whatsapp'],
            'Job' => $row['job'],
            'referral' => $row['refferal'] ?? 'facebookPage',
            'Notes' => $row['notes'],
            'status' => 'cold',
            'UID' => $agent
        ]);
    }
}
