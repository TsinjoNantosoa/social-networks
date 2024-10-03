<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>
<body class="bg-gradient-to-r from-blue-500 to-purple-600 min-h-screen flex items-center justify-center">
    <div class="loader-container hidden fixed top-0 left-0 right-0 bottom-0 bg-white bg-opacity-75 flex justify-center items-center z-50">
        <div class="spinner border-8 border-t-8 border-white rounded-full w-12 h-12 animate-spin"></div>
    </div>
    <div class="bg-white bg-opacity-90 rounded-lg shadow-lg p-8 max-w-sm w-full">
        <h1 class="text-3xl font-bold text-blue-600 mb-6 text-center">Login</h1>
        <form id="login" action="controllers/userController.php?action=login" method="post">
            <div class="mb-4">
                <input type="email" name="email" placeholder="Email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" placeholder="Password" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <div class="flex justify-between mb-4">
                <button 
                    class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200" 
                    type="button" 
                    onclick="window.location.href='display/users/password_reset_request.php'">Forgot Password?</button>
            </div>
            <div class="flex justify-between">
                <button class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200" type="submit">Login</button>
                <a href="display/users/createUser.php" class="bg-blue-600 text-white py-2 px-4 rounded-lg text-center block hover:bg-blue-700 transition duration-200">Sign Up</a>
            </div>
        </form>   
    </div>

    <style>
        .spinner {
            border-top-color: #3498db; /* Spinner color */
        }
    </style>
</body>
</html>
