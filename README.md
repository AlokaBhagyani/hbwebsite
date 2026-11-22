# HBWebsite – Hotel Booking System

A mini project developed for **ICT2308 – Database Systems**.  
This system allows customers to browse rooms, view facilities, make bookings, and send contact messages.  
Administrators can manage rooms, bookings, facilities, and messages through a secure dashboard.

---

## ✨ Features

### Public (Customer)
- View available rooms with details and facilities
- Submit bookings with check-in / check-out dates
- Contact form to send inquiries
- About page with hotel information

### Admin Dashboard
- Admin login (username + password)
- Manage rooms (Add, Edit, Delete, View)
- Manage facilities and map them to rooms
- View bookings submitted by customers
- View contact messages from customers

---

## 🗄 Database Design

The project uses a **relational database** normalized to ~3NF.

**Tables**
- `admin_cred` – Admin login credentials
- `rooms` – Room details
- `facilities` – Facility list
- `room_facility_mapping` – Many-to-many relationship between rooms and facilities
- `bookings` – Customer booking records
- `messages` – Contact form submissions

**Relationships**
- `rooms` ↔ `room_facility_mapping` ↔ `facilities`
- `rooms` ↔ `bookings`
- `messages` independent, linked to customers



---

## ⚙️ Technology Stack

- **Frontend/UI:** HTML5, CSS3, Bootstrap
- **Backend:** PHP (Procedural)
- **Database:** MySQL
- **Server Environment:** XAMPP (Apache, MariaDB, PHP)

---

## 🚀 Installation

1. Clone or extract the project:
   ```bash
 
