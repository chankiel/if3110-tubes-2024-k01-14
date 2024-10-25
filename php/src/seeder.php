<?php

require 'config.php';

try {
    $pdo->beginTransaction();

    $users = [
        ['email' => 'user1@example.com', 'password' => password_hash('password1', PASSWORD_DEFAULT), 'role' => 'jobseeker', 'nama' => 'User One'],
        ['email' => 'user2@example.com', 'password' => password_hash('password2', PASSWORD_DEFAULT), 'role' => 'company', 'nama' => 'Company One'],
        ['email' => 'user3@example.com', 'password' => password_hash('password3', PASSWORD_DEFAULT), 'role' => 'jobseeker', 'nama' => 'User Two'],
        ['email' => 'user4@example.com', 'password' => password_hash('password4', PASSWORD_DEFAULT), 'role' => 'jobseeker', 'nama' => 'User Three'],
        ['email' => 'user5@example.com', 'password' => password_hash('password5', PASSWORD_DEFAULT), 'role' => 'company', 'nama' => 'Company Two'],
        ['email' => 'user6@example.com', 'password' => password_hash('password6', PASSWORD_DEFAULT), 'role' => 'jobseeker', 'nama' => 'User Four'],
        ['email' => 'user7@example.com', 'password' => password_hash('password7', PASSWORD_DEFAULT), 'role' => 'jobseeker', 'nama' => 'User Five'],
        ['email' => 'user8@example.com', 'password' => password_hash('password8', PASSWORD_DEFAULT), 'role' => 'jobseeker', 'nama' => 'User Six'],
        ['email' => 'user9@example.com', 'password' => password_hash('password9', PASSWORD_DEFAULT), 'role' => 'company', 'nama' => 'Company Three'],
        ['email' => 'user10@example.com', 'password' => password_hash('password10', PASSWORD_DEFAULT), 'role' => 'jobseeker', 'nama' => 'User Seven']
    ];

    $sql = "INSERT INTO users (email, password, role, nama) VALUES (:email, :password, :role, :nama) ON CONFLICT (email) DO NOTHING";
    $stmt = $pdo->prepare($sql);
    
    foreach ($users as $user) {
        $stmt->execute([
            ':email' => $user['email'],
            ':password' => $user['password'],
            ':role' => $user['role'],
            ':nama' => $user['nama']
        ]);
    }

    $companyDetails = [
        [ 'user_id' => 2, 'lokasi' => 'Location 1', 'about' => 'About Company One' ],
        [ 'user_id' => 5, 'lokasi' => 'Location 2', 'about' => 'About Company Two' ],
        [ 'user_id' => 9, 'lokasi' => 'Location 3', 'about' => 'About Company Three' ]
    ];

    $sql = "INSERT INTO companydetail (user_id, lokasi, about) VALUES (:user_id, :lokasi, :about) ON CONFLICT (user_id) DO NOTHING";
    $stmt = $pdo->prepare($sql);
    
    foreach ($companyDetails as $detail) {
        $stmt->execute([
            ':user_id' => $detail['user_id'],
            ':lokasi' => $detail['lokasi'],
            ':about' => $detail['about']
        ]);
    }

    $vacancies = [
        [ 'company_id' => 2, 'company_name' => 'Company One', 'posisi' => 'Software Engineer', 'deskripsi' => 'Develop and maintain software applications.', 'jenis_pekerjaan' => 'Full-Time', 'jenis_lokasi' => 'Remote', 'is_open' => true ],
        [ 'company_id' => 5, 'company_name' => 'Company Two', 'posisi' => 'Data Analyst', 'deskripsi' => 'Analyze data and provide insights.', 'jenis_pekerjaan' => 'Part-Time', 'jenis_lokasi' => 'On-Site', 'is_open' => true ],
        [ 'company_id' => 9, 'company_name' => 'Company Three', 'posisi' => 'Web Developer', 'deskripsi' => 'Build and maintain web applications.', 'jenis_pekerjaan' => 'Full-Time', 'jenis_lokasi' => 'Remote', 'is_open' => true ],
        [ 'company_id' => 2, 'company_name' => 'Company One', 'posisi' => 'Product Manager', 'deskripsi' => 'Oversee product development.', 'jenis_pekerjaan' => 'Full-Time', 'jenis_lokasi' => 'Hybrid', 'is_open' => true ],
        [ 'company_id' => 5, 'company_name' => 'Company Two', 'posisi' => 'Marketing Specialist', 'deskripsi' => 'Manage marketing campaigns.', 'jenis_pekerjaan' => 'Full-Time', 'jenis_lokasi' => 'Remote', 'is_open' => true ],
        [ 'company_id' => 9, 'company_name' => 'Company Three', 'posisi' => 'Graphic Designer', 'deskripsi' => 'Create visual concepts.', 'jenis_pekerjaan' => 'Freelance', 'jenis_lokasi' => 'Remote', 'is_open' => true ],
        [ 'company_id' => 2, 'company_name' => 'Company One', 'posisi' => 'System Administrator', 'deskripsi' => 'Administer and maintain IT systems.', 'jenis_pekerjaan' => 'Full-Time', 'jenis_lokasi' => 'On-Site', 'is_open' => true ],
        [ 'company_id' => 5, 'company_name' => 'Company Two', 'posisi' => 'Customer Support', 'deskripsi' => 'Assist customers with queries.', 'jenis_pekerjaan' => 'Part-Time', 'jenis_lokasi' => 'Remote', 'is_open' => true ],
        [ 'company_id' => 9, 'company_name' => 'Company Three', 'posisi' => 'Sales Executive', 'deskripsi' => 'Drive sales and meet targets.', 'jenis_pekerjaan' => 'Full-Time', 'jenis_lokasi' => 'On-Site', 'is_open' => true ],
        [ 'company_id' => 2, 'company_name' => 'Company One', 'posisi' => 'Network Engineer', 'deskripsi' => 'Manage and optimize network systems.', 'jenis_pekerjaan' => 'Full-Time', 'jenis_lokasi' => 'On-Site', 'is_open' => true ]
    ];

    $sql = "INSERT INTO lowongan (company_id, company_name, posisi, deskripsi, jenis_pekerjaan, jenis_lokasi, is_open) VALUES (:company_id, :company_name, :posisi, :deskripsi, :jenis_pekerjaan, :jenis_lokasi, :is_open) ON CONFLICT (id) DO NOTHING";
    $stmt = $pdo->prepare($sql);
    
    foreach ($vacancies as $vacancy) {
        $stmt->execute([
            ':company_id' => $vacancy['company_id'],
            ':company_name' => $vacancy['company_name'],
            ':posisi' => $vacancy['posisi'],
            ':deskripsi' => $vacancy['deskripsi'],
            ':jenis_pekerjaan' => $vacancy['jenis_pekerjaan'],
            ':jenis_lokasi' => $vacancy['jenis_lokasi'],
            ':is_open' => $vacancy['is_open']
        ]);
    }

    $attachments = [
        [ 'lowongan_id' => 1, 'file_path' => '/path/to/resume1.pdf' ],
        [ 'lowongan_id' => 2, 'file_path' => '/path/to/resume2.pdf' ],
        [ 'lowongan_id' => 3, 'file_path' => '/path/to/resume3.pdf' ],
        [ 'lowongan_id' => 4, 'file_path' => '/path/to/resume4.pdf' ],
        [ 'lowongan_id' => 5, 'file_path' => '/path/to/resume5.pdf' ],
        [ 'lowongan_id' => 6, 'file_path' => '/path/to/resume6.pdf' ],
        [ 'lowongan_id' => 7, 'file_path' => '/path/to/resume7.pdf' ],
        [ 'lowongan_id' => 8, 'file_path' => '/path/to/resume8.pdf' ],
        [ 'lowongan_id' => 9, 'file_path' => '/path/to/resume9.pdf' ],
        [ 'lowongan_id' => 10, 'file_path' => '/path/to/resume10.pdf' ]
    ];

    $sql = "INSERT INTO attachmentlowongan (lowongan_id, file_path) VALUES (:lowongan_id, :file_path) ON CONFLICT (lowongan_id) DO NOTHING";
    $stmt = $pdo->prepare($sql);

    foreach ($attachments as $attachment) {
        $stmt->execute([
            ':lowongan_id' => $attachment['lowongan_id'],
            ':file_path' => $attachment['file_path']
        ]);
    }

    $applications = [
        [ 'user_id' => 1, 'lowongan_id' => 1, 'cv_path' => '/path/to/cv1.pdf', 'video_path' => '/path/to/video1.mp4', 'status' => 'waiting'],
        [ 'user_id' => 1, 'lowongan_id' => 2, 'cv_path' => '/path/to/cv2.pdf', 'video_path' => '/path/to/video2.mp4', 'status' => 'waiting'],
        [ 'user_id' => 2, 'lowongan_id' => 3, 'cv_path' => '/path/to/cv3.pdf', 'video_path' => '/path/to/video3.mp4', 'status' => 'accepted'],
        [ 'user_id' => 3, 'lowongan_id' => 4, 'cv_path' => '/path/to/cv4.pdf', 'video_path' => '/path/to/video4.mp4', 'status' => 'rejected'],
        [ 'user_id' => 4, 'lowongan_id' => 5, 'cv_path' => '/path/to/cv5.pdf', 'video_path' => '/path/to/video5.mp4', 'status' => 'waiting'],
        [ 'user_id' => 5, 'lowongan_id' => 6, 'cv_path' => '/path/to/cv6.pdf', 'video_path' => '/path/to/video6.mp4', 'status' => 'waiting'],
        [ 'user_id' => 6, 'lowongan_id' => 7, 'cv_path' => '/path/to/cv7.pdf', 'video_path' => '/path/to/video7.mp4', 'status' => 'waiting'],
        [ 'user_id' => 7, 'lowongan_id' => 8, 'cv_path' => '/path/to/cv8.pdf', 'video_path' => '/path/to/video8.mp4', 'status' => 'accepted'],
        [ 'user_id' => 8, 'lowongan_id' => 9, 'cv_path' => '/path/to/cv9.pdf', 'video_path' => '/path/to/video9.mp4', 'status' => 'rejected'],
        [ 'user_id' => 9, 'lowongan_id' => 10, 'cv_path' => '/path/to/cv10.pdf', 'video_path' => '/path/to/video10.mp4', 'status' => 'waiting']
    ];

    $sql = "INSERT INTO lamaran (user_id, lowongan_id, cv_path, video_path, status) VALUES (:user_id, :lowongan_id, :cv_path, :video_path, :status) ON CONFLICT (id) DO NOTHING";
    $stmt = $pdo->prepare($sql);

    foreach ($applications as $application) {
        $stmt->execute([
            ':user_id' => $application['user_id'],
            ':lowongan_id' => $application['lowongan_id'],
            ':cv_path' => $application['cv_path'],
            ':video_path' => $application['video_path'],
            ':status' => $application['status']
        ]);
    }

    $pdo->commit();
    echo "Database seeded successfully!";
} catch (\PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Error: " . $e->getMessage();
}
