# EASYSOLVE — Cloud Deployment Guide (Render Free Tier)

Deploy EASYSOLVE to the cloud in **under 10 minutes** — no credit card required.

---

## What You'll Get

```
https://easysolve.onrender.com   ← Your live app (URL will differ)
├── PostgreSQL database (free, 90 days)
├── Auto-migrations on every deploy
├── Seeded with plans + super admin
└── SSL (HTTPS) included
```

---

## Step 1: Push Your Code to GitHub

```bash
cd C:\Users\hp\Documents\EASYSOLVE

# Initialize git if you haven't already
git init
git add -A
git commit -m "Cloud deployment setup"

# Create a repo on GitHub first (github.com/new), then:
git remote add origin https://github.com/YOUR_USERNAME/easysolve.git
git branch -M main
git push -u origin main
```

**Make sure these files are included in the push:**
- `Dockerfile`
- `render.yaml`
- `.dockerignore`
- All your Laravel app files

**Make sure `.env` is NOT pushed** (it's in `.gitignore` already ✅)

---

## Step 2: Create a Render Account

1. Go to **https://render.com**
2. Click **Get Started** (or **Sign Up**)
3. Sign up with your **GitHub account** (easiest — it connects automatically)

No credit card needed for the free tier.

---

## Step 3: Deploy Using the Blueprint

1. Go to **https://dashboard.render.com**
2. Click **New +** → **Blueprint**
3. Select your **easysolve** repository
4. Render will detect the `render.yaml` file automatically
5. Review the resources:
   - **easysolve-db** — PostgreSQL database (free)
   - **easysolve** — Docker web service (free)
6. Click **Apply**

That's it! Render will now:
1. 🔨 Build your Docker image (installs PHP, Composer, Node.js, builds assets)
2. 🗄️ Create the PostgreSQL database
3. 🚀 Run migrations + seeders automatically
4. 🌐 Give you a live URL like `https://easysolve-xxxx.onrender.com`

**Build time:** ~5-8 minutes (first build is slowest)

---

## Step 4: Update Your APP_URL

After the first deploy completes:

1. In Render dashboard → click your **easysolve** web service
2. Go to **Environment** tab
3. Find `APP_URL` and update it to your actual Render URL:
   ```
   https://easysolve-xxxx.onrender.com
   ```
4. Click **Save Changes** — this triggers a re-deploy

---

## Step 5: Test Your Live Site

1. Visit your Render URL (from the dashboard)
2. You should see the **EASYSOLVE welcome page** ✅

3. Go to `/login`:
   - **Email:** `admin@easysolve.com`
   - **Password:** `Ea$ySolve@2026!Adm`
   - (This is set via `SUPER_ADMIN_PASSWORD` in the render.yaml)

4. Test the full flow:
   - Register a new school at `/register`
   - Go to billing → submit a payment request
   - Log in as admin → verify the payment

---

## Free Tier Limitations (Important!)

| Resource | Free Tier Limit |
|---|---|
| **Web service** | 750 hours/month, sleeps after 15 min idle |
| **Database** | Expires after 90 days |
| **Cold starts** | ~30-50 seconds after sleep (first visit wakes it) |
| **Build minutes** | 500 free build minutes/month |

**For a demo to show people, this is perfect.** The site wakes up on the first visit (might take 30 seconds).

---

## Keeping the Database Alive (Optional)

If you don't want the free database to expire after 90 days:

1. Upgrade the database to **Starter** ($7/month) in Render dashboard
2. Or just re-create it when it expires (you lose data, but for a demo it's fine)

---

## Updating After Changes

Whenever you push to `main` on GitHub, Render **auto-deploys**:

```bash
git add -A
git commit -m "your changes"
git push
```

Render rebuilds and re-runs migrations + seeders automatically.

---

## Changing the Super Admin Password

1. Render dashboard → **easysolve** web service → **Environment**
2. Find `SUPER_ADMIN_PASSWORD`
3. Change the value
4. Click **Save Changes** (triggers re-deploy)
5. Or just change it after logging in at `/admin/settings`

---

## Common Issues

### "Build failed"
- Check the build logs in Render dashboard → click the deploy event
- Most common: missing file in GitHub (make sure `Dockerfile` is pushed)

### "502 Bad Gateway" or "Service Unavailable"
- The free tier service is sleeping. Wait 30-60 seconds and refresh.
- Check logs: Render dashboard → **Logs** tab

### "Database connection error"
- Make sure the PostgreSQL database was created (check Render dashboard)
- The `render.yaml` auto-links the database credentials via `fromDatabase`

### "CSS/JS not loading"
- The Dockerfile builds assets during the Docker build stage
- Check: Render dashboard → **Logs** → look for "npm run build" output

### White screen / 500 error
- Check logs: Render dashboard → **Logs** tab
- Look for Laravel errors in the log stream

---

## Quick Reference

| What | Value |
|---|---|
| **Admin login URL** | `https://YOUR-URL.onrender.com/login` |
| **Admin email** | `admin@easysolve.com` |
| **Admin password** | `Ea$ySolve@2026!Adm` (or what you set in render.yaml) |
| **Register new school** | `https://YOUR-URL.onrender.com/register` |
| **Health check** | `https://YOUR-URL.onrender.com/up` |
