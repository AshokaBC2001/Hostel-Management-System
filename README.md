🏨 Hostel Management System

⸻

📌 Overview

The Hostel Management System is a web-based application designed to simplify hostel operations for both students and administrators.

It provides a complete digital solution for:
	•	Room booking 🛏️
	•	Student management 👨‍🎓
	•	Inquiry handling 📩
	•	Room allocation & tracking 📊

The system is developed using PHP, MySQL, HTML, CSS, and JavaScript, and runs on a local XAMPP server.

⸻

🚀 Features
	•	🔐 Secure Login System (Admin & Student)
	•	🛏️ Real-Time Room Availability Checking
	•	📊 Full Booking Management System
	•	👨‍🎓 Student Profile & Account Management
	•	🛠️ Admin Control Panel (Full CRUD)
	•	📩 Inquiry & Communication System
	•	⚡ Dynamic Seat Allocation

⸻

🎓 Student Panel

📌 Overview

The Student Panel allows students to browse rooms, check availability, book hostels, and manage their profiles.

⸻

⚙️ Features
	•	🏠 Dashboard
	•	Entry point after login
📄 dashboard.php
	•	🛏️ View Room Details
	•	View room types, facilities, capacity
📄 room-details.php
	•	📅 Check Availability
	•	Check available rooms dynamically
📄 check-availability.php
	•	📝 Book Hostel
	•	Submit booking requests
📄 book-hostel.php
	•	👤 Profile Management
	•	View & update personal details
📄 profile.php
	•	⚙️ Account Settings
	•	Change password & preferences
📄 acc-setting.php
	•	❓ Inquiry System
	•	Send issues/messages to admin
📄 inquire.php
	•	🚪 Logout
📄 logout.php
	•	🧩 Dynamic Seat Handling
📄 get-seater.php

⸻

🔄 Workflow
	1.	Login
	2.	View dashboard
	3.	Check room availability
	4.	View room details
	5.	Book hostel
	6.	Manage profile/settings
	7.	Send inquiries
	8.	Logout

⸻

🛠️ Admin Panel

📌 Overview

The Admin Panel provides full control over the hostel system including rooms, students, bookings, and inquiries.

⸻

⚙️ Features
	•	📊 Dashboard
📄 dashboard.php

⸻

	•	🛏️ Room Management
	•	Add Rooms → add-rooms.php
	•	Edit Rooms → edit-room.php
	•	Manage Rooms → manage-rooms.php

⸻

	•	📅 Booking Management
	•	View & track bookings
📄 bookings.php

⸻

	•	👨‍🎓 Student Management
	•	Register Students → register-student.php
	•	Manage Students → manage-students.php
	•	View Accounts → view-students-acc.php
	•	Student Profiles → students-profile.php
	•	Dynamic Info → get-student-info.php

⸻

	•	📨 Inquiry Management
📄 student-inquires.php

⸻

	•	⚙️ Availability & Seats
	•	Admin Availability → check-availability-admin.php
	•	Seat Logic → get-seater.php

⸻

	•	👤 Profile & Settings
	•	Profile → profile.php
	•	Account Settings → acc-setting.php

⸻

	•	🔐 Authentication
	•	Login → index.php
	•	Logout → logout.php

⸻

	•	🧪 Utility Files
	•	rwl.php
	•	rwln.php

⸻

🔄 Workflow
	1.	Login
	2.	Access dashboard
	3.	Manage rooms
	4.	Manage students
	5.	Monitor bookings
	6.	Handle inquiries
	7.	Check availability
	8.	Update profile
	9.	Logout

⸻

🛠️ Technologies Used
	•	HTML, CSS, JavaScript
	•	PHP
	•	MySQL
	•	XAMPP (Apache + MySQL)

⸻

▶️ How to Run
	1.	Clone or download the project
	2.	Move folder to:

htdocs/


	3.	Start:
	•	Apache
	•	MySQL
	4.	Open phpMyAdmin
	5.	Import the database
	6.	Run project:

http://localhost/your-project-folder/



⸻

🔑 Access Panels
	•	Student Panel → /
	•	Admin Panel → /admin/

⸻

📈 Future Improvements
	•	🔒 Better security (password hashing, validation)
	•	📱 Responsive UI design
	•	📊 Analytics dashboard
	•	📧 Email notifications
	•	☁️ Cloud deployment

⸻

🤝 Contributing

Feel free to fork this project and improve it.

⸻

📜 License

This project is developed for educational purposes.

⸻

🌟 Final Note

This project demonstrates a complete Hostel Management System with both student and admin functionalities, focusing on usability, structured workflow, and efficient hostel operations.
