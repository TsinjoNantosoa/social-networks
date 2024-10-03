<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <style>
        body {
            background: linear-gradient(135deg, #FF6B6B, #FFD93D, #6BCB77); /* Combination of colors */
            background-size: cover;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-opacity-50">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg bg-opacity-90">
        <a href="javascript:history.back()" class="flex items-center text-gray-500 hover:text-gray-700 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
        
        <h1 class="text-3xl font-bold text-blue-600 mb-6 text-center">Edit Profile</h1>

        <form class="space-y-4" action="../../controllers/userController.php?action=update" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="profile_image" class="block text-gray-700">Profile Picture:</label>
                <img id="image_preview" src="../<?= $users['profile_image'] ?>" alt="Image Preview" class="mt-4 w-12 h-12 rounded-full">
                <input type="file" id="profile_image" name="profile_image" value="<?= $users['profile_image'] ?>" class="w-full p-2 border border-gray-300 rounded-lg" accept="image/*" onchange="previewImage(event)">
            </div>
            <div class="mb-4">
                <label for="lastname" class="block text-gray-700">Last Name:</label>
                <input type="text" id="lastname" name="lastname" value="<?= $users['lastname'] ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="firstname" class="block text-gray-700">First Name:</label>
                <input type="text" id="firstname" name="firstname" value="<?= $users['firstname'] ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="date_of_birth" class="block text-gray-700">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?= $users['date_of_birth'] ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username:</label>
                <input type="text" id="username" name="username" value="<?= $users['username'] ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password:</label>
                <input type="password" id="password" name="password" value="<?= $users['password'] ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Update
            </button>
        </form>
    </div>

    <script src="../../script.js"></script>
</body>
</html>
