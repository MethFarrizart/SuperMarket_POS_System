
// Sidebar and main content animation
var move = document.querySelector('.sidebar');
var click = document.querySelector('.click');

click.addEventListener('click', () => {
    move.classList.toggle('active');
})

// Sidebar menu animaition
var link = document.querySelector('.link').querySelectorAll('a');
link.forEach(element => {
    element.addEventListener("mouseover", function() {
        link.forEach(nav => nav.classList.remove('active'))
        this.classList.add('active')
        this.style.transition = '0.3s'
    })
});


// var clickBtn = document.querySelector('.clickBtn').querySelectorAll('.toggle');
// clickBtn.forEach(obj => {
//     obj.addEventListener('click', () => {
//         clickBtn.forEach(n => n.classList.remove('toggle'))
//         this.classList.add('toggle')
//     })
// });



// clickBtn.addEventListener("click", () => {
//     for (let i = 0; i < clickBtn.length; i++) {
//         if (showDetail.style.display == "none") {
//             showDetail.style.display = "block"
//         } else {
//             showDetail.style.display = "none"
//         }
//     }
// })


// Animation Number Count 
// $(document).ready(function() {
//     $('h4 span').each(function() {
//         const This = $(this);
//         $({
//             Count: This.text()
//         }).animate({
//             Count: This.parent().attr('data-count')
//         }, {
//             duration: 2000,
//             easing: "linear",
//             step: function() {
//                 This.text(Math.ceil(this.Count))
//             }
//         })
//     })
// })


// Digital Clock
function datetime() {
    const date = new Date();
    let hrs = date.getHours();
    let min = date.getMinutes();
    let sec = date.getSeconds();

    const Month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const Day = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    let day = Day[date.getDay()] ;
    let month = Month[date.getMonth()] ;
    let year = date.getFullYear();
    let day_num = date.getDate();

    if (hrs >= 12) {
        document.getElementById('time').innerHTML = "PM";
    } else {
        document.getElementById('time').innerHTML = "AM";
    }

    if (hrs > 12) {
        hrs = hrs - 12;
    }

    if (hrs < 10) {
        hrs = "0" + hrs;
    }

    if (sec < 10) {
        sec = "0" + sec;
    }

    if (min < 10) {
        min = "0" + min;
    }

    document.getElementById('hrs').innerHTML = hrs;
    document.getElementById('min').innerHTML = min;
    document.getElementById('sec').innerHTML = sec;
    document.getElementById('day').innerHTML = day;
    document.getElementById('month').innerHTML = month;
    document.getElementById('year').innerHTML = year;
    document.getElementById('day_num').innerHTML = day_num;
    
}

setInterval(datetime, 10);


// Show the image after chose it
function preview(event) {
    frame.src = URL.createObjectURL(event.target.files[0]);
}



//  Prevent To cross the page if not already login
    // function preventBack() {
    //     window.history.forward();
    // }
    // setTimeout("preventBack()", 0)
    // window.onunload = function() {
    //     null
    // }


