<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    // Fetch the username from the database
    $conn = new mysqli('localhost', 'root', '', 'cybersecurity_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT username FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $username = $user['username'];
    } else {
        $username = "User";
    }
    $conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cybersecurity Tools Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">CyberSec Tools Hub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#categories">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </ul>
            </div>
        </div>
    </nav>

    <section id="home" class="hero-section text-center text-light">
        <div class="container">
            <h1 style="color: black;">Welcome to Cybersecurity Tools Hub</h1>
            <p style="color: black;">Your one-stop resource for cybersecurity tools categorized for easy navigation</p>
            <a href="#categories" class="btn btn-primary btn-lg">Explore Tools</a>
        </div>
    </section>

    <section id="categories" class="container my-5">
        <h2 class="text-center mb-4">Tool Categories</h2>
    
        <div class="row">
    
            <!-- Brute Force Tools -->
            <div class="col-md-4">
                <div class="card">
                    <img src="bruteforce.jpg" class="card-img-top" alt="Brute Force Tools">
                    <div class="card-body">
                        <h5 class="card-title">Brute Force Tools</h5>
                        <p class="card-text">Explore tools like Hydra, John the Ripper, and more for brute force attacks.</p>
                        <a href="#" class="btn btn-dark">Learn More</a>
                    </div>
                </div>
            </div>
    
            <!-- SQL Injection Tools -->
            <div class="col-md-4">
                <div class="card">
                    <img src="sqlinjection.jpg" class="card-img-top" alt="SQL Injection Tools">
                    <div class="card-body">
                        <h5 class="card-title">SQL Injection Tools</h5>
                        <p class="card-text">Discover tools like SQLmap, Havij, and more for SQL injection testing.</p>
                        <a href="#" class="btn btn-dark">Learn More</a>
                    </div>
                </div>
            </div>
    
            <!-- Network Scanning Tools -->
            <div class="col-md-4">
                <div class="card">
                    <img src="networkscan.jpg" class="card-img-top" alt="Network Scanning Tools">
                    <div class="card-body">
                        <h5 class="card-title">Network Scanning Tools</h5>
                        <p class="card-text">Find tools like Nmap, Netcat, and more for network scanning and analysis.</p>
                        <a href="#" class="btn btn-dark">Learn More</a>
                    </div>
                </div>
            </div>
    
            <!-- Social Engineering Tools -->
            <div class="col-md-4">
                <div class="card">
                    <img src="socialengineering.jpg" class="card-img-top" alt="Social Engineering Tools">
                    <div class="card-body">
                        <h5 class="card-title">Social Engineering Tools</h5>
                        <p class="card-text">Discover tools like SET, Metasploit, and others for social engineering attacks.</p>
                        <a href="#" class="btn btn-dark">Learn More</a>
                    </div>
                </div>
            </div>
    
            <!-- Packet Sniffing Tools -->
            <div class="col-md-4">
                <div class="card">
                    <img src="packetsniffing.jpg" class="card-img-top" alt="Packet Sniffing Tools">
                    <div class="card-body">
                        <h5 class="card-title">Packet Sniffing Tools</h5>
                        <p class="card-text">Explore tools like Wireshark, Tcpdump, and others for packet sniffing.</p>
                        <a href="#" class="btn btn-dark">Learn More</a>
                    </div>
                </div>
            </div>
    
            <!-- Forensic Tools -->
            <div class="col-md-4">
                <div class="card">
                    <img src="forensics.jpg" class="card-img-top" alt="Forensic Tools">
                    <div class="card-body">
                        <h5 class="card-title">Forensic Tools</h5>
                        <p class="card-text">Explore tools like Autopsy, FTK Imager, and more for digital forensics.</p>
                        <a href="#" class="btn btn-dark">Learn More</a>
                    </div>
                </div>
            </div>
    
            <!-- Wireless Security Tools -->
            <div class="col-md-4">
                <div class="card">
                    <img src="wirelesssecurity.jpg" class="card-img-top" alt="Wireless Security Tools">
                    <div class="card-body">
                        <h5 class="card-title">Wireless Security Tools</h5>
                        <p class="card-text">Explore tools like Aircrack-ng, Kismet, and others for wireless security testing.</p>
                        <a href="#" class="btn btn-dark">Learn More</a>
                    </div>
                </div>
            </div>
    
            <!-- Password Cracking Tools -->
            <div class="col-md-4">
                <div class="card">
                    <img src="passwordcracking.jpg" class="card-img-top" alt="Password Cracking Tools">
                    <div class="card-body">
                        <h5 class="card-title">Password Cracking Tools</h5>
                        <p class="card-text">Discover tools like Hashcat, John the Ripper, and more for password cracking.</p>
                        <a href="#" class="btn btn-dark">Learn More</a>
                    </div>
                </div>
            </div>
    
            <!-- Web Application Testing Tools -->
            <div class="col-md-4">
                <div class="card">
                    <img src="webapptesting.jpg" class="card-img-top" alt="Web Application Testing Tools">
                    <div class="card-body">
                        <h5 class="card-title">Web Application Testing Tools</h5>
                        <p class="card-text">Explore tools like OWASP ZAP, Burp Suite, and others for web application testing.</p>
                        <a href="#" class="btn btn-dark">Learn More</a>
                    </div>
                </div>
            </div>
    
            <!-- Vulnerability Assessment Tools -->
            <div class="col-md-4">
                <div class="card">
                    <img src="vulnassessment.jpg" class="card-img-top" alt="Vulnerability Assessment Tools">
                    <div class="card-body">
                        <h5 class="card-title">Vulnerability Assessment Tools</h5>
                        <p class="card-text">Discover tools like Nessus, OpenVAS, and others for vulnerability assessments.</p>
                        <a href="#" class="btn btn-dark">Learn More</a>
                    </div>
                </div>
            </div>
    
        </div>
    </section>
    
    
    <footer id="contact" class="bg-dark text-light text-center py-4">
        <div class="container">
            <p>Cybersecurity Tools Hub &copy; 2024</p>
            <p>Email: support@cybersectools.com | Phone: +123 456 7890</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
