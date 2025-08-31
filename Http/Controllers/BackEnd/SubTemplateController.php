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
 * Hak Cipta 2016 - 2025 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
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
 * @copyright Hak Cipta 2016 - 2025 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */

use Modules\Template\Enums\TemplateEnum;
use Modules\Template\Libraries\TemplateLibrary;
use Modules\Template\Models\TemplateModel;
use Modules\Template\Services\TemplateService;
use Modules\Template\Traits\TemplateTrait;

defined('BASEPATH') || exit('No direct script access allowed');

class SubTemplateController extends AdminModulController
{
    use TemplateTrait;

    public $modul_ini           = 'Template';
    public $sub_modul_ini       = 'sub-template';
    public $kategori_pengaturan = 'Template';

    public function __construct()
    {
        parent::__construct();
        isCan('b');
    }

    // Views
    public function index()
    {
        return view('template::backend.sub-template.index');
    }

    // Models
    public function model()
    {
        $Template = TemplateModel::get()->toArray();

        return json($Template);
    }

    // Helpers
    public function helper()
    {
        $Template = template();

        return json($Template);
    }

    // Configs
    public function config()
    {
        $template = config('template');

        return json($template);
    }

    // Traits
    public function trait()
    {
        $data = [
            'id'   => 1,
            'name' => 'Data',
        ];

        $this->logData('Data ditampilkan: ' . json_encode($data));

        return json($data);
    }

    // Services
    public function service()
    {
        $result = (new TemplateService())->add(5, 10);

        return json(['result' => $result]);
    }

    // Libraries
    public function library()
    {
        $text   = 'ini template text';
        $result = TemplateLibrary::wordCount($text);

        return json(['count' => $result]);
    }

    // Enums
    public function enum()
    {
        $all         = TemplateEnum::all();
        $keys        = TemplateEnum::keys();
        $values      = TemplateEnum::values();
        $randomKey   = TemplateEnum::randomKey();
        $randomValue = TemplateEnum::randomValue();

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
        $file = module_storage('template', 'app/template.txt');

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
