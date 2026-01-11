let timer = setTimeout(() => {
    window.location.href = '/QTrace-Website/login?timeout';
}, 300000 ); 

// Reset timer on mouse movement or key press
function resetTimer() {
    clearTimeout(timer);
    timer = setTimeout(() => {
        window.location.href = '/QTrace-Website/login?timeout';
    },300000);
}
window.onmousemove = resetTimer;
window.onkeydown = resetTimer;