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