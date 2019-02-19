$(".sign-form input").on("focus", function (e) {
    if (!this.defaultValue) {
        this.defaultValue = e.target.value;
    }

    if (e.target.value === this.defaultValue) {
        e.target.value = "";
    }
});

$(".sign-form input").on("blur", function (e) {
    if (e.target.value === "") {
        console.log("ok");
        e.target.value = this.defaultValue;
    }
});
