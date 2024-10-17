# Tugas Besar IF3110 2024/2025

## How to run
1. Buat database dulu, bebas namanya
2. Buat file .env, isi sesuai .env.example
3. run docker compose up --build
4. open http://localhost

## Endpoints
### General

|Endpoint|Deskripsi|Body|Param|
|---|---|---|---|
|GET ```/```|Tampilan home (Company / Jobseeker)|-|-|
|GET ```/login```|Page login|-|-|
|GET ```/register```|Page register|-|-|
|POST ```/login```|Menghandle request login dari pengguna|```credentials```|-|
|POST ```/logout```|Menghandle request logout dari pengguna|-|-|

### Company
#### FrontEnd
|Endpoint|Deskripsi|Body|Param|
|---|---|---|---|
|GET ```/jobs/add```|Page Tambah Lowongan|-|-|
|GET ```/jobs/edit/:id```|Page Edit Lowongan|-|```jobId```|
|GET ```/jobs/:id```|Page Company Detail Lowongan|-|```jobId```|
|GET ```/applications/:id```|Page Company Detail Lamaran|-|```applicationId```|
|GET ```/profile/company```|Page Company Detail Lamaran|-|-|

#### Backend
|Endpoint|Deskripsi|Body|Param|
|---|---|---|---|
|POST ```/jobs```|Menambah lowongan baru|```posisi```,```deskripsi```,```jenis_pekerjaan```,```jenis_lokasi```,```attachment(s)```|-|
|PUT ```/jobs/:id```|Mengedit lowongan|```posisi```,```deskripsi```,```jenis_pekerjaan```,```jenis_lokasi```,```attachment(s)```|```jobId```|
|PUT ```/applications/:id/approve```|Approve suatu lamaran|-|```applicationId```|
|PUT ```/applications/:id/reject```|Reject suatu lamaran|-|```applicationId```|
|PUT ```/profile/company```|Page Company Detail Lamaran|```nama```,```lokasi```,```about```|-|

### Job Seeker
#### FrontEnd
|Endpoint|Deskripsi|Body|Param|
|---|---|---|---|
|GET ```/jobs/:id/details```|page Jobseeker Detail Lowongan|-|```jobId```|
|GET ```/jobs/:id/apply```|Page Form Lamaran|-|```jobId```|
|GET ```/applications```|Page Riwayat lamaran|-|-|

#### Backend
|Endpoint|Deskripsi|Body|Param|
|---|---|---|---|
|POST ```/jobs/:id/apply```|Menambah lowongan baru|```CV```,```video```|```jobId```|
