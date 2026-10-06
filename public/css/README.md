# CSS Architecture Documentation

## 📁 Struktur Folder

```
public/css/
├── main.css              # File utama yang meng-import semua CSS
├── base/                 # Global rules & foundations
│   ├── _variables.css    # Color palette, spacing, fonts
│   ├── _reset.css        # CSS reset & normalization
│   └── _typography.css   # Font styles & text utilities
├── components/           # Reusable components
│   ├── _buttons.css      # Button styles & variants
│   ├── _forms.css        # Form controls & inputs
│   ├── _user-panel.css   # User panel (sidebar)
│   └── _menu.css         # Navigation menu
├── layout/               # Layout structure
│   ├── _header.css       # Main header & navbar
│   ├── _sidebar.css      # Sidebar layout
│   └── _footer.css       # Footer layout
└── pages/                # Page-specific styles
    └── (halaman khusus)
```

## 🎨 Color Palette (Navy Blue Theme)

### Primary Colors
- `--navy-dark`: #2c3e50
- `--navy-medium`: #34495e
- `--navy-light`: #4a5f7f

### Accent Colors
- `--accent-blue`: #3498db

### Status Colors
- `--success`: #2ecc71 (hijau)
- `--danger`: #e74c3c (merah)
- `--warning`: #f39c12 (kuning)
- `--info`: #3498db (biru)

## 📝 Cara Penggunaan

### 1. Import CSS di Blade Template

File `main.css` sudah di-import di `master.blade.php`:

```html
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
```

### 2. Menggunakan CSS Variables

```css
/* Contoh penggunaan variable */
.my-element {
    background: var(--navy-dark);
    color: var(--white);
    padding: var(--space-lg);
    border-radius: var(--radius-md);
    transition: var(--transition-normal);
}
```

### 3. Utility Classes

```html
<!-- Spacing -->
<div class="m-3 p-4">Content</div>

<!-- Display & Flex -->
<div class="d-flex align-items-center justify-content-between">
    <span>Left</span>
    <span>Right</span>
</div>

<!-- Colors -->
<p class="text-primary">Blue text</p>
<div class="bg-success">Green background</div>

<!-- Shadows & Radius -->
<div class="shadow rounded">Card</div>
```

## 🔧 Menambah Style Baru

### Untuk Component Baru

Buat file baru di `components/`:
```
public/css/components/_nama-component.css
```

Lalu import di `main.css`:
```css
@import url('components/_nama-component.css');
```

### Untuk Page-Specific Style

Buat file di `pages/`:
```
public/css/pages/_nama-halaman.css
```

Lalu import di `main.css`:
```css
@import url('pages/_nama-halaman.css');
```

## 🎯 Best Practices

### 1. Gunakan CSS Variables
✅ DO:
```css
.button {
    background: var(--accent-blue);
    padding: var(--space-md);
}
```

❌ DON'T:
```css
.button {
    background: #3498db;
    padding: 15px;
}
```

### 2. Naming Convention (BEM-like)
```css
/* Block */
.menu-item { }

/* Element */
.menu-item__link { }
.menu-item__icon { }

/* Modifier */
.menu-item--active { }
.menu-item--highlight { }
```

### 3. Mobile-First Approach
```css
/* Default (mobile) */
.element {
    width: 100%;
}

/* Tablet and up */
@media (min-width: 768px) {
    .element {
        width: 50%;
    }
}

/* Desktop and up */
@media (min-width: 992px) {
    .element {
        width: 25%;
    }
}
```

### 4. Jangan Inline Style!
❌ DON'T:
```html
<div style="background: red; padding: 20px;">
```

✅ DO:
```html
<div class="bg-danger p-4">
```

## 📦 File Size Optimization

### Saat Production
1. Minify semua CSS files
2. Combine imports jika perlu
3. Remove unused CSS (gunakan PurgeCSS)

```bash
# Install PurgeCSS (optional)
npm install -D @fullhuman/postcss-purgecss
```

## 🐛 Troubleshooting

### CSS tidak muncul?
1. Clear cache browser (Ctrl+F5)
2. Check console untuk error
3. Pastikan path import benar
4. Run `php artisan cache:clear`

### Warna tidak sesuai?
1. Check `_variables.css` untuk nilai color
2. Pastikan menggunakan CSS variable (var())
3. Check browser support untuk CSS variables

### Layout broken?
1. Check responsive classes (hidden-xs, hidden-sm)
2. Inspect element di browser DevTools
3. Check z-index conflicts

## 📚 References

- AdminLTE: https://adminlte.io/
- Bootstrap 3: https://getbootstrap.com/docs/3.4/
- CSS Variables: https://developer.mozilla.org/en-US/docs/Web/CSS/Using_CSS_custom_properties
- BEM Naming: http://getbem.com/naming/

---

**Version:** 1.0  
**Last Updated:** 2025  
**Maintainer:** Development Team
