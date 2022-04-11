Array.prototype.has = function(needle) {
	if(this.search(needle)>-1)	return true;
	return false;
};

Array.prototype.search = function(needle) {
	var index = -1;
	for(var i=0; i<this.length; i++) {
        if(typeof this[i] == 'object') {
            if(this[i].compare(needle)) {
				index = i;
				break;
			}
        } else {
            if(this[i] == needle) {
				index = i;
				break;
			}
		}
    }
	return index;
};

Array.prototype.compare = function(arr) {
	if (this.length != arr.length) return false;
	for(var i=0; i<arr.length; i++) {
		if (this[i] !== arr[i]) {
			return false;
			break;
		}
	}
	return true;
};

Array.prototype.each = function(func) {
	for(var i=0; i<this.length; i++) {
		func(this[i]);
	}
}

// Array Remove - By John Resig (MIT Licensed)
Array.prototype.remove = function(from, to) {
	var rest = this.slice(parseInt(to || from) + 1 || this.length);
	this.length = from < 0 ? this.length + from : from;
	return this.push.apply(this, rest);
};