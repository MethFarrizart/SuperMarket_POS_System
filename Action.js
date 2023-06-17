var move = document.querySelector('.sidebar');
var click = document.querySelector('.click');

click.addEventListener('click', () => {
    move.classList.toggle('active');
})


var link = document.querySelector('.link').querySelectorAll('a');
link.forEach(element => {
    element.addEventListener("mouseover", function() {
        link.forEach(nav => nav.classList.remove('active'))
        this.classList.add('active')
        this.style.transition = '0.3s'
    })
});




