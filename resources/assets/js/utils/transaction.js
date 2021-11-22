(function (global) {

    if (typeof (global) === "undefined") throw new Error("window is undefined");

    var _hash = "!";
    var disableBack = _ => {
        global.location.href += "#";

        // Making sure we have the fruit available for juice (^__^)
        global.setTimeout(_ => {
            global.location.href += "!";
        }, null);
    };

    global.onhashchange = _ => {
        if (global.location.hash !== _hash) global.location.hash = _hash;
    };

    global.onload = _ => {
        disableBack();

        // Disables backspace on page except on input fields and textarea..
        document.body.onkeydown = e => {
            var elm = e.target.nodeName.toLowerCase();
            if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                e.preventDefault();
            }
            // Stopping the event bubbling up the DOM tree...
            // e.stopPropagation();
        };
    }

    // prevent right click
    document.addEventListener('contextmenu', event => event.preventDefault());

    // // capture window leave
    // global.addEventListener('beforeunload', e => {
    //     // Cancel the event
    //     e.preventDefault(); // If you prevent default behavior in Mozilla Firefox prompt will always be shown
    //     // Chrome requires returnValue to be set
    //     return e.returnValue = '';
    // });
})(window);
