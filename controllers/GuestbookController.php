<?php

namespace Controllers;

use models\Guestbook;

class GuestbookController
{
    private Guestbook $guestbook;

    public function __construct()
    {
        $this -> guestbook = new Guestbook();
    }

    public function homePage()
    {
        $entries = $this->guestbook->getAllEntries();

        $template = "views/guestbook/home";
        require "views/layout.phtml";
    }

    public function submitEntry()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $message = $_POST['message'] ?? '';
            $imagePath = '';
    
            if (!empty($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../public/upload/';
                $filename = time() . '_' . basename($_FILES['photo']['name']);
                $uploadFile = $uploadDir . $filename;
                $ext = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
                if (in_array($ext, $allowed)) {
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                        $imagePath = 'upload/' . $filename;
                    }
                }
            }
    
            $this->guestbook->addEntry($name, $message, $imagePath);
        }
    
        header('Location: /home');
        exit;
    }

    public function gallery()
    {
        $entries = $this->guestbook->getAllEntries();
        $template = "views/guestbook/gallery";
        require "views/layout.phtml";
    }

    public function notFound() {
        // Logic to handle 404 error
        echo "Page not found!";
    }

    // Helper function to render the view
    private function view(string $view, array $data = [])
    {
        // Assuming your views are located in app/views
        extract($data);
        require_once '../app/views/' . $view . '.php';
    }
}
