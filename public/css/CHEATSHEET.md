# 🎨 CSS Quick Reference Cheatsheet

## 📋 CSS Variables

### Colors
```css
var(--navy-dark)        /* #2c3e50 */
var(--navy-medium)      /* #34495e */
var(--accent-blue)      /* #3498db */
var(--success)          /* #2ecc71 */
var(--danger)           /* #e74c3c */
var(--warning)          /* #f39c12 */
var(--white)            /* #ffffff */
var(--gray-light)       /* #bdc3c7 */
```

### Spacing
```css
var(--space-xs)         /* 5px */
var(--space-sm)         /* 10px */
var(--space-md)         /* 15px */
var(--space-lg)         /* 20px */
var(--space-xl)         /* 30px */
```

### Border Radius
```css
var(--radius-sm)        /* 3px */
var(--radius-md)        /* 5px */
var(--radius-lg)        /* 10px */
var(--radius-circle)    /* 50% */
```

### Transitions
```css
var(--transition-fast)    /* 0.2s ease */
var(--transition-normal)  /* 0.3s ease */
var(--transition-slow)    /* 0.5s ease */
```

---

## 🎯 Utility Classes

### Display
```html
<div class="d-none">Hidden</div>
<div class="d-block">Block</div>
<div class="d-flex">Flex</div>
```

### Flexbox
```html
<div class="d-flex align-items-center justify-content-between">
    <span>Left</span>
    <span>Right</span>
</div>
```

### Spacing (Margin)
```html
<div class="m-0">No margin</div>
<div class="mt-3">Top margin medium</div>
<div class="mb-4">Bottom margin large</div>
<div class="mx-auto">Center horizontally</div>
```

### Spacing (Padding)
```html
<div class="p-3">Padding all sides</div>
<div class="px-4">Padding left-right</div>
<div class="py-2">Padding top-bottom</div>
```

### Text Colors
```html
<p class="text-primary">Blue text</p>
<p class="text-success">Green text</p>
<p class="text-danger">Red text</p>
<p class="text-muted">Gray text</p>
```

### Background Colors
```html
<div class="bg-primary">Blue background</div>
<div class="bg-success">Green background</div>
<div class="bg-danger">Red background</div>
<div class="bg-white">White background</div>
```

### Borders & Shadows
```html
<div class="rounded">Medium radius</div>
<div class="rounded-circle">Circle</div>
<div class="shadow">Medium shadow</div>
<div class="shadow-lg">Large shadow</div>
```

---

## 🔘 Button Examples

### Basic Buttons
```html
<button class="btn btn-primary">Primary</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-danger">Danger</button>
<button class="btn btn-outline">Outline</button>
```

### Button Sizes
```html
<button class="btn btn-primary btn-sm">Small</button>
<button class="btn btn-primary">Normal</button>
<button class="btn btn-primary btn-lg">Large</button>
<button class="btn btn-primary btn-block">Full Width</button>
```

---

## 📝 Form Examples

### Basic Form
```html
<div class="form-group">
    <label class="form-label">Name</label>
    <input type="text" class="form-control" placeholder="Enter name">
</div>
```

### Form Sizes
```html
<input class="form-control form-control-sm" placeholder="Small">
<input class="form-control" placeholder="Normal">
<input class="form-control form-control-lg" placeholder="Large">
```

### Validation States
```html
<input class="form-control is-valid">
<div class="valid-feedback">Looks good!</div>

<input class="form-control is-invalid">
<div class="invalid-feedback">Please enter a valid value.</div>
```

### Input Groups
```html
<div class="input-group">
    <span class="input-group-addon">@</span>
    <input type="text" class="form-control" placeholder="Username">
</div>
```

---

## 📦 Layout Examples

### Grid Layout
```html
<div class="stats-cards">
    <div class="stat-card primary">Card 1</div>
    <div class="stat-card success">Card 2</div>
    <div class="stat-card warning">Card 3</div>
</div>
```

### Flexbox Layout
```html
<div class="d-flex align-items-center gap-3">
    <div>Item 1</div>
    <div class="flex-1">Item 2 (grows)</div>
    <div>Item 3</div>
</div>
```

---

## 🎨 Custom Components

### Stat Card
```html
<div class="stat-card primary">
    <div class="stat-card-header">
        <div class="stat-card-icon">
            <i class="fa fa-users"></i>
        </div>
    </div>
    <p class="stat-card-title">Total Users</p>
    <h3 class="stat-card-value">1,234</h3>
    <div class="stat-card-trend up">
        <i class="fa fa-arrow-up"></i>
        <span>12% increase</span>
    </div>
</div>
```

### Quick Action Button
```html
<div class="quick-actions">
    <a href="#" class="quick-action-btn">
        <div class="quick-action-icon">
            <i class="fa fa-plus"></i>
        </div>
        <p class="quick-action-title">Add New</p>
    </a>
</div>
```

---

## 📱 Responsive Classes

### Hide on Mobile
```html
<div class="hidden-xs">Hidden on mobile</div>
```

### Hide on Tablet
```html
<div class="hidden-sm">Hidden on tablet</div>
```

### Hide on Desktop
```html
<div class="hidden-md">Hidden on desktop</div>
```

---

## ⚡ Animation Classes

```html
<div class="fade-in">Fade in animation</div>
<div class="slide-in-down">Slide down animation</div>
<div class="slide-in-up">Slide up animation</div>
```

---

## 💡 Tips & Tricks

### 1. Combine Utilities
```html
<div class="d-flex align-items-center gap-3 p-4 rounded shadow">
    Combined utilities
</div>
```

### 2. Use CSS Variables
```css
.custom-element {
    background: var(--navy-dark);
    padding: var(--space-lg);
    border-radius: var(--radius-md);
    transition: var(--transition-normal);
}
```

### 3. Responsive Design
```css
/* Mobile First */
.element { width: 100%; }

@media (min-width: 768px) {
    .element { width: 50%; }
}
```

---

**Quick Navigation:**
- Variables: `base/_variables.css`
- Components: `components/`
- Layout: `layout/`
- Pages: `pages/`

**Full Documentation:** See `README.md`
