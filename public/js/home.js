const photoInput = document.getElementById('photoInput');
const fileUploadText = document.getElementById('file-upload-text');

fileUploadText.parentElement.addEventListener('click', () => {
    photoInput.click();
});

photoInput.addEventListener('change', () => {
    const file = photoInput.files[0];
    if (file) {
        fileUploadText.textContent = file.name;
    } else {
        fileUploadText.textContent = "📷 Ajouter une photo";
    }
});