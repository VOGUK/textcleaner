# Text Cleaner (Markup & Markdown Remover)

A simple, fast, and lightweight single-file PHP web application designed to clean up messy text. It takes text containing HTML, XML, or Markdown formatting and strips it down to pure plain text.

This app requires no databases, no external frameworks, and zero complex setup.

## Features

* **HTML & XML Stripping:** Removes all standard web tags (e.g., `<h1>`, `<div>`, `<script>`).
* **Markdown Removal:** Erases common Markdown symbols like `#`, `##`, `###`, `*`, and `**`.
* **Smart Space Cleanup:** Automatically removes the awkward orphan spaces and tabs left behind when Markdown formatting characters are deleted, snapping your text perfectly to the left margin.
* **XSS Protection:** Output is escaped using `htmlspecialchars()` to prevent Cross-Site Scripting vulnerabilities.
* **Single-File Deployment:** Everything (PHP backend, HTML structure, and CSS styling) is contained within a single `index.php` file.

## Requirements

* Any web server (Apache, Nginx, LiteSpeed, etc.)
* PHP 7.0 or higher (works perfectly with PHP 8+)

## Installation & Usage

1. Clone this repository or download the `index.php` file.
2. Upload `index.php` to your web server's public directory (e.g., `public_html`, `htdocs`, or `www`).
3. Open the file in your web browser (e.g., `https://yourdomain.com/index.php`).
4. Paste your formatted text into the top box, click **Erase Markup**, and copy your clean text from the bottom box.

## How it Works

The application processes text in three main steps:
1. `strip_tags()` handles the removal of HTML/PHP/XML.
2. `str_replace()` surgically removes specific Markdown characters.
3. `preg_replace()` utilizes Regular Expressions to hunt down and clean up leftover leading spaces and double spaces.

## License

This project is open-source and available under the [MIT License](LICENSE).
