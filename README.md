# 📌 QCAMS – QR Code Attendance Management System

A Laravel-based QR Code Attendance Management System designed for students and faculty to easily record attendance during events through QR code scanning.
QCAMS simplifies attendance tracking by replacing manual logs with a fast, secure, and contactless solution.

---

## 🚀 Overview

QCAMS allows administrators to create events and generate QR codes. Participants (students or faculty) can scan these QR codes to log their attendance in real-time.

The system records:

- Time in / Time out
- Attendance status (Present, Absent, etc.)
- Participant details (Student or Faculty)

---

## ✨ Key Features

- 📷 QR Code-based attendance tracking
- 👥 Supports both Students and Faculty
- 🗓 Event management system
- ⏱ Time in / Time out logging
- 📊 Attendance status tracking
- 🔐 Role-based authentication (Admin, Student, Faculty)
- 🗃 Soft delete support for data recovery
- ⚡ Dockerized setup for easy development

---

## 🛠 Tech Stack

- Backend: Laravel
- Frontend: Blade / Vite / NPM
- Database: MySQL Note: will be migrating to postgres for supabase support as I will deploy this project for demo purposes
- Containerization: Docker

## 📦 Installation Guide
1. Clone the Repository
```bash
git clone https://github.com/Erzan12/qr-attendance.git
cd qcams-system
```

2. Setup Environment
```bash
cp .env.example .env
```
Update the following in .env:
```bash
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
⚠️ Make sure values are not empty and avoid using root when possible.

3. Start Docker Containers
```bash
docker-compose up -d --build
```
If already built:
```bash
docker-compose up -d
```
4. Access the App Container
```bash
docker-compose exec app bash
```
5. Install Backend Dependencies
```bash
composer install
php artisan key:generate
php artisan migrate
```
```bash
6. Install Frontend Dependencies
npm install
npm run build
```

---


## ▶️ Running the System

Once everything is set up, the application should be accessible via your configured local port.

---

## 🛑 Stopping the Containers
```bash
docker-compose down
```

If you're inside the container:
```bash
exit
```

---

## 🧠 System Structure (Simplified)
- Users
  - Admin
  - Student
  - Faculty
- Events
  - Title, Date, Time, Description
- Event Participants
  - Linked to events
  - Tracks attendance status
  - Handles time-in and time-out

---

## 🔄 Attendance Flow
1. Admin creates an event
2. System generates a QR code
3. Participants scan the QR code
4. Attendance is recorded automatically
5. Status updates (Present / Absent / Partial)

---

## 📌 Future Improvements

Here are some realistic upgrades you can implement:

### 🔐 Security & Authentication
  - Add QR code expiration & encryption
  - Implement 2FA for admins
  - Prevent duplicate scans / spoofing
### 📱 User Experience
  - Mobile-friendly scanning interface
  - Progressive Web App (PWA) support
  - Real-time attendance dashboard
### 📊 Analytics & Reports
  - Export attendance (CSV / PDF)
  - Attendance summaries per event
  - Participant performance tracking
### ⚡ System Enhancements
  - Live scan validation (WebSockets)
  - Email notifications for attendance
  - API support for mobile apps
### 🧩 Code Improvements
  - Optimize repeated queries in EventParticipant (use relationships instead of find())
  - Add eager loading to improve performance
  - Use policies for better authorization handling

---

## 🤝 Contribution

This project is open for learning and improvement. Feel free to fork, modify, and contribute. I will also do code reviews per pr.

---

## 📄 License

This project is for educational and development purposes.

---