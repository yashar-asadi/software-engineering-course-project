( function ( $ ) {

    "use strict";
    /*
     * Countdown handler Function.
     *
     */
    var NovaWorksCountDownTimer = function( $scope ) {

             var timeInterval,
                 $coutdown = $scope.find( '[data-due-date]' ),
                 endTime = new Date( $coutdown.data( 'due-date' ) * 1000 ),
                 elements = {
                     days: $coutdown.find( '[data-value="days"]' ),
                     hours: $coutdown.find( '[data-value="hours"]' ),
                     minutes: $coutdown.find( '[data-value="minutes"]' ),
                     seconds: $coutdown.find( '[data-value="seconds"]' )
                 };

             NovaWorksCountDownTimer.updateClock = function() {

                 var timeRemaining = NovaWorksCountDownTimer.getTimeRemaining( endTime );

                 $.each( timeRemaining.parts, function( timePart ) {

                     var $element = elements[ timePart ];

                     if ( $element.length ) {
                         $element.html( this );
                     }

                 } );

                 if ( timeRemaining.total <= 0 ) {
                     clearInterval( timeInterval );
                 }
             };

             NovaWorksCountDownTimer.initClock = function() {
                 NovaWorksCountDownTimer.updateClock();
                 timeInterval = setInterval( NovaWorksCountDownTimer.updateClock, 1000 );
             };

             NovaWorksCountDownTimer.splitNum = function( num ) {

                 var num   = num.toString(),
                     arr   = [],
                     reult = '';

                 if ( 1 === num.length ) {
                     num = 0 + num;
                 }

                 arr = num.match(/\d{1}/g);

                 $.each( arr, function( index, val ) {
                     reult += '<span class=" novaworks-countdown-timer__digit">' + val + '</span>';
                 });

                 return reult;
             };

             NovaWorksCountDownTimer.getTimeRemaining = function( endTime ) {

                 var timeRemaining = endTime - new Date(),
                     seconds = Math.floor( ( timeRemaining / 1000 ) % 60 ),
                     minutes = Math.floor( ( timeRemaining / 1000 / 60 ) % 60 ),
                     hours = Math.floor( ( timeRemaining / ( 1000 * 60 * 60 ) ) % 24 ),
                     days = Math.floor( timeRemaining / ( 1000 * 60 * 60 * 24 ) );

                 if ( days < 0 || hours < 0 || minutes < 0 ) {
                     seconds = minutes = hours = days = 0;
                 }

                 return {
                     total: timeRemaining,
                     parts: {
                         days: NovaWorksCountDownTimer.splitNum( days ),
                         hours: NovaWorksCountDownTimer.splitNum( hours ),
                         minutes: NovaWorksCountDownTimer.splitNum( minutes ),
                         seconds: NovaWorksCountDownTimer.splitNum( seconds )
                     }
                 };
             };

             NovaWorksCountDownTimer.initClock();

             return {
                 init : function(){
                     NovaWorksCountDownTimer.initClock();
                 }
             }
         }
    $( window ).on( 'elementor/frontend/init', function () {
      elementorFrontend.hooks.addAction( 'frontend/element_ready/novaworks-countdown-timer.default', NovaWorksCountDownTimer );
    });

} )( jQuery );
