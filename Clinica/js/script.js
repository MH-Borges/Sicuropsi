document.addEventListener( 'DOMContentLoaded', function() {
    // galeria
    var elms = document.getElementsByClassName( 'splide' );
    for ( var i = 0; i < elms.length; i++ ) {
        if(i == 0){
            new Splide( elms[i], {
                type    : 'loop',
                // autoplay: true,
                perPage: 1,
            }).mount();
        }
        if(i == 1){
            new Splide( elms[i], {
                drag   : 'free',
                perPage: 5,
                focus  : 0,
                omitEnd: true,
                arrowPath: 'M28.6236 16.8294C31.0942 18.6647 31.0942 22.3353 28.6236 24.1706L7.88833 39.574C4.83451 41.8426 0.476562 39.6843 0.476562 35.9034L0.476564 5.09658C0.476564 1.31565 4.83451 -0.842576 7.88833 1.42598L28.6236 16.8294Z'
            }).mount();
        }
    }
});