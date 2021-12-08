CREATE TABLE `users` (
`user_id` int(11) NOT NULL,
`user_name` varchar(255) NOT NULL,
`user_email` varchar(255) NOT NULL,
`user_password` varchar(128) NOT NULL,
`user_status` varchar(1) NOT NULL DEFAULT 'P',
`user_data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users`
ADD PRIMARY KEY (`user_id`),
ADD UNIQUE KEY `user_email` (`user_email`),
ADD KEY `user_name` (`user_name`),
ADD KEY `user_status` (`user_status`);

INSERT INTO `users` 
(`user_name`, `user_email`, `user_password`, `user_status`) 
VALUES 
('admin', 'admin@test.com', 'e10adc3949ba59abbe56e057f20f883e', 'A');