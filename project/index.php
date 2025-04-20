<?php
require_once 'class/Element.php';
require_once 'class/Weapon.php';
require_once 'class/Character.php';

$element = new Element();
$weapon = new Weapon();
$character = new Character();

// handle element request
if (isset($_GET['page']) && $_GET['page'] === 'elements') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_element'])) {
            if ($element->add($_POST['name'], $_POST['strength'], $_POST['weakness'])) {
                header("Location: ?page=elements&success=Element added successfully");
                exit();
            }
        }
        
        if (isset($_POST['update_element'])) {
            if ($element->update($_POST['id'], $_POST['name'], $_POST['strength'], $_POST['weakness'])) {
                header("Location: ?page=elements&success=Element updated successfully");
                exit();
            }
        }
    }
    
    if (isset($_GET['delete_element'])) {
        if ($element->delete($_GET['delete_element'])) {
            header("Location: ?page=elements&success=Element deleted successfully");
            exit();
        }
    }
}

// handle weapon request
if (isset($_GET['page']) && $_GET['page'] === 'weapons') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_weapon'])) {
            if ($weapon->add($_POST['name'], $_POST['type'], $_POST['power'])) {
                header("Location: ?page=weapons&success=Weapon added successfully");
                exit();
            }
        }
        
        if (isset($_POST['update_weapon'])) {
            if ($weapon->update($_POST['id'], $_POST['name'], $_POST['type'], $_POST['power'])) {
                header("Location: ?page=weapons&success=Weapon updated successfully");
                exit();
            }
        }
    }
    
    if (isset($_GET['delete_weapon'])) {
        if ($weapon->delete($_GET['delete_weapon'])) {
            header("Location: ?page=weapons&success=Weapon deleted successfully");
            exit();
        }
    }
}

// handle character request
if (isset($_GET['page']) && $_GET['page'] === 'characters') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_character'])) {
            if ($character->add($_POST['name'], $_POST['hp'], $_POST['level'], $_POST['element_id'], $_POST['weapon_id'])) {
                header("Location: ?page=characters&success=Character added successfully");
                exit();
            }
        }
        
        if (isset($_POST['update_character'])) {
            if ($character->update($_POST['id'], $_POST['name'], $_POST['hp'], $_POST['level'], $_POST['element_id'], $_POST['weapon_id'])) {
                header("Location: ?page=characters&success=Character updated successfully");
                exit();
            }
        }
    }
    
    if (isset($_GET['delete_character'])) {
        if ($character->delete($_GET['delete_character'])) {
            header("Location: ?page=characters&success=Character deleted successfully");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Character Database</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-serif flex flex-col min-h-screen">
    <!-- Header -->
    <?php include 'view/header.php'; ?>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto p-6 flex-grow">
        <!-- <h2 class="text-3xl font-semibold mb-6 text-center text-gray-800">Welcome to Character Database</h2> -->

        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $allowed_pages = ['elements', 'weapons', 'characters'];
            if (in_array($page, $allowed_pages)) {
                include "view/$page.php";
            }
        }
        ?>
    </main>

    <!-- Footer -->
    <?php include 'view/footer.php'; ?>
</body>
</html>