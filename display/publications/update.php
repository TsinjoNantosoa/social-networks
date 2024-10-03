<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des étudiants</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-100 font-sans h-screen">

    <div class="container mx-auto px-6 py-3 h-full">
        <div class="flex h-full">
            <div class="w-screen  pr-4">
                <!-- Formulaire de modification -->
                <div id="form-modification" class="bg-white p-6 rounded-lg shadow-md h-auto flex flex-col justify-center items-center py-24">
                    <div class="flex justify-between w-1/2">
                        <h2 class="text-2xl font-bold text-grenat-600 mb-4">Formulaire de modification</h2>
                        <a href="../../controllers/publicationsController.php?action=read" class="text-2xl font-bold text-grenat-600 mb-4"><i class="fas fa-arrow fa-arrow-right"></i></a>
                    </div>
                    <form action="../../controllers/publicationsController.php?action=update&id=<?= $publicationDetails["id"] ?>&image=<?= $publicationDetails["image"] ?>" method="POST" class="w-1/2 h-full" enctype="multipart/form-data">
                        <div class="mb-4">
                            <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded-lg" value="<?= $publicationDetails["title"]?>" required>
                        </div>
                        <div class="mb-4">
                            <textarea id="content" name="content" class="w-full p-2 border border-gray-300 rounded-lg" rows="5" required><?= $publicationDetails["content"]?></textarea>
                        </div>
                        <div class="mb-4">
                            <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded-lg" accept="image/*" onchange="previewImage(event)">
                            <img id="image_preview" src="../<?= $publicationDetails["image"] ?>" alt="" class="mt-4 w-12 h-12">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white p-2 rounded-lg w-full">Modification</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="../../script.js"></script>
</body>
</html>
