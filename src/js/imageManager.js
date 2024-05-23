import { messageFade } from "./errorMessage.js";

// Image manager
const uploadImageFile = document.getElementById('uploadImageFile');
const uploadedImagesCont = document.getElementById('imagePreviewCont');
const uploadImageInput = document.getElementById('uploadImageInput');
const imageURL = document.getElementById('imageURL');
const submitImageURL = document.getElementById('submitImageURL');
const submitBtn = document.getElementById('submitBtn');
let errorObj = {};

const hiddenImageInput = document.getElementById('hiddenImageInput');

// Upload image
function uploadImage(event, files = []) {
    const hiddenFileList = [];

    // Handle image file input
    if (event.target && event.target.id == 'uploadImageInput') {
        // Create objectURL and validate each file uploaded
        for (const file of event.target.files) {
            if (file.name.toLowerCase().endsWith('.heic') || file.name.toLowerCase().endsWith('.heif')) {
                hiddenFileList.push(file);
            } else {
                validateImgs(file);
            }
        }

        if (hiddenFileList.length) {
            // Construct a new FileList from the remaining files
            const newFileList = new DataTransfer();
            hiddenFileList.forEach(heicFile => {
                newFileList.items.add(heicFile);
            });
        
            // Update the input's files property with the new FileList
            hiddenImageInput.files = newFileList.files;
            document.getElementById('hiddenSubmit').click();
            messageFade('error', 'Nogen af dine billeder er af .HEIC eller .HEIF format, de bliver konverteret til et andet format (Dette kan tage et par sekunder).')
        }
    }

    // Handle drag and drop upload
    if (event == 'dropUpload') {
        for (const file of files) {
            if (file.name.toLowerCase().endsWith('.heic') || file.name.toLowerCase().endsWith('.heif')) {
                hiddenFileList.push(file);
            } else {
                validateImgs(file);
            }
        }

        if (hiddenFileList.length) {
            // Construct a new FileList from the remaining files
            const newFileList = new DataTransfer();
            hiddenFileList.forEach(heicFile => {
                newFileList.items.add(heicFile);
            });
        
            // Update the input's files property with the new FileList
            hiddenImageInput.files = newFileList.files;
            document.getElementById('hiddenSubmit').click();
            messageFade('error', 'Nogen af dine billeder er af .HEIC eller .HEIF format, de bliver konverteret til et andet format (Dette kan tage et par sekunder).')
        }
    }

    if (errorObj.length) {
        for (const [key, value] in Object.entries(errorObj)) {
            messageFade(`Fejl:<br>
            ${key}: ${[...value]}`);
        }

        // Delete each key in errorObj
        Object.keys(errorObj).forEach(key => delete errorObj[key]);
    }
}

async function validateImgs(file) {
    // Validate image by attempting to create an HTML image element
    let img = new Image();

    img.src = URL.createObjectURL(file);

    // Valid image file/URL
    img.onload = function() {
        document.getElementById('previewText').style.display = 'block';
        createImagePreview(img.src, file['name']);
    };
    
    // Invalid image file/URL
    img.onerror = function() {
        errorObj[file] = 'Ikke et gyldigt billede'
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
    const promises = [];

    for (const item of items) {
        if (item.kind === 'file') {
            // Handle file object
            files.push(item.getAsFile());
            appendFileToInput(item.getAsFile());
        } else if (item.kind === 'string' && item.type === 'text/uri-list') {
            promises.push(new Promise((resolve, reject) => {
                item.getAsString(async (data) => {
                    if (data.startsWith('data:image/')) {
                        // Handle DataURI
                        try {
                            const response = await fetch(data);
                            const blob = await response.blob();
                            const file = new File([blob], (+new Date * Math.random()).toString(36).substring(0,6), { type: "image/jpeg" });
                            files.push(file);
                            appendFileToInput(file);
                            resolve();
                        } catch (error) {
                            console.error("Error converting DataURI to File:", error);
                            errorObj[item] = 'Blev ikke uploadet, dette kan være fordi at siden du uploader fra ikke tillader det.';
                            reject(error);
                        }
                    } else if (isValidURL(data)) {
                        // Handle URL
                        try {
                            const file = await fetchImageFileThroughProxy(data);
                            files.push(file);
                            appendFileToInput(file);
                            resolve();
                        } catch (error) {
                            console.error("Error converting URL to File:", error);
                            errorObj[item] = 'Blev ikke uploadet, dette kan være fordi at siden du uploader fra ikke tillader det.';
                            reject(error);
                        }
                    } else {
                        console.error("Unsupported data type:", data);
                        errorObj['Unsupported'] = 'Blev ikke uploadet, dette kan være fordi at siden du uploader fra ikke tillader det.';
                        reject(new Error('Unsupported data type'));
                    }
                });
            }));
        }
    }

    
    // Wait for all promises to resolve
    await Promise.all(promises);
    console.log(errorObj)

    // Check if errorObj has any items and display errors
    if (Object.keys(errorObj).length) {
        for (const [key, value] of Object.entries(errorObj)) {
            messageFade('error', `Fejl:<br>${key}: ${value}`);
        }
        // Clear errorObj
        Object.keys(errorObj).forEach(key => delete errorObj[key]);
    }

    // Proceed with the files array
    uploadImage('dropUpload', files);
}

function isValidURL(string) {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
}

function extractImageUrlFromHtml(html) {
    const doc = new DOMParser().parseFromString(html, 'text/html');
    const img = doc.querySelector('img');
    return img ? img.src : null;
}

async function fetchImageFileThroughProxy(url) {
    const response = await fetch(`/src/php/proxy.php?url=${encodeURIComponent(url)}`);
    const contentType = response.headers.get('Content-Type');

    if (contentType && contentType.includes('text/html')) {
        const html = await response.text();
        const imageUrl = extractImageUrlFromHtml(html);
        if (imageUrl) {
            return fetchImageFileThroughProxy(imageUrl);
        } else {
            throw new Error('Unable to extract image URL from HTML.');
        }
    } else if (response.ok) {
        const blob = await response.blob();
        const filename = (+new Date * Math.random()).toString(36).substring(0,6) + blob.type.replace('image/', '.');
        return new File([blob], filename, { type: blob.type });
    } else {
        throw new Error(`Network response was not ok: ${response.statusText}`);
    }
}

function appendFileToInput(file) {
    // Create a new array to hold all files (existing + new)
    const allFiles = Array.from(uploadImageInput.files);

    // Add the new file to the array of files
    allFiles.push(file);

    // Create a new FileList from the combined array of files
    const combinedFileList = new DataTransfer();
    allFiles.forEach(file => {
        combinedFileList.items.add(file);
    });

    // Set the files property of the file input to the combined FileList
    uploadImageInput.files = combinedFileList.files;
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

// Remove any images on reload
window.onload = () => {
    submitBtn.setAttribute('disabled', true);
    uploadImageInput.value = '';
    hiddenImageInput.value = '';

    for (const img of uploadedImagesCont.children) {
        img.remove();
    }
}