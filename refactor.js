const fs = require('fs');
const path = require('path');

const files = [
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

files.forEach(file => {
    const fullPath = path.join('d:/laragon/www/DefaCraftStore', file);
    if (!fs.existsSync(fullPath)) return;
    
    let content = fs.readFileSync(fullPath, 'utf8');
    
    // Extract CSS name
    let baseName = file.replace('resources/views/', '').replace('.blade.php', '').replace(/\//g, '-');
    let cssFileName = baseName + '.css';
    let cssPath = path.join('d:/laragon/www/DefaCraftStore/public/css', cssFileName);
    
    // Check if there are multiple style tags, replace all of them.
    // Actually, it's safer to extract the first one, or loop through all.
    // Most files will only have one style tag. Let's do a replace with a callback.
    let styles = [];
    
    content = content.replace(/<style(?:\s+[^>]*)?>([\s\S]*?)<\/style>/g, (match, css) => {
        styles.push(css);
        // Only return the link tag for the first match, return empty string for others
        // to avoid duplicate links.
        if (styles.length === 1) {
            return `<link rel="stylesheet" href="{{ asset('css/${cssFileName}') }}">`;
        }
        return '';
    });
    
    if (styles.length > 0) {
        let cssContent = styles.join('\n');
        
        // Minify CSS
        cssContent = cssContent.replace(/\/\*[\s\S]*?\*\//g, '')
                               .replace(/\s+/g, ' ')
                               .replace(/\s*([{}:;,])\s*/g, '$1')
                               .trim();
                               
        fs.writeFileSync(cssPath, cssContent);
        fs.writeFileSync(fullPath, content);
        console.log('Processed', file, '->', cssFileName);
    } else {
        console.log('No <style> found in', file);
    }
});
