# BitLabs ENV Configuration

## Where to Add BitLabs Variables

### Option 1: Via SSH (Recommended for Production)

1. **Connect to your server via SSH:**
   ```bash
   ssh u876970906@test.cashvers.com
   ```

2. **Navigate to the project directory:**
   ```bash
   cd /home/u876970906/domains/test.cashvers.com/public_html/coree
   ```

3. **Edit the .env file:**
   ```bash
   nano .env
   ```

4. **Add these lines at the bottom:**
   ```env
   # BitLabs API Configuration
   BITLABS_API_TOKEN=your_bitlabs_api_token_here
   BITLABS_APP_TOKEN=your_bitlabs_app_token_here
   BITLABS_SECRET_KEY=your_bitlabs_secret_key_here
   ```

5. **Save and exit:**
   - Press `CTRL + X`
   - Press `Y` to confirm
   - Press `ENTER` to save

6. **Clear the cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

---

### Option 2: Via cPanel File Manager

1. **Login to cPanel** at `https://test.cashvers.com:2083`

2. **Go to File Manager**

3. **Navigate to:**
   ```
   /domains/test.cashvers.com/public_html/coree/
   ```

4. **Right-click on `.env` file → Edit**

5. **Add at the bottom:**
   ```env
   # BitLabs API Configuration
   BITLABS_API_TOKEN=your_bitlabs_api_token_here
   BITLABS_APP_TOKEN=your_bitlabs_app_token_here
   BITLABS_SECRET_KEY=your_bitlabs_secret_key_here
   ```

6. **Save the file**

7. **Run via SSH or create a cache-clear.php file:**
   ```php
   <?php
   exec('cd /home/u876970906/domains/test.cashvers.com/public_html/coree && php artisan config:clear');
   exec('cd /home/u876970906/domains/test.cashvers.com/public_html/coree && php artisan cache:clear');
   echo "Cache cleared!";
   ?>
   ```
   Then visit: `https://test.cashvers.com/cache-clear.php`

---

## How to Get BitLabs API Keys

1. **Sign up at:** https://dashboard.bitlabs.ai/

2. **Create a new app/project**

3. **Copy your credentials:**
   - **API Token** - Used for server-side API calls
   - **App Token** - Used for client-side SDK
   - **Secret Key** - Used for webhook verification

4. **Set up webhook URL** (for automatic reward crediting):
   ```
   https://test.cashvers.com/api/bitlabs/callback
   ```

---

## Testing BitLabs Integration

1. **After adding ENV variables, test the connection:**
   ```bash
   cd /home/u876970906/domains/test.cashvers.com/public_html/coree
   php artisan tinker
   ```

2. **In tinker, run:**
   ```php
   $service = new \App\Services\BitLabsService();
   $surveys = $service->getSurveys('test_user_123');
   dd($surveys);
   ```

3. **You should see available surveys or an empty array (not an error)**

---

## BitLabs Routes Already Setup

Your BitLabs routes are already configured at:
- **Frontend:** `/bitlabs` - Shows available surveys
- **Callback:** `/api/bitlabs/callback` - Receives reward notifications

---

## Current Usage in Code

The BitLabs service is located at:
- **Service:** `coree/app/Services/BitLabsService.php`
- **Controller:** `coree/app/Http/Controllers/Dashboard/BitLabsController.php`
- **Routes:** `coree/routes/web.php`

It uses: `env('BITLABS_API_TOKEN')` to authenticate API requests.

---

## Important Notes

- ⚠️ **Never commit .env file to GitHub**
- ⚠️ **Keep API keys secret**
- ⚠️ **Always clear cache after changing ENV variables**
- ✅ **Test in development before production**

---

## Support

If you need help getting BitLabs keys:
- Email: support@bitlabs.ai
- Docs: https://docs.bitlabs.ai/

