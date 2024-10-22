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
        status VARCHAR(50) CHECK (status IN ('accepted', 'rejected', 'waiting')),
        status_reason TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

CREATE INDEX idx_user_email ON users (email);

CREATE INDEX idx_lowongan_company ON lowongan (company_id);

INSERT INTO
    users (email, password, role, nama)
VALUES
    (
        'jobseeker@example.com',
        'hashed_password_1',
        'jobseeker',
        'John Doe'
    ),
    (
        'company@example.com',
        'hashed_password_2',
        'company',
        'Company Inc.'
    ),
    (
        'jobseeker2@example.com',
        'hashed_password_3',
        'jobseeker',
        'Jane Smith'
    ),
    ('jobseeker3@example.com', 'hashed_password_4', 'jobseeker', 'Alice Johnson'),
    ('jobseeker4@example.com', 'hashed_password_5', 'jobseeker', 'Bob Brown'),
    ('jobseeker5@example.com', 'hashed_password_6', 'jobseeker', 'Charlie Davis'),
    ('jobseeker6@example.com', 'hashed_password_7', 'jobseeker', 'Diana Evans'),
    ('company2@example.com', 'hashed_password_8', 'company', 'NextGen Solutions'),
    ('company3@example.com', 'hashed_password_9', 'company', 'Innovate Tech'),
    ('company4@example.com', 'hashed_password_10', 'company', 'Creative Minds');

INSERT INTO
    companydetail (user_id, lokasi, about)
VALUES
    (
        2,
        'Jakarta, Indonesia',
        'We are a leading company in the tech industry.'
    ),
    (
        2,
        'Bandung, Indonesia',
        'Innovative solutions for modern problems.'
    ),
    (5, 'Medan, Indonesia', 'A startup focused on AI solutions.'),
    (6, 'Bali, Indonesia', 'Providing tech solutions for businesses.'),
    (7, 'Jakarta, Indonesia', 'Creative agency offering innovative marketing solutions.');

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
        6,
        'Innovate Tech',
        'Mobile App Developer',
        'Create and maintain mobile applications.',
        'Full-time',
        'On-site',
        TRUE
    ),
    (
        7,
        'Creative Minds',
        'Social Media Manager',
        'Manage social media accounts and create content.',
        'Part-time',
        'Remote',
        TRUE
    ),
    (
        5,
        'NextGen Solutions',
        'System Analyst',
        'Analyze and improve business operations.',
        'Internship',
        'Hybrid',
        TRUE
    ),
    (
        1,
        'NextGen Solutions',
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
    );

INSERT INTO
    attachmentlowongan (lowongan_id, file_path)
VALUES
    (1, '/path/to/resume_1.pdf'),
    (1, '/path/to/cover_letter_1.pdf'),
    (2, '/path/to/resume_2.pdf'),
    (4, '/path/to/resume_4.pdf'),
    (4, '/path/to/cover_letter_4.pdf'),
    (5, '/path/to/resume_5.pdf'),
    (6, '/path/to/resume_6.pdf');

INSERT INTO
    lamaran (user_id, lowongan_id, status, status_reason, cv_path, video_path)
VALUES
    (1, 1, 'waiting', NULL, '/storage/cv/lamaran_1.pdf','/storage/cv/lamaran_1.mp4' ),
    (1, 2, 'waiting', NULL , '/storage/cv/lamaran_2.pdf','/storage/cv/lamaran_2.mp4'),
    (3, 1, 'accepted', 'Great fit for the team.', '/storage/cv/lamaran_3.pdf',NULL),
    (2, 1, 'waiting', NULL, '/storage/cv/lamaran_4.pdf','/storage/cv/lamaran_4.mp4'),
    (1, 3, 'accepted', 'Excellent qualifications for the role.', '/storage/cv/lamaran_5.pdf', NULL),
    (2, 5, 'waiting', NULL, '/storage/cv/lamaran_6.pdf', '/storage/cv/lamaran_6.mp4'),
    (3, 4, 'waiting', NULL, '/storage/cv/lamaran_7.pdf', '/storage/cv/lamaran_7.mp4'),
    (5, 6, 'rejected', 'Lacked specific experience.', '/storage/cv/lamaran_8.pdf', NULL),
    (6, 8, 'waiting', NULL, '/storage/cv/lamaran_9.pdf', '/storage/cv/lamaran_9.mp4'),
    (4, 7, 'accepted', 'Strong portfolio.', '/storage/cv/lamaran_10.pdf', NULL);