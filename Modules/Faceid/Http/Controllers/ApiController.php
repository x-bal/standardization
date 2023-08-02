<?php

namespace Modules\Faceid\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Faceid\Entities\Device;
use Modules\Faceid\Entities\FotoKaryawan;
use Modules\Faceid\Entities\Log;
use Modules\Faceid\Entities\Setting;

class ApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $now = Carbon::now('Asia/Jakarta')->format('YmdHis');

            $foto = $request->file('foto');
            $fotoUrl = $foto->storeAs('logs', $now . '-' . rand(1000, 9999) . '.' . $foto->extension());

            $device = Device::where('iddev', $request->id_device)->first();

            $user = FotoKaryawan::where('employe_id', $request->employeeid)->first();

            $setting = Setting::find(1);

            if ($request->beard == 0 && $request->moustache == 0 && $request->suhu < $setting->limit) {
                $status = "Healthy";
            } else {
                $status = "Not Healthy";
            }

            Log::create([
                'user_id' => $user->user_id,
                'device_id' => $device->id,
                'moustache' => $request->moustache,
                'beard' => $request->beard,
                'suhu' => $request->suhu,
                'waktu' => $request->waktu,
                'foto' => $fotoUrl,
                'status' => $status
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => "Log berhasil disimpan"
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    function karyawan()
    {
        $arrayVar = [
            "data" => [
                [
                    "id" => 1,
                    "nik" => "050700014",
                    "nama" => "DIDIK BUDIARTO",
                    "username" => "didik.budiarto",
                    "inisial" => "DBO",
                    "email" => "didik.budiarto@kalbenutritionals.com",
                    "ext" => "700",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 2,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Department",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 1,
                            "namajabatan" =>
                            "Business Development & Analysis Dept Head",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 3, "namalevel" => "Dept Head"],
                    ],
                ],
                [
                    "id" => 2,
                    "nik" => "051000017",
                    "nama" => "I GEDE PUTU EKA PUTRA",
                    "username" => "eka.putra",
                    "inisial" => "IGP",
                    "email" => "eka.putra@kalbenutritionals.com",
                    "ext" => "100",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 5, "namalokasi" => "SHP"],
                        "divisi" => ["intiddivisi" => 1, "namadivisi" => "BOD"],
                        "departemen" => [
                            "intiddepartemen" => 2,
                            "namadepartemen" => "BOD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 1,
                            "namasubdepartemen" => "BOD",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 2,
                            "namajabatan" => "President Director",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 1, "namalevel" => "Director"],
                    ],
                ],
                [
                    "id" => 3,
                    "nik" => "060500014",
                    "nama" => "YUDHA AGUS TRI BASUKI",
                    "username" => "yudha.agus",
                    "inisial" => "YAT",
                    "email" => "yudha.agus@kalbenutritionals.com",
                    "ext" => "102",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 3,
                            "namadepartemen" => "MNF",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 21,
                            "namasubdepartemen" => "Manufacturing Department",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 3,
                            "namajabatan" => "Manufacturing Head",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 3, "namalevel" => "Dept Head"],
                    ],
                ],
                [
                    "id" => 4,
                    "nik" => "060500015",
                    "nama" => "APOLONIA LAURENSIA LUNAWATI. N",
                    "username" => "apolonia.n",
                    "inisial" => "ALL",
                    "email" => "apolonia.n@kalbenutritionals.com",
                    "ext" => "103",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 5, "namalokasi" => "SHP"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 10,
                            "namasubdepartemen" => "Human Capital Department",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 4,
                            "namajabatan" => "Sr Dept Head of HRBP, Operation GA",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 3, "namalevel" => "Dept Head"],
                    ],
                ],
                [
                    "id" => 5,
                    "nik" => "060800020",
                    "nama" => "YUNIARTO",
                    "username" => "yuniarto.rasian",
                    "inisial" => "YTO",
                    "email" => "yuniarto.rasian@kalbenutritionals.com",
                    "ext" => "420",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 7,
                            "namasubdepartemen" => "Engineering Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 6,
                            "namajabatan" => "Operational Maintenance Supervisor 1",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 6,
                    "nik" => "060800022",
                    "nama" => "YAYAN",
                    "username" => "yayan.yayan",
                    "inisial" => "YYN",
                    "email" => "yayan.yayan@kalbenutritionals.com",
                    "ext" => "212",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 4,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 7,
                            "namajabatan" => "Store Keeper BDA",
                        ],
                        "cg" => ["intidcg" => 2, "namacg" => "SHINING"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 7,
                    "nik" => "060900024",
                    "nama" => "NURHASAN",
                    "username" => "nurhasan.nurhasan",
                    "inisial" => "NHS",
                    "email" => "nurhasan.nurhasan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 8,
                            "namajabatan" => "Drier Group Leader",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 8,
                    "nik" => "060900025",
                    "nama" => "DENY MUHAMAD MULYADI",
                    "username" => "deny.mulyadi",
                    "inisial" => "DMM",
                    "email" => "deny.mulyadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 10, "namalokasi" => "Utility"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 9,
                            "namajabatan" => "Utility Leader",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 9,
                    "nik" => "061000028",
                    "nama" => "SUHATMAN",
                    "username" => "suhatman.suhatman",
                    "inisial" => "SHM",
                    "email" => "suhatman.suhatman@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 10,
                            "namajabatan" => "Wet Sachet Group Leader",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 10,
                    "nik" => "061100030",
                    "nama" => "AFRIAN CHANDRA IDRIS",
                    "username" => "afrian.idris",
                    "inisial" => "ACI",
                    "email" => "afrian.idris@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 11,
                            "namajabatan" => "Mechanical Technician",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 11,
                    "nik" => "061100031",
                    "nama" => "DARYONO",
                    "username" => "daryono.daryono",
                    "inisial" => "DRO",
                    "email" => "daryono.daryono@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 12,
                            "namajabatan" => "Bin Filling Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 12,
                    "nik" => "061100032",
                    "nama" => "MUHAMAD EFENDI",
                    "username" => "muhamad.efendi",
                    "inisial" => "MEI",
                    "email" => "muhamad.efendi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 28,
                            "namasubdepartemen" => "Production Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 13,
                            "namajabatan" => "Bin Washing Circle Leader",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 13,
                    "nik" => "061100034",
                    "nama" => "TIWIK SUYANTI",
                    "username" => "tiwik.suyanti",
                    "inisial" => "TSI",
                    "email" => "tiwik.suyanti@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 32,
                            "namasubdepartemen" => "QA Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 15,
                            "namajabatan" => "QA In Line Staff",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 14,
                    "nik" => "061200036",
                    "nama" => "ADE SAPRUDIN",
                    "username" => "ade.saprudin",
                    "inisial" => "ASN",
                    "email" => "ade.saprudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 17,
                            "namajabatan" => "Compounding Operator",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 15,
                    "nik" => "061200037",
                    "nama" => "ASEP CAHYAN",
                    "username" => "asep.cahyan",
                    "inisial" => "ASC",
                    "email" => "asep.cahyan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 18,
                            "namajabatan" => "Tipping Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 16,
                    "nik" => "061200038",
                    "nama" => "SAMIDI",
                    "username" => "samidi.samidi",
                    "inisial" => "SMI",
                    "email" => "samidi.samidi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 28,
                            "namasubdepartemen" => "Production Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 19,
                            "namajabatan" => "Drier Circle Leader",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 17,
                    "nik" => "061200039",
                    "nama" => "SUNGATNO",
                    "username" => "sungatno.hadi",
                    "inisial" => "SGO",
                    "email" => "sungatno.hadi@kalbenutritionals.com",
                    "ext" => "320",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 26,
                            "namasubdepartemen" => "Production Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 20,
                            "namajabatan" => "Process & Drier Supervisor 2",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 18,
                    "nik" => "061200040",
                    "nama" => "ZAINI",
                    "username" => "zaini.zaini",
                    "inisial" => "ZII",
                    "email" => "zaini.zaini@kalbenutritionals.com",
                    "ext" => "236",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 28,
                            "namasubdepartemen" => "Production Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 21,
                            "namajabatan" => "Filling & Packing Coordinator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 19,
                    "nik" => "061200041",
                    "nama" => "MUNADIH",
                    "username" => "munadih.munadih",
                    "inisial" => "MND",
                    "email" => "munadih.munadih@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 28,
                            "namasubdepartemen" => "Production Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 22,
                            "namajabatan" => "Wet Canning Circle Leader",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 20,
                    "nik" => "061200042",
                    "nama" => "NANDANG SUTISNA",
                    "username" => "nandang.sutisna",
                    "inisial" => "NSA",
                    "email" => "nandang.sutisna@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 8,
                            "namajabatan" => "Drier Group Leader",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 21,
                    "nik" => "061200043",
                    "nama" => "YUNUS JOHN BILORO",
                    "username" => "yunus.biloro",
                    "inisial" => "YJB",
                    "email" => "yunus.biloro@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 5,
                            "namadepartemen" => "IOS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 17,
                            "namasubdepartemen" => "IOS Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 23,
                            "namajabatan" => "IOS Jr Staff (Hybrid)",
                        ],
                        "cg" => ["intidcg" => 8, "namacg" => "RISING STAR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 22,
                    "nik" => "061200045",
                    "nama" => "KUSNADI RUDI",
                    "username" => "kusnadi.rudi",
                    "inisial" => "KRI",
                    "email" => "kusnadi.rudi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 24,
                            "namajabatan" => "Utility Operator",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 23,
                    "nik" => "070100001",
                    "nama" => "ADI SETIAHADI",
                    "username" => "adi.setiahadi",
                    "inisial" => "ASI",
                    "email" => "adi.setiahadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 34,
                            "namasubdepartemen" => "Warehouse Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 25,
                            "namajabatan" => "Warehouse Supervisor",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 24,
                    "nik" => "070100004",
                    "nama" => "AGUS TURANTO",
                    "username" => "agus.turanto",
                    "inisial" => "ATO",
                    "email" => "agus.turanto@kalbenutritionals.com",
                    "ext" => "210",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 26,
                            "namasubdepartemen" => "Production Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 26,
                            "namajabatan" => "Process & Drier  Supervisor 1",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 25,
                    "nik" => "070100007",
                    "nama" => "EKO WAHYUDI",
                    "username" => "eko.wahyudi",
                    "inisial" => "EWI",
                    "email" => "eko.wahyudi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 27,
                            "namajabatan" => "Mechanical Analyst",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 26,
                    "nik" => "070100013",
                    "nama" => "AGUS RIYANTO",
                    "username" => "agus.riyanto",
                    "inisial" => "ARO",
                    "email" => "agus.riyanto@kalbenutritionals.com",
                    "ext" => "720",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 3,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 28,
                            "namajabatan" => "Purchasing, Legal & Regulator Supervisor",
                        ],
                        "cg" => ["intidcg" => 2, "namacg" => "SHINING"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 27,
                    "nik" => "070100015",
                    "nama" => "RADEN ABBAS FAUZI",
                    "username" => "raden.fauzi",
                    "inisial" => "RAF",
                    "email" => "raden.fauzi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 28,
                    "nik" => "070100024",
                    "nama" => "YUSUP HAMDANI",
                    "username" => "yusuf.hamdani",
                    "inisial" => "YHI",
                    "email" => "yusuf.hamdani@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 30,
                            "namajabatan" => "Spray Drier Group Leader",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 29,
                    "nik" => "070200028",
                    "nama" => "JAKARIA (SK)",
                    "username" => "jakaria.(sk)",
                    "inisial" => "JSK",
                    "email" => "jakaria.(sk)@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 31,
                            "namajabatan" => "Fat Blend & Mixing Circle Leader",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 30,
                    "nik" => "070200029",
                    "nama" => "RAHMAT NURHIDAYAT",
                    "username" => "rahmat.nurhidayat",
                    "inisial" => "RNT",
                    "email" => "rahmat.nurhidayat@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 32,
                            "namajabatan" => "Evaporator Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 31,
                    "nik" => "070200030",
                    "nama" => "ARDIAN",
                    "username" => "ardian.ardian",
                    "inisial" => "ARN",
                    "email" => "ardian.ardian@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 33,
                            "namajabatan" => "Warehouse RM Major Preparator",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 32,
                    "nik" => "070200031",
                    "nama" => "YULIANTO",
                    "username" => "yulianto.yulianto",
                    "inisial" => "YLO",
                    "email" => "yulianto.yulianto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 36,
                            "namasubdepartemen" => "Warehouse Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 34,
                            "namajabatan" => "Warehouse PM Staff",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 33,
                    "nik" => "070300033",
                    "nama" => "ASEP HAEDAR",
                    "username" => "asep.haedar",
                    "inisial" => "AHR",
                    "email" => "asep.haedar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 32,
                            "namajabatan" => "Evaporator Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 34,
                    "nik" => "070300036",
                    "nama" => "JOJON DARSONO YOGA JAYA",
                    "username" => "jojon.jaya",
                    "inisial" => "JDY",
                    "email" => "jojon.jaya@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 5,
                            "namadepartemen" => "IOS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 17,
                            "namasubdepartemen" => "IOS Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 35,
                            "namajabatan" => "SHE Staff",
                        ],
                        "cg" => ["intidcg" => 8, "namacg" => "RISING STAR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 35,
                    "nik" => "070400065",
                    "nama" => "MARLENY PATANDUNG",
                    "username" => "marleny.patandung",
                    "inisial" => "MPG",
                    "email" => "marleny.patandung@kalbenutritionals.com",
                    "ext" => "500",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 33,
                            "namasubdepartemen" => "Warehouse Department",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 36,
                            "namajabatan" => "Warehouse Dept Head",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 3, "namalevel" => "Dept Head"],
                    ],
                ],
                [
                    "id" => 36,
                    "nik" => "070400068",
                    "nama" => "DWI ISDARYANTO",
                    "username" => "dwi.isdaryanto",
                    "inisial" => "DIO",
                    "email" => "dwi.isdaryanto@kalbenutritionals.com",
                    "ext" => "513",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 36,
                            "namasubdepartemen" => "Warehouse Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 37,
                            "namajabatan" => "Warehouse RM Major Staff",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 37,
                    "nik" => "070500078",
                    "nama" => "NAFIS SURACHMAN",
                    "username" => "nafis.surachman",
                    "inisial" => "NSN",
                    "email" => "nafis.surachman@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 11,
                            "namajabatan" => "Mechanical Technician",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 38,
                    "nik" => "070600083",
                    "nama" => "HENDI ISKANDAR",
                    "username" => "hendi.iskandar",
                    "inisial" => "HIR",
                    "email" => "hendi.iskandar@kalbenutritionals.com",
                    "ext" => "310",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 3, "namalokasi" => "Office Lt 3"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 30,
                            "namasubdepartemen" => "QA Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 38,
                            "namajabatan" => "QA Laboratory Supervisor",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 39,
                    "nik" => "080900029",
                    "nama" => "ADE NANDAR",
                    "username" => "ade.nandar",
                    "inisial" => "ANR",
                    "email" => "ade.nandar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 39,
                            "namajabatan" => "Dry Sachet Group Leader",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 40,
                    "nik" => "080900030",
                    "nama" => "BUGI NOVRIYANTO",
                    "username" => "bugi.novriyanto",
                    "inisial" => "BNO",
                    "email" => "bugi.novriyanto@kalbenutritionals.com",
                    "ext" => "220",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 26,
                            "namasubdepartemen" => "Production Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 40,
                            "namajabatan" => "Filling & Packing Supervisor",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 41,
                    "nik" => "080900031",
                    "nama" => "DWI KURNIAWAN",
                    "username" => "dwi.kurniawan",
                    "inisial" => "DKN",
                    "email" => "dwi.kurniawan@kalbenutritionals.com",
                    "ext" => "301",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 3, "namalokasi" => "Office Lt 3"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 32,
                            "namasubdepartemen" => "QA Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 41,
                            "namajabatan" => "QA Staff",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 42,
                    "nik" => "080900032",
                    "nama" => "FEBI DIANA",
                    "username" => "febi.diana",
                    "inisial" => "FDA",
                    "email" => "febi.diana@kalbenutritionals.com",
                    "ext" => "713",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 5,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 42,
                            "namajabatan" => "Finance & Accounting Staff",
                        ],
                        "cg" => ["intidcg" => 1, "namacg" => "AVATAR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 43,
                    "nik" => "080900033",
                    "nama" => "LINDA LABORA",
                    "username" => "linda.labora",
                    "inisial" => "LLA",
                    "email" => "linda.labora@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 43,
                            "namajabatan" => "Wet Canning Group Leader",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 44,
                    "nik" => "081000037",
                    "nama" => "DIAWAN",
                    "username" => "diawan.diawan",
                    "inisial" => "DWN",
                    "email" => "diawan.diawan@kalbenutritionals.com",
                    "ext" => "511",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 36,
                            "namasubdepartemen" => "Warehouse Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 44,
                            "namajabatan" => "Warehouse RM Minor Staff",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 45,
                    "nik" => "090593002",
                    "nama" => "HALILY SOFYAN AL HASAN",
                    "username" => "halily.sofyan",
                    "inisial" => "HSN",
                    "email" => "halily.sofyan@kalbenutritionals.com",
                    "ext" => "811",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 3, "namalokasi" => "Office Lt 3"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 5,
                            "namadepartemen" => "IOS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 17,
                            "namasubdepartemen" => "IOS Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 45,
                            "namajabatan" => "System Staff",
                        ],
                        "cg" => ["intidcg" => 8, "namacg" => "RISING STAR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 46,
                    "nik" => "100192702",
                    "nama" => "AGUNG HARTANTO",
                    "username" => "agung.hartanto",
                    "inisial" => "AHO",
                    "email" => "agung.hartanto@kalbenutritionals.com",
                    "ext" => "901",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 10,
                            "namadepartemen" => "MDP",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 20,
                            "namasubdepartemen" => "IT Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 46,
                            "namajabatan" =>
                            "Manufacturing Development & Planing Staff-IT",
                        ],
                        "cg" => ["intidcg" => 11, "namacg" => "MATRIX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 47,
                    "nik" => "100192704",
                    "nama" => "IKA OKTAFIANTI",
                    "username" => "ika.oktafianti",
                    "inisial" => "IOI",
                    "email" => "ika.oktafianti@kalbenutritionals.com",
                    "ext" => "721",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 5,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 47,
                            "namajabatan" => "Purchasing Staff",
                        ],
                        "cg" => ["intidcg" => 2, "namacg" => "SHINING"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 48,
                    "nik" => "100192705",
                    "nama" => "SAEPULLAH",
                    "username" => "saepullah.saepullah",
                    "inisial" => "SPH",
                    "email" => "saepullah.saepullah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 48,
                            "namajabatan" => "CIP Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 49,
                    "nik" => "100200007",
                    "nama" => "BURHANUDIN",
                    "username" => "burhanudin.burhanudin",
                    "inisial" => "BHN",
                    "email" => "burhanudin.burhanudin@kalbenutritionals.com",
                    "ext" => "410",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 7,
                            "namasubdepartemen" => "Engineering Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 49,
                            "namajabatan" => "Operational Maintenance Supervisor 2",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 50,
                    "nik" => "100300009",
                    "nama" => "NAZARUDIN RACHMAN SIDIK",
                    "username" => "nazarudin.sidik",
                    "inisial" => "NRS",
                    "email" => "nazarudin.sidik@kalbenutritionals.com",
                    "ext" => "900",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 3,
                            "namadepartemen" => "MNF",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 21,
                            "namasubdepartemen" => "Manufacturing Department",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 50,
                            "namajabatan" =>
                            "Manufacturing Development & Planning Dept Head",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 3, "namalevel" => "Dept Head"],
                    ],
                ],
                [
                    "id" => 51,
                    "nik" => "100492706",
                    "nama" => "SEPTIAN EKO PRIATNA",
                    "username" => "septian.priatna",
                    "inisial" => "SEP",
                    "email" => "septian.priatna@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 51,
                            "namajabatan" => "QC In Line Group Leader",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 52,
                    "nik" => "100892708",
                    "nama" => "DEDE DODI GINANJAR",
                    "username" => "dede.ginanjar",
                    "inisial" => "DDG",
                    "email" => "dede.ginanjar@kalbenutritionals.com",
                    "ext" => "201",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 28,
                            "namasubdepartemen" => "Production Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 52,
                            "namajabatan" => "Production Staff",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 53,
                    "nik" => "100892709",
                    "nama" => "RAHMAT KURNIAWAN",
                    "username" => "rahmat.kurniawan",
                    "inisial" => "RKN",
                    "email" => "rahmat.kurniawan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 39,
                            "namajabatan" => "Dry Sachet Group Leader",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 54,
                    "nik" => "100892710",
                    "nama" => "SOLEHUDIN",
                    "username" => "solehudin.solehudin",
                    "inisial" => "SLH",
                    "email" => "solehudin.solehudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 39,
                            "namajabatan" => "Dry Sachet Group Leader",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 55,
                    "nik" => "100992711",
                    "nama" => "SITI RIZKIANA NURANNISA",
                    "username" => "siti.nurannisa",
                    "inisial" => "SRN",
                    "email" => "siti.nurannisa@kalbenutritionals.com",
                    "ext" => "311",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 32,
                            "namasubdepartemen" => "QA Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 53,
                            "namajabatan" => "QA Laboratory Group Leader",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 56,
                    "nik" => "110191206",
                    "nama" => "AGA WALESSA",
                    "username" => "aga.walessa",
                    "inisial" => "AWA",
                    "email" => "aga.walessa@kalbenutritionals.com",
                    "ext" => "801",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 3, "namalokasi" => "Office Lt 3"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 5,
                            "namadepartemen" => "IOS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 17,
                            "namasubdepartemen" => "IOS Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 54,
                            "namajabatan" => "CG Leader (Hybrid)",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 57,
                    "nik" => "110191207",
                    "nama" => "MAULANA ABDUL SALIM",
                    "username" => "maulana.salim",
                    "inisial" => "MAS",
                    "email" => "maulana.salim@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 55,
                            "namajabatan" => "Blending Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 58,
                    "nik" => "110191208",
                    "nama" => "UUM UMBARA",
                    "username" => "uum.umbara",
                    "inisial" => "UUA",
                    "email" => "uum.umbara@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 56,
                            "namajabatan" => "Blending Operator",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 59,
                    "nik" => "110191209",
                    "nama" => "YERI KUSNADI",
                    "username" => "yeri.kusnadi",
                    "inisial" => "YKI",
                    "email" => "yeri.kusnadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 57,
                            "namajabatan" => "Processing Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 60,
                    "nik" => "110891211",
                    "nama" => "ADE HUMAENI",
                    "username" => "ade.humaeni",
                    "inisial" => "AHI",
                    "email" => "ade.humaeni@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 10,
                            "namajabatan" => "Wet Sachet Group Leader",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 61,
                    "nik" => "110891212",
                    "nama" => "MARKUS",
                    "username" => "markus.markus",
                    "inisial" => "MRS",
                    "email" => "markus.markus@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 58,
                            "namajabatan" => "Bin Filling Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 62,
                    "nik" => "110900055",
                    "nama" => "HERMANSYAH",
                    "username" => "hermansyah.hermansyah",
                    "inisial" => "HCO",
                    "email" => "hermansyah.hermansyah@kalbenutritionals.com",
                    "ext" => "800",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 5,
                            "namadepartemen" => "IOS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 14,
                            "namasubdepartemen" => "IOS Department",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 59,
                            "namajabatan" => "Integrated Operation System Dept. Head",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 3, "namalevel" => "Dept Head"],
                    ],
                ],
                [
                    "id" => 63,
                    "nik" => "111200086",
                    "nama" => "SADHU PUTRI SUSANTI",
                    "username" => "sadhu.susanti",
                    "inisial" => "SPS",
                    "email" => "sadhu.susanti@kalbenutritionals.com",
                    "ext" => "710",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 3,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 60,
                            "namajabatan" => "Finance & Accounting Supervisor",
                        ],
                        "cg" => ["intidcg" => 1, "namacg" => "AVATAR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 64,
                    "nik" => "120192502",
                    "nama" => "ADRI FIRMANSYAH",
                    "username" => "adri.firmansyah",
                    "inisial" => "ADF",
                    "email" => "adri.firmansyah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 61,
                            "namajabatan" => "Blending & Dumping Circle Leader",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 65,
                    "nik" => "120192503",
                    "nama" => "ARDISON",
                    "username" => "ardison.ardison",
                    "inisial" => "SON",
                    "email" => "ardison.ardison@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 62,
                            "namajabatan" => "Bin Washing Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 66,
                    "nik" => "120192504",
                    "nama" => "EKO ARIES SANTOSO",
                    "username" => "eko.santoso",
                    "inisial" => "EAS",
                    "email" => "eko.santoso@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 9, "namalokasi" => "Store Room"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 4,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 7,
                            "namajabatan" => "Store Keeper BDA",
                        ],
                        "cg" => ["intidcg" => 2, "namacg" => "SHINING"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 67,
                    "nik" => "120192505",
                    "nama" => "JAJANG ABDUL ROHMAN",
                    "username" => "jajang.rohman",
                    "inisial" => "JAR",
                    "email" => "jajang.rohman@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 63,
                            "namajabatan" => "Eductor Operator",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 68,
                    "nik" => "120192506",
                    "nama" => "NURJANAH",
                    "username" => "nurjanah.nurjanah",
                    "inisial" => "NJH",
                    "email" => "nurjanah.nurjanah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 64,
                            "namajabatan" => "Dry Sachet Tipping Operator",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 69,
                    "nik" => "120192507",
                    "nama" => "SAEPUDIN",
                    "username" => "saepudin.saepudin",
                    "inisial" => "SPD",
                    "email" => "saepudin.saepudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 65,
                            "namajabatan" => "Powder Mixer Operator",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 70,
                    "nik" => "120192508",
                    "nama" => "TARMAN SUTISNA",
                    "username" => "tarman.sutisna",
                    "inisial" => "UGI",
                    "email" => "tarman.sutisna@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 66,
                            "namajabatan" => "Can Packing Operator",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 71,
                    "nik" => "120192509",
                    "nama" => "USEP YUSEPA",
                    "username" => "usep.yusepa",
                    "inisial" => "UYA",
                    "email" => "usep.yusepa@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 18,
                            "namajabatan" => "Tipping Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 72,
                    "nik" => "120192510",
                    "nama" => "YAYAT HIDAYAT",
                    "username" => "yayat.hidayat",
                    "inisial" => "YHT",
                    "email" => "yayat.hidayat@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 67,
                            "namajabatan" => "Dry Sachet Circle Leader",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 73,
                    "nik" => "120200010",
                    "nama" => "AGUNG JOKO SUPRIHANTO",
                    "username" => "agung.suprihanto",
                    "inisial" => "AJS",
                    "email" => "agung.suprihanto@kalbenutritionals.com",
                    "ext" => "820",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 3, "namalokasi" => "Office Lt 3"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 5,
                            "namadepartemen" => "IOS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 15,
                            "namasubdepartemen" => "IOS Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 68,
                            "namajabatan" => "System Management Supervisor",
                        ],
                        "cg" => ["intidcg" => 8, "namacg" => "RISING STAR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 74,
                    "nik" => "120292511",
                    "nama" => "AHMAD SAHRONI",
                    "username" => "ahmad.sahroni",
                    "inisial" => "ASR",
                    "email" => "ahmad.sahroni@kalbenutritionals.com",
                    "ext" => "202",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 69,
                            "namajabatan" => "Junior Production Staff",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 75,
                    "nik" => "120292512",
                    "nama" => "DENY SUPRAPTO",
                    "username" => "deny.suprapto",
                    "inisial" => "DSO",
                    "email" => "deny.suprapto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 70,
                            "namajabatan" => "QC Incoming Analyst",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 76,
                    "nik" => "120292513",
                    "nama" => "DIAN SANJAYA",
                    "username" => "dian.sanjaya",
                    "inisial" => "DSA",
                    "email" => "dian.sanjaya@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 65,
                            "namajabatan" => "Powder Mixer Operator",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 77,
                    "nik" => "120292514",
                    "nama" => "HERMAWAN",
                    "username" => "hermawan.hermawan",
                    "inisial" => "HMN",
                    "email" => "hermawan.hermawan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 48,
                            "namajabatan" => "CIP Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 78,
                    "nik" => "120292515",
                    "nama" => "RUDI SUGIARTO",
                    "username" => "rudi.sugiarto",
                    "inisial" => "RSO",
                    "email" => "rudi.sugiarto@kalbenutritionals.com",
                    "ext" => "821",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 3, "namalokasi" => "Office Lt 3"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 5,
                            "namadepartemen" => "IOS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 16,
                            "namasubdepartemen" => "IOS Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 71,
                            "namajabatan" => "Improvement Junior Staff",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 13, "namalevel" => "Komite"],
                    ],
                ],
                [
                    "id" => 79,
                    "nik" => "120292516",
                    "nama" => "YAYAT NURHIDAYAT",
                    "username" => "yayat.nurhidayat",
                    "inisial" => "YNT",
                    "email" => "yayat.nurhidayat@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 32,
                            "namajabatan" => "Evaporator Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 80,
                    "nik" => "120292517",
                    "nama" => "YUANITA JOHAN",
                    "username" => "yuanita.johan",
                    "inisial" => "YJN",
                    "email" => "yuanita.johan@kalbenutritionals.com",
                    "ext" => "920",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 10,
                            "namadepartemen" => "MDP",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 23,
                            "namasubdepartemen" => "PPIC Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 72,
                            "namajabatan" => "PPIC Supervisor",
                        ],
                        "cg" => ["intidcg" => 10, "namacg" => "PLANNER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 81,
                    "nik" => "120292518",
                    "nama" => "ZAINI ARDHIANSYAH",
                    "username" => "zaini.ardhiansyah",
                    "inisial" => "ZAH",
                    "email" => "zaini.ardhiansyah@kalbenutritionals.com",
                    "ext" => "712",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 4,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 73,
                            "namajabatan" => "Finance & Accounting Junior Staff",
                        ],
                        "cg" => ["intidcg" => 1, "namacg" => "AVATAR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 82,
                    "nik" => "120500031",
                    "nama" => "AKHMAD MAKHALI",
                    "username" => "akhmad.makhali",
                    "inisial" => "AMI",
                    "email" => "akhmad.makhali@kalbenutritionals.com",
                    "ext" => "910",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 10,
                            "namadepartemen" => "MDP",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 18,
                            "namasubdepartemen" => "IT Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 74,
                            "namajabatan" => "Information Technology Supervisor",
                        ],
                        "cg" => ["intidcg" => 11, "namacg" => "MATRIX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 9, "namalevel" => "Admin"],
                    ],
                ],
                [
                    "id" => 83,
                    "nik" => "120692519",
                    "nama" => "DINA MUSTIKA WENI",
                    "username" => "dina.weni",
                    "inisial" => "DMW",
                    "email" => "dina.weni@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 9, "namalokasi" => "Store Room"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 5,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 75,
                            "namajabatan" => "Sparepart Staff BDA",
                        ],
                        "cg" => ["intidcg" => 2, "namacg" => "SHINING"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 84,
                    "nik" => "120692521",
                    "nama" => "WEMPI NUR HIDAYAT",
                    "username" => "wempi.hidayat",
                    "inisial" => "WNH",
                    "email" => "wempi.hidayat@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 33,
                            "namajabatan" => "Warehouse RM Major Preparator",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 85,
                    "nik" => "120892522",
                    "nama" => "KARYA SETIAWAN",
                    "username" => "karya.setiawan",
                    "inisial" => "KSN",
                    "email" => "karya.setiawan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 17,
                            "namajabatan" => "Compounding Operator",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 86,
                    "nik" => "120892523",
                    "nama" => "MUKTI WIBOWO",
                    "username" => "mukti.wibowo",
                    "inisial" => "MWO",
                    "email" => "mukti.wibowo@kalbenutritionals.com",
                    "ext" => "501",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 76,
                            "namajabatan" => "Warehouse Admin",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 87,
                    "nik" => "120892524",
                    "nama" => "VICKRY JANI HARIYANTO",
                    "username" => "vickry.hariyanto",
                    "inisial" => "VJH",
                    "email" => "vickry.hariyanto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 77,
                            "namajabatan" => "Electrical Technician",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 88,
                    "nik" => "120992525",
                    "nama" => "ARDIKA FAUDIN",
                    "username" => "ardika.faudin",
                    "inisial" => "AFN",
                    "email" => "ardika.faudin@kalbenutritionals.com",
                    "ext" => "221",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 78,
                            "namajabatan" => "Production Admin",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 89,
                    "nik" => "120992526",
                    "nama" => "BAYU SEPTO PRASETYO",
                    "username" => "bayu.prasetyo",
                    "inisial" => "BSP",
                    "email" => "bayu.prasetyo@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 79,
                            "namajabatan" => "Warehouse PM Checker",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 90,
                    "nik" => "121092527",
                    "nama" => "BUDI MAULANA NUGRAHA",
                    "username" => "budi.nugraha",
                    "inisial" => "BMN",
                    "email" => "budi.nugraha@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 11,
                            "namajabatan" => "Mechanical Technician",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 91,
                    "nik" => "121092528",
                    "nama" => "DODI ISKANDAR",
                    "username" => "dodi.iskandar",
                    "inisial" => "DIR",
                    "email" => "dodi.iskandar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 80,
                            "namajabatan" => "QC Microbiology Analyst",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 92,
                    "nik" => "121092529",
                    "nama" => "SUSANTO RONNI",
                    "username" => "susanto.ronni",
                    "inisial" => "SRI",
                    "email" => "susanto.ronni@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 12,
                            "namajabatan" => "Bin Filling Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 93,
                    "nik" => "121192530",
                    "nama" => "DEDE KUSNANDAR",
                    "username" => "dede.kusnandar",
                    "inisial" => "DDK",
                    "email" => "dede.kusnandar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 94,
                    "nik" => "121192531",
                    "nama" => "GUMILAR INDRA FEBRIANSYAH",
                    "username" => "gumilar.febriansyah",
                    "inisial" => "GIF",
                    "email" => "gumilar.febriansyah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 81,
                            "namajabatan" => "Dumping Operator",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 95,
                    "nik" => "121192532",
                    "nama" => "KARNAEN",
                    "username" => "karnaen.karnaen",
                    "inisial" => "KRN",
                    "email" => "karnaen.karnaen@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 96,
                    "nik" => "121192533",
                    "nama" => "MUHAMMAD SHANDI SUMANTRI",
                    "username" => "muhammad.sumantri",
                    "inisial" => "MSS",
                    "email" => "muhammad.sumantri@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 97,
                    "nik" => "121192534",
                    "nama" => "ONDI NUGROHO",
                    "username" => "ondi.nugroho",
                    "inisial" => "ONO",
                    "email" => "ondi.nugroho@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 80,
                            "namajabatan" => "QC Microbiology Analyst",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 98,
                    "nik" => "121192535",
                    "nama" => "RISNAWATI",
                    "username" => "risnawati.risnawati",
                    "inisial" => "RSN",
                    "email" => "risnawati.risnawati@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 82,
                            "namajabatan" => "Tipping Operator",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 99,
                    "nik" => "121192536",
                    "nama" => "RUDI RAHMAN",
                    "username" => "rudi.rahman",
                    "inisial" => "RRN",
                    "email" => "rudi.rahman@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 100,
                    "nik" => "121192537",
                    "nama" => "SUGIANTO",
                    "username" => "sugianto.sugianto",
                    "inisial" => "SHT",
                    "email" => "sugianto.sugianto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 18,
                            "namajabatan" => "Tipping Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 101,
                    "nik" => "121192538",
                    "nama" => "SULISWANTO",
                    "username" => "suliswanto.suliswanto",
                    "inisial" => "SWO",
                    "email" => "suliswanto.suliswanto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 102,
                    "nik" => "121192539",
                    "nama" => "YUSUP SYAHRONI",
                    "username" => "yusup.syahroni",
                    "inisial" => "YSI",
                    "email" => "yusup.syahroni@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 65,
                            "namajabatan" => "Powder Mixer Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 103,
                    "nik" => "121192540",
                    "nama" => "ZENAL MULYANA",
                    "username" => "zenal.mulyana",
                    "inisial" => "ZMA",
                    "email" => "zenal.mulyana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 104,
                    "nik" => "130100005",
                    "nama" => "AMBAR KUSUMO NUGROHO",
                    "username" => "ambar.nugroho",
                    "inisial" => "AKN",
                    "email" => "ambar.nugroho@kalbenutritionals.com",
                    "ext" => "200",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 25,
                            "namasubdepartemen" => "Production Department",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 84,
                            "namajabatan" => "Production Dept Head",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 3, "namalevel" => "Dept Head"],
                    ],
                ],
                [
                    "id" => 105,
                    "nik" => "130193003",
                    "nama" => "ADE NANA SUMARNA",
                    "username" => "ade.sumarna",
                    "inisial" => "ANS",
                    "email" => "ade.sumarna@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 62,
                            "namajabatan" => "Bin Washing Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 106,
                    "nik" => "130193004",
                    "nama" => "AGUS AKBAR",
                    "username" => "agus.akbar",
                    "inisial" => "AAR",
                    "email" => "agus.akbar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 85,
                            "namajabatan" => "Warehouse RM Major Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 107,
                    "nik" => "130193005",
                    "nama" => "AGUS PRASETIYO",
                    "username" => "agus.prasetiyo",
                    "inisial" => "APO",
                    "email" => "agus.prasetiyo@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 86,
                            "namajabatan" => "WWTP Operator",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 108,
                    "nik" => "130193006",
                    "nama" => "APANDI",
                    "username" => "apandi.apandi",
                    "inisial" => "API",
                    "email" => "apandi.apandi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 58,
                            "namajabatan" => "Bin Filling Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 109,
                    "nik" => "130193007",
                    "nama" => "ASMI LASARI",
                    "username" => "asmi.lasari",
                    "inisial" => "AMI",
                    "email" => "asmi.lasari@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 82,
                            "namajabatan" => "Tipping Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 110,
                    "nik" => "130193008",
                    "nama" => "DANI PURWANEGARA",
                    "username" => "dani.purwanegara",
                    "inisial" => "DPA",
                    "email" => "dani.purwanegara@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 79,
                            "namajabatan" => "Warehouse PM Checker",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 111,
                    "nik" => "130193009",
                    "nama" => "DEDEN SETIA JAYA SOMANTRI",
                    "username" => "deden.somantri",
                    "inisial" => "DSJ",
                    "email" => "deden.somantri@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 63,
                            "namajabatan" => "Eductor Operator",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 112,
                    "nik" => "130193010",
                    "nama" => "DEVI SAFITRI SUNDARI",
                    "username" => "devi.sundari",
                    "inisial" => "DSS",
                    "email" => "devi.sundari@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 87,
                            "namajabatan" => "Dry Sachet Circle Admin",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 113,
                    "nik" => "130193011",
                    "nama" => "DIDI SUPRIADI",
                    "username" => "didi.supriadi",
                    "inisial" => "DSI",
                    "email" => "didi.supriadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 88,
                            "namajabatan" => "Bin Washing Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 114,
                    "nik" => "130193012",
                    "nama" => "DWIKI ARIA DARMAWAN",
                    "username" => "dwiki.darmawan",
                    "inisial" => "DAD",
                    "email" => "dwiki.darmawan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 115,
                    "nik" => "130193013",
                    "nama" => "ERFAN KIMA BAHTERA",
                    "username" => "erfan.bahtera",
                    "inisial" => "EKB",
                    "email" => "erfan.bahtera@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 24,
                            "namajabatan" => "Utility Operator",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 116,
                    "nik" => "130193014",
                    "nama" => "ERIS MOCHAMAD FIRDAUS",
                    "username" => "eris.firdaus",
                    "inisial" => "EMF",
                    "email" => "eris.firdaus@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 70,
                            "namajabatan" => "QC Incoming Analyst",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 117,
                    "nik" => "130193015",
                    "nama" => "FARIZ FAUZI PRATAMA",
                    "username" => "fariz.pratama",
                    "inisial" => "FFP",
                    "email" => "fariz.pratama@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 51,
                            "namajabatan" => "QC In Line Group Leader",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 118,
                    "nik" => "130193016",
                    "nama" => "FEBRIANGGONO DANNY SETIYADI",
                    "username" => "febrianggono.setiyadi",
                    "inisial" => "FDS",
                    "email" => "febrianggono.setiyadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 119,
                    "nik" => "130193017",
                    "nama" => "HADI",
                    "username" => "hadi.hadi",
                    "inisial" => "HDI",
                    "email" => "hadi.hadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 36,
                            "namasubdepartemen" => "Warehouse Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 89,
                            "namajabatan" => "Warehouse FG Staff",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 120,
                    "nik" => "130193018",
                    "nama" => "HERU AHMAD SAPRUDIN",
                    "username" => "heru.saprudin",
                    "inisial" => "HAS",
                    "email" => "heru.saprudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 121,
                    "nik" => "130193019",
                    "nama" => "JAKARIA (CK)",
                    "username" => "jakaria.(ck)",
                    "inisial" => "JCK",
                    "email" => "jakaria.(ck)@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 57,
                            "namajabatan" => "Processing Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 122,
                    "nik" => "130193020",
                    "nama" => "KANDA",
                    "username" => "kanda.kanda",
                    "inisial" => "KNA",
                    "email" => "kanda.kanda@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 90,
                            "namajabatan" => "Warehouse FG Checker",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 123,
                    "nik" => "130193021",
                    "nama" => "KUSNADI",
                    "username" => "kusnadi.kusnadi",
                    "inisial" => "KSI",
                    "email" => "kusnadi.kusnadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 85,
                            "namajabatan" => "Warehouse RM Major Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 124,
                    "nik" => "130193022",
                    "nama" => "MADA",
                    "username" => "mada.mada",
                    "inisial" => "MDA",
                    "email" => "mada.mada@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 125,
                    "nik" => "130193023",
                    "nama" => "MUHAMAD SYAIFUL ANWAR",
                    "username" => "muhamad.anwar",
                    "inisial" => "MSA",
                    "email" => "muhamad.anwar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 63,
                            "namajabatan" => "Eductor Operator",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 126,
                    "nik" => "130193024",
                    "nama" => "NUR FAJRI",
                    "username" => "nur.fajri",
                    "inisial" => "NFI",
                    "email" => "nur.fajri@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 58,
                            "namajabatan" => "Bin Filling Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 127,
                    "nik" => "130193025",
                    "nama" => "PRIYANTO",
                    "username" => "priyanto.priyanto",
                    "inisial" => "PYO",
                    "email" => "priyanto.priyanto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 24,
                            "namajabatan" => "Utility Operator",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 128,
                    "nik" => "130193026",
                    "nama" => "RIDWAN",
                    "username" => "ridwan.ridwan",
                    "inisial" => "RDN",
                    "email" => "ridwan.ridwan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 91,
                            "namajabatan" => "Drier Circle Admin",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 129,
                    "nik" => "130193027",
                    "nama" => "RUDI SETIAWAN",
                    "username" => "rudi.setiawan",
                    "inisial" => "RSN",
                    "email" => "rudi.setiawan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 82,
                            "namajabatan" => "Tipping Operator",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 130,
                    "nik" => "130193028",
                    "nama" => "SAMSIANTO",
                    "username" => "samsianto.samsianto",
                    "inisial" => "SSO",
                    "email" => "samsianto.samsianto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 24,
                            "namajabatan" => "Utility Operator",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 131,
                    "nik" => "130193029",
                    "nama" => "SHANDY ASMARA",
                    "username" => "shandy.asmara",
                    "inisial" => "SAA",
                    "email" => "shandy.asmara@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 62,
                            "namajabatan" => "Bin Washing Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 132,
                    "nik" => "130193030",
                    "nama" => "SUDARWANTO",
                    "username" => "sudarwanto.sudarwanto",
                    "inisial" => "SDW",
                    "email" => "sudarwanto.sudarwanto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 92,
                            "namajabatan" => "Wet Canning Circle Admin",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 133,
                    "nik" => "130193031",
                    "nama" => "SUHERI",
                    "username" => "suheri.suheri",
                    "inisial" => "SHI",
                    "email" => "suheri.suheri@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 93,
                            "namajabatan" => "Warehouse RM Minor Preparator",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 134,
                    "nik" => "130193033",
                    "nama" => "SYAHRUL HIDAYAT",
                    "username" => "syahrul.hidayat",
                    "inisial" => "TSA",
                    "email" => "syahrul.hidayat@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 94,
                            "namajabatan" => "Can Filling Operator",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 135,
                    "nik" => "130393035",
                    "nama" => "BOBBY FAHMI FARHANUDIN",
                    "username" => "bobby.farhanudin",
                    "inisial" => "BFF",
                    "email" => "bobby.farhanudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 83,
                            "namajabatan" => "QC In Line Analyst",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 136,
                    "nik" => "130793036",
                    "nama" => "ADNAN SAMSULEH",
                    "username" => "adnan.samsuleh",
                    "inisial" => "ASH",
                    "email" => "adnan.samsuleh@kalbenutritionals.com",
                    "ext" => "813",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 3, "namalokasi" => "Office Lt 3"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 5,
                            "namadepartemen" => "IOS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 16,
                            "namasubdepartemen" => "IOS Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 95,
                            "namajabatan" => "System Inspector",
                        ],
                        "cg" => ["intidcg" => 8, "namacg" => "RISING STAR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 137,
                    "nik" => "130793037",
                    "nama" => "AEP SAEPUDIN",
                    "username" => "aep.saepudin",
                    "inisial" => "ASN",
                    "email" => "aep.saepudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 88,
                            "namajabatan" => "Bin Washing Operator",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 138,
                    "nik" => "130793038",
                    "nama" => "AJAT JAPAR",
                    "username" => "ajat.japar",
                    "inisial" => "AJR",
                    "email" => "ajat.japar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 96,
                            "namajabatan" => "Sachet Packing Operator",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 139,
                    "nik" => "130793039",
                    "nama" => "ALI ROHMAN",
                    "username" => "ali.rohman",
                    "inisial" => "ARN",
                    "email" => "ali.rohman@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 93,
                            "namajabatan" => "Warehouse RM Minor Preparator",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 140,
                    "nik" => "130793040",
                    "nama" => "AMRIH PANUNTUN",
                    "username" => "amrih.panuntun",
                    "inisial" => "APN",
                    "email" => "amrih.panuntun@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 141,
                    "nik" => "130793041",
                    "nama" => "ANDI KUSUMA",
                    "username" => "andi.kusuma",
                    "inisial" => "AKA",
                    "email" => "andi.kusuma@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 55,
                            "namajabatan" => "Blending Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 142,
                    "nik" => "130793042",
                    "nama" => "ANGGA CHRISTIAN YONATHAN",
                    "username" => "angga.yonathan",
                    "inisial" => "ACY",
                    "email" => "angga.yonathan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 79,
                            "namajabatan" => "Warehouse PM Checker",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 143,
                    "nik" => "130793043",
                    "nama" => "ASEP ROBAN",
                    "username" => "asep.roban",
                    "inisial" => "ARN",
                    "email" => "asep.roban@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 11,
                            "namajabatan" => "Mechanical Technician",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 144,
                    "nik" => "130793044",
                    "nama" => "DAIKIN PURNA YUDHA",
                    "username" => "daikin.yudha",
                    "inisial" => "DPY",
                    "email" => "daikin.yudha@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 81,
                            "namajabatan" => "Dumping Operator",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 145,
                    "nik" => "130793045",
                    "nama" => "DARMA ARDHI",
                    "username" => "darma.ardhi",
                    "inisial" => "DAI",
                    "email" => "darma.ardhi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 96,
                            "namajabatan" => "Sachet Packing Operator",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 146,
                    "nik" => "130793046",
                    "nama" => "DIDIK PURWANTO",
                    "username" => "didik.purwanto",
                    "inisial" => "DPO",
                    "email" => "didik.purwanto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 97,
                            "namajabatan" => "Dumping Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 147,
                    "nik" => "130793047",
                    "nama" => "HERI KURNIAWAN",
                    "username" => "heri.kurniawan",
                    "inisial" => "HKN",
                    "email" => "heri.kurniawan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 148,
                    "nik" => "130793048",
                    "nama" => "HERIYANA",
                    "username" => "heriyana.heriyana",
                    "inisial" => "HRA",
                    "email" => "heriyana.heriyana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 83,
                            "namajabatan" => "QC In Line Analyst",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 149,
                    "nik" => "130793049",
                    "nama" => "IKMAL MAULANA",
                    "username" => "ikmal.maulana",
                    "inisial" => "IMA",
                    "email" => "ikmal.maulana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 24,
                            "namajabatan" => "Utility Operator",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 150,
                    "nik" => "130793050",
                    "nama" => "IRFAN HIMAWAN",
                    "username" => "irfan.himawan",
                    "inisial" => "IHN",
                    "email" => "irfan.himawan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 80,
                            "namajabatan" => "QC Microbiology Analyst",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 151,
                    "nik" => "130793051",
                    "nama" => "JOHAN KERTIONO",
                    "username" => "johan.kertiono",
                    "inisial" => "JKN",
                    "email" => "johan.kertiono@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 66,
                            "namajabatan" => "Can Packing Operator",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 152,
                    "nik" => "130793052",
                    "nama" => "MOHAMMAD DWI ADHITYA",
                    "username" => "mohammad.adhitya",
                    "inisial" => "MDA",
                    "email" => "mohammad.adhitya@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 98,
                            "namajabatan" => "Warehouse FG Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 153,
                    "nik" => "130793053",
                    "nama" => "SAMROJI",
                    "username" => "samroji.samroji",
                    "inisial" => "SJI",
                    "email" => "samroji.samroji@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 17,
                            "namajabatan" => "Compounding Operator",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 154,
                    "nik" => "130793055",
                    "nama" => "JUJUN SIROJUDIN",
                    "username" => "jujun.sirojudin",
                    "inisial" => "JSN",
                    "email" => "jujun.sirojudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 12,
                            "namajabatan" => "Bin Filling Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 155,
                    "nik" => "130793056",
                    "nama" => "NOVAN TRIANTO",
                    "username" => "novan.trianto",
                    "inisial" => "NTO",
                    "email" => "novan.trianto@kalbenutritionals.com",
                    "ext" => "912",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 10,
                            "namadepartemen" => "MDP",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 20,
                            "namasubdepartemen" => "IT Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 99,
                            "namajabatan" => "Aplication & Development Support Staff",
                        ],
                        "cg" => ["intidcg" => 11, "namacg" => "MATRIX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 156,
                    "nik" => "130793058",
                    "nama" => "SANNI SUTIADI",
                    "username" => "sanni.sutiadi",
                    "inisial" => "SNI",
                    "email" => "sanni.sutiadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 18,
                            "namajabatan" => "Tipping Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 157,
                    "nik" => "130900125",
                    "nama" => "INSANI GUSTRIANJAR MUHAROM",
                    "username" => "insani.muharom",
                    "inisial" => "IGM",
                    "email" => "insani.muharom@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 100,
                            "namajabatan" => "Electrical Leader",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 158,
                    "nik" => "140192908",
                    "nama" => "JEPRI HAERUDIN",
                    "username" => "jepri.haerudin",
                    "inisial" => "JHN",
                    "email" => "jepri.haerudin@kalbenutritionals.com",
                    "ext" => "921",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 10,
                            "namadepartemen" => "MDP",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 24,
                            "namasubdepartemen" => "PPIC Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 101,
                            "namajabatan" => "PPIC Junior Staff",
                        ],
                        "cg" => ["intidcg" => 10, "namacg" => "PLANNER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 159,
                    "nik" => "140792910",
                    "nama" => "AGUS NUGROHO",
                    "username" => "agus.nugroho",
                    "inisial" => "AMI",
                    "email" => "agus.nugroho@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 66,
                            "namajabatan" => "Can Packing Operator",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 160,
                    "nik" => "140792911",
                    "nama" => "ARIYANTO",
                    "username" => "ariyanto.ariyanto",
                    "inisial" => "ANO",
                    "email" => "ariyanto.ariyanto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 94,
                            "namajabatan" => "Can Filling Operator",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 161,
                    "nik" => "140792913",
                    "nama" => "BAHRUDIN",
                    "username" => "bahrudin.bahrudin",
                    "inisial" => "BRN",
                    "email" => "bahrudin.bahrudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 86,
                            "namajabatan" => "WWTP Operator",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 162,
                    "nik" => "140792914",
                    "nama" => "BENI SETIYAWAN",
                    "username" => "beni.setiyawan",
                    "inisial" => "BSN",
                    "email" => "beni.setiyawan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 96,
                            "namajabatan" => "Sachet Packing Operator",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 163,
                    "nik" => "140792915",
                    "nama" => "CECEP SUPRIADI",
                    "username" => "cecep.supriadi",
                    "inisial" => "CEP",
                    "email" => "cecep.supriadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 81,
                            "namajabatan" => "Dumping Operator",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 164,
                    "nik" => "140792916",
                    "nama" => "IRPAN HIDAYAT PAMIL",
                    "username" => "irpan.pamil",
                    "inisial" => "IHP",
                    "email" => "irpan.pamil@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 10,
                            "namadepartemen" => "MDP",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 19,
                            "namasubdepartemen" => "IT Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 102,
                            "namajabatan" =>
                            "Manufacturing Development & Planing Administation-IT",
                        ],
                        "cg" => ["intidcg" => 11, "namacg" => "MATRIX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 165,
                    "nik" => "140792918",
                    "nama" => "MOKHAMAD MUSLIH",
                    "username" => "mokhamad.muslih",
                    "inisial" => "MMH",
                    "email" => "mokhamad.muslih@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 96,
                            "namajabatan" => "Sachet Packing Operator",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 166,
                    "nik" => "140792919",
                    "nama" => "R HAERUL SEJATI",
                    "username" => "r.sejati",
                    "inisial" => "RHS",
                    "email" => "r.sejati@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 51,
                            "namajabatan" => "QC In Line Group Leader",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 167,
                    "nik" => "140792920",
                    "nama" => "TAUFIK FARIDZAL",
                    "username" => "taufik.faridzal",
                    "inisial" => "TFL",
                    "email" => "taufik.faridzal@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 103,
                            "namajabatan" => "Fat Operator",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 168,
                    "nik" => "140792921",
                    "nama" => "ZAENUDDIN",
                    "username" => "zaenuddin.zaenuddin",
                    "inisial" => "ZDN",
                    "email" => "zaenuddin.zaenuddin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 96,
                            "namajabatan" => "Sachet Packing Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 169,
                    "nik" => "141092924",
                    "nama" => "PANDU WIJAYADI",
                    "username" => "pandu.wijayadi",
                    "inisial" => "PWI",
                    "email" => "pandu.wijayadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 104,
                            "namajabatan" => "Mechanical Leader",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 170,
                    "nik" => "150191702",
                    "nama" => "MOEHAMMAD FADJAR FADHILAH",
                    "username" => "moehammad.fadhilah",
                    "inisial" => "MFF",
                    "email" => "moehammad.fadhilah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 77,
                            "namajabatan" => "Electrical Technician",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 171,
                    "nik" => "150291703",
                    "nama" => "ALI NURDIN",
                    "username" => "ali.nurdin",
                    "inisial" => "ANN",
                    "email" => "ali.nurdin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 93,
                            "namajabatan" => "Warehouse RM Minor Preparator",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 172,
                    "nik" => "150291704",
                    "nama" => "BAGUS SANTOSO",
                    "username" => "bagus.santoso",
                    "inisial" => "BSO",
                    "email" => "bagus.santoso@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 79,
                            "namajabatan" => "Warehouse PM Checker",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 173,
                    "nik" => "150491706",
                    "nama" => "SUMARNA",
                    "username" => "sumarna.sumarna",
                    "inisial" => "SMA",
                    "email" => "sumarna.sumarna@kalbenutritionals.com",
                    "ext" => "922",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 10,
                            "namadepartemen" => "MDP",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 24,
                            "namasubdepartemen" => "PPIC Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 105,
                            "namajabatan" => "PPIC Admin",
                        ],
                        "cg" => ["intidcg" => 10, "namacg" => "PLANNER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 174,
                    "nik" => "150600127",
                    "nama" => "YOPPY SUKMANDAR",
                    "username" => "yoppy.sukmandar",
                    "inisial" => "YSR",
                    "email" => "yoppy.sukmandar@kalbenutritionals.com",
                    "ext" => "400",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 6,
                            "namasubdepartemen" => "Engineering Department",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 106,
                            "namajabatan" => "Engineering Dept Head",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 3, "namalevel" => "Dept Head"],
                    ],
                ],
                [
                    "id" => 175,
                    "nik" => "150791707",
                    "nama" => "ADI AMRAN SUKARYA",
                    "username" => "adi.sukarya",
                    "inisial" => "AAS",
                    "email" => "adi.sukarya@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 96,
                            "namajabatan" => "Sachet Packing Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 176,
                    "nik" => "150791708",
                    "nama" => "BAMBANG RISTYANTO",
                    "username" => "bambang.ristyanto",
                    "inisial" => "BRO",
                    "email" => "bambang.ristyanto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 107,
                            "namajabatan" => "Drier Roving Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 177,
                    "nik" => "150791709",
                    "nama" => "HAPPY SUGESTIE PRAHARA",
                    "username" => "happy.prahara",
                    "inisial" => "HSP",
                    "email" => "happy.prahara@kalbenutritionals.com",
                    "ext" => "632",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 108,
                            "namajabatan" => "General Affair Admin",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 178,
                    "nik" => "150791710",
                    "nama" => "RIRIS PURWANTO",
                    "username" => "riris.purwanto",
                    "inisial" => "RPO",
                    "email" => "riris.purwanto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 107,
                            "namajabatan" => "Drier Roving Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 179,
                    "nik" => "150800189",
                    "nama" => "BAHRUDIN DWI NURYANTO",
                    "username" => "bahrudin.nuryanto",
                    "inisial" => "BDN",
                    "email" => "bahrudin.nuryanto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 77,
                            "namajabatan" => "Electrical Technician",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 180,
                    "nik" => "160192705",
                    "nama" => "AHMAD SAEPUDIN",
                    "username" => "ahmad.saepudin",
                    "inisial" => "ASN",
                    "email" => "ahmad.saepudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 24,
                            "namajabatan" => "Utility Operator",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 181,
                    "nik" => "160200097",
                    "nama" => "ALIT PRADANA",
                    "username" => "alit.pradana",
                    "inisial" => "APA",
                    "email" => "alit.pradana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 26,
                            "namasubdepartemen" => "Production Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 40,
                            "namajabatan" => "Filling & Packing Supervisor",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 182,
                    "nik" => "160792707",
                    "nama" => "ADI SOPANA",
                    "username" => "adi.sopana",
                    "inisial" => "ASA",
                    "email" => "adi.sopana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 88,
                            "namajabatan" => "Bin Washing Operator",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 183,
                    "nik" => "170122440",
                    "nama" => "FAJAR MAULANA",
                    "username" => "fajar.maulana",
                    "inisial" => "FMA",
                    "email" => "fajar.maulana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 93,
                            "namajabatan" => "Warehouse RM Minor Preparator",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 184,
                    "nik" => "170122441",
                    "nama" => "MUHAMMAD IQBAL FAUZY",
                    "username" => "muhammad.fauzy",
                    "inisial" => "MIF",
                    "email" => "muhammad.fauzy@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 24,
                            "namajabatan" => "Utility Operator",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 185,
                    "nik" => "170122442",
                    "nama" => "SAIFUL BAHRI",
                    "username" => "saiful.bahri",
                    "inisial" => "SBI",
                    "email" => "saiful.bahri@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 98,
                            "namajabatan" => "Warehouse FG Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 186,
                    "nik" => "170700031",
                    "nama" => "ARIS SUPARLI",
                    "username" => "aris.suparli",
                    "inisial" => "ARS",
                    "email" => "aris.suparli@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 96,
                            "namajabatan" => "Sachet Packing Operator",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 187,
                    "nik" => "170700032",
                    "nama" => "HERU HAERUDIN",
                    "username" => "heru.haerudin",
                    "inisial" => "HHN",
                    "email" => "heru.haerudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 96,
                            "namajabatan" => "Sachet Packing Operator",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 188,
                    "nik" => "170700033",
                    "nama" => "PEBI",
                    "username" => "pebi.pebi",
                    "inisial" => "PBI",
                    "email" => "pebi.pebi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 96,
                            "namajabatan" => "Sachet Packing Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 189,
                    "nik" => "171122509",
                    "nama" => "MOCHAMAD FADDLY ADI",
                    "username" => "mochamad.adi",
                    "inisial" => "MFA",
                    "email" => "mochamad.adi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 107,
                            "namajabatan" => "Drier Roving Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 190,
                    "nik" => "180100012",
                    "nama" => "RUDI ROSIDIN",
                    "username" => "rudi.rosidin",
                    "inisial" => "RRN",
                    "email" => "rudi.rosidin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 109,
                            "namajabatan" => "Maintenance Planner",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 191,
                    "nik" => "180100013",
                    "nama" => "SIDIK TRIPAMBUDI",
                    "username" => "sidik.tripambudi",
                    "inisial" => "STI",
                    "email" => "sidik.tripambudi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 11,
                            "namajabatan" => "Mechanical Technician",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 192,
                    "nik" => "180100014",
                    "nama" => "DERI INDRIANI",
                    "username" => "deri.indriani",
                    "inisial" => "DII",
                    "email" => "deri.indriani@kalbenutritionals.com",
                    "ext" => "714",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 4,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 73,
                            "namajabatan" => "Finance & Accounting Junior Staff",
                        ],
                        "cg" => ["intidcg" => 1, "namacg" => "AVATAR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 193,
                    "nik" => "180100015",
                    "nama" => "RIO ANGGARA",
                    "username" => "rio.anggara",
                    "inisial" => "RAA",
                    "email" => "rio.anggara@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 56,
                            "namajabatan" => "Blending Operator",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 194,
                    "nik" => "180100016",
                    "nama" => "ABDUL MUJIB MUSTOPA",
                    "username" => "abdul.mustopa",
                    "inisial" => "AMB",
                    "email" => "abdul.mustopa@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 110,
                            "namajabatan" => "Dry Sachet Packing Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 195,
                    "nik" => "180100017",
                    "nama" => "SANIP KOMARUDIN",
                    "username" => "sanip.komarudin",
                    "inisial" => "SKR",
                    "email" => "sanip.komarudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 94,
                            "namajabatan" => "Can Filling Operator",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 196,
                    "nik" => "180100018",
                    "nama" => "EDI SAPUTRA",
                    "username" => "edi.saputra",
                    "inisial" => "ESA",
                    "email" => "edi.saputra@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 110,
                            "namajabatan" => "Dry Sachet Packing Operator",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 197,
                    "nik" => "180100019",
                    "nama" => "DANIS SENO PRABOWO",
                    "username" => "danis.prabowo",
                    "inisial" => "DSP",
                    "email" => "danis.prabowo@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 29,
                            "namajabatan" => "Sachet Filling Operator",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 198,
                    "nik" => "180100020",
                    "nama" => "HERMAN RESTU FAUZI",
                    "username" => "herman.fauzi",
                    "inisial" => "HRF",
                    "email" => "herman.fauzi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 96,
                            "namajabatan" => "Sachet Packing Operator",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 199,
                    "nik" => "180100021",
                    "nama" => "WULAN NUR FATIMAH",
                    "username" => "wulan.fatimah",
                    "inisial" => "WNF",
                    "email" => "wulan.fatimah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 111,
                            "namajabatan" => "Wet Sachet Circle Admin",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 200,
                    "nik" => "180100022",
                    "nama" => "FATONI",
                    "username" => "fatoni.fatoni",
                    "inisial" => "FTI",
                    "email" => "fatoni.fatoni@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 85,
                            "namajabatan" => "Warehouse RM Major Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 201,
                    "nik" => "180300062",
                    "nama" => "BAGUS AJIE WICAKSONO",
                    "username" => "bagus.wicaksono",
                    "inisial" => "BAW",
                    "email" => "bagus.wicaksono@kalbenutritionals.com",
                    "ext" => "631",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 13,
                            "namasubdepartemen" => "Human Capital Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 112,
                            "namajabatan" => "General Affair Staff",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 202,
                    "nik" => "180500114",
                    "nama" => "EUIS DIAN ANGGRAENI",
                    "username" => "euis.anggraeni",
                    "inisial" => "EDA",
                    "email" => "euis.anggraeni@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 83,
                            "namajabatan" => "QC In Line Analyst",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 203,
                    "nik" => "180500115",
                    "nama" => "RIDWAN NUGRAHA",
                    "username" => "ridwan.nugraha",
                    "inisial" => "RNA",
                    "email" => "ridwan.nugraha@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 3, "namalokasi" => "Office Lt 3"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 51,
                            "namajabatan" => "QC In Line Group Leader",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 204,
                    "nik" => "180500116",
                    "nama" => "MUHAMAD ALFIAN",
                    "username" => "muhamad.alfian",
                    "inisial" => "MAN",
                    "email" => "muhamad.alfian@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 81,
                            "namajabatan" => "Dumping Operator",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 205,
                    "nik" => "180600122",
                    "nama" => "BERNADHETA RISMISARI HANDAYANI",
                    "username" => "bernadheta.handayani",
                    "inisial" => "BRH",
                    "email" => "bernadheta.handayani@kalbenutritionals.com",
                    "ext" => "600",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 10,
                            "namasubdepartemen" => "Human Capital Department",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 113,
                            "namajabatan" => "Human Capital Dept Head",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 3, "namalevel" => "Dept Head"],
                    ],
                ],
                [
                    "id" => 206,
                    "nik" => "180700142",
                    "nama" => "SANITA",
                    "username" => "sanita.sanita",
                    "inisial" => "SNA",
                    "email" => "sanita.sanita@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 48,
                            "namajabatan" => "CIP Operator",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 207,
                    "nik" => "180700143",
                    "nama" => "AKHMAD YUNUS YULIANTO",
                    "username" => "akhmad.yulianto",
                    "inisial" => "AYS",
                    "email" => "akhmad.yulianto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 85,
                            "namajabatan" => "Warehouse RM Major Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 208,
                    "nik" => "190100054",
                    "nama" => "TATA TAOFIK QUROHMAN",
                    "username" => "tata.qurohman",
                    "inisial" => "TTQ",
                    "email" => "tata.qurohman@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 80,
                            "namajabatan" => "QC Microbiology Analyst",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 209,
                    "nik" => "190700187",
                    "nama" => "MAHMUD FAUJI TANJUNG",
                    "username" => "mahmud.tanjung",
                    "inisial" => "MFT",
                    "email" => "mahmud.tanjung@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 28,
                            "namasubdepartemen" => "Production Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 21,
                            "namajabatan" => "Filling & Packing Coordinator",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 210,
                    "nik" => "200100017",
                    "nama" => "TEGUH SEJATI",
                    "username" => "teguh.sejati",
                    "inisial" => "TSJ",
                    "email" => "teguh.sejati@kalbenutritionals.com",
                    "ext" => "913",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 10,
                            "namadepartemen" => "MDP",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 20,
                            "namasubdepartemen" => "IT Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 99,
                            "namajabatan" => "Aplication & Development Support Staff",
                        ],
                        "cg" => ["intidcg" => 11, "namacg" => "MATRIX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 211,
                    "nik" => "200100031",
                    "nama" => "WINDY ADRIANY KACARIBU",
                    "username" => "windy.kacaribu",
                    "inisial" => "WAK",
                    "email" => "windy.kacaribu@kalbenutritionals.com",
                    "ext" => "612",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 13,
                            "namasubdepartemen" => "Human Capital Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 114,
                            "namajabatan" => "Recruitment & Learning Development Staff",
                        ],
                        "cg" => ["intidcg" => 6, "namacg" => "SALT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 212,
                    "nik" => "200100042",
                    "nama" => "MUSTAGHBIRIN",
                    "username" => "mustaghbirin.mustaghbirin",
                    "inisial" => "MSN",
                    "email" => "mustaghbirin.mustaghbirin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 93,
                            "namajabatan" => "Warehouse RM Minor Preparator",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 213,
                    "nik" => "200200053",
                    "nama" => "MUHAMAD MISBAH",
                    "username" => "muhamad.misbah",
                    "inisial" => "MMH",
                    "email" => "muhamad.misbah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 80,
                            "namajabatan" => "QC Microbiology Analyst",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 214,
                    "nik" => "200300076",
                    "nama" => "MARIA KURNIATI GEDI RAYA",
                    "username" => "maria.raya",
                    "inisial" => "MKG",
                    "email" => "maria.raya@kalbenutritionals.com",
                    "ext" => "640",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 13,
                            "namasubdepartemen" => "Human Capital Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 115,
                            "namajabatan" => "Payroll & Personnel Staff",
                        ],
                        "cg" => ["intidcg" => 6, "namacg" => "SALT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 215,
                    "nik" => "200500092",
                    "nama" => "IRVAN HASAN",
                    "username" => "irvan.hasan",
                    "inisial" => "IHA",
                    "email" => "irvan.hasan@kalbenutritionals.com",
                    "ext" => "430",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 7,
                            "namasubdepartemen" => "Engineering Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 116,
                            "namajabatan" => "Operational Maintenance Supervisor 3",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 216,
                    "nik" => "200700143",
                    "nama" => "TENDI SOBARNANSYAH",
                    "username" => "tendi.sobarnansyah",
                    "inisial" => "TSH",
                    "email" => "tendi.sobarnansyah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 117,
                            "namajabatan" => "Mechanic Helper",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 217,
                    "nik" => "200700144",
                    "nama" => "MUHAMAD RIDWAN",
                    "username" => "muhamad.ridwan",
                    "inisial" => "MRN",
                    "email" => "muhamad.ridwan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 118,
                            "namajabatan" => "Warehouse RM Major Checker",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 218,
                    "nik" => "201200194",
                    "nama" => "DENLEI DIYOROSSI",
                    "username" => "denlei.diyorossi",
                    "inisial" => "DDI",
                    "email" => "denlei.diyorossi@kalbenutritionals.com",
                    "ext" => "911",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 10,
                            "namadepartemen" => "MDP",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 20,
                            "namasubdepartemen" => "IT Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 99,
                            "namajabatan" => "Aplication & Development Support Staff",
                        ],
                        "cg" => ["intidcg" => 11, "namacg" => "MATRIX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 9, "namalevel" => "Admin"],
                    ],
                ],
                [
                    "id" => 219,
                    "nik" => "210100004",
                    "nama" => "SETYO DEWI UTARI",
                    "username" => "setyo.utari",
                    "inisial" => "SDU",
                    "email" => "setyo.utari@kalbenutritionals.com",
                    "ext" => "610",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 11,
                            "namasubdepartemen" => "Human Capital Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 119,
                            "namajabatan" => "HRD Supervisor",
                        ],
                        "cg" => ["intidcg" => 6, "namacg" => "SALT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 220,
                    "nik" => "211200171",
                    "nama" => "TOSHIHITO  ABE",
                    "username" => "toshihito.abe",
                    "inisial" => "TAE",
                    "email" => "toshihito.abe@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 3,
                            "namadepartemen" => "MNF",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 22,
                            "namasubdepartemen" => "Manufacturing Division",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 121,
                            "namajabatan" => "Technical Advisor",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 221,
                    "nik" => "220100111",
                    "nama" => "KUKUH GUMILANG",
                    "username" => "kukuh.gumilang",
                    "inisial" => "KKG",
                    "email" => "kukuh.gumilang@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 122,
                            "namajabatan" => "Engineering Admin",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 222,
                    "nik" => "221200453",
                    "nama" => "FIKRI FIRMANSYAH",
                    "username" => "fikri.firmansyah",
                    "inisial" => "FFH",
                    "email" => "fikri.firmansyah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 123,
                            "namajabatan" => "Preventive Maintenance Leader",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 12, "namalevel" => "CG Leader"],
                    ],
                ],
                [
                    "id" => 223,
                    "nik" => "221200468",
                    "nama" => "ERWANDA",
                    "username" => "erwanda",
                    "inisial" => "EDA",
                    "email" => "erwanda@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 5,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 124,
                            "namajabatan" => "Management System Staff",
                        ],
                        "cg" => ["intidcg" => 2, "namacg" => "SHINING"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 224,
                    "nik" => "230100001",
                    "nama" => "CHRISTIANTO YITRO SUJIWA",
                    "username" => "christanto.yitro",
                    "inisial" => "CYS",
                    "email" => "christanto.yitro@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 11,
                            "namasubdepartemen" => "Human Capital Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 125,
                            "namajabatan" => "IR & GA Supervisor",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 4, "namalevel" => "SPV"],
                    ],
                ],
                [
                    "id" => 225,
                    "nik" => "230100003",
                    "nama" => "SANDI RISTIYAWAN ANGGARA",
                    "username" => "sandi.anggara",
                    "inisial" => "SRA",
                    "email" => "sandi.anggara@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => [
                            "intidlokasi" => 28,
                            "namalokasi" => "QA - LAB INLINE",
                        ],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 83,
                            "namajabatan" => "QC In Line Analyst",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 226,
                    "nik" => "230100009",
                    "nama" => "FATCHUR RACHMAN",
                    "username" => "fatchur.rachman",
                    "inisial" => "FRC",
                    "email" => "fatchur.rachman@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 29,
                            "namasubdepartemen" => "QA Department",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 126,
                            "namajabatan" => "Quality Assurance Dept Head",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 3, "namalevel" => "Dept Head"],
                    ],
                ],
                [
                    "id" => 227,
                    "nik" => "230100042",
                    "nama" => "GITA SYEMA DEWI",
                    "username" => "gita.dewi",
                    "inisial" => "GSD",
                    "email" => "gita.dewi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => [
                            "intidlokasi" => 28,
                            "namalokasi" => "QA - LAB INLINE",
                        ],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 83,
                            "namajabatan" => "QC In Line Analyst",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 228,
                    "nik" => "230100043",
                    "nama" => "ANJAR SUDRAJAT",
                    "username" => "anjar.sudrajat",
                    "inisial" => "AST",
                    "email" => "anjar.sudrajat@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 98,
                            "namajabatan" => "Warehouse FG Forklift Operator",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 229,
                    "nik" => "230100044",
                    "nama" => "RAKHA ADI PUTRA",
                    "username" => "rakha.putra",
                    "inisial" => "RAP",
                    "email" => "rakha.putra@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 5,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 127,
                            "namajabatan" => "Purchasing, Legal & Inventory Staff",
                        ],
                        "cg" => ["intidcg" => 2, "namacg" => "SHINING"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 230,
                    "nik" => "K190100004",
                    "nama" => "DIANTO",
                    "username" => "dianto.dianto",
                    "inisial" => "DTO",
                    "email" => "dianto.dianto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 129,
                            "namajabatan" => "Drier Continous Cleaner",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 231,
                    "nik" => "K190400185",
                    "nama" => "BASUKI",
                    "username" => "basuki.basuki",
                    "inisial" => "BAI",
                    "email" => "basuki.basuki@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 130,
                            "namajabatan" => "Eductor Helper",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 232,
                    "nik" => "K190800327",
                    "nama" => "MUHAMMAD RIZQY FIRDAUS",
                    "username" => "muhammad.firdaus",
                    "inisial" => "MRF",
                    "email" => "muhammad.firdaus@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 131,
                            "namajabatan" => "HVAC Technician",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 233,
                    "nik" => "K191000365",
                    "nama" => "SAIDIN IMRON WIJAYA",
                    "username" => "saidin.wijaya",
                    "inisial" => "SIW",
                    "email" => "saidin.wijaya@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 132,
                            "namajabatan" => "Warehouse RM Minor Assistant",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 234,
                    "nik" => "K200200052",
                    "nama" => "DANANG PRASETIYO",
                    "username" => "danang.prasetiyo",
                    "inisial" => "DPO",
                    "email" => "danang.prasetiyo@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 133,
                            "namajabatan" => "Warehouse RM Major Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 235,
                    "nik" => "K200300084",
                    "nama" => "DANIEL ABRAHAM SINAMBELA",
                    "username" => "daniel.sinambela",
                    "inisial" => "DAS",
                    "email" => "daniel.sinambela@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 129,
                            "namajabatan" => "Drier Continous Cleaner",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 236,
                    "nik" => "K200300085",
                    "nama" => "NUR AHMAD BUKHORI AINUL YAQIN AL FAIZ",
                    "username" => "nur.faiz",
                    "inisial" => "NAB",
                    "email" => "nur.faiz@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 132,
                            "namajabatan" => "Warehouse RM Minor Assistant",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 237,
                    "nik" => "K200400108",
                    "nama" => "ZAENUDIN",
                    "username" => "zaenudin.zaenudin",
                    "inisial" => "ZAE",
                    "email" => "zaenudin.zaenudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 12, "namacg" => "HORENSO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 238,
                    "nik" => "K200500146",
                    "nama" => "DIKA LESMANA",
                    "username" => "dika.lesmana",
                    "inisial" => "DLA",
                    "email" => "dika.lesmana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 136,
                            "namajabatan" => "Warehouse PM Assistant",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 239,
                    "nik" => "K200600145",
                    "nama" => "DIAN HADIAN",
                    "username" => "dian.hadian",
                    "inisial" => "DHN",
                    "email" => "dian.hadian@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 137,
                            "namajabatan" => "Warehouse RM Minor Helper",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 240,
                    "nik" => "K200600151",
                    "nama" => "NUKMANUL ANWAR",
                    "username" => "nukmanul.anwar",
                    "inisial" => "NAR",
                    "email" => "nukmanul.anwar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 138,
                            "namajabatan" => "Warehouse FG Assistant",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 241,
                    "nik" => "K200600153",
                    "nama" => "TODO ARDO SINAGA",
                    "username" => "todo.sinaga",
                    "inisial" => "TAS",
                    "email" => "todo.sinaga@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 133,
                            "namajabatan" => "Warehouse RM Major Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 242,
                    "nik" => "K200600176",
                    "nama" => "RINO",
                    "username" => "rino.rino",
                    "inisial" => "RNO",
                    "email" => "rino.rino@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 133,
                            "namajabatan" => "Warehouse RM Major Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 243,
                    "nik" => "K200700207",
                    "nama" => "ADE RAHMAN",
                    "username" => "ade.rahman",
                    "inisial" => "ARM",
                    "email" => "ade.rahman@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 9, "namalokasi" => "Store Room"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 4,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 7,
                            "namajabatan" => "Store Keeper BDA",
                        ],
                        "cg" => ["intidcg" => 2, "namacg" => "SHINING"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 244,
                    "nik" => "K200700231",
                    "nama" => "BUDI UTOYO",
                    "username" => "budi.utoyo",
                    "inisial" => "BUO",
                    "email" => "budi.utoyo@kalbenutritionals.com",
                    "ext" => "105",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 3,
                            "namadepartemen" => "MNF",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 21,
                            "namasubdepartemen" => "Manufacturing Department",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 139,
                            "namajabatan" => "Deputy Manufacturing Head",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 3, "namalevel" => "Dept Head"],
                    ],
                ],
                [
                    "id" => 245,
                    "nik" => "K200800227",
                    "nama" => "M. ALDI LA MUCHTAR",
                    "username" => "m..muchtar",
                    "inisial" => "MAL",
                    "email" => "m..muchtar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 56,
                            "namajabatan" => "Blending Operator",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 246,
                    "nik" => "K200800232",
                    "nama" => "ADIKA TRYPUTRANTO",
                    "username" => "adika.tryputranto",
                    "inisial" => "ATT",
                    "email" => "adika.tryputranto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 133,
                            "namajabatan" => "Warehouse RM Major Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 247,
                    "nik" => "K200800233",
                    "nama" => "DEDE ISKANDAR",
                    "username" => "dede.iskandar",
                    "inisial" => "DIR",
                    "email" => "dede.iskandar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 133,
                            "namajabatan" => "Warehouse RM Major Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 248,
                    "nik" => "K200800241",
                    "nama" => "AJI APRIALDI",
                    "username" => "aji.aprialdi",
                    "inisial" => "AAI",
                    "email" => "aji.aprialdi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 140,
                            "namajabatan" => "Helper WWTP",
                        ],
                        "cg" => ["intidcg" => 5, "namacg" => "SAUBERPRO"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 249,
                    "nik" => "K200900258",
                    "nama" => "DIKI MAULANA",
                    "username" => "diki.maulana",
                    "inisial" => "DMA",
                    "email" => "diki.maulana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 250,
                    "nik" => "K200900259",
                    "nama" => "MOHAMAD YUDI PERMANA",
                    "username" => "mohamad.permana",
                    "inisial" => "MYP",
                    "email" => "mohamad.permana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 251,
                    "nik" => "K200900262",
                    "nama" => "AHMAD MUDDAI",
                    "username" => "ahmad.muddai",
                    "inisial" => "AMI",
                    "email" => "ahmad.muddai@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 138,
                            "namajabatan" => "Warehouse FG Assistant",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 252,
                    "nik" => "K201000279",
                    "nama" => "EKKY MUHAMMAD RIZKULLAH",
                    "username" => "ekky.rizkullah",
                    "inisial" => "EMR",
                    "email" => "ekky.rizkullah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 141,
                            "namajabatan" => "QC In Line Field",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 253,
                    "nik" => "K201000285",
                    "nama" => "DAVIDS",
                    "username" => "davids.davids",
                    "inisial" => "DVS",
                    "email" => "davids.davids@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 129,
                            "namajabatan" => "Drier Continous Cleaner",
                        ],
                        "cg" => ["intidcg" => 16, "namacg" => "MACGYVER"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 254,
                    "nik" => "K201000286",
                    "nama" => "IQBAL SYAHRINDRA MUSTOPA",
                    "username" => "iqbal.mustopa",
                    "inisial" => "ISM",
                    "email" => "iqbal.mustopa@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 133,
                            "namajabatan" => "Warehouse RM Major Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 255,
                    "nik" => "K201000287",
                    "nama" => "DWI KARTIKA",
                    "username" => "dwi.kartika",
                    "inisial" => "DKA",
                    "email" => "dwi.kartika@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 142,
                            "namajabatan" => "Receptionist",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 256,
                    "nik" => "K201000295",
                    "nama" => "ANGGRI PRIWANDA",
                    "username" => "anggri.priwanda",
                    "inisial" => "APW",
                    "email" => "anggri.priwanda@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 257,
                    "nik" => "K201000296",
                    "nama" => "AHMAD KHAERUL FIKRI",
                    "username" => "ahmad.fikri",
                    "inisial" => "AKF",
                    "email" => "ahmad.fikri@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 258,
                    "nik" => "K201000297",
                    "nama" => "DENDI PRIMADI",
                    "username" => "dendi.primadi",
                    "inisial" => "DPI",
                    "email" => "dendi.primadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 259,
                    "nik" => "K201100303",
                    "nama" => "AGUS WIDIYANTO",
                    "username" => "agus.widiyanto",
                    "inisial" => "AWO",
                    "email" => "agus.widiyanto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 130,
                            "namajabatan" => "Eductor Helper",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 260,
                    "nik" => "K201100306",
                    "nama" => "SARAH SANUBARI",
                    "username" => "sarah.sanubari",
                    "inisial" => "SSI",
                    "email" => "sarah.sanubari@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 141,
                            "namajabatan" => "QC In Line Field",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 261,
                    "nik" => "K201100308",
                    "nama" => "MASTANI",
                    "username" => "mastani.mastani",
                    "inisial" => "MTI",
                    "email" => "mastani.mastani@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 137,
                            "namajabatan" => "Warehouse RM Minor Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 262,
                    "nik" => "K201100309",
                    "nama" => "MUHAMAD AKMAL AZIIZ",
                    "username" => "muhamad.aziiz",
                    "inisial" => "MAA",
                    "email" => "muhamad.aziiz@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 133,
                            "namajabatan" => "Warehouse RM Major Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 263,
                    "nik" => "K201100311",
                    "nama" => "ARI DESAR PAMUNGKAS",
                    "username" => "ari.pamungkas",
                    "inisial" => "ADP",
                    "email" => "ari.pamungkas@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 143,
                            "namajabatan" => "Dumping Helper",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 264,
                    "nik" => "K201200336",
                    "nama" => "HERU TRI MARDIAN",
                    "username" => "heru.mardian",
                    "inisial" => "HTM",
                    "email" => "heru.mardian@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 132,
                            "namajabatan" => "Warehouse RM Minor Assistant",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 265,
                    "nik" => "K210100001",
                    "nama" => "ZAKARIA",
                    "username" => "zakaria.zakaria",
                    "inisial" => "ZKA",
                    "email" => "zakaria.zakaria@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 136,
                            "namajabatan" => "Warehouse PM Assistant",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 266,
                    "nik" => "K210100003",
                    "nama" => "DINA OKTAVIA PUTRI",
                    "username" => "dina.putri",
                    "inisial" => "DOP",
                    "email" => "dina.putri@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 3, "namalokasi" => "Office Lt 3"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 5,
                            "namadepartemen" => "IOS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 16,
                            "namasubdepartemen" => "IOS Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 144,
                            "namajabatan" => "TPM Admin",
                        ],
                        "cg" => ["intidcg" => 8, "namacg" => "RISING STAR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 267,
                    "nik" => "K210200048",
                    "nama" => "SETIA MAULANA",
                    "username" => "setia.maulana",
                    "inisial" => "SMA",
                    "email" => "setia.maulana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 133,
                            "namajabatan" => "Warehouse RM Major Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 268,
                    "nik" => "K210200049",
                    "nama" => "ABI YOGA ASMARA",
                    "username" => "abi.asmara",
                    "inisial" => "AYA",
                    "email" => "abi.asmara@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 269,
                    "nik" => "K210200050",
                    "nama" => "HISAR DESMON SINAGA",
                    "username" => "hisar.sinaga",
                    "inisial" => "HDS",
                    "email" => "hisar.sinaga@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 129,
                            "namajabatan" => "Drier Continous Cleaner",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 270,
                    "nik" => "K210200054",
                    "nama" => "AHMAD",
                    "username" => "ahmad.ahmad",
                    "inisial" => "AMD",
                    "email" => "ahmad.ahmad@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 130,
                            "namajabatan" => "Eductor Helper",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 271,
                    "nik" => "K210200062",
                    "nama" => "DEDEN RUHDIANTO",
                    "username" => "deden.ruhdianto",
                    "inisial" => "DRU",
                    "email" => "deden.ruhdianto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 130,
                            "namajabatan" => "Eductor Helper",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 272,
                    "nik" => "K210300077",
                    "nama" => "KHONSA",
                    "username" => "khonsa.khonsa",
                    "inisial" => "KHN",
                    "email" => "khonsa.khonsa@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 92,
                            "namajabatan" => "Wet Canning Circle Admin",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 273,
                    "nik" => "K210300079",
                    "nama" => "RUSTA RUSDIANTO",
                    "username" => "rusta.rusdianto",
                    "inisial" => "RST",
                    "email" => "rusta.rusdianto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 274,
                    "nik" => "K210300080",
                    "nama" => "ABDUL KHARIS",
                    "username" => "abdul.kharis",
                    "inisial" => "AKS",
                    "email" => "abdul.kharis@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 275,
                    "nik" => "K210300086",
                    "nama" => "ENJAY ZARKASIH",
                    "username" => "enjay.zarkasih",
                    "inisial" => "ENJ",
                    "email" => "enjay.zarkasih@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 276,
                    "nik" => "K210300098",
                    "nama" => "LUKMAN NULHAKIM",
                    "username" => "lukman.nulhakim",
                    "inisial" => "LNH",
                    "email" => "lukman.nulhakim@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 277,
                    "nik" => "K210300099",
                    "nama" => "SAUD SIHOMBING",
                    "username" => "saud.sihombing",
                    "inisial" => "JSS",
                    "email" => "saud.sihombing@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 134,
                            "namajabatan" => "Bin Washing Helper",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 278,
                    "nik" => "K210400104",
                    "nama" => "ODI NANDANG SOMANTRI",
                    "username" => "odi.somantri",
                    "inisial" => "ONS",
                    "email" => "odi.somantri@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 134,
                            "namajabatan" => "Bin Washing Helper",
                        ],
                        "cg" => ["intidcg" => 18, "namacg" => "METAMORFOSIS"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 279,
                    "nik" => "K210400107",
                    "nama" => "ALI RAMDANI",
                    "username" => "ali.ramdani",
                    "inisial" => "ARI",
                    "email" => "ali.ramdani@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 130,
                            "namajabatan" => "Eductor Helper",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 280,
                    "nik" => "K210500154",
                    "nama" => "IMAN SANDI",
                    "username" => "iman.sandi",
                    "inisial" => "ISI",
                    "email" => "iman.sandi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 137,
                            "namajabatan" => "Warehouse RM Minor Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 281,
                    "nik" => "K210500161",
                    "nama" => "ANGGI IRWANSYAH",
                    "username" => "anggi.irwansyah",
                    "inisial" => "AIH",
                    "email" => "anggi.irwansyah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 137,
                            "namajabatan" => "Warehouse RM Minor Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 282,
                    "nik" => "K210600175",
                    "nama" => "UBAIDILAH ALI MURTADHO",
                    "username" => "ubaidilah.murtadho",
                    "inisial" => "UAM",
                    "email" => "ubaidilah.murtadho@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 4,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 7,
                            "namajabatan" => "Store Keeper BDA",
                        ],
                        "cg" => ["intidcg" => 2, "namacg" => "SHINING"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 283,
                    "nik" => "K210600177",
                    "nama" => "TAUFIK HIDAYAT TU\'MARUF",
                    "username" => "taufik.tu\'maruf",
                    "inisial" => "THT",
                    "email" => "taufik.tu\'maruf@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 137,
                            "namajabatan" => "Warehouse RM Minor Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 284,
                    "nik" => "K210700205",
                    "nama" => "DANI ENDAR MULYANA",
                    "username" => "dani.mulyana",
                    "inisial" => "DEM",
                    "email" => "dani.mulyana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 133,
                            "namajabatan" => "Warehouse RM Major Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 285,
                    "nik" => "K210700211",
                    "nama" => "MUHAMMAD ALFIN BASYAR",
                    "username" => "muhammad.basyar",
                    "inisial" => "MAB",
                    "email" => "muhammad.basyar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 145,
                            "namajabatan" => "QA Admin",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 286,
                    "nik" => "K210900224",
                    "nama" => "IRFAN SUHEGAR",
                    "username" => "irfan.suhegar",
                    "inisial" => "ISR",
                    "email" => "irfan.suhegar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 117,
                            "namajabatan" => "Mechanic Helper",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 287,
                    "nik" => "K210900227",
                    "nama" => "YOSA NIZAR FERNANTA",
                    "username" => "yosa.fernanta",
                    "inisial" => "YNF",
                    "email" => "yosa.fernanta@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 134,
                            "namajabatan" => "Bin Washing Helper",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 288,
                    "nik" => "K211000233",
                    "nama" => "ANDI MUNTAHA",
                    "username" => "andi.muntaha",
                    "inisial" => "AMA",
                    "email" => "andi.muntaha@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 138,
                            "namajabatan" => "Warehouse FG Assistant",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 289,
                    "nik" => "K220200017",
                    "nama" => "MULYANA",
                    "username" => "mulyana.mulyana",
                    "inisial" => "MYA",
                    "email" => "mulyana.mulyana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 290,
                    "nik" => "K220200018",
                    "nama" => "HENDI",
                    "username" => "hendi.hendi",
                    "inisial" => "HDI",
                    "email" => "hendi.hendi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 291,
                    "nik" => "K220200025",
                    "nama" => "ROBI SUPRIADI",
                    "username" => "robi.supriadi",
                    "inisial" => "RBS",
                    "email" => "robi.supriadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 292,
                    "nik" => "K220200026",
                    "nama" => "ASEP JAMALUDIN",
                    "username" => "asep.jamaludin",
                    "inisial" => "AJL",
                    "email" => "asep.jamaludin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 293,
                    "nik" => "K220300040",
                    "nama" => "ASEP SETIAWAN",
                    "username" => "asep.setiawan",
                    "inisial" => "ASN",
                    "email" => "asep.setiawan@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 4,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 146,
                            "namajabatan" => "Purchasing Administration",
                        ],
                        "cg" => ["intidcg" => 2, "namacg" => "SHINING"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 294,
                    "nik" => "K220400056",
                    "nama" => "ANWAR ZAELANI",
                    "username" => "anwar.zaelani",
                    "inisial" => "AZI",
                    "email" => "anwar.zaelani@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 15, "namacg" => "UVESPA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 295,
                    "nik" => "K220400065",
                    "nama" => "ERIK SUSANTO",
                    "username" => "erik.susanto",
                    "inisial" => "ESO",
                    "email" => "erik.susanto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 296,
                    "nik" => "K220400071",
                    "nama" => "RETSU EKA TITIS",
                    "username" => "retsu.titis",
                    "inisial" => "RET",
                    "email" => "retsu.titis@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 13, "namacg" => "GEMASD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 297,
                    "nik" => "K220400073",
                    "nama" => "FAISAL FERDIANSYAH PUTRA",
                    "username" => "faisal.putra",
                    "inisial" => "FFA",
                    "email" => "faisal.putra@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 147,
                            "namajabatan" => "QC Microbiology Field",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 298,
                    "nik" => "K220500075",
                    "nama" => "AZIZ MUSTOFA",
                    "username" => "aziz.mustofa",
                    "inisial" => "AMF",
                    "email" => "aziz.mustofa@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 138,
                            "namajabatan" => "Warehouse FG Assistant",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 299,
                    "nik" => "K220600103",
                    "nama" => "YANA RUDIANA",
                    "username" => "yana.rudiana",
                    "inisial" => "YRA",
                    "email" => "yana.rudiana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 138,
                            "namajabatan" => "Warehouse FG Assistant",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 300,
                    "nik" => "K220600104",
                    "nama" => "NANDI SUNARDI",
                    "username" => "nandi.sunardi",
                    "inisial" => "NSI",
                    "email" => "nandi.sunardi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 137,
                            "namajabatan" => "Warehouse RM Minor Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 301,
                    "nik" => "K220600105",
                    "nama" => "DWI LESNA PRASETYO",
                    "username" => "dwi.prasetyo",
                    "inisial" => "DLP",
                    "email" => "dwi.prasetyo@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 137,
                            "namajabatan" => "Warehouse RM Minor Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 302,
                    "nik" => "K220600106",
                    "nama" => "RIYAN MAULANA YUSUF",
                    "username" => "riyan.yusuf",
                    "inisial" => "RMY",
                    "email" => "riyan.yusuf@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 133,
                            "namajabatan" => "Warehouse RM Major Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 303,
                    "nik" => "K220600108",
                    "nama" => "VICKY ARDIANSYAH",
                    "username" => "vicky.ardiansyah",
                    "inisial" => "VKY",
                    "email" => "vicky.ardiansyah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 14, "namacg" => "HYBRID"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 304,
                    "nik" => "K220600119",
                    "nama" => "TIAS OKTAVIAN",
                    "username" => "tias.oktavian",
                    "inisial" => "TON",
                    "email" => "tias.oktavian@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 137,
                            "namajabatan" => "Warehouse RM Minor Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 305,
                    "nik" => "K220700142",
                    "nama" => "MAZMUR",
                    "username" => "mazmur.mazmur",
                    "inisial" => "MZR",
                    "email" => "mazmur.mazmur@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 111,
                            "namajabatan" => "Wet Sachet Circle Admin",
                        ],
                        "cg" => ["intidcg" => 19, "namacg" => "EMAX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 306,
                    "nik" => "K220800151",
                    "nama" => "NOSA RULI WALFAJRI",
                    "username" => "nosa.walfajri",
                    "inisial" => "NRW",
                    "email" => "nosa.walfajri@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 148,
                            "namajabatan" => "Admin Technician",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 307,
                    "nik" => "K220800163",
                    "nama" => "HANI NURAINI FAUZIYYAH",
                    "username" => "hani.fauziyyah",
                    "inisial" => "HNF",
                    "email" => "hani.fauziyyah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 149,
                            "namajabatan" => "HRD Administration",
                        ],
                        "cg" => ["intidcg" => 6, "namacg" => "SALT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 308,
                    "nik" => "K221100201",
                    "nama" => "DEN ZUHARA IBNU",
                    "username" => "den.ibnu",
                    "inisial" => "DZI",
                    "email" => "den.ibnu@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => [
                            "intidlokasi" => 28,
                            "namalokasi" => "QA - LAB INLINE",
                        ],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 150,
                            "namajabatan" => "QC Field Administration",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 309,
                    "nik" => "K230100015",
                    "nama" => "ADITYA DAVIT NUGROHO",
                    "username" => "aditya.nugroho",
                    "inisial" => "AND",
                    "email" => "aditya.nugroho@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 31, "namalokasi" => "RM"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 137,
                            "namajabatan" => "Warehouse RM Minor Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 310,
                    "nik" => "K230200018",
                    "nama" => "MUHAMAD FIRMAN GANI",
                    "username" => "muhamad.firman",
                    "inisial" => "MFG",
                    "email" => "muhamad.firman@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => [
                            "intidlokasi" => 28,
                            "namalokasi" => "QA - LAB INLINE",
                        ],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 83,
                            "namajabatan" => "QC In Line Analyst",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 311,
                    "nik" => "K230200019",
                    "nama" => "KANIA DEWI FITRIANI",
                    "username" => "kania.fitriani",
                    "inisial" => "KDF",
                    "email" => "kania.fitriani@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => [
                            "intidlokasi" => 28,
                            "namalokasi" => "QA - LAB INLINE",
                        ],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 150,
                            "namajabatan" => "QC Field Administration",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 312,
                    "nik" => "K230200024",
                    "nama" => "PUTRI NUR RAHMAWATI",
                    "username" => "putri.rahmawati",
                    "inisial" => "PNR",
                    "email" => "putri.rahmawati@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 149,
                            "namajabatan" => "HRD Administration",
                        ],
                        "cg" => ["intidcg" => 2, "namacg" => "SHINING"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 313,
                    "nik" => "K230200025",
                    "nama" => "ALI DAVIT",
                    "username" => "ali.davit",
                    "inisial" => "ADT",
                    "email" => "ali.davit@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => [
                            "intidlokasi" => 28,
                            "namalokasi" => "QA - LAB INLINE",
                        ],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 150,
                            "namajabatan" => "QC Field Administration",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 314,
                    "nik" => "O181200144",
                    "nama" => "CAHYADI",
                    "username" => "cahyadi.cahyadi",
                    "inisial" => "CYI",
                    "email" => "cahyadi.cahyadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => ["intidjabatan" => 152, "namajabatan" => "Driver"],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 315,
                    "nik" => "O190600102",
                    "nama" => "TATANG MEINSYAHYAR",
                    "username" => "tatang.meinsyahyar",
                    "inisial" => "TMR",
                    "email" => "tatang.meinsyahyar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => ["intidjabatan" => 152, "namajabatan" => "Driver"],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 316,
                    "nik" => "O191000171",
                    "nama" => "ADE RENALDI",
                    "username" => "ade.renaldi",
                    "inisial" => "ARI",
                    "email" => "ade.renaldi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 317,
                    "nik" => "O191100184",
                    "nama" => "MOHAMAD ZEIN",
                    "username" => "mohamad.zein",
                    "inisial" => "MZN",
                    "email" => "mohamad.zein@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 318,
                    "nik" => "O200200008",
                    "nama" => "MULYONO",
                    "username" => "mulyono.mulyono",
                    "inisial" => "MYO",
                    "email" => "mulyono.mulyono@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 153,
                            "namajabatan" => "Building Maintenance",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 319,
                    "nik" => "O200200010",
                    "nama" => "AMSIR",
                    "username" => "amsir.amsir",
                    "inisial" => "AMR",
                    "email" => "amsir.amsir@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 8, "namalokasi" => "Workshop"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 6,
                            "namadepartemen" => "ENG",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 8,
                            "namasubdepartemen" => "Engineering Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 153,
                            "namajabatan" => "Building Maintenance",
                        ],
                        "cg" => ["intidcg" => 4, "namacg" => "CEPOT WARRIOR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 320,
                    "nik" => "O200600033",
                    "nama" => "IFQI DJUL FAHMI",
                    "username" => "ifqi.fahmi",
                    "inisial" => "IDF",
                    "email" => "ifqi.fahmi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 321,
                    "nik" => "O200600034",
                    "nama" => "ILHAM GULTOM",
                    "username" => "ilham.gultom",
                    "inisial" => "IGM",
                    "email" => "ilham.gultom@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 322,
                    "nik" => "O200900056",
                    "nama" => "DEA ROBIANTA",
                    "username" => "dea.robianta",
                    "inisial" => "DRA",
                    "email" => "dea.robianta@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 323,
                    "nik" => "O220100005",
                    "nama" => "AHMAD AFIF FUDIN",
                    "username" => "ahmad.fudin",
                    "inisial" => "AAN",
                    "email" => "ahmad.fudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 324,
                    "nik" => "O220100006",
                    "nama" => "ASEP TEGUH",
                    "username" => "asep.teguh",
                    "inisial" => "ATH",
                    "email" => "asep.teguh@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 325,
                    "nik" => "O220100011",
                    "nama" => "JENI",
                    "username" => "jeni.jeni",
                    "inisial" => "JNI",
                    "email" => "jeni.jeni@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 326,
                    "nik" => "O220100012",
                    "nama" => "JUHANA",
                    "username" => "juhana.juhana",
                    "inisial" => "JHA",
                    "email" => "juhana.juhana@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 327,
                    "nik" => "O220100015",
                    "nama" => "SAEFUL ANWAR",
                    "username" => "saeful.anwar",
                    "inisial" => "SAR",
                    "email" => "saeful.anwar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 328,
                    "nik" => "O220100016",
                    "nama" => "SAMSUDIN",
                    "username" => "samsudin.samsudin",
                    "inisial" => "SSN",
                    "email" => "samsudin.samsudin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 329,
                    "nik" => "O220100017",
                    "nama" => "SURYANTO",
                    "username" => "suryanto.suryanto",
                    "inisial" => "SYO",
                    "email" => "suryanto.suryanto@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 155,
                            "namajabatan" => "Komandan Regu",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 330,
                    "nik" => "O220100018",
                    "nama" => "UMAR WIRANATA KUSUMA",
                    "username" => "umar.kusuma",
                    "inisial" => "UWK",
                    "email" => "umar.kusuma@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 155,
                            "namajabatan" => "Komandan Regu",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 331,
                    "nik" => "O220100020",
                    "nama" => "TAUFIK HIDAYAT",
                    "username" => "taufik.hidayat",
                    "inisial" => "THT",
                    "email" => "taufik.hidayat@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 155,
                            "namajabatan" => "Komandan Regu",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 332,
                    "nik" => "O220100021",
                    "nama" => "NUNUNG",
                    "username" => "nunung.nunung",
                    "inisial" => "NNG",
                    "email" => "nunung.nunung@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 333,
                    "nik" => "O220100022",
                    "nama" => "ASEP MUSDIONO",
                    "username" => "asep.musdiono",
                    "inisial" => "AMO",
                    "email" => "asep.musdiono@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 156,
                            "namajabatan" => "Komandan",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 334,
                    "nik" => "O220100023",
                    "nama" => "EKA AMSORIH",
                    "username" => "eka.amsorih",
                    "inisial" => "EAI",
                    "email" => "eka.amsorih@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 335,
                    "nik" => "O220300033",
                    "nama" => "ADI SUKARDI",
                    "username" => "adi.sukardi",
                    "inisial" => "ASI",
                    "email" => "adi.sukardi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 336,
                    "nik" => "O220300036",
                    "nama" => "DERA ARIYANDI",
                    "username" => "dera.ariyandi",
                    "inisial" => "DAI",
                    "email" => "dera.ariyandi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 6, "namalokasi" => "POS"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 337,
                    "nik" => "O220300037",
                    "nama" => "ISKANDAR",
                    "username" => "iskandar.iskandar",
                    "inisial" => "IKR",
                    "email" => "iskandar.iskandar@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 6, "namalokasi" => "POS"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 338,
                    "nik" => "O220300038",
                    "nama" => "ANDREANSYAH",
                    "username" => "andreansyah.andreansyah",
                    "inisial" => "ANH",
                    "email" => "andreansyah.andreansyah@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 6, "namalokasi" => "POS"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 339,
                    "nik" => "O220300040",
                    "nama" => "DEDE ROSADI",
                    "username" => "dede.rosadi",
                    "inisial" => "DRI",
                    "email" => "dede.rosadi@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 6, "namalokasi" => "POS"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 340,
                    "nik" => "O220500055",
                    "nama" => "ARIFIN",
                    "username" => "arifin.arifin",
                    "inisial" => "AFN",
                    "email" => "arifin.arifin@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 157,
                            "namajabatan" => "Cleaning Service Leader",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 341,
                    "nik" => "O220800097",
                    "nama" => "I MADE RESTU ARYA SAPUTRA",
                    "username" => "i.saputra",
                    "inisial" => "IMR",
                    "email" => "i.saputra@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 342,
                    "nik" => "O230100006",
                    "nama" => "LUSIA KARENIA ALLETA",
                    "username" => "lusia.alle",
                    "inisial" => "LKA",
                    "email" => "lusia.alle@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 343,
                    "nik" => "O230200011",
                    "nama" => "EUIS SONIA",
                    "username" => "euis.sonia",
                    "inisial" => "ESA",
                    "email" => "euis.sonia@kalbenutritionals.com",
                    "ext" => "#N/A",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 14, "namalevel" => "Member CG"],
                    ],
                ],
                [
                    "id" => 344,
                    "nik" => "4dm1n",
                    "nama" => "admin",
                    "username" => "admin",
                    "inisial" => "admin",
                    "email" => "admin@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 10,
                            "namadepartemen" => "MDP",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 18,
                            "namasubdepartemen" => "IT Section",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 99,
                            "namajabatan" => "Aplication & Development Support Staff",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 9, "namalevel" => "Admin"],
                    ],
                ],
                [
                    "id" => 345,
                    "nik" => "230500073",
                    "nama" => "MUHAMMAD NAUFAL AMANULLAH",
                    "username" => "muhammad.amanullah",
                    "inisial" => "MNA",
                    "email" => "muhammad.amanullah@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 13,
                            "namasubdepartemen" => "Human Capital Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 114,
                            "namajabatan" => "Recruitment & Learning Development Staff",
                        ],
                        "cg" => ["intidcg" => 6, "namacg" => "SALT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 346,
                    "nik" => "230600088",
                    "nama" => "PUTRI RAHMAWATI",
                    "username" => "putri.rahmawati",
                    "inisial" => "PRI",
                    "email" => "putri.rahmawati@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 1,
                            "namadepartemen" => "BDA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 5,
                            "namasubdepartemen" =>
                            "Business Development & Analysis Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 42,
                            "namajabatan" => "Finance & Accounting Staff",
                        ],
                        "cg" => ["intidcg" => 1, "namacg" => "AVATAR"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 347,
                    "nik" => "K230300029",
                    "nama" => "DIANA PUTRI ANUGRAHANI",
                    "username" => "diana.anugrahani",
                    "inisial" => "DPA",
                    "email" => "diana.anugrahani@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 149,
                            "namajabatan" => "HRD Administration",
                        ],
                        "cg" => ["intidcg" => 6, "namacg" => "SALT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 348,
                    "nik" => "K230300033",
                    "nama" => "MUHAMAD RUHYAT",
                    "username" => "muhamad.ruhyat",
                    "inisial" => "MRT",
                    "email" => "muhamad.ruhyat@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 134,
                            "namajabatan" => "Bin Washing Helper",
                        ],
                        "cg" => ["intidcg" => 17, "namacg" => "SUPERBIN"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 349,
                    "nik" => "K230300056",
                    "nama" => "ADITHIA EKA SETIAWAN",
                    "username" => "adithia.setiawan",
                    "inisial" => "AES",
                    "email" => "adithia.setiawan@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => [
                            "intidlokasi" => 28,
                            "namalokasi" => "QA - LAB INLINE",
                        ],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 145,
                            "namajabatan" => "QA Admin",
                        ],
                        "cg" => ["intidcg" => 20, "namacg" => "BIMASAKTI"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 350,
                    "nik" => "K230400054",
                    "nama" => "ANDI GUSNADI",
                    "username" => "andi.gusnadi",
                    "inisial" => "AGI",
                    "email" => "andi.gusnadi@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 2, "namalokasi" => "Office Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 76,
                            "namajabatan" => "Warehouse Admin",
                        ],
                        "cg" => ["intidcg" => 23, "namacg" => "FINISHGOOD"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 351,
                    "nik" => "K230400055",
                    "nama" => "LANGGENG MULYONO",
                    "username" => "langgeng.mulyono",
                    "inisial" => "LMO",
                    "email" => "langgeng.mulyono@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => [
                            "intidlokasi" => 17,
                            "namalokasi" => "Finish Good",
                        ],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 137,
                            "namajabatan" => "Warehouse RM Minor Helper",
                        ],
                        "cg" => ["intidcg" => 22, "namacg" => "RMPM"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 352,
                    "nik" => "K230400058",
                    "nama" => "AKBAR MAULANA PAMUNGKAS",
                    "username" => "akbar.pamungkas",
                    "inisial" => "AMP",
                    "email" => "akbar.pamungkas@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => [
                            "intidlokasi" => 28,
                            "namalokasi" => "QA - LAB INLINE",
                        ],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 141,
                            "namajabatan" => "QC In Line Field",
                        ],
                        "cg" => ["intidcg" => 21, "namacg" => "GANIMEDA"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 353,
                    "nik" => "K230500082",
                    "nama" => "AZIS BAHARI",
                    "username" => "azis.bahari",
                    "inisial" => "ABI",
                    "email" => "azis.bahari@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 1, "namalokasi" => "Office Lt 1"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 10,
                            "namadepartemen" => "MDP",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 19,
                            "namasubdepartemen" => "IT Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 158,
                            "namajabatan" => "IT Helpdesk",
                        ],
                        "cg" => ["intidcg" => 11, "namacg" => "MATRIX"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 354,
                    "nik" => "K230600089",
                    "nama" => "ANHARUN NUHA",
                    "username" => "anharun.nuha",
                    "inisial" => "ANA",
                    "email" => "anharun.nuha@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 130,
                            "namajabatan" => "Eductor Helper",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 355,
                    "nik" => "K230600090",
                    "nama" => "ERVIN CHOIRUL ANWAR",
                    "username" => "ervin.anwar",
                    "inisial" => "eca",
                    "email" => "ervin.anwar@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 130,
                            "namajabatan" => "Eductor Helper",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 356,
                    "nik" => "K230600091",
                    "nama" => "IRFAN ANGGARA",
                    "username" => "irfan.anggara",
                    "inisial" => "IAA",
                    "email" => "irfan.anggara@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 357,
                    "nik" => "K230600092",
                    "nama" => "NUR SANDI SEPTIANDI",
                    "username" => "nur.septiandi",
                    "inisial" => "NSS",
                    "email" => "nur.septiandi@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 358,
                    "nik" => "K230600093",
                    "nama" => "ARIS SETIAWAN",
                    "username" => "aris.setiawan",
                    "inisial" => "ASN",
                    "email" => "aris.setiawan@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 359,
                    "nik" => "K230600098",
                    "nama" => "AHMAD IQBAL AMMAR",
                    "username" => "ahmad.ammar",
                    "inisial" => "AIA",
                    "email" => "ahmad.ammar@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 4, "namalokasi" => "PRD"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 135,
                            "namajabatan" => "Sachet Packing Helper",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 360,
                    "nik" => "O230300018",
                    "nama" => "DIEMAS ANGGER MEGANTARA",
                    "username" => "diemas.megantara",
                    "inisial" => "DAM",
                    "email" => "diemas.megantara@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 361,
                    "nik" => "O230300025",
                    "nama" => "RATU NABILA KHOIRUNNISA",
                    "username" => "ratu.khoirunnisa",
                    "inisial" => "RNK",
                    "email" => "ratu.khoirunnisa@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 6, "namalokasi" => "POS"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 7, "namalevel" => "Security"],
                    ],
                ],
                [
                    "id" => 362,
                    "nik" => "O230300026",
                    "nama" => "RIKI SUJANA",
                    "username" => "riki.sujana",
                    "inisial" => "RSA",
                    "email" => "riki.sujana@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 6, "namalokasi" => "POS"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 154,
                            "namajabatan" => "Security",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 7, "namalevel" => "Security"],
                    ],
                ],
                [
                    "id" => 363,
                    "nik" => "O230400027",
                    "nama" => "ENDAN KURNIAWAN",
                    "username" => "endan.kurniawan",
                    "inisial" => "EKN",
                    "email" => "endan.kurniawan@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 364,
                    "nik" => "O230400031",
                    "nama" => "MOCHAMAD IKRAM SANTOSA",
                    "username" => "mochamad.santosa",
                    "inisial" => "MIS",
                    "email" => "mochamad.santosa@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 365,
                    "nik" => "O230500041",
                    "nama" => "HAMDAN",
                    "username" => "hamdan",
                    "inisial" => "HDN",
                    "email" => "hamdan@kalbenutritionals.com",
                    "ext" => "000",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 7, "namalokasi" => "Mobile"],
                        "divisi" => ["intiddivisi" => 2, "namadivisi" => "Supporting"],
                        "departemen" => [
                            "intiddepartemen" => 4,
                            "namadepartemen" => "HC",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 12,
                            "namasubdepartemen" => "Human Capital Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 151,
                            "namajabatan" => "Cleaning Service",
                        ],
                        "cg" => ["intidcg" => 7, "namacg" => "EFFERVESCENT"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 366,
                    "nik" => "K230600105",
                    "nama" => "ROBI MUHAMAD RAMDANI",
                    "username" => "robi.ramdani",
                    "inisial" => "RMR",
                    "email" => "robi.ramdani@kalbenutritionals.com",
                    "ext" => "0",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 32, "namalokasi" => "RMPM Lt 2"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 9,
                            "namadepartemen" => "WHS",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 35,
                            "namasubdepartemen" => "Warehouse Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 137,
                            "namajabatan" => "Warehouse RM Minor Helper",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 367,
                    "nik" => "K230600106",
                    "nama" => "MARCELINO DWI ARYA SAPUTRA",
                    "username" => "marcelino.saputra",
                    "inisial" => "MDA",
                    "email" => "marcelino.saputra@kalbenutritionals.com",
                    "ext" => "0",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => [
                            "intidlokasi" => 28,
                            "namalokasi" => "QA - LAB INLINE",
                        ],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 8,
                            "namadepartemen" => "QA",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 31,
                            "namasubdepartemen" => "QA Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 83,
                            "namajabatan" => "QC In Line Analyst",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
                [
                    "id" => 368,
                    "nik" => "K230600107",
                    "nama" => "AGUNG ARIS ROZAQI",
                    "username" => "agung.rozaqi",
                    "inisial" => "AAR",
                    "email" => "agung.rozaqi@kalbenutritionals.com",
                    "ext" => "0",
                    "gambarprofile" => "unknown.jpg",
                    "relationships" => [
                        "lokasi" => ["intidlokasi" => 15, "namalokasi" => "DRIER"],
                        "divisi" => [
                            "intiddivisi" => 3,
                            "namadivisi" => "Manufacturing",
                        ],
                        "departemen" => [
                            "intiddepartemen" => 7,
                            "namadepartemen" => "PRD",
                        ],
                        "subdepartemen" => [
                            "intidsubdepartemen" => 27,
                            "namasubdepartemen" => "Production Sub Unit",
                        ],
                        "jabatan" => [
                            "intidjabatan" => 87,
                            "namajabatan" => "Dry Sachet Circle Admin",
                        ],
                        "cg" => ["intidcg" => 24, "namacg" => "NONCG"],
                        "company" => [
                            "intidcompany" => 1,
                            "namacompany" => "PT Kalbe Morinaga Indonesia",
                        ],
                        "level" => ["intidlevel" => 5, "namalevel" => "Staff"],
                    ],
                ],
            ],
        ];

        return response()->json($arrayVar);
    }
}
