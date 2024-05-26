const topbar = document.createElement('div');
topbar.id = 'topbar';

const navWrapper = document.createElement('div');
navWrapper.id = 'navWrapper';

const navPaths = {
	'Hjem': '/',
	'Upload': '/upload/',
	'Admin': {
		'index': '/admin/',
		'Billedmanager': '/admin/imageManager.php',
		'Konfig': '/admin/config.html'
	}
}

let dropdownEle

for (const [key, path] of Object.entries(navPaths)) {
	if (typeof(path) == 'object') {	
		for (const [subkey, subpath] of Object.entries(path)) {
			if (subkey == 'index') {
				const navEle = createNewElement('a', key, 'navBtns', 'dropdownBtn');
				navEle.setAttribute('href', subpath);
		
				const activeNavEle = document.createElement('div');
				activeNavEle.className = 'activeNav';

				dropdownEle = document.createElement('div');
				dropdownEle.id = 'dropdownCont';

				navEle.appendChild(activeNavEle);
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

const navBtns = Array.from(document.getElementsByClassName('navBtns'));

// Sort navigation buttons by href length in descending order
navBtns.sort((a, b) => b.attributes.href.value.length - a.attributes.href.value.length);

// Find active page, and mark corresponding button
for (const btn of navBtns) {
    const href = btn.attributes.href.value;
    if (window.location.pathname.startsWith(href)) {
        btn.children[0].style.display = 'inline-block';
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

const dropdownBtn = document.getElementById('dropdownBtn');
const dropdownCont = document.getElementById('dropdownCont');
let hideTimer;

dropdownBtn.addEventListener('mouseenter', () => {
	dropdownCont.classList.remove('close');
	dropdownCont.classList.add('open');
});

dropdownBtn.addEventListener('mouseleave', () => {
	dropdownCont.classList.remove('open');
	dropdownCont.classList.add('close');
	clearTimeout(hideTimer);
	hideTimer.setTimeout(() => {
        dropdownCont.style.display = 'none';
    }, 300);
});

// Check if the user is on a mobile device
const isMobileDevice = () => {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

// Function to create arrow button
const createArrowButton = () => {
    const arrowButton = document.createElement('div');
    arrowButton.className = 'arrowButton';
    // You can customize the appearance of the arrow button here
    arrowButton.innerHTML = '&#9660;'; // Downward pointing triangle or any other suitable icon
    return arrowButton;
}

// Add arrow button if user is on a mobile device
if (isMobileDevice()) {
    const arrowButton = createArrowButton();
    navWrapper.appendChild(arrowButton);

    arrowButton.addEventListener('click', () => {
        const dropdownCont = document.getElementById('dropdownCont');
        dropdownCont.classList.toggle('open');
    });
}