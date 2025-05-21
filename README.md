# Budgeto

**Budgeto** is a finance management website designed for students and individuals living away from home. It helps users easily track their income and expenses, manage budgets, and gain AI-powered financial insights.

![Budgeto Banner](https://via.placeholder.com/1200x300.png?text=Budgeto+-+Smart+Finance+Manager)

---

## 🚀 Features

- **User Authentication**
  - Signup, Login, and Password Reset
- **Dashboard Overview**
  - Total Income, Expenses, and Balance
  - Budget progress and pie chart visualizations
- **Income & Expense Management**
  - Add, edit, and delete transactions
  - Categorize as income or expense
- **Budget & Savings Module**
  - Set monthly budgets
  - Get alerts when nearing limits
- **AI & Smart Features**
  - Smart tips based on spending behavior
  - Predictive insights for future budgeting
- **Responsive Design**
  - Works well on mobile, tablet, and desktop
  - Clean and colorful UI with vibrant fonts and imagery

---

## 🛠️ Tech Stack

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Visualization:** Chart.js
- **Styling:** Custom CSS with consistent color scheme

Color Palette:
- `#022B3A`, `#1F7A8C`, `#BFDBF7`, `#E1E5F2`, `#FFFFFF`

---

## ⚙️ Installation & Setup

# Database
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 07:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `budgeto_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budgets`
--

INSERT INTO `budgets` (`id`, `user_email`, `budget`) VALUES
(1, 'anjuyadav12@gmail.com', 7500.00),
(2, 'harshitparihar@gmail.com', 9000.00),
(3, 'himanshusingh190604@gmail.com', 8000.00),
(4, 'ashu9930singh@gmail.com', 15000.00),
(5, 'mital@gmail.com', 50000.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type` enum('expense','income') DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `email`, `type`, `category`, `amount`, `note`, `date`) VALUES
(1, 'himanshusingh190604@gmail.com', 'expense', 'Food', 2700.00, '', '2025-05-15'),
(2, 'himanshusingh190604@gmail.com', 'income', 'Part Time', 3500.00, '', '2025-05-05'),
(3, 'anjuyadav12@gmail.com', 'expense', 'Hostel Fees', 300.00, '', '2025-05-02'),
(4, 'anjuyadav12@gmail.com', 'income', 'Allowance', 8000.00, '', '2025-05-01'),
(5, 'anjuyadav12@gmail.com', 'income', 'Part time', 2500.00, '', '2025-05-03'),
(6, 'anjuyadav12@gmail.com', 'expense', 'Mess Fees', 2500.00, '', '2025-05-02'),
(7, 'anjuyadav12@gmail.com', 'expense', 'Electricity', 500.00, '', '2025-05-15'),
(8, 'anjuyadav12@gmail.com', 'expense', 'Groceries', 1280.00, '', '2025-05-05'),
(9, 'harshitparihar@gmail.com', 'income', 'Allowance', 12000.00, '', '2025-05-01'),
(10, 'harshitparihar@gmail.com', 'expense', 'Rent', 2500.00, '', '2025-05-05'),
(11, 'harshitparihar@gmail.com', 'expense', 'Tiffin', 1250.00, '', '2025-05-06'),
(12, 'harshitparihar@gmail.com', 'expense', 'Fruits', 70.00, '', '2025-05-17'),
(13, 'himanshusingh190604@gmail.com', 'expense', 'Rent', 2200.00, '', '2025-05-02'),
(14, 'himanshusingh190604@gmail.com', 'expense', 'Milk', 300.00, '', '2025-05-10'),
(15, 'himanshusingh190604@gmail.com', 'expense', 'Groceries', 800.00, '', '2025-05-06'),
(16, 'himanshusingh190604@gmail.com', 'income', 'Allowance', 8000.00, '', '2025-05-02'),
(17, 'himanshusingh190604@gmail.com', 'expense', 'Auto', 600.00, '', '2025-05-02'),
(18, 'himanshusingh190604@gmail.com', 'expense', 'Water', 450.00, '', '2025-05-16'),
(19, 'ashu9930singh@gmail.com', 'income', 'Salary', 35000.00, '', '2025-04-30'),
(20, 'ashu9930singh@gmail.com', 'expense', 'Room Rent', 6000.00, '', '2025-05-02'),
(21, 'ashu9930singh@gmail.com', 'expense', 'Groceries', 1200.00, '', '2025-05-05'),
(22, 'ashu9930singh@gmail.com', 'expense', 'Vegetables', 90.00, '', '2025-05-08'),
(23, 'ashu9930singh@gmail.com', 'income', 'Salary', 35000.00, '', '2025-03-31'),
(24, 'ashu9930singh@gmail.com', 'expense', 'Rent', 6000.00, '', '2025-04-02'),
(25, 'ashu9930singh@gmail.com', 'expense', 'Netflix', 599.00, '', '2025-05-05'),
(26, 'ashu9930singh@gmail.com', 'expense', 'Netflix', 299.00, '', '2025-04-06'),
(27, 'ashu9930singh@gmail.com', 'expense', 'Groceries', 950.00, '', '2025-04-05'),
(28, 'mital@gmail.com', 'income', 'Salary', 100000.00, '', '2025-05-01'),
(29, 'mital@gmail.com', 'expense', 'Rent', 10000.00, '', '2025-05-02'),
(30, 'mital@gmail.com', 'expense', 'Food', 6000.00, '', '2025-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Himanshu Singh', 'himanshusingh190604@gmail.com', '$2y$10$9w2mtFznnwDa2XK0302afepm1JM.YRzJb.VkzeY9ljRuhXg0UQi6S', '2025-05-15 18:06:59'),
(2, 'Ashutosh Singh', 'ashu9930singh@gmail.com', '$2y$10$fbBm0k3YbXRX/0e9V0GLzuIBoasyLeIfRrb6reB4PDYF.Wnadi6Qm', '2025-05-15 18:22:29'),
(3, 'Anju Yadav', 'anjuyadav12@gmail.com', '$2y$10$gZB6hgqC8FbOiKJVUW2JIu.qBcihrNTXCyJkTSWx0eWaX1VOdhjhq', '2025-05-17 08:12:22'),
(4, 'Harshit Singh Parihar', 'harshitparihar@gmail.com', '$2y$10$eDFXzLyv71Nm1VFaeGtEZulVdQ4nnp4.2m7GOdN3vtdgNE7fKZq9q', '2025-05-17 17:07:52'),
(5, 'Aditi Rao', 'aditirao@gmail.com', '$2y$10$6bYBgej9WWQ5zjzu6T09KegDxqNdpwPwjzlqP1aCwkShZTER8afva', '2025-05-18 06:54:12'),
(6, 'Mital Klohiiya', 'mital@gmail.com', '$2y$10$YKblQ50RguQhwEiG0eHRRO3/1Rui0a0iRfBWHlk1acoXk2LS3duIO', '2025-05-19 09:05:02'),
(7, 'Aman Kumar Yadav', 'aman1008@gmail.com', '$2y$10$G93x6P4rQxW6o.0GRffK1.7A/JolIN0DpceiVtdQAP6ekuKtQ6jLa', '2025-05-19 15:50:45'),
(8, 'Diwakar Pandey', 'diwz0404@gmail.com', '$2y$10$MSl6ttbAWycbG0ALDdeMwuYg3haUXRuucyPNfMwYQklZSFGgeECoi', '2025-05-19 16:11:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

# Website Snippets

![Homepage](image.png)
![Dashboard](image-1.png)

### 1. Clone the Repository

```bash
git clone https://github.com/himanshusingh-ai/Budgeto.git

📬 Contact
Created by Himanshu
GitHub: https://github.com/your-username

📄 License
This project is licensed under the MIT License.

🙌 Contribute
Suggestions and contributions are welcome! Open an issue or submit a pull request.
