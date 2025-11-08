# Monlix ENV Configuration

## Where to Add Monlix Variables

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
   # Monlix API Configuration
   MONLIX_API_KEY=your_monlix_api_key_here
   MONLIX_PUBLISHER_ID=your_publisher_id_here
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
   # Monlix API Configuration
   MONLIX_API_KEY=your_monlix_api_key_here
   MONLIX_PUBLISHER_ID=your_publisher_id_here
   ```

6. **Save the file**

7. **Clear cache** (via SSH or cache-clear.php)

---

## How to Get Monlix API Keys

1. **Sign up at:** https://monlix.com/publishers/signup

2. **Login to Publisher Dashboard**

3. **Go to Settings → API**

4. **Copy your credentials:**
   - **API Key** - Used for server-side API calls
   - **Publisher ID** - Your unique publisher identifier

5. **Set up Postback URL** (for automatic reward crediting):
   ```
   https://test.cashvers.com/api/monlix/callback
   ```

---

## Testing Monlix Integration

1. **After adding ENV variables, test the connection:**
   ```bash
   cd /home/u876970906/domains/test.cashvers.com/public_html/coree
   php artisan tinker
   ```

2. **In tinker, run:**
   ```php
   $service = new \App\Services\MonlixService();
   $offers = $service->getOffers('test_user_123');
   dd($offers);
   ```

3. **You should see available offers or an empty array (not an error)**

---

## Monlix Routes Already Setup

Your Monlix routes are already configured at:
- **Frontend:** `/monlix` - Shows available offers
- **Click Handler:** `/monlix/click` - Tracks offer clicks
- **Callback:** `/api/monlix/callback` - Receives conversion notifications

---

## Current Usage in Code

The Monlix service is located at:
- **Service:** `coree/app/Services/MonlixService.php`
- **Controller:** `coree/app/Http/Controllers/Dashboard/MonlixController.php`
- **Routes:** `coree/routes/web.php`

It uses these ENV variables:
- `env('MONLIX_API_KEY')` - Your API key
- `env('MONLIX_PUBLISHER_ID')` - Your publisher ID

---

## Complete .env Configuration

After setup, your .env file should have both BitLabs and Monlix:

```env
# BitLabs API Configuration
BITLABS_API_TOKEN=your_bitlabs_api_token_here
BITLABS_APP_TOKEN=your_bitlabs_app_token_here
BITLABS_SECRET_KEY=your_bitlabs_secret_key_here

# Monlix API Configuration
MONLIX_API_KEY=your_monlix_api_key_here
MONLIX_PUBLISHER_ID=your_publisher_id_here
```

---

## Important Notes

- ⚠️ **Never commit .env file to GitHub**
- ⚠️ **Keep API keys secret**
- ⚠️ **Always clear cache after changing ENV variables**
- ✅ **Test in development before production**

---

## Postback/Callback Setup

### For BitLabs:
```
https://test.cashvers.com/api/bitlabs/callback
```

### For Monlix:
```
https://test.cashvers.com/api/monlix/callback
```

These URLs tell the offerwall providers where to send conversion notifications when users complete offers.

---

## Testing After Setup

1. **Visit `/monlix` on your site**
2. **Should see available offers** (if your account is approved)
3. **Click an offer** - Should track the click
4. **Complete the offer** - Should receive callback and credit user

---

## Support

If you need help getting Monlix credentials:
- Email: support@monlix.com
- Docs: https://docs.monlix.com/
- Dashboard: https://monlix.com/publishers/

---

## Quick Reference

| Variable | Description | Example |
|----------|-------------|---------|
| MONLIX_API_KEY | Your API authentication key | abc123def456... |
| MONLIX_PUBLISHER_ID | Your publisher identifier | 12345 |

Both can be found in your Monlix Publisher Dashboard under Settings → API.

