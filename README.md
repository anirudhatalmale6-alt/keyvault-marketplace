# KeyVault — Digital Products Marketplace

A marketplace for selling digital goods — game keys, gift cards, subscriptions and
prepaid cards — with automated supplier fulfilment, wallet/balance, multi-currency
and a full admin panel. Built to be extended (G2A / Eneba / Kinguin connectors, more
payment gateways, more languages) without rewrites.

> **Status:** Phase 1 — Foundation. See the roadmap below for what is built and what
> is coming next.

## Tech stack

| Layer      | Choice                                             |
|------------|----------------------------------------------------|
| Backend    | Laravel 12 (PHP 8.2+ / 8.4 ready)                  |
| Frontend   | Vue 3 + Inertia.js (single codebase, no separate SPA) |
| Styling    | Tailwind CSS with class-based dark/light mode      |
| Database   | MySQL 8 / PostgreSQL in production, SQLite locally |
| Cache/Queue| Redis (via predis) — falls back to database driver |
| Auth       | Register, login, email verification, password reset|

## Requirements

- PHP 8.2+ with `pdo_mysql`, `mbstring`, `openssl`, `bcmath`, `curl`, `zip`
- Composer 2
- Node.js 20+ and npm
- MySQL 8 / PostgreSQL (production) and optionally Redis

## Getting started

```bash
# 1. Install dependencies
composer install
npm install

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Database
#    Local (SQLite):
touch database/database.sqlite
#    Or point .env at your MySQL DB (DB_CONNECTION=mysql, DB_DATABASE=...)
php artisan migrate --seed

# 4. Build assets & run
npm run dev          # or: npm run build
php artisan serve
```

The seeder creates:

- Currencies: **USD** (base), **EUR**, **DZD** — with exchange rates
- Top-level categories: Game Keys, Gift Cards, Subscriptions, Prepaid Cards
- Core platform settings (site name, locales, default margin)
- An admin account — `admin@keyvault.test` / `password`

## What's in Phase 1 (Foundation)

- Laravel 12 + Vue 3 + Inertia project, production build pipeline
- Authentication: registration, login, **email verification**, password reset,
  profile management (2FA lands in a later phase)
- **Roles & permissions** (Admin / Staff / Customer) via `spatie/laravel-permission`,
  with granular per-area permissions and route middleware
- **Redis queues + Laravel Horizon** for background jobs (powers the future
  supplier sync & instant-delivery engine); cache & logging configured
- **API-ready** REST layer (Laravel Sanctum) — `/api/v1/*` catalog + account endpoints
- Settings system (cached key/value store)
- MTCGame / Loaded-style storefront: hero banner carousel + featured sidebar,
  category chips, horizontal product rails, portrait product cards with pricing,
  header search, currency & language switchers, trust strip, cart
- **Dark / light mode** with a manual toggle that persists (no flash on load)
- Customer dashboard: wallet balance, order history, referral code
- Core database schema & Eloquent models for the whole marketplace:
  `categories`, `products`, `product_keys` (encrypted), `suppliers` (encrypted
  credentials), `orders`, `order_items`, `wallets` + `wallet_transactions`,
  `currencies`, `wishlists`, `settings`, roles/permissions tables
- Atomic, row-locked wallet credit/debit with transaction ledger
- Demo catalog seeded (28 products across 4 categories) so the store looks populated
- Automated tests (auth flows, storefront, wallet logic) — `php artisan test`

## Roadmap (9 phases)

1. **Foundation** — auth, roles, queues, API, storefront, schema ✅ *(this phase)*
2. **Store & Product System** — categories, brands, product pages, search, wishlist,
   related products, reviews, SEO, attributes (platform/region/edition), digital delivery
3. **Supplier Integration** — supplier API architecture, multiple suppliers, lowest-price
   selection, stock sync, auto imports/updates, cron jobs, error logs, manual sync
4. **Checkout & Payments** — wallet, Stripe, PayPal, crypto (BTC/USDT TRC20), order
   history, refunds, invoice generation
5. **Instant Delivery Engine** — reserve stock, auto-purchase key, encrypt & store,
   instant delivery + email, retry & supplier failover, price comparison, priority/backup
6. **Multi-Marketplace Selling** — G2A / Eneba / Kinguin integration, auto stock & price
   updates, auto order handling, margin & marketplace-specific pricing
7. **Growth Features** — coupons, affiliate, referrals, loyalty points, multi-currency,
   multi-language, support tickets, 2FA, newsletter, reviews
8. **Advanced Admin Panel** — dashboard, sales/profit/supplier analytics, full CRUD,
   pricing rules, currencies, taxes, coupons, roles, audit logs, notifications, queue
   monitoring, failed jobs, system & API health
9. **Security & Deployment** — Docker, VPS, SSL, rate limiting, daily backups, encrypted
   API keys, Cloudflare, firewall, monitoring, performance optimisation

## Testing

```bash
php artisan test
```

## License

Proprietary — built for the project owner.
