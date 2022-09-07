<?php

namespace App\Http\Controllers\system;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EntriesOperations;
use App\ContractPayments;
use App\Expenses;
use App\Revenues;

class customOldDataController extends Controller
{
    //
    public function ConvertPaymentsToRevenues()
    {
        $OldPayments = ContractPayments::orderBy('id','asc')->get();
        foreach ($OldPayments as $key => $value) {
            $stringArr = explode('/',$value['PaymentDate']);
            // return $value['PaymentDate'];
            $data = [
                'UID' => $value['UID'],
                'LinkedID' => $value['ContractID'],
                'Type' => $value['Type'] == 'InAdvance' ? 'contract_inAdvance' : 'contract_payment',
                'amount' => $value['Amount'],
                'Notes' => $value['notes'],
                'Date' => $stringArr[2].'-'.$stringArr[0].'-'.$stringArr[1],
                'DateStr' => strtotime( $stringArr[2].'-'.$stringArr[0].'-'.$stringArr[1]),
                'month' =>  $stringArr[0],
                'year' =>  $stringArr[2],
                'safe_id' => $value['SafeID'],
                'branch_id' => 1
            ];
            $revenue = Revenues::create($data);
        }
    }
    public function ConvertTransfersToRevenuesExpenses()
    {
        $safesAccountsArr = [1632,1633,1635,1691,1739,1749,1778,1783];
        $safesIds = [
            1632 => 1,
            1633 => 2,
            1635 => 3,
            1691 => 4,
            1739 => 5,
            1749 => 6,
            1778 => 7,
            1783 => 8
        ];
        $OldFunds = EntriesOperations::where('Type','transfeer')->orderBy('id','asc')->get();
        // return $OldFunds;
        $arr = [];
        foreach ($OldFunds as $key => $value) {
            $entries = $value->Entries()->whereIn('accounts_tree_id',$safesAccountsArr)->get();
            $arr[] = [
                'operation' => $value,
                'entries' => $entries
            ];
            foreach ($entries as $entry) {
                $stringArr = explode('/',$entry['PaymentDate']);
                if ($entry->Debit != null) {
                    if (isset($safesIds[$entry['accounts_tree_id']])) {
                        $data = [
                            'UID' => 1,
                            'Type' => 'transfeerFromAnother',
                            'amount' => $entry['Debit'],
                            'Notes' => $entry['Statement'],
                            'Date' => $stringArr[2].'-'.$stringArr[0].'-'.$stringArr[1],
                            'DateStr' => strtotime( $stringArr[2].'-'.$stringArr[0].'-'.$stringArr[1]),
                            'month' =>  $stringArr[0],
                            'year' =>  $stringArr[2],
                            'safe_id' => $safesIds[$entry['accounts_tree_id']],
                            'branch_id' => 1
                        ];
                        $revenue = Revenues::create($data);
                    } else {
                        $arr[] = [
                            'D-Entry' => $entry
                        ];

                    }
                }
                if ($entry->Credit != null) {
                    if (isset($safesIds[$entry['accounts_tree_id']])) {
                        $data = [
                            'UID' => 1,
                            'Type' => 'transfeerToAnother',
                            'Expense' => $entry['Credit'],
                            'Des' => $entry['Statement'],
                            'ExpenseDate' => $stringArr[2].'-'.$stringArr[0].'-'.$stringArr[1],
                            'month' =>  $stringArr[0],
                            'year' =>  $stringArr[2],
                            'safe_id' => $safesIds[$entry['accounts_tree_id']],
                            'branch_id' => 1
                        ];
                        $revenue = Expenses::create($data);
                    } else {
                        $arr[] = [
                            'C-Entry' => $entry
                        ];

                    }
                }
            }
        }
        return $arr;
    }

    public function refineExpensesDays()
    {
        $expenses = Expenses::orderBy('id','asc')->get();
        foreach ($expenses as $key => $value) {
            $stringArr = explode('/',$value['ExpenseDate']);
            // $data = [
            //     'UID' => $value['UID'],
            //     'LinkedID' => $value['ContractID'],
            //     'Type' => $value['Type'] == 'InAdvance' ? 'contract_inAdvance' : 'contract_payment',
            //     'amount' => $value['Amount'],
            //     'Notes' => $value['notes'],
            //     'Date' => date('Y-m-d',strtotime(str_replace("/","-",$value['PaymentDate']))),
            //     'DateStr' => strtotime( date('Y-m-d',strtotime(str_replace("/","-",$value['PaymentDate'])))),
            //     'month' =>  date('m',strtotime(str_replace("/","-",$value['PaymentDate']))),
            //     'year' =>  date('Y',strtotime(str_replace("/","-",$value['PaymentDate']))),
            //     'safe_id' => $value['SafeID'],
            //     'branch_id' => 1
            // ];
            if (isset($stringArr[2])) {
                $revenue = Expenses::find($value['id'])->update([
                    'ExpenseDate'=>$stringArr[2].'-'.$stringArr[0].'-'.$stringArr[1]
                ]);
            }
        }
    }
}
