<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publication</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-100 text-gray-800">
<div class="overflow-y-auto max-h-screen p-6" id="publicationList">
    <?php foreach ($publications as $publication): ?>
        <div class="border-2 border-purple-500 rounded-lg shadow-lg p-6 mb-6 bg-gradient-to-r from-white to-purple-100">
            <!-- Username and actions -->
            <div class="flex justify-between items-center mb-4">
                <div class="flex space-x-4">
                    <h5 class="text-2xl font-bold text-purple-700"><?= $publication['username'] ?></h5>
                </div>
                <p class="text-sm font-medium text-gray-500"><?= $publication['publication_date'] ?></p>
                <div class="flex space-x-3">
                <?php if ($publication['user_id'] == $_SESSION['user_id']): ?>
                    <a href="../../controllers/publicationsController.php?action=detailUpdate&id=<?= $publication['id'] ?>" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="../../controllers/publicationsController.php?action=delete&id=<?= $publication['id'] ?>&image=<?= $publication['image'] ?>" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </a>
                <?php endif; ?>
                </div>
            </div>

            <!-- Publication content -->
            <div class="bg-purple-50 rounded-lg p-4">
                <h4 class="text-xl font-bold text-purple-600 text-center mb-4"><?= $publication["title"] ?></h4>
                <p class="text-gray-700"><?= $publication["content"] ?></p>
                <img src="../<?= $publication["image"] ?>" alt="Publication image" class="my-6 mx-auto rounded-lg shadow-md">
            </div>

            <!-- Reactions and comments -->
            <div class="flex justify-between items-center space-x-4 mb-4">
                <!-- Reaction Form -->
                <div class="flex items-center space-x-4">
                    <label class="flex items-center space-x-1 cursor-pointer">
                        <a href="../../controllers/publicationsController.php?action=react&reaction=like&idpublication=<?= $publication['id'] ?>&user_id=<?= $publication['user_id'] ?>">
                            <i class="fa-solid fa-thumbs-up text-blue-600 hover:text-blue-800 text-lg"></i>
                        </a>
                        <span><?= $reaction_counts['like'] == 0 ? '' : $reaction_counts['like'] ?></span>
                    </label>
                    
                    <label class="flex items-center space-x-1 cursor-pointer">
                        <a href="../../controllers/publicationsController.php?action=react&reaction=love&idpublication=<?= $publication['id'] ?>&user_id=<?= $publication['user_id'] ?>">
                            <i class="fa-solid fa-heart text-red-600 hover:text-red-800 text-lg"></i>
                        </a>
                        <span><?= $reaction_counts['love'] == 0 ? '' : $reaction_counts['love'] ?></span>
                    </label>

                    <label class="flex items-center space-x-1 cursor-pointer">
                        <a href="../../controllers/publicationsController.php?action=react&reaction=sad&idpublication=<?= $publication['id'] ?>&user_id=<?= $publication['user_id'] ?>">
                            <i class="fa-solid fa-face-sad-tear text-yellow-500 hover:text-yellow-700 text-lg"></i>
                        </a>
                        <span><?= $reaction_counts['sad'] == 0 ? '' : $reaction_counts['sad'] ?></span>
                    </label>

                    <label class="flex items-center space-x-1 cursor-pointer">
                        <a href="../../controllers/publicationsController.php?action=react&reaction=funny&idpublication=<?= $publication['id'] ?>&user_id=<?= $publication['user_id'] ?>">
                            <i class="fa-solid fa-face-laugh-squint text-green-500 hover:text-green-700 text-lg"></i>
                        </a>
                        <span><?= $reaction_counts['funny'] == 0 ? '' : $reaction_counts['funny'] ?></span>
                    </label>
                </div>

                <button onclick="toggleCommentSection(<?= $publication['id'] ?>)" class="text-gray-600 hover:text-gray-800">
                    <i class="fa-solid fa-comment text-2xl"></i>
                </button>
            </div>

            <!-- Hidden Comment Section -->
            <div id="comment-section-<?= $publication['id'] ?>" class="hidden mt-4">
                <form action="../../controllers/publicationsController.php?action=create" method="post" class="flex flex-col space-y-2">
                    <input type="text" name="content" placeholder="Écrire un commentaire..." class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <input type="hidden" name="publication_id" value="<?= $publication['id']?>" required>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Envoyer</button>
                </form>

                <!-- List of Comments -->
                <ul class="pl-5 space-y-2 mt-4">
                    <?php foreach($comments as $comment): ?>
                        <?php if ($comment['publication_id'] == $publication['id']): ?>
                            <li class="bg-gray-100 rounded-md p-3 shadow-sm">
                                <span class="font-semibold"><?= $comment['username']; ?></span>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center space-x-1 cursor-pointer">
                                            <a href="../../controllers/publicationsController.php?action=react&reaction=like&idpubli=<?= $publication['id'] ?>&idcomment=<?= $comment['id'] ?>&user_id=<?= $publication['user_id'] ?>">
                                                <i class="fa-solid fa-thumbs-up text-blue-600 hover:text-blue-800 text-lg"></i>
                                            </a>
                                            <span><?= $reaction_counts['like'] == 0 ? '' : $reaction_counts['like'] ?></span>
                                        </label>
                                    </div>

                                    <?php if ($comment['user_id'] == $_SESSION['user_id']): ?>
                                        <div class="flex space-x-2 mt-2">
                                            <button onclick="toggleCommentAble(<?= $comment['id'] ?>)" class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="../../controllers/publicationsController.php?action=delete&idcomment=<?= $comment['id'] ?>" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    <?php endforeach; ?>
</div>

<script>
    function toggleCommentSection(id) {
        const commentSection = document.getElementById(`comment-section-${id}`);
        commentSection.classList.toggle('hidden');
    }
</script>
</body>
</html>
