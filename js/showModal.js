window.onload = function(){
    var log = document.getElementById("log");
    var reg = document.getElementById("reg");
    var modalLog = document.getElementById("modalLog");
    var modalReg = document.getElementById("modalReg");
    var logout = document.getElementById("logout");
    log.onclick = function() {
        modalLog.style.display = "flex";
    };
    reg.onclick = function() {
        modalReg.style.display = "flex";
    };
    window.onclick = function(event) {
        if (event.target == modalLog) {
            modalLog.style.display = "none";
        } else if (event.target == modalReg) {
            modalReg.style.display = "none";
        }
    };
    logout.onclick = function() {
        $('.reg-links').css('visibility', 'visible');
        $('.welcome').css('display', 'none');
    }
};