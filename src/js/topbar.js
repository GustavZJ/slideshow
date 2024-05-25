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

const navBtns = document.getElementsByClassName('navBtns');

// Find active page, and mark corrosponding button
for (const btn of navBtns) {
	if (btn.attributes.href.value.includes(window.location.pathname)) {
		btn.children[0].style.display = 'inline-block';
		break
	}
}