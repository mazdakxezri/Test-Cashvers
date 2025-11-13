# 🔧 Monlix API Integration - Updated Implementation

**Date:** November 13, 2025  
**Status:** ✅ Fully Implemented

---

## 📋 Environment Variables Required

Update your `.env` file with:

```env
# Monlix API Configuration
MONLIX_APP_ID=your_app_id_from_dashboard
MONLIX_SECRET_KEY=your_secret_key_from_postback_tab
```

**Where to get these:**
1. Login to Monlix Publisher Dashboard
2. **APP_ID:** Found when you create/approve your app/website
3. **SECRET_KEY:** Found under Postback tab in dashboard

---

## 🔗 API Endpoint Used

```
https://api.monlix.com/api/campaigns?appid={appid}&userid={userid}&userip={ip}&ua={useragent}
```

**Parameters:**
- `appid` - Your Monlix app ID (from ENV)
- `userid` - User's UID from your platform
- `userip` - User's IP address (for server-side calls)
- `ua` - User's User-Agent (for server-side calls)

---

## 📊 Response Format

Monlix returns array of campaigns:

```json
[
  {
    "id": 63256,
    "name": "Parimatch - Android",
    "description": "Open the app, deposit and wager at least $10...",
    "countries": ["GB"],
    "oss": "android",
    "payout": 24.19,
    "image": "https://imps.mnlx.me/...",
    "goals": [...],
    "url": "https://api.monlix.com/api/cmp/redirect/{appid}/{campaignId}/{{userid}}",
    "hasGoals": false,
    "multipleTimes": false,
    "categories": ["Gambling"]
  }
]
```

---

## 🔄 Data Transformation

Our `MonlixService` transforms this to match ogadsOffers format:

```php
[
    'offerid' => $campaign['id'],
    'name_short' => $campaign['name'],
    'description' => $campaign['description'],
    'adcopy' => $campaign['description'],
    'picture' => $campaign['image'],
    'payout' => $displayPayout, // Highest goal or base payout
    'link' => $url, // With userid replaced
    'countries' => $campaign['countries'],
    'oss' => $campaign['oss'],
    'categories' => $campaign['categories'],
    'partner' => 'monlix',
]
```

---

## 💰 Payout Calculation

**For CPE (Cost Per Event) Offers:**
- If offer has `goals` array, we use the **highest** goal payout
- Otherwise, use base `payout` value

**Commission Split:**
- Configurable via `monlix_rate` setting (default: 0.75 = 75% to user)
- Example: $24.19 payout → $18.14 to user (75%), $6.05 platform fee (25%)

---

## 🎯 How It Works Now

### 1. **Display on /earn Page**

```php
// HomeService.php
if ($userUid && env('MONLIX_APP_ID')) {
    $monlixOffers = $this->monlixService->getOffers(
        $userUid,
        $request->ip(),
        $request->header('User-Agent')
    );
    
    // Merge with ogads offers
    $data['ogadsOffers'] = collect($data['ogadsOffers'])
        ->merge($monlixOffers)
        ->all();
}
```

### 2. **User Clicks Offer**
- Redirects to: `https://api.monlix.com/api/cmp/redirect/{appid}/{campaignId}/{userid}`
- Monlix tracks the conversion

### 3. **User Completes Offer**
- Monlix sends postback to: `https://test.cashvers.com/callback/monlix`
- We verify signature with SECRET_KEY
- Credit user balance
- Create track record

---

## 🔒 Postback URL

Set this in your Monlix dashboard:

```
https://test.cashvers.com/callback/monlix?user_id={userid}&campaign_id={campaignid}&payout={payout}&signature={signature}
```

**Required Parameters:**
- `user_id` - User's UID
- `campaign_id` - Monlix campaign ID
- `payout` - Conversion payout amount
- `signature` - SHA256 hash for verification

---

## ✅ Testing Checklist

- [ ] Add MONLIX_APP_ID to .env
- [ ] Add MONLIX_SECRET_KEY to .env
- [ ] Clear cache: `php artisan config:clear`
- [ ] Visit /earn - Should see Monlix offers (if approved)
- [ ] Check logs for any Monlix API errors
- [ ] Configure postback URL in Monlix dashboard
- [ ] Test offer completion and postback

---

## 🐛 Troubleshooting

**No offers showing?**
1. Check MONLIX_APP_ID is set correctly
2. Verify your app is approved in Monlix dashboard
3. Check Laravel logs: `storage/logs/laravel.log`

**Offers not crediting?**
1. Check MONLIX_SECRET_KEY is correct
2. Verify postback URL is configured in Monlix
3. Check logs for "Invalid postback signature" errors

**API timeout?**
- Monlix API has 10-second timeout configured
- If slow, offers will silently fail and log error

---

## 📝 Code Locations

- **Service:** `coree/app/Services/MonlixService.php`
- **Controller:** `coree/app/Http/Controllers/Dashboard/MonlixController.php`
- **Routes:** `coree/routes/web.php` (lines 71-73, 101)
- **Integration:** `coree/app/Services/HomeService.php` (lines 77-90)

---

## 🎯 Key Differences from OGads

| Feature | OGads | Monlix |
|---------|-------|--------|
| Auth Method | API Key in header | App ID in params |
| Endpoint | `/api/v2` | `/api/campaigns` |
| Response | JSON object with 'offers' | Array of campaigns |
| User ID | Appended to link | In URL template |
| CPE Support | No | Yes (goals array) |
| Payout | Single value | Can be multiple goals |

---

**Updated:** November 13, 2025  
**API Version:** Monlix v1  
**Integration Status:** ✅ Complete

