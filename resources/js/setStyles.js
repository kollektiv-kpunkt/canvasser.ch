window.addEventListener('DOMContentLoaded', setStyles);
window.addEventListener('resize', setStyles);

function setStyles() {
    document.documentElement.style.setProperty('--vh', `${window.innerHeight * 0.01}px`);
    document.documentElement.style.setProperty('--vw', `${window.innerWidth * 0.01}px`);
}
