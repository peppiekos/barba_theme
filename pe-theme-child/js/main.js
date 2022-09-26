const body = document.body;
const select = (e) => document.querySelector(e);
const selectAll = (e) => document.querySelectorAll(e);

initPageTransitions();

// Animation - First Page Load
function initLoader() { 
  var tl = gsap.timeline();
  tl.set(".overlay-background", { 
    right: "100%",
  });  
  tl.set(".loading-screen", { 
    top: "0",
  }); 
  tl.set(".loading-words", { 
    opacity: 1,
    y: -50
  });
  tl.to(".loading-screen", {
    duration: .8,
    top: "-100%",
    ease: "Power4.easeInOut",
    delay: .5
  });
  tl.to(".loading-words", {
    duration: .3,
    opacity: 0,
    ease: "linear",
  },"=-.8");
  tl.set(".loading-screen", { 
    top: "calc(-100%)" 
  }); 
}

// Animation - Page transition In
function pageTransitionIn() {
  var tl = gsap.timeline();

  tl.call(function() {    
  });

  tl.set(".overlay-background", { 
    right: "0%",
  });

  tl.set(".loading-screen", { 
    top: "100%" 
  }); 

  tl.set(".loading-words", { 
    opacity: 0,
    y: 0
  });

  tl.to(".overlay-background", { 
    right: "100%",
  });

  tl.to(".loading-screen", {
    duration: .5,
    top: "0%",
    ease: "Power4.easeIn"
  });
  
  tl.to(".loading-words", {
    duration: .8,
    opacity: 1,
    y: -50,
    ease: "Power4.easeOut",
    delay: .05
  });

  tl.to(".loading-screen", {
    duration: .8,
    top: "-100%",
    ease: "Power3.easeInOut"
  },"=-.2");

  tl.to(".loading-words", {
    duration: .6,
    opacity: 0,
    ease: "linear"
  },"=-.8");
  
  tl.set("html", { 
    cursor: "auto"
  },"=-0.6");

  tl.set(".loading-screen", { 
    top: "100%" 
  }); 

  tl.set(".loading-words", {
    opacity: 0,
  });
  
}

// Animation - Page transition Out
function pageTransitionOut() {
    var tl = gsap.timeline();
    tl.call(function() {

    });   
}

function initPageTransitions() {  
  // do something before the transition starts
  barba.hooks.before(() => {
    select('html').classList.add('is-transitioning');
  });

  // do something after the transition finishes
  barba.hooks.after(() => {
    select('html').classList.remove('is-transitioning'); 
  });

  // scroll to the top of the page
  barba.hooks.enter(() => {
    
  });

  // scroll to the top of the page
  barba.hooks.afterEnter(() => {
    window.scrollTo(0, 0);    
  });
  if (jQuery(window).width() > 540) { 
    barba.hooks.leave(() => {
      jQuery(".btn-hamburger, .btn-menu").removeClass('active');
      jQuery("main").removeClass('nav-active');
    }); 
  }
  barba.init({
    preventRunning: true,   
    sync: true,   
    timeout:7000,
    transitions: [{
      name: 'overlay-transition',
      once(data) {
        // do something once on the initial page load      
        initScript(); 
        initLoader();
        initOverlayMenu();
      },
      async leave(data) {
        // animate loading screen in
        // initRemoveClasses();
        pageTransitionIn(data.current);
        await delay(495);
        data.current.container.remove();
      },
      async enter(data) {
        // animate loading screen away
        pageTransitionOut(data.next);   
        initNextWord(data);
      },
      async afterEnter(data) {      
        initScript(); 
      },      
    }],   
  }); 
}

function initNextWord(data) {
  // update Text Loading https://github.com/barbajs/barba/issues/507
  let parser = new DOMParser();
  let dom = parser.parseFromString(data.next.html, 'text/html');
  let nextProjects = dom.querySelector('.loading-words');
  document.querySelector('.loading-words').innerHTML = nextProjects.innerHTML;
}

function delay(n) {
    n = n || 2000;
    return new Promise((done) => {
        setTimeout(() => {
            done();
        }, n);
    });
}

function initFollower() {  
    const cursor = document.querySelector('.follower');
    gsap.set(cursor, {
        xPercent: -50,
        yPercent: -50,
    });
    document.addEventListener('pointermove', movecursor );
    function movecursor(e) {    
        gsap.to(cursor, {
            duration: 0.25,
            x: e.clientX,
            y: e.clientY,
        });
    }; 
}

function ready() {
    console.log('🚀Ready for takeoff');   
}

/**
* Window Inner Height Check
*/
// function initWindowInnerheight() {    
//   // https://css-tricks.com/the-trick-to-viewport-units-on-mobile/
//   jQuery(document).ready(function(){
//     let vh = window.innerHeight * 0.01;
//     document.documentElement.style.setProperty('--vh', `${vh}px`);
//     jQuery('.hamburger-container').click(function(){
//       let vh = window.innerHeight * 0.01;
//       document.documentElement.style.setProperty('--vh', `${vh}px`);
    
//     });
//   });
// }

// Overlay menu
function initOverlayMenu() {   
  jQuery("#hamburger-container").click(function(){
    if (jQuery(".site-header").hasClass('menu-opened')) {
        jQuery("#hamburger-container").removeClass('active');
        jQuery(".site-header").removeClass('menu-opened');          
    } else {
        jQuery("#hamburger-container").addClass('active');
        jQuery(".site-header").addClass('menu-opened');          
    }
  }); 
  jQuery(".overlay-menu ul li a").click(function(){
    jQuery("#hamburger-container").removeClass('active');
    jQuery(".site-header").removeClass('menu-opened');  
  });
  // Escape button
  jQuery(document).keydown(function(e){
    if(e.keyCode == 27) {
      if (jQuery('.site-header').hasClass('menu-opened')) {
          jQuery("#hamburger-container").removeClass('active');
          jQuery(".site-header").removeClass('menu-opened');         
      }
    }
  });
}


// function initRemoveClasses() {
//     jQuery('.follower').removeClass('active-c-f'); 
//     jQuery('.follower').removeClass('active-slide-cursor');
//     jQuery('.follower').removeClass('circle-link-cursor');
//     jQuery('body').removeClass('menu-opened');  
//     jQuery('.hamburger-container').removeClass('active');     
// } 

/**
 * Fire all scripts on page load
 */
function initScript() {
    // select('body').classList.remove('is-loading');
    ready();
    // initOverlayMenu();    
    initFollower();    
}

// barba.init({ 
//   preventRunning: true,
//   transitions: [{
//     name: 'opacity-transition',
//     leave(data) {   
//       return gsap.to(data.current.container, {
//         opacity: 0,        
//         // delay: 1,
//         duration: 0.5
//       });      
//     },
//     after(data) {      
//       return gsap.fromTo(data.next.container, {opacity: 0}, {opacity: 1, duration: 0.5});     
//     }
//   }]   
// });

// barba.hooks.beforeLeave((data) => { 
//     select('html').classList.add('is-transitioning');              
// });

// barba.hooks.enter((data) => {   
//     jQuery('.follower').removeClass('active-c-f'); 
//     jQuery('.follower').removeClass('active-slide-cursor');
//     jQuery('.follower').removeClass('circle-link-cursor');  
// });

// barba.hooks.after((data) => {
//     select('html').classList.remove('is-transitioning');     
// });


// barba.hooks.afterEnter((data) => {
//     window.scrollTo(0, 0);
//     ready();    
// });




