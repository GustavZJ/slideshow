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
            files = URL.createObjectURL(target.files[i]);
            validateImgs(files);
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
    const fileIndex = document.getElementsByClassName('imageCont').length;

    // Create image object and set src
    const imageCont = document.createElement('div');
    imageCont.className = 'imageCont';
    imageCont.innerHTML = `<img class="previewImage" src="${file}">
                        <button class="btnRed deleteImageBtn deleteBtn fa fa-trash" onclick="deleteImage(this)"></button>`;

    imageCont.dataset.index = fileIndex;

    // Append image to HTML
    uploadedImagesCont.appendChild(imageCont);

    submitBtn.removeAttribute('disabled');
}

// Delete image
function deleteImage(target) {
    // Get image (deleteImageBtn -> imageCont)
    const imageCont = target.parentElement;
    const fileIndex = imageCont.dataset.index;

    // Remove corresponding file from the input files array
    if (fileIndex !== undefined) {
        const newFiles = Array.from(uploadImageInput.files);
        newFiles.splice(fileIndex, 1);

        // Construct a new FileList from the remaining files
        const newFileList = new DataTransfer();
        newFiles.forEach(file => {
            newFileList.items.add(file);
        });

        // Update the input's files property with the new FileList
        uploadImageInput.files = newFileList.files;
    }

    // Remove the image container from the DOM
    imageCont.remove();

    // Disable upload btn if no images remain
    if (uploadedImagesCont.childElementCount == 0) {
        submitBtn.setAttribute('disabled', true);
    }

    // Update the index of the remaining images
    for (let i = 0; i < uploadedImagesCont.childElementCount; i++) {
        uploadedImagesCont.children[i].dataset.index = i;
    }
}

// Disable submitBtn on load (This is because it might remain enabled, if the user reloads when it's enabled)
window.onload = () => {
    submitBtn.setAttribute('disabled', true);
}