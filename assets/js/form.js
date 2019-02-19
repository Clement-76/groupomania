$(".sign-form input").on("focus", function (e) {
    if (!this.defaultValue) {
        this.defaultValue = e.target.value;
    }

    if (e.target.value === this.defaultValue) {
        e.target.value = "";
        $(e.target).attr("type", "password");
        $(e.target).siblings().attr("src", "assets/images/invisible_eye_icon.svg");
    }
});

$(".sign-form input").on("blur", function (e) {
    if (e.target.value === "") {
        e.target.value = this.defaultValue;
        $(e.target).attr("type", "text");
    }
});
