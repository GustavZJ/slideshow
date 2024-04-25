// Image manager
const uploadImageFile = document.getElementById('uploadImageFile');
const uploadedImagesCont = document.getElementById('uploadedImagesCont');
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
    imageCont.innerHTML = `<img class="previewImage" src="${file}">
                        <button class="btnRed deleteImageBtn deleteBtn fa fa-trash" onclick="deleteImagePreview(this)"></button>`;

    // Save name of image, this is used to identify the image, if it's deleted
    imageCont.dataset.name = name;

    // Append image to HTML
    uploadedImagesCont.appendChild(imageCont);

    // Enable upload btn
    submitBtn.removeAttribute('disabled');
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

// Delete file from input
function deleteFiles(fileName = null, target = null) {
    // Set file name to stored file name of image, if target !null
    // (Otherwise, the delete function was called because of rejected image)
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
    if (uploadedImagesCont.childElementCount == 0) {
        submitBtn.setAttribute('disabled', true);
    }
}

// Disable submitBtn on load (This is because it might remain enabled, if the user reloads when it's enabled)
window.onload = () => {
    submitBtn.setAttribute('disabled', true);
}