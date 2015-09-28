module.exports = function(utc) {
    if(! utc) return '--:--';
    return require('./utc_to_local.js')(utc, 'hh:mm A');
}