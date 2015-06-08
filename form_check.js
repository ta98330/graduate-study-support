function passCheck() {
    var str = document.pass_insert.newpass.value;
    if( str.charAt(0) == "0" ) {
        alert("先頭に０は選択できません．");
        form.reset("form");
        return 1;
    }
    return 0;
}