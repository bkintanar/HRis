module.exports = function(utc, format) {
    var local = moment.utc(utc).toDate();
    return moment(local).format(format);
};