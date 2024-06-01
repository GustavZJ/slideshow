import { confirmAction } from '/src/js/confirmAction.js'
import { messageFade } from '/src/js/errorMessage.js'

            // Hide delete btn if no images present
            if (!document.getElementById('imagePreviewCont').childElementCount == 0) {
                document.getElementById('deleteBtn').style.display = 'inline-block';
                document.getElementById('deleteAllBtn').style.display = 'inline-block';
                document.getElementById('deletePreviewText').style.display = 'none';
            }

            function disableBtns() {
                document.getElementById('deleteBtn').setAttribute('disabled', true);
                for (const child of document.getElementById('imagePreviewCont').children) {
                    if (child.children[1].checked) {
                        document.getElementById('deleteBtn').removeAttribute('disabled');
                        break;
                    }
                }
            }

            // Function to run php script in background
            jQuery(document).ready(function ($) {
                // Uncheck checkboxes, since sometimes checkboxes will randomly be checked after delete
                $('input[type="checkbox"]').prop('checked', false);
                document.getElementById('deleteBtn').setAttribute('disabled', true);
                
                const images = document.getElementsByClassName('imageCont');
                const errorList = [];
                let deleteCount = 0;
                let errMsg = ''

                document.getElementById('deleteBtn').addEventListener('click', disableBtns);
                document.querySelectorAll('.imageCont').forEach(el => el.addEventListener('click', disableBtns));

                document.getElementById('deleteAllBtn').onclick = () => {
                confirmAction('slet alle billeder')
                    .then (value => {
                        if (value) {
                            $('input[type="checkbox"]').prop('checked', true);
                            $('form').submit();
                        }
                    });
                }

                // Handle delete action
                $("#deleteForm").submit(function (event) {
                    $.ajax({
                        type: 'POST',
                        url: '/src/php/delete.php',
                        data: $(this).serialize(),
                        success: function (response) {
                            for (let file in response) {
                                if (response[file] === "success") {
                                    deleteCount += 1;
                                    $(`.previewImage[src='../uploads/${file.replace('?', '%3F')}']`).closest('.imageCont').remove();
                                } else {
                                    errorList.push(file);
                                }
                            }

                            // Hide delete btn if no images present
                            if (document.getElementById('imagePreviewCont').childElementCount == 0) {
                                document.getElementById('deleteBtn').style.display = 'none';
                                document.getElementById('deleteAllBtn').style.display = 'none';
                                document.getElementById('deletePreviewText').style.display = 'block';
                            }

                            disableBtns();
                            
                            // Give succeess message
                            if (errorList.length == 0) {
                                messageFade('success', `${deleteCount} billede(r) blev fjernet`);
                            }
                            else {
                                if (deleteCount > 0) {
                                    errMsg += `${deleteCount} billede(r) blev fjernet<br>`;
                                }
                                errMsg += (`Fejl, disse billeder blev ikke fjernet:<br>
                                ${[...errorList].join('<br>')}`);
                                messageFade('error', errMsg);
                            }

                            // Reset counters, etc.
                            deleteCount = 0;
                            errMsg = '';
                            errorList.length = 0
                        },
                        error: function() {
                            messageFade('error', 'Ingen billeder blev fjernet');
                        }
                    });
                    // Prevent default action of going to php page
                    event.preventDefault();
                });
            });