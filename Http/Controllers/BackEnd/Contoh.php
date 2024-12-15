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

use Modules\Template\Enums\ContohEnum;
use Modules\Template\Libraries\ContohLibrary;
use Modules\Template\Models\Agama;
use Modules\Template\Services\ContohService;
use Modules\Template\Traits\ContohTrait;

defined('BASEPATH') || exit('No direct script access allowed');

class Contoh extends AdminModulController
{
    use ContohTrait;

    public $modul_ini     = 'contoh';
    public $sub_modul_ini = 'sub-contoh';
    public $subModulAkas = 'sub-contoh';

    public function __construct()
    {
        parent::__construct();
        isCan('b');
    }

    // Views
    public function indexAkas()
    {
        return view('template::backend.index');
    }

    // Models
    public function model()
    {
        $contoh = Agama::get()->toArray();

        return json($contoh);
    }

    // Helpers
    public function helper()
    {
        $contoh = contoh();

        return json($contoh);
    }

    // Configs
    public function config()
    {
        $contoh = config('contoh');

        return json($contoh);
    }

    // Traits
    public function trait()
    {
        $data = [
            'id'   => 1,
            'name' => 'Contoh Data',
        ];

        $this->logData('Data ditampilkan: ' . json_encode($data));

        return json($data);
    }

    // Services
    public function service()
    {
        $result = (new ContohService())->add(5, 10);

        return json(['result' => $result]);
    }

    // Libraries
    public function library()
    {
        $text   = 'ini contoh text';
        $result = ContohLibrary::wordCount($text);

        return json(['count' => $result]);
    }

    // Enums
    public function enum()
    {
        $all         = ContohEnum::all();
        $keys        = ContohEnum::keys();
        $values      = ContohEnum::values();
        $randomKey   = ContohEnum::randomKey();
        $randomValue = ContohEnum::randomValue();

        return json([
            'all'         => $all,
            'keys'        => $keys,
            'values'      => $values,
            'randomKey'   => $randomKey,
            'randomValue' => $randomValue,
        ]);
    }

    // Storage
    public function storage()
    {
        $file = module_storage('app/contoh.txt');

        if (file_exists($file)) {
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            readfile($file);
        } else {
            show_error('File tidak ditemukan');
        }

        exit;
    }

    // Hak Akses Baca
    public function baca()
    {
        isCan('b');

        return json(['message' => 'Anda memiliki hak akses baca']);
    }

    // Hak Akses tambah/ubah
    public function form()
    {
        isCan('u');

        return json(['message' => 'Anda memiliki hak akses tambah/ubah']);
    }

    // Hak Akses Hapus
    public function hapus()
    {
        isCan('h');

        return json(['message' => 'Anda memiliki hak akses hapus']);
    }
}
