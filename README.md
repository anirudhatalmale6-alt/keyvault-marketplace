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
- Branded, responsive storefront (hero, categories, features) with header search,
  currency & language switchers
- **Dark / light mode** with a manual toggle that persists (no flash on load)
- Customer dashboard: wallet balance, order history, referral code
- Core database schema & Eloquent models for the whole marketplace:
  `categories`, `products`, `product_keys` (encrypted), `suppliers` (encrypted
  credentials), `orders`, `order_items`, `wallets` + `wallet_transactions`,
  `currencies`, `wishlists`, `settings`
- Atomic, row-locked wallet credit/debit with transaction ledger
- Automated tests (auth flows, storefront, wallet logic) — `php artisan test`

## Roadmap

1. **Foundation** — auth, storefront shell, schema, dark/light ✅ *(this phase)*
2. **Catalog & Store** — products, categories, product pages, search, cart, wishlist
3. **Wallet, Checkout & Stripe** — checkout flow, first payment gateway, orders
4. **Supplier Automation Engine** — driver layer, auto import, price/stock sync,
   auto-purchase keys, instant delivery, retries, logs
5. **More Payments** — PayPal, crypto (BTC / USDT TRC20), local methods
6. **Growth & Support** — promo codes, referrals, multi-currency conversion,
   multi-language (EN/FR/AR), support tickets, 2FA
7. **Admin Panel** — products, users, orders, suppliers, pricing rules, currencies,
   coupons, analytics, taxes, activity logs, roles & permissions, notifications
8. **Deployment** — Docker, VPS deploy, rate limiting, audit logs, hardening

## Testing

```bash
php artisan test
```

## License

Proprietary — built for the project owner.
