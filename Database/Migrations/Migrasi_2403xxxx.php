<?php

/*
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package   OpenSID
 * @author    Tim Pengembang OpenDesa
 * @copyright Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */

use App\Enums\StatusEnum;
use App\Models\Modul;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

defined('BASEPATH') || exit('No direct script access allowed');

return new class () extends MY_model {
    public function up(): void
    {
        $hasil = true;

        // Tambah Navigasi
        $hasil = $hasil && $this->tambahMenu($hasil);

        // Tambah Tabel
        $hasil = $hasil && $this->tambahTabel($hasil);
    }

    protected function tambahMenu($hasil)
    {
        // Menu Utama
        $hasil = $hasil && $this->tambah_modul([
            'config_id'  => identitas('id'),
            'modul'      => 'Contoh',
            'url'        => null,
            'slug'       => 'contoh',
            'aktif'      => StatusEnum::YA,
            'ikon'       => 'fa-globe',
            'urut'       => Modul::max('urut') + 1,
            'level'      => 1,
            'parent'     => 0,
            'hidden'     => 0,
            'ikon_kecil' => 'fa-globe',
        ]);

        // Sub Menu
        $contoh = Modul::whereSlug('contoh')->first();

        return $hasil && $this->tambah_modul([
            'config_id'  => identitas('id'),
            'modul'      => 'Sub Contoh',
            'url'        => 'sub-contoh',
            'slug'       => 'sub-contoh',
            'aktif'      => StatusEnum::YA,
            'ikon'       => 'fa-globe',
            'urut'       => Modul::whereParent($contoh->id)->max('urut') + 1 ?? 1,
            'level'      => 2,
            'parent'     => $contoh->id,
            'hidden'     => 0,
            'ikon_kecil' => 'fa-globe',
        ]);
    }

    protected function tambahTabel($hasil)
    {
        Schema::create('tabel_contoh', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('config_id');
            $table->string('nama');
            $table->timestamps();
        });

        return $hasil;
    }

    public function down(): void
    {
        $prodeskel = Modul::whereSlug('prodeskel')->first();
        Modul::whereParent($prodeskel->id)->delete();

        Schema::dropIfExists('tabel_contoh');
    }
};
