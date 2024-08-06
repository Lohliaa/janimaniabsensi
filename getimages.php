<?php
// Function to get list of images from a folder, sorted by modification time
function getImagesFromFolder($folder) {
    $images = [];
    if (is_dir($folder)) {
        if ($dh = opendir($folder)) {
            while (($file = readdir($dh)) !== false) {
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $images[$file] = filemtime($folder . '/' . $file);
                }
            }
            closedir($dh);
        }
    }
    // Sort images by modification time, newest first
    arsort($images);
    return array_keys($images);
}

// Handle AJAX request to get images
if(isset($_GET['action']) && $_GET['action'] == 'get_images') {
    $imageFolder = 'img'; // Make sure this is the correct path to your images folder
    $images = getImagesFromFolder($imageFolder);
    echo json_encode($images);
    exit;
}
?>
