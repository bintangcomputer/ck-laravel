<x-filament-panels::page>



    <div class="mb-4">

        <button
            type="button"
            onclick="window.print()"
            class="fi-btn fi-btn-color-success">

            Print

        </button>


    </div>

    <!-- <div class="bg-white p-6 rounded">  CARA YG INI TIDAK BERFUNGSI-->
    <div class="print-area">


        <div class="text-center mb-4">

            <!-- company.name, address, phone sudah didefinisikan di config
             ada di \config\company.php -->

            <h1 class="text-2xl font-bold">
                {{ config('company.name') }}
            </h1>

            <!-- <h1 class="text-3xl font-bold">
                PT BINTANG MEDIA COMPUTER
            </h1> -->

            <p class="text-sm">
                {{ config('company.address') }}
            </p>

            <p class="text-sm">
                {{ config('company.phone') }}
            </p>


            <hr style="border:none;border-top:2px #888 solid;">
            <p class="text-1xl font-bold mb-4">
                BUKTI PEMBELIAN VALAS
            </p>
        </div>
        <!-- <hr style="border:1px solid black;"> -->
        <!-- <hr style="border:none;border-top:1px #888 solid;"> -->



        <table class="mb-4">
            <tr>
                <td>No Bukti</td>
                <td>: {{ $buying->bill_no }}</td>
            </tr>

            <tr>
                <td>Tanggal</td>
                <!-- <td>: {{ $buying->date }}</td> -->
                <td>
                    : {{ \Carbon\Carbon::parse($buying->date)->format('d-m-Y') }}
                </td>

            </tr>

            <tr>
                <td>Jam</td>
                <!-- INI PAKAI DETIK JUGA -->
                <td>: {{ $buying->time }}</td>
                <!-- INI TANPA DETIK -->
                <!-- <td>
                    : {{ \Carbon\Carbon::parse($buying->time)->format('H:i') }}
                </td> -->
            </tr>

            <tr>
                <td>Customer</td>
                <td>: {{ $buying->customer_name }}</td>
            </tr>

            <tr>
                <td>Negara</td>
                <td>: {{ $buying->country_name }}</td>
            </tr>
        </table>

        <table class="w-full border">

            <thead>

                <tr class="border-b">

                    <th class="text-left p-2">Valas</th>
                    <th class="text-right p-2">Nominal</th>
                    <th class="text-right p-2">Kurs</th>
                    <th class="text-right p-2">Subtotal</th>

                </tr>

            </thead>

            <tbody>

                @foreach($buying->items as $item)

                <tr class="border-b">

                    <td class="p-2">
                        {{ $item->currency_code }}
                    </td>

                    <td class="p-2 text-right">
                        {{ number_format($item->nominal, 2) }}
                    </td>

                    <td class="p-2 text-right">
                        {{ number_format($item->buying_rate, 2) }}
                    </td>

                    <td class="p-2 text-right">
                        {{ number_format($item->subtotal, 2) }}
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

        <div class="mt-4 text-right text-lg font-bold">

            TOTAL :
            {{ number_format($buying->total, 2) }}

        </div>
        <!-- untuk tandatangan -->
        <div class="mt-12">

            <table class="w-full">

                <tr>

                    <td class="text-center">
                        Diterima Oleh
                    </td>

                    <td class="text-center">
                        Petugas
                    </td>

                </tr>

                <tr>
                    <td style="height:80px;"></td>
                    <td></td>
                </tr>

                <tr>

                    <td class="text-center">
                        ( __________________ )
                    </td>

                    <td class="text-center">
                        ( __________________ )
                    </td>

                </tr>

            </table>

        </div>



    </div>


    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }


        @media print {

            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>

</x-filament-panels::page>