import { messageFade } from "./errorMessage.js";

// Image manager
const uploadImageFile = document.getElementById('uploadImageFile');
const uploadedImagesCont = document.getElementById('imagePreviewCont');
const uploadImageInput = document.getElementById('uploadImageInput');
const imageURL = document.getElementById('imageURL');
const submitImageURL = document.getElementById('submitImageURL');
const submitBtn = document.getElementById('submitBtn');

// Convert URL to file
async function urlToFile(url, filename, mimeType) {
    const response = await fetch(url, {
        method: 'GET', // or 'POST', 'DELETE', etc.
        credentials: 'include', // Ensure cookies are included in the request
      })
      .then(response => console.log(response))
      .then(response => response.json())
      .then(data => console.log(data))
      .catch(error => console.error('Error:', error));
    const buffer = await response.arrayBuffer();
    return new File([buffer], filename, { type: mimeType });
}

// Upload image
function uploadImage(event, files = []) {
    // Handle image file input
    if (event.target && event.target.id == 'uploadImageInput') {
        // Create objectURL and validate each file uploaded
        for (let i = 0; i < event.target.files.length; i++) {
            files = validateImgs(event.target.files[i]);
        }
    }
    // Handle drag and drop upload
    if (event === 'dropUpload' && files.length > 0) {
        for (let i = 0; i < files.length; i++) {
            validateImgs((files[i]));
        }
    }
}

async function validateImgs(file) {
    // Validate image by attempting to create an HTML image element
    let img = new Image();
    //if HEIC file
    if (file.name.toLowerCase().includes(".heic") || file.name.toLowerCase().includes(".heif")) {
        img.src = '/temp/placeholder.png';
    }
    else {
        img.src = URL.createObjectURL(file);
    }

    // Valid image file/URL
    img.onload = function() {
        document.getElementById('previewText').style.display = 'block';
        createImagePreview(img.src, file['name']);
    };
    
    // Invalid image file/URL
    img.onerror = function() {
        messageFade('Error', 'Invalid image file/URL');
        deleteFiles(file); // Remove invalid file
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
    image.className = 'previewImage';
    image.src = file;
    imageCont.appendChild(image);

    // Create delete btn
    const btn = document.createElement('button');
    btn.className = 'btnRed deleteImageBtn deleteBtn fa fa-trash';
    btn.addEventListener('click', event => deleteImagePreview(event));
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
  
async function dropFile(event) {
    event.preventDefault(); // Prevent setting image path as URL
    uploadImageFile.classList.remove('dragHighlight');

    const items = event.dataTransfer.items;
    const files = [];

    for (let i = 0; i < items.length; i++) {
        if (items[i].kind === 'file') {
            files.push(items[i].getAsFile());
        }
        else if (items[i].kind === 'string') {
            const url = await new Promise(resolve => items[i].getAsString(resolve));
            const filename = url.split('/').pop();
            const file = await urlToFile(url, filename, 'image/jpeg');
            console.log(file);
            files.push(file);
        }
    }

    uploadImage('dropUpload', files);
}


// Delete image
function deleteImagePreview(event) {
    // Remove the image container from the DOM
    event.target.closest('.imageCont').remove();

    // Remove image from file input
    deleteFiles(null, event.target);
}

// Add event listeners, this ensures HTML elements can run function, while script is a module
document.addEventListener('DOMContentLoaded', () => {
    // Add event listener for drag events on uploadLabel
    uploadImageFile.addEventListener('dragover', event => dragOver(event));
    uploadImageFile.addEventListener('dragenter', event => dragEnter(event));
    uploadImageFile.addEventListener('dragleave', event => dragLeave(event));
    uploadImageFile.addEventListener('drop', event => dropFile(event));

    // Add event listener to file input
    uploadImageInput.addEventListener('change', event => uploadImage(event))
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
        document.getElementById('previewText').style.display = 'none';
    }
}

// Check if upload btn should be disable or enabled on page load
// This should hopefully prevent issues with cache
window.onload = () => {
    if (uploadImageInput.files.length == 0) {
        submitBtn.setAttribute('disabled', true);
    }
    else {
        submitBtn.removeAttribute('disabled');
    }
}