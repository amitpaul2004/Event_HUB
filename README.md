# 📘 Event HUB – Event Management System

Event HUB is a complete event management platform built using PHP and MySQL.  
It allows admins to create and manage events, while users can register, view details, and track participation.  
This project is ideal for event organizations, clubs, colleges, seminars, and workshops.

---

## 🚀 Project Overview
Event HUB provides an easy-to-use system to organize events efficiently.  
It includes complete event listings, attendee registrations, admin dashboard, and a responsive frontend UI.

---

## Overview:
<img width="1896" height="861" alt="image" src="https://github.com/user-attachments/assets/88acb736-a0a1-4890-9ca5-6d5eab3f8af6" />

---

## Demo Vedio :
https://screenapp.io/app/v/cs2qhILKs8


---

## ⭐ Key Features
- ✔ Add, edit, update, and delete events  
- ✔ User event registration  
- ✔ Event categories & details  
- ✔ Admin dashboard  
- ✔ Responsive Bootstrap UI  
- ✔ Secure PHP & MySQL backend  
- ✔ Clean folder structure  

---

## 🛠 Technologies Used

| Part | Technology |
|------|------------|
| Frontend | HTML, CSS, JavaScript, Bootstrap |
| Backend  | PHP (Core PHP) |
| Database | MySQL |
| Server   | Apache (XAMPP/APACHE)

---

# ⚙️ Installation & Setup

Follow these steps carefully to run the project.

---

## 1️⃣ Install Required Software

Install **XAMPP** (Recommended):  
https://www.apachefriends.org/

It includes:

- Apache Server  
- PHP  
- MySQL  

---

## 2️⃣ Move Project to Server Directory

1. Extract `Event_HUB.zip`
2. Rename folder to:
Event_HUB
3. Move it to:
C:\xampp\htdocs\


---

## 3️⃣ Import the Database

1. Open XAMPP → Start **Apache** and **MySQL**
2. Visit:http://localhost/phpmyadmin
3. Create a database: event_hub
4. Go to **Import**  
5. Choose:
Event_HUB/database/event_hub.sql

Done! Database is ready.

---

## 4️⃣ Configure Database (Important)

Open:

config.php

Put this code:

```php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "event_hub";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

## Run the Project
http://localhost/Event_HUB/
