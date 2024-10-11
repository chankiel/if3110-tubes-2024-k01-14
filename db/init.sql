CREATE TABLE IF NOT EXISTS "user" (
    user_id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) CHECK (role IN ('jobseeker', 'company')) NOT NULL,
    nama VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS "companydetail" (
    user_id INT REFERENCES "user"(user_id) ON DELETE CASCADE,
    lokasi VARCHAR(255),
    about TEXT
);

CREATE TABLE IF NOT EXISTS "lowongan" (
    lowongan_id SERIAL PRIMARY KEY,
    company_id INT REFERENCES "user"(user_id) ON DELETE CASCADE,
    posisi VARCHAR(255),
    deskripsi TEXT,
    jenis_pekerjaan VARCHAR(255),
    jenis_lokasi VARCHAR(255),
    is_open BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS "attachmentlowongan" (
    attachment_id SERIAL PRIMARY KEY,
    lowongan_id INT REFERENCES "lowongan"(lowongan_id) ON DELETE CASCADE,
    file_path TEXT
);

CREATE TABLE IF NOT EXISTS "lamaran" (
    lamaran_id SERIAL PRIMARY KEY,
    user_id INT REFERENCES "user"(user_id) ON DELETE CASCADE,
    lowongan_id INT REFERENCES "lowongan"(lowongan_id) ON DELETE CASCADE,
    cv_path TEXT,
    video_path TEXT,
    status VARCHAR(50) CHECK (status IN ('accepted', 'rejected', 'waiting')),
    status_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_user_email ON "user"(email);

CREATE INDEX idx_lowongan_company ON "lowongan"(company_id);