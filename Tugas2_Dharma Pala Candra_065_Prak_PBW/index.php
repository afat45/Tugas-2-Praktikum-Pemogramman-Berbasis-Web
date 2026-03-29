<?php
// Koneksi ke Database
$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan jika menggunakan default Laragon
$db   = "tugas_pbw";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil Data Profile
$profileRes = $conn->query("SELECT * FROM profile LIMIT 1");
$profile = $profileRes->fetch_assoc();

// Ambil Data Skills
$skills = [];
$skillsRes = $conn->query("SELECT * FROM skills");
while($row = $skillsRes->fetch_assoc()) { $skills[] = $row; }

// Ambil Data Experience
$experience = [];
$expRes = $conn->query("SELECT * FROM experience");
while($row = $expRes->fetch_assoc()) { $experience[] = $row; }

// Ambil Data Certificates
$certificates = [];
$certRes = $conn->query("SELECT * FROM certificates");
while($row = $certRes->fetch_assoc()) { $certificates[] = $row; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio | <?php echo $profile['name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">{{ profile.name }}</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About Me</a></li>
                        <li class="nav-item"><a class="nav-link" href="#certificates">Certificates</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <section id="home" class="hero-section d-flex align-items-center">
            <div class="container text-center">
                <img :src="profile.image" alt="Profile" class="profile-img mb-4 shadow">
                <h1 class="display-4 fw-bold">Hi, I'm {{ profile.name }}</h1>
                <p class="lead">{{ profile.tagline }}</p>
            </div>
        </section>

        <section id="about" class="py-5">
            <div class="container">
                <h2 class="text-center mb-5">About Me</h2>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <p>{{ profile.description }}</p>
                        <h4 class="mt-4">Experience</h4>
                        <ul class="list-group list-group-flush">
                            <li v-for="exp in experience" :key="exp.id" class="list-group-item bg-transparent">
                                <strong>{{ exp.year }}</strong> - {{ exp.title }}
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Skills</h4>
                        <div v-for="skill in skills" :key="skill.id" class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>{{ skill.name }}</span>
                                <span>{{ skill.level }}%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" :style="{ width: skill.level + '%' }"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="certificates" class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-5">Certificates</h2>
                <div class="row g-4">
                    <div class="col-md-4" v-for="cert in certificates" :key="cert.id">
                        <div class="card h-100 shadow-sm border-0">
                            <img :src="cert.image" class="card-img-top" alt="Certificate">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ cert.title }}</h5>
                                <p class="card-text text-muted small">{{ cert.issuer }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-dark text-white text-center py-4">
            <p>&copy; 2026 {{ profile.name }}. Built with PHP & Vue</p>
        </footer>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script>
        const { createApp } = Vue
        createApp({
            data() {
                return {
                    // Mengonversi data PHP ke JSON agar bisa digunakan Vue
                    profile: <?php echo json_encode($profile); ?>,
                    skills: <?php echo json_encode($skills); ?>,
                    experience: <?php echo json_encode($experience); ?>,
                    certificates: <?php echo json_encode($certificates); ?>
                }
            }
        }).mount('#app')
    </script>
</body>
</html>