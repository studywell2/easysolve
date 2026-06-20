# EASYSOLVE — Complete Deployment Guide for cPanel Shared Hosting

This is your first time hosting Laravel, so this guide walks you through **every single step**.

---

## Overview: How It Works

```
Your cPanel server
├── home/
│   └── yourusername/
│       ├── easysolve/              ← Your entire Laravel app lives here (NOT web-accessible)
│       │   ├── app/
│       │   ├── bootstrap/
│       │   ├── config/
│       │   ├── database/
│       │   ├── resources/
│       │   ├── routes/
│       │   ├── storage/            ← File uploads go here
│       │   ├── vendor/
│       │   ├── .env                 ← Your secrets (DB passwords, etc.)
│       │   ├── artisan
│       │   ├── composer.json
│       │   └── ...
│       │
│       └── public_html/            ← Web root (only public files here)
│           ├── index.php           ← The production index.php
│           ├── .htaccess           ← Apache rewrite rules
│           ├── build/              ← Compiled CSS/JS
│           └── storage → symlink   ← Points to ../easysolve/storage/app/public/
```

**Why this structure?**
- Your `.env` file (with database passwords) is **not accessible** via the web ✅
- Your `storage/` folder (uploaded files) is **not directly accessible** ✅
- Only `index.php`, CSS, and JS are served to browsers ✅

---

## PHASE 1: Buy Hosting + Domain (₦ Naira)

### Recommended Providers
| Provider | Price | SSH | Link |
|---|---|---|---|
| **Whogohost** | ₦2,500/mo | ✅ | whogohost.com |
| **TrueHost NG** | ₦2,000/mo | ✅ | truehost.africa/ng |
| **QServers** | ₦3,500/mo | ✅ | qservers.net |

### What to buy:
1. A **Linux Shared Hosting** plan (any basic plan works)
2. A **domain name** (`.com.ng` is cheaper — ~₦1,500/yr)
3. Confirm the plan includes **PHP 8.2+** and **SSH Access**

### After purchase, you'll receive:
- cPanel login URL (usually `yourdomain.com/cpanel` or `yourdomain.com:2083`)
- cPanel username & password
- SSH access details (same credentials or an SSH key from cPanel)
- Nameserver info (point your domain to these if domain is from another registrar)

---

## PHASE 2: Set PHP Version in cPanel

1. Log into **cPanel**
2. Find **"Select PHP Version"** (or "MultiPHP Manager")
3. Set PHP version to **8.2** or higher (8.3 recommended)
4. Make sure these extensions are enabled:
   - ✅ mysqli
   - ✅ pdo_mysql
   - ✅ mbstring
   - ✅ openssl
   - ✅ tokenizer
   - ✅ xml
   - ✅ ctype
   - ✅ json
   - ✅ bcmath
   - ✅ curl
   - ✅ gd
   - ✅ fileinfo

---

## PHASE 3: Create MySQL Database in cPanel

1. Go to **cPanel → MySQL® Databases**

2. **Create Database:**
   - New Database name: `easysolve`
   - Full name becomes: `yourusername_easysolve`
   - Click **Create Database**

3. **Create User:**
   - Scroll to "Add New User"
   - Username: `easysolve` → becomes `yourusername_easysolve`
   - Password: Generate a strong one and **SAVE IT**
   - Click **Create User**

4. **Add User to Database:**
   - Select the user + database
   - Click **Add**
   - Check **ALL PRIVILEGES** → **Make Changes**

5. **Write down these 3 values:**
   ```
   DB_DATABASE = yourusername_easysolve
   DB_USERNAME = yourusername_easysolve
   DB_PASSWORD = (your password)
   ```

---

## PHASE 4: Prepare & Upload Files

### Step 1: Build assets locally (already done ✅)
The `public/build/` folder was already created.

### Step 2: Create a zip file
On your computer, zip these folders/files (**include `vendor/`**, **exclude `node_modules/`**):

```
app/
bootstrap/
config/
database/
public/          ← includes build/ folder
resources/
routes/
storage/         ← (just the folder structure, can be empty)
vendor/          ← INCLUDE THIS
.env.production  ← the template we created
artisan
composer.json
composer.lock
deploy.sh        ← the script we created
package.json
```

**Exclude:**
```
node_modules/
.env             ← don't upload your local .env
.git/
tests/
```

### Step 3: Upload via cPanel File Manager

1. Go to **cPanel → File Manager**
2. Navigate to the **root of your home directory** (`/home/yourusername/`)
   - This is the PARENT of `public_html`, NOT inside it
3. Click **+ Folder** → create a folder named `easysolve`
4. Open the `easysolve` folder
5. Click **Upload** → select your zip file
6. Wait for upload to complete
7. Right-click the zip → **Extract** → extract into the current `easysolve` folder
8. Delete the zip file after extraction

### Step 4: Move public files to public_html

**Via File Manager:**
1. Open `easysolve/public/`
2. Select ALL files inside it (including `.htaccess` and `build/`)
3. Click **Move**
4. Move them to `public_html/`
   - If `public_html/` already has a `default.html` or `index.html`, delete it first

**Via SSH (faster):**
```bash
cd ~/easysolve/public
cp -a * ~/public_html/
cp -a .htaccess ~/public_html/
```

### Step 5: Copy the production index.php
Replace the `index.php` in `public_html/` with the production version:

**Via File Manager:**
1. Open `public_html/`
2. Find `index.php` → right-click → **Edit**
3. Replace ALL its content with the content from `public/index.production.php`
   - (This file is in your local project at `public/index.production.php`)

**Via SSH:**
```bash
cp ~/easysolve/public/index.production.php ~/public_html/index.php
```

### Step 6: Create the storage symlink
This makes uploaded files (proof of payments, school logos) accessible via the web.

**Via SSH:**
```bash
ln -s ~/easysolve/storage/app/public ~/public_html/storage
```

**Via File Manager (if no SSH):**
1. Create a `.php` file in `public_html/` called `symlink.php`
2. Add this code:
   ```php
   <?php
   $target = dirname(__DIR__) . '/easysolve/storage/app/public';
   $link = __DIR__ . '/storage';
   if (!file_exists($link)) {
       symlink($target, $link);
       echo "Symlink created successfully!";
   } else {
       echo "Symlink already exists.";
   }
   ```
3. Visit `https://yourdomain.com.ng/symlink.php` in your browser
4. Delete `symlink.php` after it works

---

## PHASE 5: Configure .env via SSH

Connect to your server via SSH:
```bash
ssh yourusername@yourdomain.com.ng
```

### Step 1: Create .env
```bash
cd ~/easysolve
cp .env.production .env
nano .env
```

### Step 2: Edit the values (in nano editor)
Update these lines with your real values:
```
APP_URL=https://yourdomain.com.ng

DB_DATABASE=yourusername_easysolve
DB_USERNAME=yourusername_easysolve
DB_PASSWORD=YOUR_REAL_DB_PASSWORD

SUPER_ADMIN_PASSWORD=Pick_A_Strong_Password_Here

PLATFORM_BANK_NAME="Your Real Bank"
PLATFORM_BANK_ACCOUNT_NAME="Your Real Account Name"
PLATFORM_BANK_ACCOUNT_NUMBER="Your Real Account Number"
```

Save in nano: `Ctrl+O` → `Enter` → `Ctrl+X`

### Step 2: Run the deployment script
```bash
cd ~/easysolve
chmod +x deploy.sh
./deploy.sh
```

This will:
- ✅ Generate app key
- ✅ Run database migrations
- ✅ Seed the database (creates plans + super admin)
- ✅ Create storage directories
- ✅ Set permissions
- ✅ Cache config/routes/views

### Step 3 (if no SSH): Alternative approach
If you can't use SSH, do this via **cPanel → Terminal** (many cPanels have this built-in):
1. Open **cPanel → Terminal**
2. Run the same commands above

Or via **cPanel → Cron Jobs**:
1. Add a one-time cron job: `cd /home/yourusername/easysolve && php artisan migrate --force && php artisan db:seed --force && php artisan key:generate --force && php artisan storage:link && php artisan config:cache`
2. Set it to run in 1 minute
3. Remove the cron job after it runs

---

## PHASE 6: Enable SSL (Free)

1. Go to **cPanel → SSL/TLS Status** (or "AutoSSL")
2. Click **Run AutoSSL**
3. Wait for it to issue certificates
4. Go to **cPanel → Domains**
5. Enable **Force HTTPS Redirect** for your domain

---

## PHASE 7: Test Your Site

1. Visit `https://yourdomain.com.ng`
   - You should see the EASYSOLVE welcome page

2. Visit `https://yourdomain.com.ng/login`
   - Login with:
     - Email: `admin@easysolve.com`
     - Password: (the `SUPER_ADMIN_PASSWORD` you set in `.env`)
   - This takes you to the admin panel

3. Test the bank transfer flow:
   - Register a new school at `/register`
   - Go to billing → submit a payment request
   - Log in as admin → go to Payment Requests → verify it

---

## Common Issues & Fixes

### "500 Internal Server Error"
```bash
# Check the error log
cat ~/easysolve/storage/logs/laravel.log | tail -50

# Most common fixes:
cd ~/easysolve
php artisan key:generate --force
php artisan config:clear
chmod -R 775 storage bootstrap/cache
```

### "Blank page / no CSS"
- Make sure you moved the `build/` folder to `public_html/`
- Check: `ls ~/public_html/build/` should show `manifest.json` and `assets/`

### "Database connection refused"
- Check `.env` DB credentials match cPanel exactly
- Database name and username include the cPanel prefix (e.g., `user_easysolve`)
- Try `127.0.0.1` instead of `localhost` for DB_HOST

### "Permission denied" on storage
```bash
chmod -R 775 ~/easysolve/storage
chmod -R 775 ~/easysolve/bootstrap/cache
```

### "artisan: command not found"
- Use `php artisan` (not just `artisan`)
- Make sure you're in the `~/easysolve` directory: `cd ~/easysolve`

### Can't access uploaded files (proof of payment images)
- The symlink might not have been created. Run:
  ```bash
  ln -s ~/easysolve/storage/app/public ~/public_html/storage
  ```

---

## Post-Deployment Checklist

- [ ] Change super admin password after first login
- [ ] Set your real bank account details in `.env`
- [ ] Test the registration → billing → payment request flow
- [ ] Test the admin → verify payment → activate subscription flow
- [ ] Set up email (test password reset flow)
- [ ] Remove `deploy.sh` from the server: `rm ~/easysolve/deploy.sh`
- [ ] Set up a daily cron job for scheduled tasks:
  ```
  * * * * * cd /home/yourusername/easysolve && php artisan schedule:run >> /dev/null 2>&1
  ```
  (Add via cPanel → Cron Jobs)
