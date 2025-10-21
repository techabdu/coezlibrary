-- Insert sample policies
INSERT INTO policies (title, content, category, display_order, is_active) VALUES
('Borrowing Rules', 'Students can borrow up to 5 books for 14 days. Faculty members can borrow up to 10 books for 30 days.', 'Borrowing', 1, 1),
('Late Fees', 'Overdue items incur a fee of $0.50 per day. Maximum late fee is $10 per item.', 'Fines', 1, 1),
('Computer Usage', 'Computers are available for academic use only. Time limit is 2 hours per session.', 'Facilities', 1, 1),
('Noise Policy', 'Please maintain silence in reading areas. Group discussions are allowed only in designated study rooms.', 'Conduct', 1, 1),
('Library Card', 'All students must present a valid student ID to obtain a library card. Cards are non-transferable.', 'Membership', 1, 1),
('Lost Items', 'Lost items must be replaced or paid for at current market value plus a $5 processing fee.', 'Fines', 2, 1),
('Study Room Booking', 'Study rooms can be booked for up to 2 hours per day. Advance booking is required.', 'Facilities', 2, 1),
('Food and Drinks', 'No food allowed in the library. Only covered drinks are permitted.', 'Conduct', 2, 1);