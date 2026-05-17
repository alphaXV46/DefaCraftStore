<?php
$files = [
    'resources/views/profile/edit.blade.php',
    'resources/views/produk/show.blade.php',
    'resources/views/partials/header.blade.php',
    'resources/views/partials/footer.blade.php',
    'resources/views/layouts/guest.blade.php',
    'resources/views/layouts/auth.blade.php',
    'resources/views/keranjang/index.blade.php',
    'resources/views/admin/transaksi/show.blade.php',
    'resources/views/admin/dashboard.blade.php'
];

foreach ($files as $file) {
    $fullPath = 'd:/laragon/www/DefaCraftStore/' . $file;
    if (!file_exists($fullPath)) continue;
    
    $content = file_get_contents($fullPath);
    
    $baseName = str_replace(['resources/views/', '.blade.php'], '', $file);
    $baseName = str_replace('/', '-', $baseName);
    $cssFileName = $baseName . '.css';
    $cssPath = 'd:/laragon/www/DefaCraftStore/public/css/' . $cssFileName;
    
    if (preg_match_all('/<style(?:[^>]*)>([\s\S]*?)<\/style>/i', $content, $matches)) {
        $cssContent = implode("\n", $matches[1]);
        
        // Minify CSS
        $cssContent = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $cssContent);
        $cssContent = str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], ' ', $cssContent);
        $cssContent = preg_replace('/\s+/', ' ', $cssContent);
        $cssContent = trim($cssContent);
        
        file_put_contents($cssPath, $cssContent);
        
        $linkTag = '<link rel="stylesheet" href="{{ asset(\'css/' . $cssFileName . '\') }}">';
        
        $firstMatch = true;
        $content = preg_replace_callback('/<style(?:[^>]*)>([\s\S]*?)<\/style>/i', function($m) use (&$firstMatch, $linkTag) {
            if ($firstMatch) {
                $firstMatch = false;
                return $linkTag;
            }
            return '';
        }, $content);
        
        file_put_contents($fullPath, $content);
        echo "Processed: $file -> $cssFileName\n";
    }
}
