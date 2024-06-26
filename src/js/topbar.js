jQuery(document).ready(function ($) {
    $.ajax({
        type: 'POST',
        url: '/src/php/getRole.php',
        success: function (role) {
            // Remember to set the main page of subsites as index, then use the key of the main site so get the name
            const navPaths = {
                'Hjem': '/landing.php',
                'Upload': '/upload/',
                'Admin': {
                    'index': '/admin/',
                    'Billedmanager': '/admin/imageManager.php',
                    'Konfig': '/admin/config.php'
                }
            }

            const topbar = document.createElement('div');
            topbar.id = 'topbar';

            if (role == "admin") {
                const navWrapper = document.createElement('div');
                navWrapper.id = 'navWrapper';
                let dropdownEle

                // Create navbtns from nav dict
                for (const [key, path] of Object.entries(navPaths)) {
                    if (typeof(path) == 'object') {
                        // If it's an object, page has subpages, so add dropdown
                        for (const [subkey, subpath] of Object.entries(path)) {
                            if (subkey == 'index') {
                                const navEle = createNewElement('a', key, 'navBtns', 'dropdownBtn');
                                navEle.setAttribute('href', subpath);
                            
                                dropdownEle = createNewElement('div', '', '', 'dropdownCont');
                            
                                // For mobile devices
                                const dropdownBtnEle = createNewElement('button', '<i class="fa fa-caret-down"></i>', 'expandBtn', 'expandDropdownBtn');
                            
                                navEle.appendChild(dropdownEle);
                                navWrapper.appendChild(navEle);
                                navWrapper.appendChild(dropdownBtnEle);
                            } else {
                                const navEle = createNewElement('a', subkey, 'navBtns');
                                navEle.setAttribute('href', subpath);
                            
                                const activeNavEle = document.createElement('div');
                                activeNavEle.className = 'activeNav';
                                navEle.appendChild(activeNavEle);
                                dropdownEle.appendChild(navEle);
                            }
                        }
                    } else if (typeof(path) != 'object') {
                        // Else it's just regular button
                        const navEle = createNewElement('a', key, 'navBtns');
                        navEle.setAttribute('href', path);
                    
                        const activeNavEle = createNewElement('div', '', 'activeNav');
                        navEle.appendChild(activeNavEle);
                        navWrapper.appendChild(navEle);
                    }
                }
                topbar.appendChild(navWrapper);
            }

            const logoutWrapper = createNewElement('div', '<button class="btnWhite" id="logoutBtn">Log ud</button>', '', 'logoutWrapper');
            topbar.appendChild(logoutWrapper);

            document.body.prepend(topbar);


            // Sort navigation buttons by href length in descending order
            const navBtns = Array.from(document.getElementsByClassName('navBtns'));
            navBtns.sort((a, b) => b.attributes.href.value.length - a.attributes.href.value.length);

            // Find active page, and mark corresponding button
            for (const btn of navBtns) {
                const href = btn.attributes.href.value;
                if (window.location.pathname.startsWith(href)) {
                    btn.classList.add('active');
                    break;
                }
            }

            function createNewElement(tag, html, className = '', idName = '') {
                const newEle = document.createElement(tag);
                newEle.innerHTML = html;
                if (className && typeof(className) == 'list') {
                    newEle.classList.add([...className]);
                } else if (className) {
                    newEle.classList.add(className);
                }
                if (idName) {
                    newEle.id = idName;
                }
                return newEle;
            }

            // Dropdown menu
            if (role == 'admin') {
                const dropdownBtn = document.getElementById('dropdownBtn');
                const dropdownCont = document.getElementById('dropdownCont');
                const expandDropdownBtn = document.getElementById('expandDropdownBtn');

                // Dropdown menu for non-mobile devices
                if (window.matchMedia('(hover: hover)').matches) {
                    dropdownBtn.addEventListener('mouseenter', () => {
                        dropdownCont.style.display = 'grid';
                        dropdownCont.classList.remove('close');
                        dropdownCont.classList.add('open');
                    });
                
                    dropdownBtn.addEventListener('mouseleave', () => {
                        dropdownCont.classList.remove('open');
                        dropdownCont.classList.add('close');
                        dropdownCont.onanimationend = () => {
                            if (dropdownCont.classList.contains('close')) {
                                dropdownCont.style.display = 'none';
                            }
                        }
                    });
                }
            
                // Dropdown menu for mobile devices
                expandDropdownBtn.addEventListener('click', (e) => {
                    e.preventDefault(); // Prevent the default button action
                    if (dropdownCont.style.display === 'grid') {
                        dropdownCont.classList.remove('open');
                        dropdownCont.classList.add('close');
                        dropdownCont.onanimationend = () => {
                            if (dropdownCont.classList.contains('close')) {
                                dropdownCont.style.display = 'none';
                            }
                        }
                    } else {
                        dropdownCont.style.display = 'grid';
                        dropdownCont.classList.remove('close');
                        dropdownCont.classList.add('open');
                    }
                });
            }
            
            $('#logoutBtn').click(function () {
                $.ajax({
                    type: 'POST',
                    url: '/src/php/logout.php',
                    success: function() {
                        window.location.pathname = '/index.html';
                    }
                })
            })
        }
    });
});