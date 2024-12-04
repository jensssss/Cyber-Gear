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
<title>CyberGear - Cryptography Tools</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
    *, *::after, *::before {
        box-sizing: border-box;
    }
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #0a0a0a;
        color: #fff;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        overflow-x: hidden;
        justify-content: center;
        align-items: center;
        transition: background-color 0.3s ease;
    }

    header {
        background-color: #333;
        color: #00FF99;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 20;
        min-width: 100%;
        max-width: 1200px;
        box-shadow: 0 4px 15px rgba(0, 255, 153, 0.3);
        border-bottom: 2px solid #00FF99;
        transition: all 0.3s ease-in-out;
    }

    header h1 {
        font-size: 28px;
        margin: 0;
        color: #00FF99;
        text-shadow: 0 0 5px rgba(0, 255, 153, 0.8);
    }

    header button {
        background-color: #444;
        border: none;
        color: white;
        padding: 10px 20px;
        cursor: pointer;
        margin-left: 10px;
        font-size: 14px;
        transition: background-color 0.3s ease;
        border-radius: 5px;
    }

    header button:hover {
        background-color: #00FF99;
        color: #333;
        box-shadow: 0 0 10px rgba(0, 255, 153, 0.6);
    }

    nav.menu-bar {
        width: 100%;
        background-color: #111;
        color: #fff;
        font-weight: 700;
        padding: 10px 0;
        display: flex;
        justify-content: center;
        z-index: 10;
        border-top: 3px solid #00FF99;
        box-shadow: 0 4px 10px rgba(0, 255, 153, 0.5);
    }

    nav.menu-bar ul {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    nav.menu-bar li {
        padding: 15px 25px;
        margin: 0 1em;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        border-radius: 5px;
    }

    nav.menu-bar li a {
        text-decoration: none;
        color: #fff;
    }

    nav.menu-bar li:hover {
        background-color: #00FF99;
    }

    nav.menu-bar li:hover > a {
        color: #111;
    }

    nav.menu-bar li.active, nav.menu-bar li.active a{
        background-color: #00FF99;
        color: #111;
    }

    /* Hide menu by default on small screens */
    nav.menu-bar .menu-list {
        display: none;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
    }

    /* Show the menu when toggled */
    nav.menu-bar.active .menu-list {
        display: flex;
    }

    /* Style for the hamburger menu */
    nav.menu-bar .menu-toggle {
        display: none;
        font-size: 30px;
        color: #fff;
        background-color: transparent;
        border: none;
        cursor: pointer;
        z-index: 30;
    }

    main {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
        margin-left: 0;
        width: 100%;
        max-width: 1200px;
        transition: all 0.3s ease-in-out;
    }

    section {
        width: 100%;
        padding: 20px;
        text-align: center;
    }

    section h1 {
        margin-bottom: 20px;
        font-size: 36px;
        color: #00FF99;
        text-shadow: 0 0 10px rgba(0, 255, 153, 0.8);
        animation: glow 1.5s ease-in-out infinite alternate;
    }

    section p {
        font-size: 20px;
        line-height: 1.6;
        color: #ddd;
    }

    .os-section {
        margin-top: 3em;
    }

    .os-section h2 {
        font-size: 28px;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        margin-bottom: 15px;
        padding: 10px 20px;
        border-radius: 5px;
        text-shadow: 2px 2px 6px rgba(0, 255, 153, 0.6), 0 0 15px rgba(0, 255, 153, 0.8);
        animation: glowAnimation 1.5s ease-in-out infinite alternate;
    }

    @keyframes glowAnimation {
        0% {
            text-shadow: 2px 2px 6px rgba(0, 255, 153, 0.6), 0 0 15px rgba(0, 255, 153, 0.8);
        }
        100% {
            text-shadow: 0 0 10px rgba(0, 255, 153, 1), 0 0 20px rgba(0, 255, 153, 0.8), 0 0 30px rgba(0, 255, 153, 0.6);
        }
    }

    .tool-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 30px;
        justify-items: center;
        animation: fadeIn 1s ease-in-out;
    }

    .tool-item {
        background-color: #222;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 255, 153, 0.3);
        border-radius: 8px;
        width: 100%;
        max-width: 350px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .tool-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 255, 153, 0.6);
    }

    .tool-item h3 {
        margin-top: 0;
        color: #00FF99;
        font-size: 24px;
        text-shadow: 0 0 5px rgba(0, 255, 153, 0.8);
    }

    .tool-item p {
        font-size: 16px;
        color: #bbb;
        margin: 10px 0;
    }

    .tool-item a {
        color: #00FF99;
        font-weight: bold;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .tool-item a:hover {
        color: #fff;
        text-decoration: underline;
    }

    .tool-item img {
        width: auto;
        max-width: 90%;
        height: 5em;
        border-radius: 8px;
        margin-bottom: 1em;
    }

    footer {
        background-color: #111;
        color: #fff;
        padding: 20px;
        text-align: center;
        width: 100%;
        position: relative;
        bottom: 0;
    }

    .footer-content p {
        margin: 10px 0;
        font-size: 16px;
        color: #bbb;
    }

    .footer-content ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
    }

    .footer-content ul li {
        margin: 0 15px;
    }

    .footer-content ul li a {
        color: #00FF99;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s ease;
    }

    .footer-content ul li a:hover {
        color: #fff;
        text-decoration: underline;
    }

    @keyframes glow {
        0% {
        text-shadow: 0 0 5px rgba(0, 255, 153, 0.8);
        }
        100% {
        text-shadow: 0 0 20px rgba(0, 255, 153, 1);
        }
    }

    @keyframes fadeIn {
        0% {
        opacity: 0;
        transform: translateY(20px);
        }
        100% {
        opacity: 1;
        transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .menu-bar ul {
            flex-direction: column;
            align-items: flex-start;
        }

        header {
            display: none;
        }

        .menu-bar li {
            padding: 10px;
            font-size: 16px;
        }

        nav.menu-bar {
            position: fixed; /* Fix the navigation bar to the top of the screen */
            top: 0; /* Align to the top */
            left: 0;
            right: 0;
            background-color: #111;
            box-shadow: 0 4px 10px rgba(0, 255, 153, 0.5);
            z-index: 20; /* Ensure it stays above the content */
        }

        nav.menu-bar .menu-toggle {
            display: block; /* Show the hamburger menu button */
        }

        nav.menu-bar ul {
            display: none; /* Hide the navigation items by default */
            flex-direction: column;
            padding: 10px;
            background-color: #111;
            position: absolute;
            top: 60px; /* Align the menu under the hamburger button */
            left: 0;
            right: 0;
            z-index: 20;
        }

        nav.menu-bar.active ul {
            display: flex; /* Show the menu when active */
        }

        section h1 {
            font-size: 28px;
        }

        section p {
            font-size: 16px;
        }

        .tool-item h3 {
            font-size: 18px;
        }

        .tool-list {
            grid-template-columns: 1fr; /* Stack tools vertically */
        }

        .tool-item {
            width: 90%;  /* Make items take up more space */
        }

        button, a {
            touch-action: manipulation; /* Improve touch interaction */
        }

        .tool-item img {
            max-width: 100%;  /* Make images responsive */
            height: auto;
        }

        /* Add padding to the top of the content to avoid overlap with the fixed menu */
        main {
            padding-top: 120px; /* Ensure there’s enough space for both the header and the fixed menu */
        }
    }
</style>
</head>
<body>

<header>
    <h1>CyberGear</h1>
    <div>
    <button>Home</button>
    <button onClick="window.location.href='logout.php';">Logout</button>
    </div>
</header>

<nav class="menu-bar">
    <button class="menu-toggle" aria-label="Toggle navigation">&#9776;</button> <!-- Hamburger menu button -->
    <ul>
    <li><a href="../Cyber-Gear/forensic.html">Forensic</a></li>
    <li><a href="../Cyber-Gear/network-security.html">Network Security</a></li>
    <li><a href="../Cyber-Gear/osint.html">OSINT</a></li>
    <li><a href="../Cyber-Gear/vulnerability-assessment.html">Vulnerability Assessment</a></li>
    <li><a href="../Cyber-Gear/cryptography.html">Cryptography</a></li>
    </ul>
</nav>  

<main>
    <section>
    <h1>Cybersecurity Tools</h1>
    <p>Below are categorized cybersecurity tools commonly used for various purposes. Each category highlights reliable and widely used tools across different platforms and operating systems.</p>


    <div id="linux" class="os-section">
        <!-- <h2>Linux</h2> -->
        <div class="tool-list">
        <div class="tool-item">
            <img src="https://w1.pngwing.com/pngs/70/795/png-transparent-internet-logo-computer-network-computer-network-diagram-telecommunications-network-networking-hardware-user-local-area-network-management.png" alt="GnuPG Logo">
            <h3><a href="../Cyber-Gear/network-security.html">Network Security</a></h3>
            <p>This category includes tools that focus on monitoring, securing, and protecting networks from potential threats. They help detect unauthorized access, prevent cyberattacks, and maintain the integrity of network communications. Examples include firewalls, intrusion detection systems (IDS), and network analyzers.</p>
        </div>
        <div class="tool-item">
            <img src="data:image/jpeg;base64,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" alt="OpenSSL Logo">
            <h3><a href="../Cyber-Gear/vulnerability-assessment.html">Vulnerability Assesment</a></h3>
            <p>These tools are essential for identifying weaknesses in systems, applications, or networks. They provide detailed reports on potential risks, allowing organizations to proactively address security gaps before they are exploited. Common examples include vulnerability scanners, penetration testing tools, and compliance checkers.</p>
        </div>
        <div class="tool-item">
            <img src="data:image/jpeg;base64,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" alt="Cryptsetup Logo">
            <h3><a href="../Cyber-Gear/osint.html">OSINT</a></h3>
            <p>Open Source Intelligence tools specialize in collecting and analyzing publicly available information from online sources, such as social media, websites, and databases. They are widely used for threat intelligence, investigations, and tracking cybercriminal activities. These tools are invaluable for both ethical hackers and investigators.</p>
        </div>
        <div class="tool-item">
            <img src="data:image/jpeg;base64,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" alt="Cryptsetup Logo">
            <h3><a href="../Cyber-Gear/forensic.html">Forensic</a></h3>
            <p>Digital forensic tools are designed to recover, analyze, and preserve electronic data in a manner suitable for legal proceedings. They are used to investigate cybercrimes, trace attackers, and provide evidence in court cases. Examples include data recovery tools, disk imaging software, and forensic analysis suites.</p>
        </div>
        <div class="tool-item">
            <img src="data:image/png;base64,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" alt="Cryptsetup Logo">
            <h3><a href="../Cyber-Gear/cryptography.html">Cryptography</a></h3>
            <p>Cryptography tools are critical for securing sensitive data through encryption and decryption. They ensure data privacy, protect communications, and verify the authenticity of information. From encrypting files to generating secure keys, these tools are a cornerstone of modern cybersecurity practices.</p>
        </div>
        </div>
    </div>

    </section>
</main>
<footer>
    <div class="footer-content">
    <p>&copy; 2024 CyberGear. All rights reserved.</p>
    <ul>
        <li><a href="#">Terms & Conditions</a></li>
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">Contact Us</a></li>
    </ul>
    </div>
</footer>

<script>
    const menuToggle = document.querySelector('.menu-toggle');
    const menuBar = document.querySelector('.menu-bar');

    menuToggle.addEventListener('click', () => {
    menuBar.classList.toggle('active');
    });
</script>  
</body>
</html>