var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;

// hide when clicked out of
$(document).click((click)=>{
    var target = $(click.target);

    if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
        hideOptionsMenu();
    }
});

//150 - hide when scroll
$(window).scroll(() => {
    hideOptionsMenu();
});

//114
function openPage (url) {

    if(timer != null){
        clearTimeout(timer);   
    }

    if(url.indexOf("?") == -1) {
        url = url + "?";
    }
    var encodeUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    $("#mainContent").load(encodeUrl);
    $("body").scrollTop(0);
    history.pushState(null, null, url);
}

function createPlaylist () {
    var name = prompt('Please enter the name of your playlist');
    if(alert != null) {

        $.post("includes/handlers/ajax/createPlaylist.php", {name:name, username:userLoggedIn})
        .done((error)=>{
            if(error != "") {
                alert(error);
                return;
            }
            openPage("yourMusic.php");
        })
    }
}

function deletePlaylist(playlistId) {
    var prompt = confirm("Are you sure you want to delete this playlist?");

    if(prompt) {
        $.post("includes/handlers/ajax/deletePlaylist.php", {playlistId:playlistId})
        .done((error)=>{
            if(error != "") {
                alert(error);
                return;
            }
            openPage("yourMusic.php");
        })
    }
}

function hideOptionsMenu () {
    var menu = $(".optionsMenu");
    if(menu.css("display") != "none") {
        menu.css("display", "none");
    }
}

function showOptionMenu (button) {
    var menu = $(".optionsMenu");
    var menuWidth = menu.width();
    
    var scrollTop = $(window).scrollTop(); //A distance from the top of the window to the top of a document
    var elementOffset = $(button).offset().top; // distance from top of document

    var top = elementOffset - scrollTop;
    var left = $(button).position().left;

    menu.css({"top": top + "px", "left": left - menuWidth + "px", "display": "inline"});
}

function formatTime (seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time/60);
    var seconds = time - minutes * 60;

    var extraZero = (seconds < 10) ? "0": "";
    // if(seconds <10 ){
    //     extraZero="0";
    // } else {
    //     extraZero="";
    // }

    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%");
};

function updateVolumeProgressBar (audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");

}

function playFirstSong () {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function (){
        nextSong();
    });
    
    this.audio.addEventListener("canplay", function(){
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("timeupdate", function(){
        if(this.duration) {
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function() {
        updateVolumeProgressBar(this);
    })
    this.setTrack = function(track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }

    this.play = function () {
        this.audio.play();
    }

    this.pause = function () {
        this.audio.pause();
    }

    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }
}