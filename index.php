<!-- index.php - Homepage with domain search bar -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoDaddy Clone - Homepage</title>
    <style>
        /* Internal CSS - Professional, real-looking, amazing design */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; color: #333; }
        header { background-color: #007bff; color: white; padding: 20px; text-align: center; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .search-bar { display: flex; justify-content: center; margin: 20px 0; }
        .search-bar input { width: 60%; padding: 10px; font-size: 18px; border: 1px solid #ccc; border-radius: 4px 0 0 4px; }
        .search-bar button { padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 0 4px 4px 0; cursor: pointer; }
        .search-bar button:hover { background-color: #218838; }
        .extensions { text-align: center; margin: 20px 0; }
        .extensions span { margin: 0 10px; font-weight: bold; color: #007bff; }
        .promotions { background-color: #fff; border: 1px solid #ddd; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .promotions h3 { color: #ff5722; }
        .pricing { display: flex; justify-content: space-around; flex-wrap: wrap; }
        .plan { background-color: #e9ecef; padding: 15px; margin: 10px; border-radius: 8px; text-align: center; width: 200px; transition: transform 0.3s; }
        .plan:hover { transform: scale(1.05); box-shadow: 0 6px 12px rgba(0,0,0,0.15); }
        .nav { text-align: right; padding: 10px; }
        .nav a { color: white; margin: 0 10px; text-decoration: none; }
        .nav a:hover { text-decoration: underline; }
        @media (max-width: 768px) { .search-bar input { width: 70%; } .pricing { flex-direction: column; align-items: center; } }
    </style>
</head>
<body>
    <header>
        <h1>GoDaddy Clone</h1>
        <div class="nav">
            <a href="#" onclick="redirectTo('login.php')">Login</a>
            <a href="#" onclick="redirectTo('register.php')">Register</a>
        </div>
    </header>
    <div class="container">
        <form action="search.php" method="POST" class="search-bar">
            <input type="text" name="domain" placeholder="Search for your domain..." required>
            <button type="submit">Search</button>
        </form>
        <div class="extensions">
            Popular extensions: <span>.com</span> <span>.net</span> <span>.org</span> <span>.io</span> <span>.app</span>
        </div>
        <div class="promotions">
            <h3>Special Promotions</h3>
            <p>Get .com domains for just $0.99 for the first year!</p>
            <div class="pricing">
                <div class="plan">
                    <h4>Basic</h4>
                    <p>$9.99/year</p>
                </div>
                <div class="plan">
                    <h4>Premium</h4>
                    <p>$19.99/year</p>
                </div>
                <div class="plan">
                    <h4>Business</h4>
                    <p>$29.99/year</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Internal JS for redirection
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
