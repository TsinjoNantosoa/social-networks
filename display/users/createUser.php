<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
</head>
<body class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 min-h-[90vh] flex items-center justify-center">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <a href="javascript:history.back()" class="flex items-center text-gray-500 hover:text-gray-700 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>

        <h1 class="text-3xl font-bold text-blue-600 mb-6 text-center">Registration</h1>

        <form class="space-y-4" action="../../controllers/userController.php?action=create" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="profile_image" class="block text-gray-700">Profile Picture:</label>
                <div class="flex items-center justify-center bg-gray-100 p-4 rounded-full w-32 h-32 mx-auto">
                    <img id="image_preview" src="../../public/img/profile/default.png" alt="Image Preview" class="w-28 h-28 object-cover rounded-full">
                </div>
                <input type="file" id="profile_image" name="profile_image" class="w-full p-2 mt-4 border border-gray-300 rounded-lg" accept="image/*" onchange="previewImage(event)">
            </div>
            <div class="mb-4">
                <label for="lastname" class="block text-gray-700">Last Name:</label>
                <input type="text" id="lastname" name="lastname" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="firstname" class="block text-gray-700">First Name:</label>
                <input type="text" id="firstname" name="firstname" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="date_of_birth" class="block text-gray-700">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <span class="block text-gray-700">Gender:</span>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" id="male" name="sex" value="male" class="text-blue-600" required>
                        <span class="ml-2 text-gray-700">Male</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" id="female" name="sex" value="female" class="text-blue-600" required>
                        <span class="ml-2 text-gray-700">Female</span>
                    </label>
                </div>
            </div>
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username:</label>
                <input type="text" id="username" name="username" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password:</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Register
            </button>
        </form>
    </div>

    <script src="../../public/javascript/script.js"></script>
</body>
</html>
