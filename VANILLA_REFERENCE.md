# Quick Reference: Vanilla Laravel Setup

## What Was Removed
- **Tailwind CSS** - No more utility-first classes
- **Alpine.js** - No more `x-data`, `@click`, `x-show` directives
- **GSAP & ScrollTrigger** - No animations libraries
- **PostCSS/Autoprefixer** - Not needed without Tailwind

## What Remains
- **Laravel Blade** - Your templating engine
- **Vite** - Asset bundler
- **Axios** - HTTP client for API calls
- **Standard CSS** - Full control over styling
- **Vanilla JavaScript** - Pure ES6 code

## How to Add Interactivity Now

### Before (Alpine.js):
```html
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open">Content</div>
</div>
```

### After (Vanilla JS):
```html
<div id="menu">
    <button id="toggle">Toggle</button>
    <div id="content" style="display: none;">Content</div>
</div>

<script>
    const toggle = document.getElementById('toggle');
    const content = document.getElementById('content');
    toggle.addEventListener('click', () => {
        content.style.display = content.style.display === 'none' ? 'block' : 'none';
    });
</script>
```

## How to Style Now

### Before (Tailwind):
```html
<div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg">
    <h1 class="text-2xl font-bold text-gray-900">Title</h1>
</div>
```

### After (CSS):
```html
<div class="card">
    <h1>Title</h1>
</div>

<style>
    .card {
        background-color: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    h1 {
        font-size: 1.875rem;
        font-weight: 700;
    }
</style>
```

## Available CSS Classes

Check `resources/css/app.css` for:
- `.btn` - Button styles
- `.card` - Card container
- `.input` - Form inputs
- `.form-group` - Form wrapper
- `.grid` - Grid layout
- `.alert` - Alert messages
- `.badge` - Badge labels
- `.navbar` - Navigation bar

## Adding New Features

### 1. Simple Toggle
```html
<button id="myButton">Click me</button>
<div id="myContent" style="display: none;">Hidden</div>

<script>
    document.getElementById('myButton').addEventListener('click', function() {
        const el = document.getElementById('myContent');
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    });
</script>
```

### 2. Form Submission
```html
<form id="myForm">
    <input type="text" name="email" required>
    <button type="submit">Submit</button>
</form>

<script>
    document.getElementById('myForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(this);
        const response = await axios.post('/api/endpoint', Object.fromEntries(formData));
        console.log(response.data);
    });
</script>
```

### 3. Styling with CSS Variables
```html
<div class="custom-box">Content</div>

<style>
    :root {
        --custom-color: #6366f1;
        --custom-padding: 1.5rem;
    }
    .custom-box {
        background-color: var(--custom-color);
        padding: var(--custom-padding);
        color: white;
    }
</style>
```

## File Structure

```
resources/
├── css/
│   ├── app.css          ← Main styles (with CSS variables)
│   └── premium.css      ← Optional additional styles
├── js/
│   ├── app.js           ← Main entry point
│   ├── bootstrap.js     ← Axios setup
│   └── animations/      ← (Currently empty - for future use)
└── views/
    ├── layouts/
    │   ├── app.blade.php
    │   └── navigation.blade.php
    ├── components/
    │   ├── dropdown.blade.php
    │   └── modal.blade.php
    └── welcome.blade.php
```

## Development Commands

```bash
# Development server with hot reload
npm run dev

# Production build
npm run build

# Run Laravel app (if needed)
php artisan serve

# Run migrations
php artisan migrate

# Create new migration
php artisan make:migration create_table_name
```

## Tips & Best Practices

### 1. Use CSS Variables
Define colors, sizes, and values in `:root` for consistency:
```css
:root {
    --primary: #6366f1;
    --spacing: 1rem;
    --border-radius: 0.5rem;
}
```

### 2. Keep JavaScript Simple
Use vanilla JS for small interactions; consider a framework only if needed for complex SPAs.

### 3. Mobile First
Write CSS for mobile first, then add larger screen styles:
```css
/* Mobile */
.menu { display: flex; flex-direction: column; }

/* Desktop */
@media (min-width: 768px) {
    .menu { flex-direction: row; }
}
```

### 4. Semantic HTML
Use proper HTML tags for accessibility:
```html
<nav>Navigation</nav>
<main>Content</main>
<aside>Sidebar</aside>
<footer>Footer</footer>
```

### 5. Accessibility
- Use `aria-*` attributes
- Ensure keyboard navigation
- Respect `prefers-reduced-motion`
- Test with screen readers

## Dark Mode Support

The CSS already includes dark mode support:
```css
@media (prefers-color-scheme: dark) {
    :root {
        --bg-primary: #0f172a;
        --text-primary: #f1f5f9;
    }
}
```

Users' system preferences are automatically respected.

## Common Patterns

### Modal Dialog
See `resources/views/components/modal.blade.php` for vanilla implementation.

### Dropdown Menu
See `resources/views/components/dropdown.blade.php` for vanilla implementation.

### Navigation Toggle
See `resources/views/layouts/navigation.blade.php` for mobile menu implementation.

---

**Next Steps**: Start building features with vanilla JavaScript and standard CSS!
