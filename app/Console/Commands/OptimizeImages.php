<?php

namespace App\Console\Commands;

use App\Models\Produk;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class OptimizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert all existing product images to WebP and update database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting image optimization...');

        $path = public_path('images/produk');
        $backupPath = $path . '/originals';

        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $manager = new ImageManager(new Driver());
        $produks = Produk::all();
        $count = 0;

        foreach ($produks as $produk) {
            $filename = $produk->gambar;

            if (!$filename || str_ends_with($filename, '.webp')) {
                continue;
            }

            $fullPath = $path . '/' . $filename;

            if (!File::exists($fullPath)) {
                $this->warn("File not found: {$filename}");
                continue;
            }

            try {
                $newFilename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                $newPath = $path . '/' . $newFilename;

                // Konversi
                $image = $manager->decode(File::get($fullPath));
                $image->scaleDown(width: 1000);
                $encoded = $image->encodeUsingFormat(Format::WEBP, quality: 80);
                $encoded->save($newPath);

                // Update Database
                $produk->gambar = $newFilename;
                $produk->save();

                // Move Original to backup
                File::move($fullPath, $backupPath . '/' . $filename);

                $this->line("Converted: {$filename} -> {$newFilename}");
                $count++;
            } catch (\Exception $e) {
                $this->error("Failed to convert {$filename}: " . $e->getMessage());
            }
        }

        $this->info("Optimization complete! {$count} images processed.");
    }
}
