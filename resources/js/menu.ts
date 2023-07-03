// mobile menu
const navigation = document.getElementById('bm-desktop-navigation')!;
const viewBreakpoint = 768;

if (window.innerWidth <= viewBreakpoint) {
    navigation.classList.add('mobile');
}

document.addEventListener('resize', function () {
    if (window.innerWidth <= viewBreakpoint && !navigation.classList.contains('mobile')) {
        navigation.classList.add('mobile');
    } else {
        navigation.classList.remove('mobile');
    }
});

// active links with Swup
window.Swup.on('clickLink', function (ev) {
    const activeLinks = document.querySelectorAll('.bm-navbar a.active');
    for (const link of activeLinks) {
        link.classList.remove('active');
    }

    let link = ev.target as HTMLElement | null;
    if (!link) return;

    if (link.tagName !== 'A') {
        link = link.closest('a.nav-link');
    }
    if (!link) return;

    if (!link.classList.contains('nav-link')) {
        let href = link.attributes.getNamedItem('href')!.value.split(/(\?)|(#)/)[0];

        link = document.querySelector(`.bm-navbar a.nav-link[href="${href}"]`);
    }

    if (link) {
        link.classList.add('active');
    }
});
