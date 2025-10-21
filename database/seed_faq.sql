-- Seed FAQ data with sample questions and answers
INSERT INTO faq (question, answer, category, display_order) VALUES 
-- General Category
('What are the library hours?', 'The library is open:\nMonday-Friday: 8:00 AM - 8:00 PM\nSaturday: 9:00 AM - 5:00 PM\nSunday: Closed\n\nHours may vary during holidays and exam periods.', 'general', 1),
('How do I get a library card?', 'Students can get their library card from the circulation desk by presenting their valid student ID. Faculty and staff members need to present their employee ID.', 'general', 2),
('Can visitors use the library?', 'Visitors can access the library for reference purposes only. A day pass can be obtained from the reception desk with valid ID.', 'general', 3),

-- Borrowing Category
('How many books can I borrow at once?', 'Undergraduate students: 5 books\nGraduate students: 8 books\nFaculty: 10 books\nStaff: 5 books', 'borrowing', 1),
('What is the loan period?', 'Regular books: 14 days\nReference books: Library use only\nReserve materials: 2 hours in-library use', 'borrowing', 2),
('What are the fines for late returns?', 'Regular books: ₱5 per day\nReserve materials: ₱10 per hour\nLost books must be replaced or paid for at current market value plus processing fee.', 'borrowing', 3),

-- Digital Resources Category
('How do I access e-books?', 'Currently, our e-book collection is under development. Once available, you will be able to access them through our digital library portal using your student/faculty credentials.', 'digital', 1),
('Can I download e-journals?', 'Our e-journal system is being implemented. For now, you can access our physical journal collection in the periodicals section.', 'digital', 2),
('How do I access the online databases?', 'Access our online databases through the "Databases" section of our website. Most databases are accessible within campus without login. For off-campus access, use your institutional credentials.', 'digital', 3),

-- Services Category
('Do you offer research assistance?', 'Yes, our librarians provide research assistance through:\n- One-on-one consultations\n- Group workshops\n- Online research guides\nSchedule an appointment at the reference desk or through our contact form.', 'services', 1),
('Is there a printing service?', 'Yes, printing services are available at the library. Black & white: ₱2/page, Color: ₱10/page. You can send print jobs from the library computers or your own device.', 'services', 2),
('Are there study rooms available?', 'Yes, we have group study rooms available. They can be booked for 2-hour slots at the circulation desk. Maximum 6 people per room.', 'services', 3);