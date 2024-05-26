const topbar = document.createElement('div');
topbar.id = 'topbar';

const navWrapper = document.createElement('div');
navWrapper.id = 'navWrapper';

// topbar.innerHTML = (`
// <div id="navWrapper">
// 	<a href="/" class="navBtns">Hjem
// 		<div class="activeNav"></div>
// 	</a>
// 	<a href="/upload/" class="navBtns">Upload
// 		<div class="activeNav"></div>
// 	</a>
// 	<a href="/admin/" class="navBtns">Admin
// 		<div class="activeNav"></div>
// 		<div id="dropdownCont">
// 			<a class="navBtns">Test 1</a>
// 			<a class="navBtns">Test 2</a>
// 			<a class="navBtns">Test 3</a>
// 		</div>
// 	</a>
// </div>
// `)

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
				const navEle = document.createElement('a');
				navEle.className = 'navBtns';
				navEle.id = 'dropdownBtn';
				navEle.setAttribute('href', subpath);
				navEle.innerHTML = key;
		
				const activeNavEle = document.createElement('div');
				activeNavEle.className = 'activeNav';

				dropdownEle = document.createElement('div');
				dropdownEle.id = 'dropdownCont';

				navEle.appendChild(activeNavEle);
				navEle.appendChild(dropdownEle);
				navWrapper.appendChild(navEle);
			} else {
				const navEle = document.createElement('a');
				navEle.className = 'navBtns';
				navEle.setAttribute('href', subpath);
				navEle.innerHTML = subkey;
		
				const activeNavEle = document.createElement('div');
				activeNavEle.className = 'activeNav';
				navEle.appendChild(activeNavEle);
				dropdownEle.appendChild(navEle);
			}
		}
	} else {
		const navEle = document.createElement('a');
		navEle.className = 'navBtns';
		navEle.setAttribute('href', path);
		navEle.innerHTML = key;

		const activeNavEle = document.createElement('div');
		activeNavEle.className = 'activeNav';
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