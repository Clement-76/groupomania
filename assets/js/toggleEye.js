/**
 * toggle the source of an element (for example: img, a)
 * between two sources
 * @param object elt the target element of the toggle
 * @param array src the sources to toggle
 */
function toggleEye(elt, src) {
    if (elt.getAttribute('src') === src[0]) {
        elt.src = src[1];
        $(elt).siblings().attr("type", "password");
    } else {
        elt.src = src[0];
        $(elt).siblings().attr("type", "text");
    }
}

$(() => {
    $(".eye").on("click", (e) => {
        toggleEye(e.target, ['assets/images/visible_eye_icon.svg', 'assets/images/invisible_eye_icon.svg']);
    });
});
