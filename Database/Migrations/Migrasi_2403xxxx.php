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

use App\Traits\Migrator;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () {
    use Migrator;

    public function up(): void
    {
        // Tambah Navigasi
        $this->tambahModul();

        // Tambah Tabel
        $this->tambahTabel();

        // Panggil Seeder
        // $this->call(OtherSeeder::class);
        // (new TemplateSeeder())->run();
    }

    protected function tambahModul()
    {
        // Menu Utama
        $this->createModul([
            'config_id' => identitas('id'),
            'modul'     => 'Contoh',
            'url'       => '',
            'slug'      => 'contoh',
            'ikon'      => 'fa-globe',
            'level'     => 1,
        ]);

        // Sub Menu
        $this->createModul([
            'config_id'   => identitas('id'),
            'modul'       => 'Sub Contoh',
            'url'         => 'sub-contoh',
            'slug'        => 'sub-contoh',
            'ikon'        => 'fa-globe',
            'level'       => 2,
            'parent_slug' => 'contoh',
        ]);
    }

    protected function tambahTabel()
    {
        if (! Schema::hasTable('tabel_contoh')) {
            Schema::create('tabel_contoh', static function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('config_id');
                $table->string('nama');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        $this->deleteModul(['config_id' => identitas('id'), 'slug' => 'contoh']);

        // Jika database gabungan, jangan hapus tabel
        if (DB::table('config')->count() > 1) {
            Schema::dropIfExists('tabel_contoh');
        }
    }
};
