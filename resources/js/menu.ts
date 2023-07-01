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

    let link = ev.target as HTMLElement;
    if (link.tagName !== 'a') {
        link = link.closest('a')!;
    }

    link.classList.add('active');
});
