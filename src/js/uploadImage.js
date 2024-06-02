import { messageFade } from '/src/js/errorMessage.js'

let max_file_uploads = 0;

jQuery(document).ready(function ($) {
    async function createFile(filePath){
            let response = await fetch(filePath);
            let data = await response.blob();
            let metadata = {
                type: data.type
            };
            return new File([data], (+new Date * Math.random()).toString(36).substring(0,6) + '.jpg', metadata);
        }
    $.ajax({
        type: 'POST',
        url: '/src/php/defaultVal.php',
        success: function (key_val) {
        const key_val_object = Object.entries(key_val).reduce((obj, [key, val]) => {
            obj[key] = val;
            return obj;
        }, {});

            max_file_uploads = key_val_object['max_file_uploads'];
            $('#amountText').text(`Billeder: 0/${max_file_uploads}`);
        }
    });
    
    $('#hiddenForm').submit(function (event) {
        event.preventDefault();

        const formData = new FormData(this); // Create FormData object

        $.ajax({
            type: 'POST',
            url: '/src/php/convertHEIC.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                const allFiles = [];
                (async function () {
                    for await (const filePath of response['files']) {
                        // Add the new file to the array of files
                        await createFile(filePath.slice(18)).then(function(result) {allFiles.push(result)});
                    }

                    // Create a new FileList from the combined array of files
                    const combinedFileList = new DataTransfer();
                    allFiles.forEach(fileItem => {
                        combinedFileList.items.add(fileItem);
                    });

                    // Set the files property of the file input to the combined FileList
                    document.getElementById('uploadImageInput').files = combinedFileList.files;
                    document.getElementById('uploadImageInput').dispatchEvent(new Event('change'));

                    document.getElementById('hiddenImageInput').value = '';
                    allFiles.length = 0;

                    let errMsg = '';
                    let counter = 0;
                    let allSuccess = true;
                    
                    for (const [key, value] of Object.entries(response['errors'])) {
                        console.log(value);
                        if (value.toLowerCase().includes('success')) {
                            counter += 1;
                        } else {
                            errMsg += `${key}: ${[...value].join(' og ')}.<br>`;
                            allSuccess = false;
                        }
                    }

                    if (!allSuccess && counter > 0) {
                        errMsg = `${counter} billede(r) blev konverteret uden fejl.<br>Men:<br>${errMsg}`;
                        messageFade('error', errMsg);
                    } else {
                        errMsg = `Fejl:<br>${errMsg}`;
                        messageFade('error', errMsg);
                    }
                })();
            },
                error: function () {
                    messageFade('error', 'Noget gik galt med konvetering! Prøv igen.');
                }
        })
    });
    
    $('#uploadForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        const file_count = document.getElementById('uploadImageInput').files.length;
        const formData = new FormData(this); // Create FormData object

        $('#uploadImageInput').attr('disabled', true);
        $('#submitBtn').attr('disabled', true);
        $('#clearBtn').attr('disabled', true);
        $('#uploadLabel').css('cursor', 'default');
        
        // Loading dots, so that you can see it's not frozen incase it's slow
        $("#submitBtn").val('Uploader');
        const dots = window.setInterval(function() {
            const dotCount = ($("#submitBtn").val().match(/\./g) || []).length;

            if (dotCount >= 3) {
                $("#submitBtn").val('Uploader');
            } else {
                $("#submitBtn").val($("#submitBtn").val() + '.');
            }
        }, 500);
        
        if (file_count > max_file_uploads) {
            clearInterval(dots);
            messageFade("error", `Antallet af filer du prøver at uploade (${file_count}) overskrider grænsen sat af administratorerne (${max_file_uploads}).`);
            $('#uploadImageInput').removeAttr('disabled');
            $('#submitBtn').removeAttr('disabled');
            $('#clearBtn').removeAttr('disabled');
            $('#submitBtn').val('Upload');
            $('#uploadLabel').css('cursor', 'pointer');
        } else {
            $.ajax({
                type: 'POST',
                url: '/src/php/upload.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    clearInterval(dots);
                    $('#uploadImageInput').removeAttr('disabled');
                    $('#submitBtn').val('Upload');
                    $('#uploadLabel').css('cursor', 'pointer');
                    $('#submitBtn').attr('disabled', true);
                    $('#clearBtn').attr('disabled', true);

                    let allSuccess = true;
                    let errMsg = '';
                    let counter = 0;

                    for (const [key, value] of Object.entries(response)) {
                        if (value.toLowerCase().includes('success')) {
                            counter += 1;
                        } else {
                            allSuccess = false;
                            errMsg += `${key}: ${[...value].join(' og ')}.<br>`;
                        }
                    }

                    if (allSuccess) {
                        let msg = '';
                        if (counter > 1) {
                            msg += `Alle ${counter} billede(r) blev uploadet uden fejl.`
                        } else {
                            msg += `${counter} billede blev uploadet uden fejl.`
                        }
                        messageFade('success', msg);
                    } else if (counter > 0) {
                        errMsg = `${counter} billede(r) blev uploadet uden fejl.<br>Men:<br>${errMsg}`;
                        messageFade('error', errMsg);
                    } else {
                        errMsg = `Fejl:<br>${errMsg}`;
                        messageFade('error', errMsg);
                    }

                    for (let i = document.getElementById('imagePreviewCont').childElementCount - 1; i >= 0; i--) {
                        document.getElementById('imagePreviewCont').children[i].remove();
                        document.getElementById('uploadImageInput').value = '';
                    }
                },
                error: function () {
                    clearInterval(dots);
                    messageFade('error', 'Noget gik galt! Prøv igen.');
                    $('#uploadImageInput').removeAttr('disabled');
                    $('#submitBtn').removeAttr('disabled');
                    $('#submitBtn').val('Upload');
                    $('#clearBtn').removeAttr('disabled');
                    $('#uploadLabel').css('cursor', 'pointer');
                }
            });
        }
    });
});