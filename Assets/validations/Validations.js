/*
  Created by IntelliJ IDEA.
  User: CENTILLIONAIRE
  Date: 08-10-2023
  Day:  Sunday
  Time: 07:07 pm
  To change this template use File | Settings | File Templates.
*/

function checkUserName(userName){
    return (/^[a-z]{1}[a-z0-9]{4,14}$/.test(userName));
}

function checkEmail(userEmail){
    const indexOfAtSymbol = userEmail.indexOf('@');
    const substringBeforeAtSymbol = userEmail.slice(0, indexOfAtSymbol).replace(/\./g, '');
    const lengthBeforeAtSymbol = substringBeforeAtSymbol.length;

    return (/^(?=.*[0-9]?)(?=.*[a-zA-Z])(?!.*\.{2,})[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)*@(gmail\.com|utu\.ac\.in|outlook\.com|yahoo\.com)$/.test(userEmail) && (lengthBeforeAtSymbol >= 6 && lengthBeforeAtSymbol <= 30));
}

function checkPassword(userPassword){
    return /^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[!@#$%^&*_])[a-zA-Z0-9!@#$%^&*_]{6,10}$/.test(userPassword);
}

function checkSongTitle(userSongTitle){
    return /^[a-zA-Z0-9.\-+ ()"\[\]?]{2,}$/gm.test(userSongTitle);
}

function checkArtistName(userArtistName){
    return /^[a-zA-Z0-9., \-&]{2,}/gm.test(userArtistName)
}

function checkAlbumName(userAlbumName){
    return /^[a-zA-Z0-9.:\-+ ()"]{2,}/gm.test(userAlbumName)
}

function checkPlaylistName(playlistName){
    return /^[a-zA-Z0-9.\-]{2,}/gm.test(playlistName)
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}


function isValidDurationFormat(duration) {
    const regex = /^[0-5]?[0-9]:[0-5][0-9]$/;
    return regex.test(duration);
}

function isInvalidDurationValue(duration) {
    const parts = duration.split(':');
    const minutes = parseInt(parts[0], 10);
    const seconds = parseInt(parts[1], 10);

    return minutes <= 0 && seconds <= 0;
}