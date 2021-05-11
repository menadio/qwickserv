<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            [
                "name"=> "Abbey Mortgage Bank",
                "slug"=> "abbey-mortgage-bank",
                "code"=> "801",
                "longcode"=> "",
                "type"=> "nuban",
            ],
            [
                "name"=> "Access Bank",
                "slug"=> "access-bank",
                "code"=> "044",
                "longcode"=> "044150149",
                "type"=> "nuban"
            ],
            [
                "name"=> "Access Bank (Diamond)",
                "slug"=> "access-bank-diamond",
                "code"=> "063",
                "longcode"=> "063150162",
                "type"=> "nuban"
            ],
            [
                "name"=> "ALAT by WEMA",
                "slug"=> "alat-by-wema",
                "code"=> "035A",
                "longcode"=> "035150103",
                "type"=> "nuban"
            ],
            [
                "name"=> "ASO Savings and Loans",
                "slug"=> "asosavings",
                "code"=> "401",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Bowen Microfinance Bank",
                "slug"=> "bowen-microfinance-bank",
                "code"=> "50931",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "CEMCS Microfinance Bank",
                "slug"=> "cemcs-microfinance-bank",
                "code"=> "50823",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Citibank Nigeria",
                "slug"=> "citibank-nigeria",
                "code"=> "023",
                "longcode"=> "023150005",
                "type"=> "nuban"
            ],
            [
                "name"=> "Coronation Merchant Bank",
                "slug"=> "coronation-merchant-bank",
                "code"=> "559",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Ecobank Nigeria",
                "slug"=> "ecobank-nigeria",
                "code"=> "050",
                "longcode"=> "050150010",
                "type"=> "nuban"
            ],
            [
                "name"=> "Ekondo Microfinance Bank",
                "slug"=> "ekondo-microfinance-bank",
                "code"=> "562",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Eyowo",
                "slug"=> "eyowo",
                "code"=> "50126",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Fidelity Bank",
                "slug"=> "fidelity-bank",
                "code"=> "070",
                "longcode"=> "070150003",
                "type"=> "nuban"
            ],
            [
                "name"=> "First Bank of Nigeria",
                "slug"=> "first-bank-of-nigeria",
                "code"=> "011",
                "longcode"=> "011151003",
                "type"=> "nuban"
            ],
            [
                "name"=> "First City Monument Bank",
                "slug"=> "first-city-monument-bank",
                "code"=> "214",
                "longcode"=> "214150018",
                "type"=> "nuban"
            ],
            [
                "name"=> "FSDH Merchant Bank Limited",
                "slug"=> "fsdh-merchant-bank-limited",
                "code"=> "501",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Globus Bank",
                "slug"=> "globus-bank",
                "code"=> "00103",
                "longcode"=> "103015001",
                "type"=> "nuban"
            ],
            [
                "name"=> "Guaranty Trust Bank",
                "slug"=> "guaranty-trust-bank",
                "code"=> "058",
                "longcode"=> "058152036",
                "type"=> "nuban"
            ],
            [
                "name"=> "Hackman Microfinance Bank",
                "slug"=> "hackman-microfinance-bank",
                "code"=> "51251",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Hasal Microfinance Bank",
                "slug"=> "hasal-microfinance-bank",
                "code"=> "50383",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Heritage Bank",
                "slug"=> "heritage-bank",
                "code"=> "030",
                "longcode"=> "030159992",
                "type"=> "nuban"
            ],
            [
                "name"=> "Ibile Microfinance Bank",
                "slug"=> "ibile-mfb",
                "code"=> "51244",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Infinity MFB",
                "slug"=> "infinity-mfb",
                "code"=> "50457",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Jaiz Bank",
                "slug"=> "jaiz-bank",
                "code"=> "301",
                "longcode"=> "301080020",
                "type"=> "nuban"
            ],
            [
                "name"=> "Keystone Bank",
                "slug"=> "keystone-bank",
                "code"=> "082",
                "longcode"=> "082150017",
                "type"=> "nuban"
            ],
            [
                "name"=> "Kuda Bank",
                "slug"=> "kuda-bank",
                "code"=> "50211",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Lagos Building Investment Company Plc.",
                "slug"=> "lbic-plc",
                "code"=> "90052",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Mayfair MFB",
                "slug"=> "mayfair-mfb",
                "code"=> "50563",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "One Finance",
                "slug"=> "one-finance",
                "code"=> "565",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "PalmPay",
                "slug"=> "palmpay",
                "code"=> "999991",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Parallex Bank",
                "slug"=> "parallex-bank",
                "code"=> "526",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Parkway - ReadyCash",
                "slug"=> "parkway-ready-cash",
                "code"=> "311",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Paycom",
                "slug"=> "paycom",
                "code"=> "999992",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Petra Mircofinance Bank Plc",
                "slug"=> "petra-microfinance-bank-plc",
                "code"=> "50746",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Polaris Bank",
                "slug"=> "polaris-bank",
                "code"=> "076",
                "longcode"=> "076151006",
                "type"=> "nuban"
            ],
            [
                "name"=> "Providus Bank",
                "slug"=> "providus-bank",
                "code"=> "101",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Rand Merchant Bank",
                "slug"=> "rand-merchant-bank",
                "code"=> "502",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Rubies MFB",
                "slug"=> "rubies-mfb",
                "code"=> "125",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Sparkle Microfinance Bank",
                "slug"=> "sparkle-microfinance-bank",
                "code"=> "51310",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Stanbic IBTC Bank",
                "slug"=> "stanbic-ibtc-bank",
                "code"=> "221",
                "longcode"=> "221159522",
                "type"=> "nuban"
            ],
            [
                "name"=> "Standard Chartered Bank",
                "slug"=> "standard-chartered-bank",
                "code"=> "068",
                "longcode"=> "068150015",
                "type"=> "nuban"
            ],
            [
                "name"=> "Sterling Bank",
                "slug"=> "sterling-bank",
                "code"=> "232",
                "longcode"=> "232150016",
                "type"=> "nuban"
            ],
            [
                "name"=> "Suntrust Bank",
                "slug"=> "suntrust-bank",
                "code"=> "100",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "TAJ Bank",
                "slug"=> "taj-bank",
                "code"=> "302",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "TCF MFB",
                "slug"=> "tcf-mfb",
                "code"=> "51211",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Titan Bank",
                "slug"=> "titan-bank",
                "code"=> "102",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Union Bank of Nigeria",
                "slug"=> "union-bank-of-nigeria",
                "code"=> "032",
                "longcode"=> "032080474",
                "type"=> "nuban"
            ],
            [
                "name"=> "United Bank For Africa",
                "slug"=> "united-bank-for-africa",
                "code"=> "033",
                "longcode"=> "033153513",
                "type"=> "nuban"
            ],
            [
                "name"=> "Unity Bank",
                "slug"=> "unity-bank",
                "code"=> "215",
                "longcode"=> "215154097",
                "type"=> "nuban"
            ],
            [
                "name"=> "VFD Microfinance Bank Limited",
                "slug"=> "vfd",
                "code"=> "566",
                "longcode"=> "",
                "type"=> "nuban"
            ],
            [
                "name"=> "Wema Bank",
                "slug"=> "wema-bank",
                "code"=> "035",
                "longcode"=> "035150103",
                "type"=> "nuban"
            ],
            [
                "name"=> "Zenith Bank",
                "slug"=> "zenith-bank",
                "code"=> "057",
                "longcode"=> "057150013",
                "type"=> "nuban"
            ]
        ];

        foreach ($banks as $bank) {

            Bank::create([
                'name'      => $bank['name'],
                'slug'      => $bank['slug'],
                'code'      => $bank['code'],
                'longcode'  => $bank['longcode'],
                'type'      => $bank['type']
            ]);
        }
    }
}
