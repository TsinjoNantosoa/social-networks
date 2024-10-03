<?php
if (isset($_GET['token']) && isset($_GET['expires'])) {
    $token = $_GET['token'];
    $expires = $_GET['expires'];
    ?>
    <form action="../../controllers/passwordController.php?action=reset_password" method="POST">
    <input type="hidden" name="token" value="<?php echo $token; ?>">
    <input type="hidden" name="expires" value="<?php echo $expires; ?>">
        <label for="password">Nouveau mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Réinitialiser</button>
    </form>
    <?php
} else {
    echo "Token invalide.";
}
?>
