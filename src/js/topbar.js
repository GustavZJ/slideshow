// Remember to set the main page of subsites as index, then use the key of the main site so get the name
const navPaths = {
	'Hjem': '/',
	'Upload': '/upload/',
	'Admin': {
		'index': '/admin/',
		'Billedmanager': '/admin/imageManager.php',
		'Konfig': '/admin/config.html'
	}
}

const topbar = document.createElement('div');
topbar.id = 'topbar';

const navWrapper = document.createElement('div');
navWrapper.id = 'navWrapper';

let dropdownEle

for (const [key, path] of Object.entries(navPaths)) {
	if (typeof(path) == 'object') {	
		for (const [subkey, subpath] of Object.entries(path)) {
			if (subkey == 'index') {
				const navEle = createNewElement('a', `${key} <button id="expandDropdownBtn" class="expandBtn" aria-label="Expand Dropdown">&#9660;</button>`, 'navBtns', 'dropdownBtn');
				navEle.setAttribute('href', subpath);

				dropdownEle = document.createElement('div');
				dropdownEle.id = 'dropdownCont';

				navEle.appendChild(dropdownEle);
				navWrapper.appendChild(navEle);
			} else {
				const navEle = createNewElement('a', subkey, 'navBtns');
				navEle.setAttribute('href', subpath);
				
				const activeNavEle = document.createElement('div');
				activeNavEle.className = 'activeNav';
				navEle.appendChild(activeNavEle);
				dropdownEle.appendChild(navEle);
			}
		}
	} else {
		const navEle = createNewElement('a', key, 'navBtns');
		navEle.setAttribute('href', path);

		const activeNavEle = createNewElement('div', '', 'activeNav');
		navEle.appendChild(activeNavEle);
		navWrapper.appendChild(navEle);
	}
}

topbar.appendChild(navWrapper);
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

// Dropdown menu for non-mobile devices
const dropdownBtn = document.getElementById('dropdownBtn');
const dropdownCont = document.getElementById('dropdownCont');
const expandDropdownBtn = document.getElementById('expandDropdownBtn');
let hideTimer;

dropdownBtn.addEventListener('mouseenter', () => {
    dropdownCont.style.display = 'grid';
    dropdownCont.classList.remove('close');
    dropdownCont.classList.add('open');
});

dropdownBtn.addEventListener('mouseleave', () => {
    dropdownCont.classList.remove('open');
    dropdownCont.classList.add('close');
    clearTimeout(hideTimer);
    hideTimer = setTimeout(() => {
        dropdownCont.style.display = 'none';
    }, 300);
});

// Handle click event for mobile devices
expandDropdownBtn.addEventListener('click', (e) => {
    e.preventDefault(); // Prevent the default button action
    if (dropdownCont.style.display === 'grid') {
        dropdownCont.style.display = 'none';
        dropdownCont.classList.remove('open');
        dropdownCont.classList.add('close');
    } else {
        dropdownCont.style.display = 'grid';
        dropdownCont.classList.remove('close');
        dropdownCont.classList.add('open');
    }
});