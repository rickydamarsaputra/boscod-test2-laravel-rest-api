<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\RekeningAdmin;
use App\Models\TransaksiTransfer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\returnSelf;

class TransaksiController extends Controller
{
    public function transfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nilai_transfer' => 'required',
            'bank_tujuan' => 'required',
            'rekening_tujuan' => 'required',
            'atasnama_tujuan' => 'required',
            'bank_pengirim' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $transaksi_id = TransaksiTransfer::generateTransactionId();
            $kode_unik = rand(100, 999);
            $biaya_admin = 2500;
            $total_transfer = $request->input('nilai_transfer') + $biaya_admin;

            $bank_pengirim_id = Bank::where('nama_bank', $request->input('bank_pengirim'))->first();
            $bank_tujuan_id = Bank::where('nama_bank', $request->input('bank_tujuan'))->first();
            $bank_perantara_id = Bank::where('nama_bank', $request->input('bank_pengirim'))->first();
            $admin = RekeningAdmin::where('nama_pemilik', $request->input('atasnama_tujuan'))
                ->where('nomor_rekening', $request->input('rekening_tujuan'))
                ->first();

            if (!$bank_pengirim_id) return response()->json(['errors' => 'bank pengirim not found!'], Response::HTTP_BAD_REQUEST);
            if (!$bank_tujuan_id) return response()->json(['errors' => 'bank tujuan not found!'], Response::HTTP_BAD_REQUEST);
            if (!$bank_perantara_id) return response()->json(['errors' => 'bank perantara not found!'], Response::HTTP_BAD_REQUEST);
            if (!$admin) return response()->json(['errors' => 'admin name or rekening tujuan invalid!'], Response::HTTP_BAD_REQUEST);

            $transaksi = TransaksiTransfer::create([
                'user_id' => auth()->user()->id,
                'id_transaksi' => $transaksi_id,
                'bank_pengirim_id' => $bank_pengirim_id->id,
                'bank_tujuan_id' => $bank_tujuan_id->id,
                'bank_perantara_id' => $bank_perantara_id->id,
                'nilai_transfer' => $request->input('nilai_transfer'),
                'kode_unik' => $kode_unik,
                'biaya_admin' => $biaya_admin,
                'total_transfer' => $total_transfer,
                'rekening_tujuan' => $admin->nomor_rekening,
                'atasnama_tujuan' => $admin->nama_pemilik,
                'rekening_perantara' => $admin->nomor_rekening,
                'berlaku_hingga' => Carbon::now()->addDay()->toDateTimeString()
            ]);

            return response()->json([
                'id_transaksi' =>  $transaksi->id_transaksi,
                'nilai_transfer' => $transaksi->nilai_transfer,
                'kode_unik' => $transaksi->kode_unik,
                'biaya_admin' => $transaksi->biaya_admin,
                'total_transfer' => $transaksi->total_transfer,
                'bank_perantara' => $transaksi->bank_perantara->nama_bank,
                'rekening_perantara' => $transaksi->rekening_perantara,
                'berlaku_hingga' => $transaksi->berlaku_hingga
            ], Response::HTTP_OK);
        } catch (\Exception $err) {
            return response()->json(['errors' => 'failed to transfer'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json('transfer');
    }
}
