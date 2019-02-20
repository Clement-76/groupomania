$(".sign-form input:not([type='submit'])").on("focus", function (e) {
    if (!this.defaultValue) {
        this.defaultValue = e.target.value;
    }

    if (e.target.value === this.defaultValue) {
        e.target.value = "";

        if ($(e.target).parent().hasClass("eye-container")) {
            $(e.target).attr("type", "password");
            $(e.target).siblings().attr("src", "assets/images/invisible_eye_icon.svg");
        }
    }
});

$(".sign-form input").on("blur", function (e) {
    if (e.target.value === "") {
        e.target.value = this.defaultValue;
        if ($(e.target).parent().hasClass("eye-container")) {
            $(e.target).attr("type", "text");
        }
    }
});
