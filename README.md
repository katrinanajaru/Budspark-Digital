# BudSpark Digital Website

## Overview

This project is the official marketing website for **BudSpark Digital**. It presents the company brand, services, portfolio, leadership team, testimonials, FAQ, and a consultation booking form for new client enquiries.

The site is built as a lightweight static frontend with a PHP-powered email handler for consultation form submissions.

## Main Sections

- Hero section with BudSpark Digital positioning and calls to action
- About section focused on business outcomes and delivery approach
- Services section covering web development, email marketing, graphic design, and software development
- Project portfolio with featured case studies
- Graphics gallery for design work
- Client testimonials
- Team section for company leadership
- FAQ section
- Consultation booking form

## Tech Stack

- HTML5
- CSS3
- JavaScript
- Bootstrap
- jQuery
- PHP
- PHPMailer

## Project Structure

- `index.html` - main website page
- `css/` - custom styles
- `js/` - frontend interactions
- `images/` - logos, team photos, and project/gallery assets
- `mailing/mailfunction.php` - consultation form email handler
- `mailing/mailingvariables.php` - SMTP configuration
- `vendor/` - Composer dependencies

## Local Setup

1. Place the project inside your XAMPP `htdocs` directory.
2. Start `Apache` from XAMPP.
3. Install PHP dependencies if needed:

```bash
composer install
```

4. Configure SMTP credentials in `mailing/mailingvariables.php`.
5. Open the site in your browser:

```text
http://localhost/BudSpark%20Digital%20website/
```

## Consultation Form

The consultation form posts to `mailing/mailfunction.php` and sends booking details by email using PHPMailer and SMTP.

Before using the form, make sure:

- Composer dependencies are installed
- SMTP host, port, sender email, sender name, and password are set correctly
- Your mail server allows SMTP access from your local environment

## Notes

- This project currently uses a single-page layout.
- Email functionality will not work unless SMTP is configured correctly.
- `composer.json` still contains the original package metadata and can be renamed later if you want it aligned with the BudSpark brand as well.
