# EdTech Platform Project Plan (Udemy / 10 Minute School Clone)

## 1. Project Overview
An enterprise-level multi-vendor e-learning platform where instructors can create and sell courses, and students can purchase and learn. The platform will operate on a commission-based SaaS model.

## 2. Technology Stack
- **Backend Frameowrk:** Laravel (PHP)
- **Frontend / UI:** Blade Templates + TailwindCSS (Alpine.js or Vue.js for interactive components)
- **Database:** MySQL / PostgreSQL
- **Video Hosting:** AWS S3, Vimeo, or Mux (for secure video streaming)
- **Payment Gateway:** bKash, SSLCommerz (Local) & Stripe (International)

---

## 3. Core Features by Role

### 👨‍🎓 Student Features
- User registration & profile management.
- Browse courses (Search, filter by category, price, rating).
- Shopping cart & secure checkout.
- **Learning Dashboard:** Video player, course progress tracking, quizzes, and resources.
- Review & Rating system for completed courses.
- Automated Certificate generation upon completion.

### 👨‍🏫 Instructor Features
- Instructor application & approval system.
- **Course Builder:** Upload videos, create modules/lessons, add PDFs, and create quizzes.
- Pricing & discount management.
- **Financial Dashboard:** Track sales, revenue, and request payouts.
- Q&A section to interact with students.

### 🛡️ Super Admin Features
- Dashboard with overall analytics (Total users, total revenue, active courses).
- Manage Users (Approve/Ban instructors and students).
- Category & Tag management.
- **Commission Management:** Set percentage cut for the platform.
- **Payout Management:** Process withdrawal requests from instructors.
- Site settings (Logo, terms, banners).

---

## 4. High-Level Database Schema (Core Tables)

1. **Users Table:** id, name, email, password, role (student, instructor, admin)
2. **Categories Table:** id, name, slug, icon
3. **Courses Table:** id, instructor_id, category_id, title, description, price, thumbnail, status (draft, published, pending)
4. **Modules Table:** id, course_id, title, order
5. **Lessons (Videos) Table:** id, module_id, title, video_url, duration, order
6. **Enrollments Table:** id, student_id, course_id, payment_status, enrolled_at
7. **Payments Table:** id, enrollment_id, user_id, amount, gateway, transaction_id
8. **Payouts Table:** id, instructor_id, amount, status, processed_at

---

## 5. Development Phases

### Phase 1: Foundation & Authentication (Week 1)
- Install Laravel & Setup Database.
- Implement Multi-Authentication (Admin, Instructor, Student) using Laravel Breeze/Jetstream or Spatie Permission.
- Setup layout, navigation, and basic dashboard views.

### Phase 2: Course Management & Instructor Panel (Week 2)
- Category & Tag CRUD.
- Instructor course creation workflow (Course details, Thumbnail).
- Curriculum Builder (Modules & Lessons uploading).
- Admin approval system for courses.

### Phase 3: Frontend & E-commerce System (Week 3)
- Home page, Course catalog, and Course details page.
- Shopping cart implementation.
- Payment Gateway Integration (Checkout process).
- Enrollment logic upon successful payment.

### Phase 4: Learning Experience & Student Panel (Week 4)
- Student Dashboard (My Courses).
- Video Player implementation and Progress Tracking.
- Quiz & Assignment system.
- Certificate generation.

### Phase 5: Finance, Polish & Launch (Week 5)
- Instructor commission calculation & payout system.
- Review and Rating system.
- SEO optimization & Email Notifications.
- Final testing, bug fixing, and server deployment.
