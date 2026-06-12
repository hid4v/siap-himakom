# Development Plan & Progress - SIAP-HIMAKOM

This plan tracks the development progress of the SIAP-HIMAKOM system.

---

## Progress Overview

| Phase | Description | Status |
| :--- | :--- | :--- |
| **Phase 1** | Environment & Dependency Setup | Completed |
| **Phase 2** | Database Migrations & Models | Completed |
| **Phase 3** | Security & Filters | Completed |
| **Phase 4** | Routing & Layouts Setup | Completed |
| **Phase 5** | Public Landing Page (FlexStart) | Completed |
| **Phase 6** | Auth & Dashboard Controllers | Completed |
| **Phase 7** | Admin CRUDs & Server-Side DataTables | Completed |
| **Phase 8** | Member Booking Flow | Completed |
| **Phase 9** | Testing & Final Polish | Completed |

---

## Detailed Task Checklist

### Phase 1: Environment & Dependency Setup
- [x] Create `DESIGN.md` in root directory
- [x] Create `Plan.md` in root directory
- [x] Install `hermawan/codeigniter4-datatables` package via Composer
- [x] Create MySQL database `siap_himakom`
- [x] Configure `.env` file credentials

### Phase 2: Database Migrations & Models
- [x] Generate migrations for: `users`, `categories`, `assets`, `loans`, `loan_details`
- [x] Run the migration script
- [x] Create `AppSeeder` with default admin, member, categories, and initial assets
- [x] Seed the database
- [x] Write Models: `UserModel.php`, `CategoryModel.php`, `AssetModel.php`, `LoanModel.php`, `LoanDetailModel.php`

### Phase 3: Security & Filters
- [x] Write `AuthFilter` to redirect guests to `/login`
- [x] Write `AdminFilter` to restrict admin pages to role `admin`
- [x] Update `app/Config/Filters.php` config aliases and routes mapping

### Phase 4: Routing & Layouts Setup
- [x] Declare explicit routes in `app/Config/Routes.php`
- [x] Create Auth layouts (Login & Register)
- [x] Setup AdminLTE base layout wrapper `admin_layout.php` with navigation and sidebar

### Phase 5: Public Landing Page
- [x] Integrate FlexStart template layout on the homepage
- [x] Render Ilmu Komputer ULM program details (Visi, Misi, website links)
- [x] Display available assets catalog from database (statistics section removed)
- [x] Set up FAQ list and Contact info section

### Phase 6: Auth & Dashboard Controllers
- [x] Write user registration and authentication methods in `AuthController`
- [x] Write `DashboardController` routing roles (Admin dashboard vs Member dashboard)
- [x] Draw Chart.js graphs on Admin dashboard:
  - Monthly borrowing history (Line chart)
  - Asset share per category (Doughnut chart)

### Phase 7: Admin CRUDs (Server-Side DataTables)
- [x] Write Users admin panel (role adjustments and user accounts deletion/editing)
- [x] Write Categories admin CRUD
- [x] Write Assets admin CRUD (managing details, stocks, and photo uploading)
- [x] Write Loans admin panel (approving, rejecting, marking picked-up/borrowed, and returned assets)

### Phase 8: Member Booking Flow
- [x] Write Member Catalog booking page (allows selecting multiple items, updating stock validation)
- [x] Write Member Loan submission handling
- [x] Write Loan History & Booking details lists
- [x] Write Member Profile update form

### Phase 9: Verification & Testing
- [x] Run complete checkout & loan status transitions test manually
- [x] Verify validations (prevent borrowing more than available stock, date validators)
- [x] Validate responsive views on mobile and desktop layout devices
- [x] Document final changes in `walkthrough.md`

### Phase 10: UI/UX Adjustments & Refinements
- [x] Update landing page `landing.php` (remove stats, update color scheme variables)
- [x] Update auth views `login.php` and `register.php` (white background, flat cards)
- [x] Update layouts `admin_layout.php` and `member_dashboard.php` colors
- [x] Redesign admin dashboard `dashboard.php` widgets to match classic solid colored small boxes
- [x] Change primary font family to Montserrat across all pages (matching `https://ilkom.ulm.ac.id/`)
- [x] Redesign Visi & Misi box on landing page to a regular clean box
- [x] Clean admin sidebar by removing excessive dividing lines and underlines
- [x] Format "Tahun" chart badge with a smooth circular/pill layout
- [x] Update `DESIGN.md` and `Plan.md` documentation
- [x] Verify all adjustments manually

### Phase 11: Alert & Confirmation UI Overhaul
- [x] Replace native `confirm()` dialogs on admin loans page with styled Bootstrap Modal (approve, reject, borrow, return)
- [x] Replace native `alert()` on admin loans page with Bootstrap Toast notifications (success/error feedback)
- [x] Replace native `alert()` on member catalog page with Bootstrap Toast for cart validation errors
- [x] Update `DESIGN.md` documentation with new UI patterns
