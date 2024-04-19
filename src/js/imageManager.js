// Image manager
const uploadImageFile = document.getElementById('uploadImageFile');
const uploadedImagesCont = document.getElementById('uploadedImagesCont');
const uploadImageInput = document.getElementById('uploadImageInput');
const imageURL = document.getElementById('imageURL');
const submitImageURL = document.getElementById('submitImageURL');

// Upload image
function uploadImage(target, files = []) {
    // Handle image file input
    if (target.id == 'uploadImageInput') {
        // Create objectURL and validate each file uploaded
        for (let i = 0; i < target.files.length; i++) {
            files = URL.createObjectURL(target.files[i]);
            validateImgs(files);
        }
    }
    // Handle image URL input
    else if (target.id == 'submitImageURL') {
        // Define file and validate
        files = imageURL[index].value;
        validateImgs(files, index);
    }
    // Load images from question (Dosen't need verification)
    else if (target == 'loadImgs') {
        for (i = 0; i < files.length; i++) {
            createImagePreview(files[i], index);
        }
    }
    // Drag and drop upload
    else if (files.length > 0) {
        for (i = 0; i < files.length; i++) {
            validateImgs(URL.createObjectURL(files[i]));
        }
    }
}

// Drag image to upload
function dragOver(event) {
    event.preventDefault(); // Prevent setting image path as URL
}
  
function dragEnter(event) {
    event.preventDefault(); // Prevent setting image path as URL
    uploadImageFile.classList.add('dragHighlight');
}
  
function dragLeave(event) {
    event.preventDefault(); // Prevent setting image path as URL
    uploadImageFile.classList.remove('dragHighlight');
}
  
function dropFile(event) {
    event.preventDefault(); // Prevent setting image path as URL
    uploadImageFile.classList.remove('dragHighlight');
    uploadImageInput.files = event.dataTransfer.files;
    uploadImage('dropUpload', event.dataTransfer.files);
}

function validateImgs(file) {
    // Check if it's a valid image file/URL
    let imgs = new Image();
    imgs.src = file;
    
    // Valid image file/URL
    imgs.onload = function() {
        createImagePreview(file);
    };
    // Invalid image file/URL
    // imgs.onerror = function() {
    //     messageFade('Error', 'Invalid image file/URL')
    // };
}

// Append image to HTML
function createImagePreview(file) {
    // Create image object and set src
    let imageCont = document.createElement('div');
    imageCont.className = 'imageCont';
    imageCont.innerHTML = `<img class="previewImage" src="${file}">
                        <button class="btnRed deleteImageBtn deleteBtn fa fa-trash" onclick="deleteImage(this)"></button>`;

    // Append image to HTML
    uploadedImagesCont.appendChild(imageCont);
}

// Delete image
function deleteImage(target) {
    // Get image and delete it (deleteImageBtn -> imageCont)
    target.parentElement.remove();
}