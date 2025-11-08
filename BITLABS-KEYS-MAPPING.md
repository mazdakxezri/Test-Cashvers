# BitLabs Keys Mapping - YOUR ACTUAL KEYS

## 🔑 Here's What You Have:

1. **App/API Token:** `de658a4a-f254-4c3d-889a-414af40b2215`
2. **Secret Key:** `tw68IdwjF1pgk5LZwhcwAUk1FSS9gzHh`
3. **Server to Server Key:** `GmsC4VbvSAklJffQXWwUnr6bMKB9tflA`

---

## 📝 Add These to Your .env File:

```env
# BitLabs API Configuration
BITLABS_API_TOKEN=de658a4a-f254-4c3d-889a-414af40b2215
BITLABS_APP_TOKEN=de658a4a-f254-4c3d-889a-414af40b2215
BITLABS_SECRET_KEY=tw68IdwjF1pgk5LZwhcwAUk1FSS9gzHh
```

---

## 📋 Key Mapping Explained:

| Your BitLabs Key | ENV Variable | Purpose |
|-----------------|--------------|---------|
| App/API Token | `BITLABS_API_TOKEN` | Server-side API calls |
| App/API Token | `BITLABS_APP_TOKEN` | Client-side SDK (same as API Token) |
| Secret Key | `BITLABS_SECRET_KEY` | Webhook verification |
| ~~Server to Server Key~~ | Not needed | (Use API Token instead) |

---

## ✅ COPY THIS EXACT TEXT:

**Copy these 3 lines and paste into your .env file:**

```
BITLABS_API_TOKEN=de658a4a-f254-4c3d-889a-414af40b2215
BITLABS_APP_TOKEN=de658a4a-f254-4c3d-889a-414af40b2215
BITLABS_SECRET_KEY=tw68IdwjF1pgk5LZwhcwAUk1FSS9gzHh
```

---

## 🔗 Set Up Webhook in BitLabs Dashboard:

1. Go to **BitLabs Dashboard** → **Settings** → **Webhooks**
2. Add this URL:
   ```
   https://test.cashvers.com/api/bitlabs/callback
   ```
3. Use **Secret Key** for verification: `tw68IdwjF1pgk5LZwhcwAUk1FSS9gzHh`
4. Save

---

## 🧪 Test After Adding:

1. **Add keys to .env**
2. **Clear cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```
3. **Visit:** `https://test.cashvers.com/bitlabs`
4. **Should see:** Available surveys (if your account is approved)

---

## ⚠️ IMPORTANT:

- **Delete this file** after adding keys to .env (for security)
- **Never share these keys** publicly
- **Never commit to GitHub**

---

**That's it! Add those 3 lines to your .env file and BitLabs will work!** 🚀

