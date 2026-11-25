(() => {
	const toggle = document.querySelector('.nav-toggle');
	if (!toggle) return;

	const nav = document.getElementById(toggle.getAttribute('aria-controls'));
	const mobile = window.matchMedia('(max-width: 47.99rem)');

	function setExpanded(expanded) {
		nav.hidden = mobile.matches && !expanded;
		toggle.setAttribute('aria-expanded', String(expanded));
	}

	function syncLayout() {
		toggle.hidden = !mobile.matches;
		setExpanded(false);
	}

	toggle.addEventListener('click', () => setExpanded(nav.hidden));
	toggle.parentElement.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
			setExpanded(false);
			toggle.focus();
		}
	});
	nav.addEventListener('click', (event) => {
		if (mobile.matches && event.target.closest('a')) {
			setExpanded(false);
			toggle.focus();
		}
	});
	mobile.addEventListener('change', syncLayout);
	syncLayout();
})();
