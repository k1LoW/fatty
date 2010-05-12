/**
 * Base64 encoding
 * http://www.ietf.org/rfc/rfc2045.txt
 */
var Base64 = function() {
    this.initialize();
};

Base64.prototype.initialize = function() {
    this.symbols = [];
    var startChar = "A".charCodeAt(0);
    for(var i = 0; i < 26; i++) {
        this.symbols.push(String.fromCharCode(startChar + i));
    }
    startChar = "a".charCodeAt(0);
    for(var i = 0; i < 26; i++) {
        this.symbols.push(String.fromCharCode(startChar + i));
    }
    startChar = "0".charCodeAt(0);
    for(var i = 0; i < 10; i++) {
        this.symbols.push(String.fromCharCode(startChar + i));
    }
    this.symbols.push("+", "/");

    this.encodeMap = [];
    for(var i = 0; i < this.symbols.length; i++) {
        this.encodeMap[i] = this.symbols[i];
    }

    this.decodeMap = [];
    for(var i = 0; i < this.symbols.length; i++) {
        this.decodeMap[this.symbols[i]] = i;
    }
    this.decodeMap["="] = null;
};

Base64.prototype.encode = function(octets) {
    var i;
    var map = this.encodeMap;
    var encoded = [];
    for (i = 0, len = Math.floor(octets.length / 3) * 3;
         i < len; i += 3) {
        var b0 = octets[i];
        var b1 = octets[i + 1];
        var b2 = octets[i + 2];
        var qs = map[(b0 >> 2) & 0x3f]
            + map[((b0 << 4) + (b1 >> 4)) & 0x3f]
            + map[((b1 << 2) + (b2 >> 6)) & 0x3f]
            + map[b2 & 0x3f];
        encoded.push(qs);
    }

    switch(octets.length % 3) {
    case 1:
        var b0 = octets[i];
        var qs = map[(b0 >> 2) & 0x3f]
            + map[(b0 << 4) & 0x3f]
            + "==";
        encoded.push(qs);
        break;
    case 2:
        var b0 = octets[i];
        var b1 = octets[i + 1];
        var qs = map[(b0 >> 2) & 0x3f]
            + map[((b0 << 4) + (b1 >> 4)) & 0x3f]
            + map[(b1 << 2) & 0x3f]
            + "=";
        encoded.push(qs);
        break;
    }

    return encoded.join("");
};

Base64.prototype.decode = function(encoded) {
    if(encoded.length % 4 != 0) {
        throw "encoded.length must be a multiple of 4.";
    }

    var decoded = [];
    var map = this.decodeMap;
    for (var i = 0, len = encoded.length; i < len; i += 4) {
        var b0 = map[encoded[i]];
        var b1 = map[encoded[i + 1]];
        var b2 = map[encoded[i + 2]];
        var b3 = map[encoded[i + 3]];

        var d0 = ((b0 << 2) + (b1 >> 4)) & 0xff;
        decoded.push(d0);

        if(b2 == null) break; // encoded[i + 1] == "="

        var d1 = ((b1 << 4) + (b2 >> 2)) & 0xff;
        decoded.push(d1);

        if(b3 == null) break; // encoded[i + 2] == "="

        var d2 = ((b2 << 6) + b3) & 0xff;
        decoded.push(d2);

    }

    return decoded;
};

Base64.prototype.uriEncodedToOctets = function(uriEncoded) {
    var octets = [];
    for(var i = 0, len = uriEncoded.length; i < len; i++) {
        // Note that IE6 doesn't allow an expression like "uriEncoded[i]";
        var c = uriEncoded.charAt(i);
        var b;
        if (c == "%") {
            var hex = uriEncoded.charAt(++i) + uriEncoded.charAt(++i);
            b = parseInt(hex, 16);
        } else {
            b = c.charCodeAt(0);
        }
        octets.push(b);
    }
    return octets;
};

Base64.prototype.encodeStringAsUTF8 = function(utf8str) {
    var uriEncoded = encodeURIComponent(utf8str);
    var octets = this.uriEncodedToOctets(uriEncoded);
    return this.encode(octets);
};

Base64.prototype.octetsToUriEncoded = function(octets) {
    var uriEncoded = [];

    for(var i = 0, len = octets.length; i < len; i++) {
        var hex = octets[i].toString(16);
        hex = ("0" + hex).substr(hex.length - 1, 2);
        uriEncoded.push("%" + hex);
    }
    return uriEncoded.join("");
};

Base64.prototype.decodeStringAsUTF8 = function(encoded) {
    var octets = this.decode(encoded);
    var uriEncoded = this.octetsToUriEncoded(octets);
    return         decodeURIComponent(uriEncoded);
};

var base64 = new Base64();
