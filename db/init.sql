CREATE TABLE
    IF NOT EXISTS users (
        id SERIAL PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(50) CHECK (role IN ('jobseeker', 'company')) NOT NULL,
        nama VARCHAR(255) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS companydetail (
        user_id INT REFERENCES users (id) ON DELETE CASCADE,
        lokasi VARCHAR(255),
        about TEXT
    );

CREATE TABLE
    IF NOT EXISTS lowongan (
        id SERIAL PRIMARY KEY,
        company_id INT REFERENCES users (id) ON DELETE CASCADE,
        company_name VARCHAR(255),
        posisi VARCHAR(255),
        deskripsi TEXT,
        jenis_pekerjaan VARCHAR(255),
        jenis_lokasi VARCHAR(255),
        is_open BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE
    IF NOT EXISTS attachmentlowongan (
        id SERIAL PRIMARY KEY,
        lowongan_id INT REFERENCES lowongan (id) ON DELETE CASCADE,
        file_path TEXT
    );

CREATE TABLE
    IF NOT EXISTS lamaran (
        id SERIAL PRIMARY KEY,
        user_id INT REFERENCES users (id) ON DELETE CASCADE,
        lowongan_id INT REFERENCES lowongan (id) ON DELETE CASCADE,
        cv_path TEXT DEFAULT NULL,
        video_path TEXT DEFAULT NULL,
        status VARCHAR(50) CHECK (status IN ('accepted', 'rejected', 'waiting')) DEFAULT 'waiting',
        status_reason TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

CREATE OR REPLACE FUNCTION update_company_name()
RETURNS TRIGGER
AS $$
BEGIN
    UPDATE lowongan
    SET company_name = NEW.nama
    WHERE company_id = NEW.id;
    RETURN NEW;
END;
$$ language plpgsql;

CREATE OR REPLACE TRIGGER company_name_trigger
AFTER UPDATE ON users
FOR EACH ROW EXECUTE FUNCTION update_company_name();

CREATE INDEX idx_user_email ON users (email);

CREATE INDEX idx_lowongan_company ON lowongan (company_id);

INSERT INTO
    users (email, password, role, nama)
VALUES
    (
        'jobseeker@example.com',
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW',
        'jobseeker',
        'John Doe'
    ),
    (
        'company@example.com',
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW',
        'company',
        'Company Inc.'
    ),
    (
        'jobseeker2@example.com',
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW',
        'jobseeker',
        'Jane Smith'
    ),
    (   'jobseeker3@example.com', 
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW', 
        'jobseeker', 
        'Alice Johnson'
    ),
    (   'company2@example.com', 
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW', 
        'company', 
        'NextGen Solutions'
    ),
    (   'company3@example.com', 
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW', 
        'company', 
        'Innovate Tech'
    ),
    (   'company4@example.com', 
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW', 
        'company', 
        'Creative Minds'
    ),
    (   'jobseeker4@example.com', 
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW', 
        'jobseeker', 
        'Bob Brown'
    ),
    (   'jobseeker5@example.com', 
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW', 
        'jobseeker', 
        'Charlie Davis'
    ),
    (   'jobseeker6@example.com', 
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW', 
        'jobseeker', 
        'Diana Evans'
    ),
    (
        'jobseeker7@example.com',
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW',
        'jobseeker',
        'Eve Carter'
    ),
    (
        'jobseeker8@example.com',
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW',
        'jobseeker',
        'Frank Moore'
    ),
    (
        'company5@example.com',
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW',
        'company',
        'Tech Innovations'
    ),
    (
        'company6@example.com',
        '$2y$10$R7JArDscT9lePEQy0dOKnuh3TmbIgBckwgu4DiOgS2BpjdCevEdVW',
        'company',
        'Future Vision'
    );

INSERT INTO
    companydetail (user_id, lokasi, about)
VALUES
    (
        2,
        'Jakarta, Indonesia',
        'We are a leading company in the tech industry.'
    ),
    (   5, 
        'Bali, Indonesia', 
        'Providing tech solutions for businesses.'
    ),
    (
        6,
        'Cyberjaya, Malaysia',
        'Leading tech firm developing the next generation of software solutions.'
    ),
    (
        7,
        'Bangkok, Thailand',
        'Innovators in sustainable technology.'
    ),
    (
        13,
        'Singapore',
        'Creating disruptive technologies for various industries.'
    ),
    (
        14,
        'Ho Chi Minh City, Vietnam',
        'Positive impact through technology and consultancy.'
    );

INSERT INTO
    lowongan (
        company_id,
        company_name,
        posisi,
        deskripsi,
        jenis_pekerjaan,
        jenis_lokasi,
        is_open
    )
VALUES
    (
        2,
        'Company Inc.',
        'Software Engineer',
        'Responsible for developing applications.',
        'Full-time',
        'Remote',
        TRUE
    ),
    (
        2,
        'Company Inc.',
        'Data Analyst',
        'Analyze and interpret complex data.',
        'Part-time',
        'On-site',
        TRUE
    ),
    (
        2,
        'Company Inc.',
        'Product Manager',
        'Manage product development and strategy.',
        'Internship',
        'Hybrid',
        TRUE
    ),
    (
        5,
        'NextGen Solutions',
        'AI Engineer',
        'Develop AI models and algorithms.',
        'Full-time',
        'Remote',
        TRUE
    ),
    (
        5,
        'NextGen Solutions',
        'Mobile App Developer',
        'Create and maintain mobile applications.',
        'Full-time',
        'On-site',
        TRUE
    ),
    (
        5,
        'NextGen Solutions',
        'Social Media Manager',
        'Manage social media accounts and create content.',
        'Part-time',
        'Remote',
        TRUE
    ),
    (
        6,
        'Innovate Tech',
        'System Analyst',
        'Analyze and improve business operations.',
        'Internship',
        'Hybrid',
        TRUE
    ),
    (
        6,
        'Innovate Tech',
        'System Analyst',
        'Analyze and improve business operations.',
        'Internship',
        'Hybrid',
        TRUE
    ),
    (
        6,
        'Innovate Tech',
        'Web Designer',
        'Design the layout of websites and applications.',
        'Full-time',
        'On-site',
        TRUE
    ),
    (
        7,
        'Creative Minds',
        'Frontend Developer',
        'Build user-facing applications with responsiveness and performance in mind.',
        'Full-time',
        'Remote',
        TRUE
    ),
    (
        7,
        'Creative Minds',
        'DevOps Engineer',
        'Manage deployments and operational efficiency for software applications.',
        'Full-time',
        'On-site',
        TRUE
    ),
    (
        7,
        'Creative Minds',
        'UX/UI Designer',
        'Design user interfaces and enhance user experience across platforms.',
        'Part-time',
        'Remote',
        TRUE
    ),
    (
        13,
        'Tech Innovations',
        'Full Stack Developer',
        'Collaborate across the full software stack.',
        'Full-time',
        'Hybrid',
        TRUE
    ),
    (
        13,
        'Tech Innovations',
        'Network Administrator',
        'Manage and support the company’s network infrastructure.',
        'Full-time',
        'On-site',
        TRUE
    ),
    (
        14,
        'Future Vision',
        'Technical Project Manager',
        'Oversee projects from initiation to closure ensuring delivery.',
        'Internship',
        'Hybrid',
        TRUE
    );

INSERT INTO
    attachmentlowongan (lowongan_id, file_path)
VALUES
    (1, '/path/to/attachment_1.png'),
    (2, '/path/to/attachment_2.png'),
    (3, '/path/to/attachment_3.png'),
    (4, '/path/to/attachment_4.png'),
    (5, '/path/to/attachment_5.png'),
    (6, '/path/to/attachment_6.png'),
    (7, '/path/to/attachment_7.png'),
    (8, '/path/to/attachment_8.png'),
    (9, '/path/to/attachment_9.png'),
    (10, '/path/to/attachment_10.png'),
    (11, '/path/to/attachment_11.png'),
    (12, '/path/to/attachment_12.png'),
    (13, '/path/to/attachment_13.png'),
    (14, '/path/to/attachment_14.png'),
    (15, '/path/to/attachment_15.png');

INSERT INTO
    lamaran (user_id, lowongan_id, status, status_reason, cv_path, video_path)
VALUES
    (1, 1, 'waiting', NULL, '/storage/cv/lamaran_1.pdf','/storage/cv/lamaran_1.mp4' ),
    (1, 2, 'waiting', NULL , '/storage/cv/lamaran_2.pdf','/storage/cv/lamaran_2.mp4'),
    (3, 3, 'accepted', 'Great fit for the team.', '/storage/cv/lamaran_3.pdf',NULL),
    (4, 4, 'waiting', NULL, '/storage/cv/lamaran_4.pdf','/storage/cv/lamaran_4.mp4'),
    (1, 5, 'accepted', 'Excellent qualifications for the role.', '/storage/cv/lamaran_5.pdf', NULL),
    (3, 6, 'waiting', NULL, '/storage/cv/lamaran_6.pdf', '/storage/cv/lamaran_6.mp4'),
    (3, 7, 'waiting', NULL, '/storage/cv/lamaran_7.pdf', '/storage/cv/lamaran_7.mp4'),
    (8, 8, 'rejected', 'Lacked specific experience.', '/storage/cv/lamaran_8.pdf', NULL),
    (8, 9, 'waiting', NULL, '/storage/cv/lamaran_9.pdf', '/storage/cv/lamaran_9.mp4'),
    (4, 10, 'accepted', 'Strong portfolio.', '/storage/cv/lamaran_10.pdf', NULL),
    (12, 11, 'waiting', NULL, '/storage/cv/lamaran_11.pdf', '/storage/cv/lamaran_11.mp4'),
    (1, 12, 'waiting', NULL, '/storage/cv/lamaran_12.pdf', '/storage/cv/lamaran_12.mp4'),
    (10, 13, 'accepted', 'Excellent skills match.', '/storage/cv/lamaran_13.pdf', NULL),
    (11, 14, 'rejected', 'Insufficient experience.', '/storage/cv/lamaran_14.pdf', NULL),
    (4, 14, 'waiting', NULL, '/storage/cv/lamaran_15.pdf', '/storage/cv/lamaran_15.mp4'),
    (9, 1, 'waiting', NULL, '/storage/cv/lamaran_11.pdf', '/storage/cv/lamaran_11.mp4'),
    (1, 2, 'waiting', NULL, '/storage/cv/lamaran_12.pdf', '/storage/cv/lamaran_12.mp4'),
    (3, 3, 'accepted', 'Excellent skills match.', '/storage/cv/lamaran_13.pdf', NULL),
    (11, 4, 'rejected', 'Insufficient experience.', '/storage/cv/lamaran_14.pdf', NULL),
    (4, 5, 'waiting', NULL, '/storage/cv/lamaran_15.pdf', '/storage/cv/lamaran_15.mp4');;