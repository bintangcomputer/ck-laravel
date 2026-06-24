<x-filament-panels::page>

    <div class="grid grid-cols-2 gap-4 mb-4">

        <div>
            <label>Tanggal Awal</label>

            <input
                type="date"
                wire:model="dateFrom"
                class="w-full border rounded p-2">
        </div>

        <div>
            <label>Tanggal Akhir</label>

            <input
                type="date"
                wire:model="dateTo"
                class="w-full border rounded p-2">
        </div>

    </div>

    <button
        wire:click="tampilkan"
        class="px-4 py-2 bg-primary-600 text-white rounded">

        Tampilkan

    </button>

    <div class="mt-6">

        <table class="w-full border">

            <thead>

                <tr class="border-b">

                    <th class="text-left p-2">No Bukti</th>
                    <th class="text-left p-2">Tanggal</th>
                    <th class="text-left p-2">Customer</th>
                    <th class="text-left p-2">negara</th>
                    <th class="text-right p-2">Total</th>
                    <th class="text-center p-2">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach($buyings as $buying)

                <tr class="border-b">

                    <td class="p-2">
                        {{ $buying->bill_no }}
                    </td>

                    <td class="p-2">
                        {{ $buying->date }}
                    </td>

                    <td class="p-2">
                        {{ $buying->customer_name }}
                    </td>

                    <td class="p-2">
                        {{ $buying->country_name }}
                    </td>


                    <td class="p-2 text-right">
                        {{ number_format($buying->total, 2) }}
                    </td>

                    <td class="text-center p-2">

                        <a
                            href="/admin/buyings/{{ $buying->id }}/edit"
                            class="px-3 py-1 bg-primary-600 text-white rounded">

                            Detail

                        </a>



                        <!-- <a
                            href="/admin/buyings/{{ $buying->id }}/edit"
                            class="px-3 py-1 bg-blue-600 text-white rounded mr-2">

                            Detail

                        </a> -->

                        <!-- <a
                            href="/admin/buying-print?id={{ $buying->id }}"
                            target="_blank"

                            class="fi-btn fi-btn-color-success">

                            Cetak

                        </a> -->

                        <!-- <a
                            href="/admin/buying-print?id={{ $buying->id }}"
                            target="_blank"
                            class="fi-btn fi-btn-color-success">

                            Cetak

                        </a> -->
                        <a
                            href="/admin/buying-print?id={{ $buying->id }}"

                            class="fi-btn fi-btn-color-success">

                            Cetak

                        </a>


                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

        <!-- <div class="mt-4 text-right font-bold text-lg">
            Grand Total :
            {{ number_format($grandTotal, 2) }}
        </div> -->

        <!-- <div class="mt-4 text-right">

            <span class="font-bold">
                Grand Total :
            </span>

            {{ number_format($grandTotal, 2) }}

        </div> -->

        <div class="mt-4 text-right text-lg font-bold">

            Grand Total :
            Rp.{{ number_format($grandTotal, 2) }}

        </div>

    </div>

</x-filament-panels::page>