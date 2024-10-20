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
    );

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
    );

INSERT INTO
    lowongan (
        company_id,
        posisi,
        deskripsi,
        jenis_pekerjaan,
        jenis_lokasi,
        is_open
    )
VALUES
    (
        2,
        'Software Engineer',
        'Responsible for developing applications.',
        'Full-time',
        'Remote',
        TRUE
    ),
    (
        2,
        'Data Analyst',
        'Analyze and interpret complex data.',
        'Part-time',
        'On-site',
        TRUE
    ),
    (
        2,
        'Product Manager',
        'Manage product development and strategy.',
        'Contract',
        'Hybrid',
        TRUE
    );

INSERT INTO
    attachmentlowongan (lowongan_id, file_path)
VALUES
    (1, '/path/to/resume_1.pdf'),
    (1, '/path/to/cover_letter_1.pdf'),
    (2, '/path/to/resume_2.pdf');

INSERT INTO
    lamaran (user_id, lowongan_id, status, status_reason)
VALUES
    (1, 1, 'waiting', NULL),
    (1, 2, 'waiting', NULL),
    (3, 1, 'accepted', 'Great fit for the team.'),
    (2, 1, 'waiting', NULL);