import { messageFade } from "./errorMessage.js";

// Image manager
const uploadImageFile = document.getElementById('uploadImageFile');
const uploadedImagesCont = document.getElementById('imagePreviewCont');
const uploadImageInput = document.getElementById('uploadImageInput');
const imageURL = document.getElementById('imageURL');
const submitImageURL = document.getElementById('submitImageURL');
const submitBtn = document.getElementById('submitBtn');

// Upload image
function uploadImage(target, files = []) {
    // Handle image file input
    if (target.id == 'uploadImageInput') {
        // Create objectURL and validate each file uploaded
        for (let i = 0; i < target.files.length; i++) {
            files = validateImgs(target.files[i]);
        }
    }
    // Drag and drop upload
    else if (files.length > 0) {
        for (i = 0; i < files.length; i++) {
            validateImgs((files[i]));
        }
    }
}

function validateImgs(file) {
    // Validate image by attempting to create an HTML image element
    let imgs = new Image();
    imgs.src = URL.createObjectURL(file);
    
    // Valid image file/URL
    imgs.onload = function() {
        createImagePreview(imgs.src, file['name']);
    };
    
    // Invalid image file/URL
    imgs.onerror = function() {
        deleteFiles(file); // Remove invalid file
        messageFade('Error', 'Invalid image file/URL');
    };
}

// Append image to HTML
function createImagePreview(file, name) {
    // Create image object and set src
    const imageCont = document.createElement('div');
    imageCont.className = 'imageCont';

    // Save name of image, this is used to identify the image, if it's deleted
    imageCont.dataset.name = name;

    // Create image
    const image = document.createElement('img');
    image.className = 'imageCont';
    image.src = file;
    imageCont.appendChild(image);

    // Create delete btn
    const btn = document.createElement('button');
    btn.className = 'btnRed deleteImageBtn deleteBtn fa fa-trash';
    btn.addEventListener('onclick', deleteImagePreview(this));
    imageCont.appendChild(btn);

    // Append image to HTML
    uploadedImagesCont.appendChild(imageCont);

    // Enable upload btn
    submitBtn.removeAttribute('disabled');
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
    uploadImageInput.files = event.dataTransfer.files; // Add file to file input
    uploadImage('dropUpload', event.dataTransfer.files);
}


// Delete image
function deleteImagePreview(target) {
    // Get image (deleteImageBtn -> imageCont)
    const imageCont = target.parentElement;

    // Remove the image container from the DOM
    imageCont.remove();
    // Remove image from file input
    deleteFiles(null, target);
}

// Add event listeners, this ensures HTML elements can run function, while script is a module
document.addEventListener('DOMContentLoaded', () => {
    // Add event listener for drag events on uploadLabel
    // const uploadLabel = document.getElementById('uploadLabel');
    uploadImageFile.addEventListener('dragover', event => dragOver(event));
    uploadImageFile.addEventListener('dragenter', event => dragEnter(event));
    uploadImageFile.addEventListener('dragleave', event => dragLeave(event));
    uploadImageFile.addEventListener('drop', event => dropFile(event));

    // Add event listener to file input
    uploadImageInput.addEventListener('change', uploadImage(this))
});

// Delete file from input
function deleteFiles(fileName = null, target = null) {
    // If target is true, delete was called by image delete btn, so we use the targeted image to get the name
    // Otherwise, the delete function was called because of rejected image
    if (target) {
        fileName = target.parentElement.dataset.name;
    }

    // Remove corresponding file from the input files array
    const newFiles = Array.from(uploadImageInput.files);
    const fileIndex = newFiles.indexOf(fileName)
    newFiles.splice(fileIndex, 1);

    // Construct a new FileList from the remaining files
    const newFileList = new DataTransfer();
    newFiles.forEach(file => {
        newFileList.items.add(file);
    });

    // Update the input's files property with the new FileList
    uploadImageInput.files = newFileList.files;

    // Disable upload btn if no images remain
    if (uploadImageInput.files.length == 0) {
        submitBtn.setAttribute('disabled', true);
    }
}

// Check if upload btn should be disable or enabled on page load
// This should hopefully prevent issues with cache
window.onload = () => {
    if (uploadImageInput.files.length == 0) {
        submitBtn.setAttribute('disabled', true);
    }
    else {
        submitBtn.setAttribute('disabled', false);
    }
}