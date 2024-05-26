const topbar = document.createElement('div');
topbar.id = 'topbar';
topbar.innerHTML = (`
<div id="navWrapper">
	<a href="/" class="navBtns">Hjem
		<div class="activeNav"></div>
	</a>
	<a href="/upload/" class="navBtns">Upload
		<div class="activeNav"></div>
	</a>
	<a href="/admin/" class="navBtns">Admin
		<div class="activeNav"></div>
	</a>
</div>
`)

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