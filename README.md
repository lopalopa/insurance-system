Insurance Management System - Starter Repo
==========================================

Drop the `insurance-system` folder into your `htdocs` (XAMPP) or web root.
Point your browser to: http://localhost/insurance-system/public/login.php

Setup:
1. Create the database and tables:
   - Import `sql/create_db.sql` into MySQL (phpMyAdmin or CLI).
2. Update DB credentials in `includes/db.php`.
3. (Optional) Run `create_admin.php` once to create an admin user, or insert a user manually:
   - Default admin credentials created by the script: admin@example.com / Admin@123
4. Make sure `uploads/` is writable by the web server (for attachments).

What is included:
- Basic auth (login / logout)
- Customer CRUD (list/add/edit/delete)
- Policy CRUD (list/add)
- Claim list page (starter)
- PDO with prepared statements, password_hash usage
- Bootstrap 5 CDN for quick UI

Security reminder:
- Change DB credentials, use HTTPS in production.
- Do not expose `create_admin.php` on a public server.
- Improve input validation and add CSRF tokens for production.
