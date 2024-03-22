

CREATE TABLE `hms_appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `specialization_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `consultancy_fee` int(11) NOT NULL,
  `appointment_date` varchar(255) NOT NULL,
  `appointment_time` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Cancelled','Completed','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hms_appointments`
--

INSERT INTO `hms_appointments` (`id`, `patient_id`, `specialization_id`, `doctor_id`, `consultancy_fee`, `appointment_date`, `appointment_time`, `created`, `status`) VALUES
(16, 37, 1, 14, 800, '2022-06-28', '2', '2022-06-27 21:43:08', 'Active'),
(17, 38, 1, 14, 800, '2022-06-29', '1', '2022-06-30 00:04:04', 'Active'),
(18, 39, 1, 14, 1000, '2022-06-29', '6', '2022-06-30 00:04:30', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `hms_doctor`
--

CREATE TABLE `hms_doctor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `fee` int(11) NOT NULL,
  `specialization` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hms_doctor`
--

INSERT INTO `hms_doctor` (`id`, `name`, `email`, `address`, `mobile`, `fee`, `specialization`) VALUES
(14, 'Satish ', 'satis@phpzag.com', 'Pipariya', '1234567890', 45000, 1),
(15, 'Any Flower', 'andy@phpzag.com', 'sfasfasfasfas', '123456789', 1000, 2),
(16, 'Smith', 'smith@phpzag.com', 'dsfdsgd', '1234567890', 1200, 5),
(17, 'Tim', 'tim@phpzag.com', 'fdhfhdf', '1234567890', 700, 3),
(18, 'Chris', 'chris@phpzag.com', 'ewtewt', '123456789', 1100, 6);

-- --------------------------------------------------------

--
-- Table structure for table `hms_patients`
--

CREATE TABLE `hms_patients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `age` int(11) NOT NULL,
  `medical_history` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hms_patients`
--

INSERT INTO `hms_patients` (`id`, `name`, `email`, `gender`, `mobile`, `address`, `age`, `medical_history`) VALUES
(37, 'Greg', 'greg@phpzag.com', 'Male', '1234567890', 'Pipariya', 20, 'Fever'),
(38, 'dgdgd', 'phpzag@gmail.com', 'Male', '12345678900', 'dsdgsd', 35, 'tutu'),
(39, 'fgdhfdh', '', 'Male', '1234567890', 'tut', 33, 'utur');

-- --------------------------------------------------------

--
-- Table structure for table `hms_slots`
--

CREATE TABLE `hms_slots` (
  `id` int(11) NOT NULL,
  `slots` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hms_slots`
--

INSERT INTO `hms_slots` (`id`, `slots`) VALUES
(1, '09:00 AM'),
(2, '09:30 AM'),
(3, '10:00 AM'),
(4, '10:30 AM'),
(5, '11:00 AM'),
(6, '11:30 AM'),
(7, '12:00 PM'),
(8, '12:30 PM'),
(9, '01:00 PM'),
(10, '01:30 PM'),
(11, '02:00 PM'),
(12, '02:30 PM'),
(13, '03:00 PM'),
(14, '03:30 PM'),
(15, '04:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `hms_specialization`
--

CREATE TABLE `hms_specialization` (
  `id` int(11) NOT NULL,
  `specialization` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hms_specialization`
--

INSERT INTO `hms_specialization` (`id`, `specialization`) VALUES
(1, 'General Physician'),
(2, 'Dentist'),
(3, 'Ear, Nose, Throat (ENT)'),
(4, 'Artho'),
(5, 'Neurology'),
(6, 'Cardiology');

-- --------------------------------------------------------

--
-- Table structure for table `hms_users`
--

CREATE TABLE `hms_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hms_users`
--

INSERT INTO `hms_users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`) VALUES
(1, 'adam', 'smith', 'adam@phpzag.com', '202cb962ac59075b964b07152d234b70', 'admin'),
(2, 'Any', 'Marks', 'mark@phpzag.com', '202cb962ac59075b964b07152d234b70', 'admin'),
(3, 'William', 'Robert', 'robert@phpzag.com', '202cb962ac59075b964b07152d234b70', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hms_appointments`
--
ALTER TABLE `hms_appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hms_doctor`
--
ALTER TABLE `hms_doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hms_patients`
--
ALTER TABLE `hms_patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hms_slots`
--
ALTER TABLE `hms_slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hms_specialization`
--
ALTER TABLE `hms_specialization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hms_users`
--
ALTER TABLE `hms_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hms_appointments`
--
ALTER TABLE `hms_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hms_doctor`
--
ALTER TABLE `hms_doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hms_patients`
--
ALTER TABLE `hms_patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `hms_slots`
--
ALTER TABLE `hms_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `hms_specialization`
--
ALTER TABLE `hms_specialization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hms_users`
--
ALTER TABLE `hms_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;


