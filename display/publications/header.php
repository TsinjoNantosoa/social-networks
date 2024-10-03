<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<header class="bg-indigo-700 text-white py-4 px-8 sticky top-0 z-10 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Profile Section -->
        <div class="text-lg flex space-x-4 items-center">
            <img src="../<?= $_SESSION['profile_image'] ?>" alt="Profile Image" class="w-10 h-10 rounded-full">
            <span class="font-semibold"><?php echo $_SESSION["username"] ?></span>
        </div>

        <!-- Search and Navigation -->
        <div class="flex items-center space-x-8">
            <form class="flex items-center border border-gray-300 hidden" action="../../controllers/publicationsController.php?action=search" method="post" id="searchinput">
                <input type="text" id="search" name="search" placeholder="Search publication..." class="w-full border-none focus:outline-none p-2 text-gray-800">
            </form>
            <button onclick="toggleSearch()">
                <i class="fas fa-search text-white"></i>
            </button>
            <a href="../../controllers/publicationsController.php?action=read" class="text-white hover:text-gray-300 font-bold text-lg">All</a>
            <button onclick="toggleSetting()" class="text-white hover:text-gray-300 font-bold text-lg">
                Setting
            </button>
            <!-- Logout Link Directly in the Header -->
            <a href="../../controllers/userController.php?action=logout" class="text-white hover:text-gray-300 font-bold text-lg">
                Logout
            </a>
        </div>

        <!-- User Settings Dropdown (Hidden by Default) -->
        <div id="settingUsers" class="flex flex-col space-y-4 bg-indigo-500 p-4 rounded-lg shadow-lg max-w-sm absolute right-8 top-16 hidden">
            <a href="../../controllers/userController.php?action=detailUpdate" class="text-gray-200 hover:text-gray-100">
                Edit <?php echo $_SESSION["username"]; ?>
            </a>
            <a href="../../controllers/userController.php?action=delete" class="text-red-400 hover:text-red-300">
                Delete <?php echo $_SESSION["username"]; ?>
            </a>
        </div>
    </div>
</header>

<script>
    // Toggle the search input visibility
    function toggleSearch() {
        var searchInput = document.getElementById('searchinput');
        if (searchInput.classList.contains('hidden')) {
            searchInput.classList.remove('hidden');
        } else {
            searchInput.classList.add('hidden');
        }
    }

    // Toggle the settings menu visibility
    function toggleSetting() {
        var settingMenu = document.getElementById('settingUsers');
        if (settingMenu.classList.contains('hidden')) {
            settingMenu.classList.remove('hidden');
        } else {
            settingMenu.classList.add('hidden');
        }
    }
</script>
</body>
</html>
