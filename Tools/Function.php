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

function convertSnakeToCamel(string $snake): string
{
    return preg_replace_callback('/_([a-z])/', static fn ($matches) => strtoupper($matches[1]), $snake);
}

function convertSnakeToPascal(string $snake): string
{
    $camel = convertSnakeToCamel($snake);

    return ucfirst($camel); // PascalCase dimulai dengan huruf kapital
}

function scanAndFixNaming(array $includePaths, array $excludePaths, array $excludeFiles, array $excludedFunctions, array $excludedClasses): void
{
    foreach ($includePaths as $includePath) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($includePath, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        $phpFiles = new RegexIterator($iterator, '/\.php$/i');

        foreach ($phpFiles as $file) {
            $filePath = $file->getPathname();

            // Cek apakah file atau path dikecualikan
            if (in_array($filePath, $excludeFiles, true)) {
                echo "Melewati file: {$filePath} (file dikecualikan)\n";

                continue;
            }

            foreach ($excludePaths as $excludePath) {
                if (str_starts_with($filePath, $excludePath)) {
                    echo "Melewati file: {$filePath} (path dikecualikan)\n";

                    continue 2;
                }
            }

            $content         = file_get_contents($filePath);
            $originalContent = $content;

            // Regex untuk mencari fungsi snake_case
            $functionPattern = '/function\s+(\w+_[a-zA-Z0-9_]+)/';

            // Cari dan ganti fungsi snake_case
            $content = preg_replace_callback($functionPattern, static function ($matches) use ($excludedFunctions) {
                $functionName = $matches[1];
                if (in_array($functionName, $excludedFunctions, true)) {
                    return $matches[0]; // Jangan ubah fungsi yang dikecualikan
                }
                $camel = convertSnakeToCamel($functionName);

                return 'function ' . $camel;
            }, $content);

            // Regex untuk mencari kelas snake_case
            $classPattern = '/class\s+(\w+_[a-zA-Z0-9_]+)/';

            // Cari dan ganti kelas snake_case
            $content = preg_replace_callback($classPattern, static function ($matches) use ($excludedClasses) {
                $className = $matches[1];
                if (in_array($className, $excludedClasses, true)) {
                    return $matches[0]; // Jangan ubah kelas yang dikecualikan
                }
                $pascal = convertSnakeToPascal($className);

                return 'class ' . $pascal;
            }, $content);

            // Jika file berubah, tulis ulang
            if ($content !== $originalContent) {
                echo "Memperbaiki file: {$filePath}\n";
                file_put_contents($filePath, $content);
            }
        }
    }
}

// Konfigurasi
$includePaths      = ['.']; // Path yang akan dipindai (sesuaikan dengan proyek Anda)
$excludePaths      = []; // Path yang dikecualikan
$excludeFiles      = []; // File yang dikecualikan
$excludedFunctions = ['__construct']; // Fungsi yang dikecualikan
$excludedClasses   = ['my_class_to_skip']; // Kelas yang dikecualikan

scanAndFixNaming($includePaths, $excludePaths, $excludeFiles, $excludedFunctions, $excludedClasses);
