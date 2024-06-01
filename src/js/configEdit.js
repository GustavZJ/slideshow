import { messageFade } from "/src/js/errorMessage.js"
        const removeImageInputs = document.getElementsByClassName('removeImageInputs');

        function validateInput() {
            let allValid = true;
            let atLeastOneFilled = false;

            const textInputs = document.querySelectorAll('.textInputs');
            textInputs.forEach(ele => {
                if (!ele.disabled) {
                    if (ele.value.trim() !== '' && ele.value !== ele.placeholder) {
                        atLeastOneFilled = true;

                        if (isNaN(ele.value)) {
                            allValid = false;
                        }
                    }
                }
            });

            // Check if the checkbox state has changed
            if ($('#autoremove').prop('checked') != $('#autoremove').data('curState')) {
                atLeastOneFilled = true;
            }

            // Check if the checkbox state has changed
            if ($('#autoremovetimeoption').val() != $('#autoremovetimeoption').data('curState')) {
                atLeastOneFilled = true;
            }

            // Enable the button if there is at least one filled input and all inputs are valid numbers
            if (allValid && atLeastOneFilled) {
                $('#confirmBtn').removeAttr('disabled');
            } else {
                $('#confirmBtn').attr('disabled', true);
            }
        }

        function disableImageRemove() {
            if ($('#autoremove').prop('checked')) {
                removeImageCont.style.opacity = '100%';
                Object.values(removeImageInputs).forEach(ele => ele.removeAttribute('disabled'));
            } else {
                removeImageCont.style.opacity = '50%';
                Object.values(removeImageInputs).forEach(ele => ele.setAttribute('disabled', true));
            }
        }

        jQuery(document).ready(function ($) {
            document.querySelectorAll('.textInputs').forEach(ele => ele.addEventListener('input', validateInput));
            $('#autoremove').on('change', function () {
                disableImageRemove();
                validateInput();
            });
            $('#autoremovetimeoption').on('change', function () {
                validateInput();
            });

            $.ajax({
                type: 'POST',
                url: '/src/php/defaultVal.php',
                success: function (key_val) {
                    for (const [key, val] of Object.entries(key_val)) {
                        if (!["autoremovetime", "autoremovetimeoption", "autoremove"].includes(key)) {
                            document.getElementById(key).placeholder = val;
                        } else if (key == "autoremovetimeoption") {
                            document.getElementById(key).value = val;
                            document.getElementById(key).dataset.curState = val;
                        } else if (key == "autoremove") {
                            if (val == "true" || val == 'on') {
                                document.getElementById(key).checked = true;
                                document.getElementById(key).dataset.curState = 'true';
                            }
                            else {
                                document.getElementById(key).checked = false;
                                document.getElementById(key).dataset.curState = 'false';
                            }
                        }
                    }

                    $('.removeImageInputs').each(function () { $(this).attr('disabled', true) });

                    $('#confirmBtn').attr('disabled', true);
                    $('.textInputs').each(function () { $(this).val('')});
                        
                    disableImageRemove();
                    validateInput();

                },
                error: function () {
                    messageFade('error', 'Noget gik galt, nuværende indstillnger kunne ikke indlæses');
                }
            });

            $("#configForm").submit(function (event) {
                event.preventDefault(); // Prevent the default form submission
                $("#confirmBtn").attr('disabled', true);
                // Loading dots, so that you can see it's not frozen incase it's slow
                $("#confirmBtn").text('Opdaterer');
                const dots = window.setInterval(function() {
                    const dotCount = ($("#confirmBtn").text().match(/\./g) || []).length;

                    if (dotCount >= 3) {
                        $("#confirmBtn").text('Opdaterer');
                    } else {
                        $("#confirmBtn").text($("#confirmBtn").text() + '.');
                    }
                }, 500);


                // Temporarily enable disabled inputs
                $(this).find('.configInputs:disabled').removeAttr('disabled');

                $(this).find('input').each(function () {
                    // Check if the input value is empty
                    if (!$(this).val().trim()) {
                        // If it's empty, set it to the placeholder value
                        $(this).val($(this).attr('placeholder'));
                    }
                });


                // Serialize the form data into an array of objects
                const formArray = $(this).serialize();

                // Convert the array of objects into a single object
                const formData = {};
                formArray.forEach(function (item) {
                    formData[item.name] = item.value;
                });

                if (!$('#autoremove').prop('checked')) {
                    formData['autoremove'] = 'off';
                }

                $.ajax({
                    type: 'POST',
                    url: '/src/php/changeConfig.php',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        clearInterval(dots);
                        $("#confirmBtn").text('Opdater konfig');
                        $('#confirmBtn').removeAttr('disabled');
                        $('input.textInputs').each(function () {
                            // Set the placeholder to the value of the input
                            $(this).attr('placeholder', $(this).val());

                            if ($(this).attr('id') == 'upload_max_filesize') {
                                if (!$(this).attr('placeholder').endsWith('M')) {
                                    $(this).attr('placeholder', $(this).attr('placeholder') + 'M');
                                }
                            }
                        });

                        $('.removeImageInputs').each(function () { $(this).attr('disabled', true) });

                        $('#confirmBtn').attr('disabled', true);
                        $('.textInputs').each(function () {$(this).val('')});

                        disableImageRemove();
                        validateInput();

                        if (response.exit_code === 0) {
                            messageFade("success", "Konfigureringer opdateret successfuldt!");
                        } else {
                            messageFade("error", "Ikke alle variable blev sat!");
                        }
                    },
                    error: function () {
                        clearInterval(dots);
                        $("#confirmBtn").text('Opdater konfig');
                        $('#confirmBtn').removeAttr('disabled');
                        messageFade("error", "Noget gik galt, konfigureringen blev ikke opdateret, prøv igen!");

                        $('.textInputs').each(function () { 
                            if ($(this).val() == $(this).attr('placeholder')) {
                                $(this).val('') 
                            }
                        });
                    }
                });
            });
        });