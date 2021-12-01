(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
    typeof define === 'function' && define.amd ? define(['exports'], factory) :
    (global = global || self, factory(global.travelMarker = {}));
}(this, (function (exports) { 'use strict';

    var latlngDistance = function (p1, p2) {
        var EarthRadiusMeters = 6378137.0; // meters
        var dLat = (p2.lat - p1.lat) * Math.PI / 180;
        var dLon = (p2.lng - p1.lng) * Math.PI / 180;
        var angle = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(p1.lat * Math.PI / 180) * Math.cos(p2.lat * Math.PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
        var c = 2 * Math.atan2(Math.sqrt(angle), Math.sqrt(1 - angle));
        var distance = EarthRadiusMeters * c;
        return distance;
    };
    var getAngle = function (p1, p2) {
        var f1 = Math.PI * p1.lat() / 180;
        var f2 = Math.PI * p2.lat() / 180;
        var dl = Math.PI * (p2.lng() - p1.lng()) / 180;
        return Math.atan2(Math.sin(dl) * Math.cos(f2), Math.cos(f1) * Math.sin(f2) - Math.sin(f1) * Math.cos(f2) * Math.cos(dl));
    };

    var DefaultMarker = /** @class */ (function () {
        function DefaultMarker(markerOptions, speed, interval, speedMultiplier, path, cameraOnMarker) {
            this.marker = null;
            this.path = [];
            this.playing = false;
            this.numDelta = 0;
            this.delta = null;
            this.index = 0;
            this.deltaIndex = 0;
            this.deltaCurr = null;
            this.deltaLast = null;
            this.angle = 0;
            this.speed = 0;
            this.interval = 0;
            this.speedMultiplier = 1;
            this.cameraOnMarker = false;
            this.markerOptions = {};
            this.eventEmitter = null;
            // console.log(markerOptions, speed, interval, path, cameraOnMarker);
            this.marker = new google.maps.Marker(markerOptions);
            // console.log(this.marker);
            this.markerOptions = markerOptions;
            this.speed = speed;
            this.interval = interval;
            this.speedMultiplier = speedMultiplier;
            this.path = path;
            this.cameraOnMarker = cameraOnMarker;
            return this;
        }
        DefaultMarker.prototype.setEventEmitter = function (eventEmitter) {
            this.eventEmitter = eventEmitter;
        };
        DefaultMarker.prototype.getAnimation = function () {
            return this.marker.getAnimation();
        };
        DefaultMarker.prototype.getCursor = function () {
            return this.marker.getCursor();
        };
        DefaultMarker.prototype.getClickable = function () {
            return this.marker.getClickable();
        };
        DefaultMarker.prototype.getDraggable = function () {
            return this.marker.getDraggable();
        };
        DefaultMarker.prototype.getIcon = function () {
            return this.marker.getDraggable();
        };
        DefaultMarker.prototype.getLabel = function () {
            return this.marker.getLabel();
        };
        DefaultMarker.prototype.getMap = function () {
            return this.marker.getMap();
        };
        DefaultMarker.prototype.getOpacity = function () {
            return this.marker.getOpacity();
        };
        DefaultMarker.prototype.getPosition = function () {
            return this.marker.getPosition();
        };
        DefaultMarker.prototype.getShape = function () {
            return this.marker.getShape();
        };
        DefaultMarker.prototype.getTitle = function () {
            return this.marker.getTitle();
        };
        DefaultMarker.prototype.getVisible = function () {
            return this.marker.getVisible();
        };
        DefaultMarker.prototype.getZIndex = function () {
            return this.marker.getZIndex();
        };
        DefaultMarker.prototype.setMap = function (map) {
            this.marker.setMap(map);
        };
        DefaultMarker.prototype.setPosition = function (latLng) {
            if (this.cameraOnMarker) {
                this.getMap().panTo(latLng);
            }
            this.marker.setPosition(latLng);
        };
        DefaultMarker.prototype.setTitle = function (title) {
            this.marker.setTitle(title);
        };
        DefaultMarker.prototype.setLabel = function (label) {
            this.marker.setLabel(label);
        };
        DefaultMarker.prototype.setDraggable = function (draggable) {
            this.marker.setDraggable(draggable);
        };
        DefaultMarker.prototype.setIcon = function (icon) {
            this.marker.setIcon(icon);
        };
        DefaultMarker.prototype.setOpacity = function (opacity) {
            this.marker.setOpacity(opacity);
        };
        DefaultMarker.prototype.setVisible = function (visible) {
            this.marker.setVisible(visible);
        };
        DefaultMarker.prototype.setZIndex = function (zIndex) {
            this.marker.setZIndex(zIndex);
        };
        DefaultMarker.prototype.setAnimation = function (animation) {
            this.marker.setAnimation(animation);
        };
        DefaultMarker.prototype.setClickable = function (clickable) {
            this.marker.setClickable(clickable);
        };
        DefaultMarker.prototype.setOptions = function (options) {
            this.marker.setOptions(options);
        };
        DefaultMarker.prototype.addListener = function (eventName, handler) {
            var _this = this;
            if (!this.marker) {
                setTimeout(function () { return _this.addListener(eventName, handler); }, 300);
            }
            else {
                return this.marker.addListener(eventName, handler);
            }
        };
        DefaultMarker.prototype.setSpeed = function (speed) {
            if (speed === void 0) { speed = this.speed; }
            this.speed = speed;
        };
        DefaultMarker.prototype.setInterval = function (interval) {
            if (interval === void 0) { interval = this.interval; }
            this.interval = interval;
        };
        DefaultMarker.prototype.setSpeedMultiplier = function (multiplier) {
            this.speedMultiplier = multiplier;
        };
        DefaultMarker.prototype.addLocation = function (locationArray) {
            var _this = this;
            if (locationArray === void 0) { locationArray = []; }
            locationArray.forEach(function (location) {
                if (location.lat && location.lng) {
                    _this.path.push(location);
                }
            });
        };
        DefaultMarker.prototype.updateOptions = function (markerOptions) {
            this.markerOptions = Object.assign(this.markerOptions, markerOptions);
            this.setOptions(this.markerOptions);
        };
        // animation
        DefaultMarker.prototype.play = function () {
            this.playing = true;
            this.eventEmitter.emitEvent('play', {
                location: this.marker.getPosition(),
                status: 'playing',
                playing: this.playing,
                index: this.index
            });
            this.animate();
        };
        DefaultMarker.prototype.pause = function () {
            this.playing = false;
            this.eventEmitter.emitEvent('paused', {
                location: this.marker.getPosition(),
                status: 'paused',
                playing: this.playing,
                index: this.index
            });
            this.animate();
        };
        DefaultMarker.prototype.reset = function () {
            this.playing = false;
            this.index = 0;
            this.delta = null;
            this.setPosition(this.path[this.index]);
            this.eventEmitter.emitEvent('reset', {
                location: this.marker.getPosition(),
                status: 'reset',
                playing: this.playing,
                index: this.index
            });
        };
        DefaultMarker.prototype.next = function () {
            if (this.index === this.path.length - 1) { // last index
                return;
            }
            this.index++;
            this.delta = null;
            this.setPosition(this.path[this.index]);
            this.eventEmitter.emitEvent('next', {
                location: this.marker.getPosition(),
                status: 'playing',
                playing: this.playing,
                index: this.index
            });
        };
        DefaultMarker.prototype.prev = function () {
            if (!this.index) { // first Index
                return;
            }
            this.index--;
            this.delta = null;
            this.setPosition(this.path[this.index]);
            this.eventEmitter.emitEvent('previous', {
                location: this.marker.getPosition(),
                status: 'playing',
                playing: this.playing,
                index: this.index
            });
        };
        DefaultMarker.prototype.updateMarker = function () {
            var _this = this;
            if (this.index >= this.path.length - 1) {
                this.eventEmitter.emitEvent('finished', {
                    location: this.marker.getPosition(),
                    status: 'finished',
                    playing: this.playing,
                    index: this.index
                });
                return 'no more points to show';
            }
            if (!this.playing) {
                return 'paused';
            }
            if (!this.marker) {
                setTimeout(function () { return _this.updateMarker(); }, 100);
            }
            this.eventEmitter.emitEvent('checkpoint', {
                location: this.marker.getPosition(),
                status: 'playing',
                playing: this.playing,
                index: this.index
            });
            var curr = this.marker.getPosition();
            var next = this.path[this.index + 1];
            var distance = latlngDistance({ lat: curr.lat(), lng: curr.lng() }, { lat: next.lat(), lng: next.lng() });
            // console.log('update car', next.lat(), next.lng(), distance, this.index);
            this.angle = getAngle(curr, next) * 180 / Math.PI;
            // console.log('angle', this.angle);
            this.numDelta = Math.floor((distance * (1000 / this.interval)) / this.speed);
            // console.log(this.numDelta);
            this.index++;
            if (!this.numDelta) {
                // console.log('skip to next marker');
                setTimeout(function () { return _this.updateMarker(); }, this.interval * Math.ceil(1 / this.speedMultiplier));
            }
            else {
                var deltaLat = (next.lat() - curr.lat()) / this.numDelta;
                var deltaLng = (next.lng() - curr.lng()) / this.numDelta;
                this.delta = { lat: deltaLat, lng: deltaLng };
                this.deltaIndex = 0;
                this.deltaCurr = { lat: curr.lat(), lng: curr.lng() };
                this.deltaLast = { lat: next.lat(), lng: next.lng() };
                // console.log(this.delta, this.deltaCurr, this.deltaLast, this.deltaIndex);
                setTimeout(function () { return _this.animate(); }, this.interval * Math.ceil(1 / this.speedMultiplier));
            }
        };
        DefaultMarker.prototype.animate = function () {
            var _this = this;
            if (!this.deltaCurr || !this.delta || !this.deltaLast) {
                // console.log('update marker');
                this.updateMarker();
                return;
            }
            if (!this.playing) {
                // console.log('paused');
                return 'paused';
            }
            this.deltaCurr.lat += this.delta.lat * Math.ceil(this.speedMultiplier);
            this.deltaCurr.lng += this.delta.lng * Math.ceil(this.speedMultiplier);
            var newPos = { lat: this.deltaCurr.lat, lng: this.deltaCurr.lng };
            // console.log('new pos', newPos, this.deltaIndex);
            this.setPosition(newPos);
            var nextIndex = this.deltaIndex + Math.ceil(this.speedMultiplier);
            // console.log('nextIndex', nextIndex,  Math.ceil(1 / this.speedMultiplier));
            if (nextIndex < this.numDelta) {
                this.deltaIndex = nextIndex;
                setTimeout(function () { return _this.animate(); }, this.interval * Math.ceil(1 / this.speedMultiplier));
            }
            else {
                // console.log('last', this.deltaLast);
                setTimeout(function () {
                    _this.setPosition(_this.deltaLast);
                    _this.updateMarker();
                }, this.interval * Math.ceil(1 / this.speedMultiplier));
            }
        };
        return DefaultMarker;
    }());

    var CustomOverlayMarker = /** @class */ (function () {
        function CustomOverlayMarker(map, overlayOptions, speed, interval, speedMultiplier, path, cameraOnMarker) {
            this.marker = null;
            this.overlayOptions = {
                offsetX: 0,
                offsetY: 0,
                offsetAngle: 0,
                imageUrl: '',
                imageWidth: 0,
                imageHeight: 0
            };
            this.map = null;
            this.angle = 0;
            this.path = [];
            this.playing = false;
            this.numDelta = 0;
            this.delta = null;
            this.index = 0;
            this.deltaIndex = 0;
            this.deltaCurr = null;
            this.deltaLast = null;
            this.speed = 0;
            this.interval = 0;
            this.speedMultiplier = 1;
            this.cameraOnMarker = false;
            this.eventEmitter = null;
            this.map = map;
            this.overlayOptions = overlayOptions;
            this.speed = speed;
            this.interval = interval;
            this.speedMultiplier = speedMultiplier;
            this.path = path;
            this.cameraOnMarker = cameraOnMarker;
            var position = path[0];
            this.angle = path.length > 1 ? getAngle(path[0], path[1]) * 180 / Math.PI : 0;
            // this.div_ = null;
            var marker = new google.maps.OverlayView();
            marker.setMap(map);
            marker.div_ = null;
            marker.overlayOptions = this.overlayOptions;
            marker.angle = this.angle;
            marker.position = position;
            marker.cameraOnMarker = cameraOnMarker;
            marker.onAdd = function () {
                var div = document.createElement('DIV');
                div.style.borderStyle = 'none';
                div.style.borderWidth = '0px';
                div.style.position = 'absolute';
                // Create the img element and attach it to the div.
                var img = document.createElement('img');
                img.src = marker.overlayOptions.imageUrl;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.position = 'absolute';
                div.appendChild(img);
                marker.div_ = div;
                // Add the element to the "overlayLayer" pane.
                var panes = marker.getPanes();
                panes.overlayMouseTarget.appendChild(div);
            };
            marker.setOverlayOptions = function (options) {
                marker.overlayOptions = options;
                marker.draw();
            };
            marker.setPosition = function (pos) {
                if (marker.cameraOnMarker) {
                    marker.getMap().setCenter(pos);
                }
                if (typeof pos.lat === 'function' || typeof pos.lng === 'function') {
                    marker.position = pos;
                }
                else {
                    marker.position = new google.maps.LatLng(pos.lat, pos.lng);
                }
                marker.draw();
            };
            marker.getPosition = function () {
                return marker.position;
            };
            marker.setAngle = function (angle) {
                marker.angle = angle;
                marker.draw();
            };
            marker.draw = function () {
                // We use the south-west and north-east
                // coordinates of the overlay to peg it to the correct position and size.
                // To do this, we need to retrieve the projection from the overlay.
                // overlayProjection = this.getProjection();
                var div = marker.div_;
                var point = null;
                // if (this.position) {
                //   console.log('this.position', this.position);
                // }
                // var myPos = this.position !== undefined ? this.position : pos;
                // console.log('myPos', myPos);
                if (marker.position) {
                    point = marker.getProjection().fromLatLngToDivPixel(marker.position);
                }
                if (point) {
                    div.style.left = point.x - (marker.overlayOptions.imageWidth / 2) + marker.overlayOptions.offsetX + 'px';
                    div.style.top = point.y - (marker.overlayOptions.imageHeight / 2) + marker.overlayOptions.offsetY + 'px';
                    div.style.width = marker.overlayOptions.imageWidth + "px";
                    div.style.height = marker.overlayOptions.imageHeight + "px";
                    div.style.transform = 'rotate(' + marker.angle + marker.overlayOptions.offsetAngle + 'deg)';
                    // div.style.zIndex = '9999999';
                    // marker.div_ = div;
                }
                // google.maps.event.addDomListener(marker.div_, 'click', function(event) {
                //   console.log('overlay');
                // });
                /*
                // Retrieve the south-west and north-east coordinates of this overlay
                // in LatLngs and convert them to pixel coordinates.
                // We'll use these coordinates to resize the div.
                var sw = overlayProjection.fromLatLngToDivPixel(this.bounds_.getSouthWest());
                var ne = overlayProjection.fromLatLngToDivPixel(this.bounds_.getNorthEast());
          
                // Resize the image's div to fit the indicated dimensions.
                var div = this.div_;
                div.style.left = sw.x + 'px';
                div.style.top = ne.y + 'px';
                div.style.width = (ne.x - sw.x) + 'px';
                div.style.height = (sw.y - ne.y) + 'px';
                */
            };
            marker.addListener = function (eventName, handler) {
                if (!marker.div_) {
                    setTimeout(function () { return marker.addListener(eventName, handler); }, 300);
                }
                else {
                    google.maps.event.addDomListener(marker.div_, eventName, handler);
                }
            };
            // The onRemove() method will be called automatically from the API if
            // we ever set the overlay's map property to 'null'.
            marker.onRemove = function () {
                marker.div_.parentNode.removeChild(this.div_);
                marker.div_ = null;
            };
            this.marker = marker;
            return this;
        }
        CustomOverlayMarker.prototype.equalLatLng = function (loc1, loc2) {
            return loc1.lat() === loc2.lat() && loc1.lng() === loc2.lng();
        };
        CustomOverlayMarker.prototype.addListener = function (eventName, handler) {
            this.marker.addListener(eventName, handler);
        };
        CustomOverlayMarker.prototype.getPosition = function () {
            return this.marker.getPosition();
        };
        CustomOverlayMarker.prototype.setMap = function (map) {
            this.marker.setMap(map);
        };
        CustomOverlayMarker.prototype.setEventEmitter = function (eventEmitter) {
            this.eventEmitter = eventEmitter;
        };
        CustomOverlayMarker.prototype.addLocation = function (locationArray) {
            var _this = this;
            if (locationArray === void 0) { locationArray = []; }
            locationArray.forEach(function (location) {
                if (location.lat && location.lng) {
                    _this.path.push(location);
                }
            });
        };
        CustomOverlayMarker.prototype.setSpeed = function (speed) {
            if (speed === void 0) { speed = this.speed; }
            this.speed = speed;
        };
        CustomOverlayMarker.prototype.setInterval = function (interval) {
            if (interval === void 0) { interval = this.interval; }
            this.interval = interval;
        };
        CustomOverlayMarker.prototype.setSpeedMultiplier = function (multiplier) {
            this.speedMultiplier = multiplier;
        };
        CustomOverlayMarker.prototype.updateOptions = function (overlayOptions) {
            this.overlayOptions = Object.assign(this.overlayOptions, overlayOptions);
            this.marker.setOverlayOptions(this.overlayOptions);
        };
        // animation
        CustomOverlayMarker.prototype.play = function () {
            this.playing = true;
            this.eventEmitter.emitEvent('play', {
                location: this.marker.getPosition(),
                status: 'playing',
                playing: this.playing,
                index: this.index
            });
            this.animate();
        };
        CustomOverlayMarker.prototype.pause = function () {
            this.playing = false;
            this.eventEmitter.emitEvent('paused', {
                location: this.marker.getPosition(),
                status: 'paused',
                playing: this.playing,
                index: this.index
            });
            this.animate();
        };
        CustomOverlayMarker.prototype.reset = function () {
            this.playing = false;
            this.index = 0;
            this.delta = null;
            this.angle = this.path.length > 1 ? getAngle(this.path[0], this.path[1]) * 180 / Math.PI : 0;
            this.marker.setPosition(this.path[this.index]);
            this.marker.setAngle(this.angle);
            this.eventEmitter.emitEvent('reset', {
                location: this.marker.getPosition(),
                status: 'reset',
                playing: this.playing,
                index: this.index
            });
        };
        CustomOverlayMarker.prototype.next = function () {
            if (this.index === this.path.length - 1) { // last index
                return;
            }
            this.index++;
            this.delta = null;
            this.marker.setPosition(this.path[this.index]);
            if (this.index < (this.path.length - 2)) {
                var currentLoc = this.path[this.index];
                var nextLoc = this.path[this.index + 1];
                if (this.equalLatLng(currentLoc, nextLoc)) {
                    return;
                }
                this.angle = getAngle(currentLoc, nextLoc) * 180 / Math.PI;
                this.marker.setAngle(this.angle);
            }
        };
        CustomOverlayMarker.prototype.prev = function () {
            if (!this.index) { // first Index
                return;
            }
            this.index--;
            this.delta = null;
            this.marker.setPosition(this.path[this.index]);
            if (this.index < (this.path.length - 2)) {
                var currentLoc = this.path[this.index];
                var nextLoc = this.path[this.index + 1];
                if (this.equalLatLng(currentLoc, nextLoc)) {
                    return;
                }
                this.angle = getAngle(this.path[this.index], this.path[this.index + 1]) * 180 / Math.PI;
                this.marker.setAngle(this.angle);
            }
        };
        CustomOverlayMarker.prototype.updateMarker = function () {
            var _this = this;
            if (this.index === this.path.length - 1) {
                this.eventEmitter.emitEvent('finished', {
                    location: this.marker.getPosition(),
                    status: 'finished',
                    playing: this.playing,
                    index: this.index
                });
                return 'no more points to show';
            }
            if (!this.playing) {
                return 'paused';
            }
            if (!this.marker) {
                setTimeout(function () { return _this.updateMarker(); }, 100);
            }
            this.eventEmitter.emitEvent('checkpoint', {
                location: this.marker.getPosition(),
                status: 'playing',
                playing: this.playing,
                index: this.index
            });
            var curr = this.marker.getPosition();
            var next = this.path[this.index + 1];
            var distance = latlngDistance({ lat: curr.lat(), lng: curr.lng() }, { lat: next.lat(), lng: next.lng() });
            // console.log('update car', next.lat(), next.lng(), distance, this.index);
            this.numDelta = Math.floor((distance * (1000 / this.interval)) / this.speed);
            // console.log(this.numDelta);
            this.index++;
            if (!this.numDelta) {
                // console.log('skip to next marker');
                this.updateMarker();
            }
            else {
                this.angle = getAngle(curr, next) * 180 / Math.PI;
                // console.log('angle', this.angle);
                this.marker.setAngle(this.angle);
                var deltaLat = (next.lat() - curr.lat()) / this.numDelta;
                var deltaLng = (next.lng() - curr.lng()) / this.numDelta;
                this.delta = { lat: deltaLat, lng: deltaLng };
                this.deltaIndex = 0;
                this.deltaCurr = { lat: curr.lat(), lng: curr.lng() };
                this.deltaLast = { lat: next.lat(), lng: next.lng() };
                // console.log(this.delta, this.deltaCurr, this.deltaLast, this.deltaIndex);
                setTimeout(function () { return _this.animate(); }, this.interval * Math.ceil(1 / this.speedMultiplier));
            }
        };
        CustomOverlayMarker.prototype.animate = function () {
            var _this = this;
            if (!this.deltaCurr || !this.delta || !this.deltaLast) {
                // console.log('update marker');
                this.updateMarker();
                return;
            }
            if (!this.playing) {
                // console.log('paused');
                return 'paused';
            }
            this.deltaCurr.lat += this.delta.lat * Math.ceil(this.speedMultiplier);
            this.deltaCurr.lng += this.delta.lng * Math.ceil(this.speedMultiplier);
            var newPos = { lat: this.deltaCurr.lat, lng: this.deltaCurr.lng };
            // console.log('new pos', newPos, this.deltaIndex);
            this.marker.setPosition(newPos);
            var nextIndex = this.deltaIndex + Math.ceil(this.speedMultiplier);
            if (nextIndex < this.numDelta) {
                this.deltaIndex = nextIndex;
                setTimeout(function () { return _this.animate(); }, this.interval * Math.ceil(1 / this.speedMultiplier));
            }
            else {
                // console.log('last', this.deltaLast);
                setTimeout(function () {
                    _this.marker.setPosition(_this.deltaLast);
                    _this.updateMarker();
                }, this.interval * Math.ceil(1 / this.speedMultiplier));
            }
        };
        return CustomOverlayMarker;
    }());

    // https://github.com/tenry92/typed-event-emitter
    /******************************************************************************
     * The MIT License (MIT)                                                      *
     *                                                                            *
     * Copyright (c) 2016 Simon "Tenry" Burchert                                  *
     *                                                                            *
     * Permission is hereby granted, free of charge, to any person obtaining a    *
     * copy of this software and associated documentation files (the "Software"), *
     * to deal in the Software without restriction, including without limitation  *
     * the rights to use, copy, modify, merge, publish, distribute, sublicense,   *
     * and/or sell copies of the Software, and to permit persons to whom the      *
     * Software is furnished to do so, subject to the following conditions:       *
     *                                                                            *
     * The above copyright notice and this permission notice shall be included in *
     * all copies or substantial portions of the Software.                        *
     *                                                                            *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR *
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,   *
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL    *
     * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER *
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING    *
     * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER        *
     * EALINGS IN THE SOFTWARE.                                                   *
     ******************************************************************************/
    var Listener = /** @class */ (function () {
        function Listener(owner, event, listener) {
            this.owner = owner;
            this.event = event;
            this.listener = listener;
        }
        Listener.prototype.unbind = function () {
            this.owner.removeListener(this);
        };
        return Listener;
    }());
    var EventEmitter = /** @class */ (function () {
        function EventEmitter() {
            this.eventListeners = new Map();
        }
        EventEmitter.prototype.on = function (event, listener) {
            if (!this.eventListeners.has(event)) {
                this.eventListeners.set(event, [listener]);
            }
            else {
                this.eventListeners.get(event).push(listener);
            }
            return new Listener(this, event, listener);
        };
        EventEmitter.prototype.addListener = function (event, listener) {
            return this.on(event, listener);
        };
        EventEmitter.prototype.removeListener = function () {
            if (arguments.length === 0) {
                this.eventListeners.clear();
            }
            else if (arguments.length === 1 && typeof arguments[0] === 'object') {
                var id = arguments[0];
                this.removeListener(id.event, id.listener);
            }
            else if (arguments.length >= 1) {
                var event_1 = arguments[0];
                var listener = arguments[1];
                if (this.eventListeners.has(event_1)) {
                    var listeners = this.eventListeners.get(event_1);
                    var idx = void 0;
                    while (!listener || (idx = listeners.indexOf(listener)) !== -1) {
                        listeners.splice(idx, 1);
                    }
                }
            }
        };
        /**
         * Emit event. Calls all bound listeners with args.
         */
        EventEmitter.prototype.emit = function (event) {
            var args = [];
            for (var _i = 1; _i < arguments.length; _i++) {
                args[_i - 1] = arguments[_i];
            }
            if (this.eventListeners.has(event)) {
                for (var _a = 0, _b = this.eventListeners.get(event); _a < _b.length; _a++) {
                    var listener = _b[_a];
                    listener.apply(void 0, args);
                }
            }
        };
        /**
         * @typeparam T The event handler signature.
         */
        EventEmitter.prototype.registerEvent = function () {
            var _this = this;
            var eventBinder = function (handler) {
                return _this.addListener(eventBinder, handler);
            };
            return eventBinder;
        };
        return EventEmitter;
    }());

    var __extends = (undefined && undefined.__extends) || (function () {
        var extendStatics = function (d, b) {
            extendStatics = Object.setPrototypeOf ||
                ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
                function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
            return extendStatics(d, b);
        };
        return function (d, b) {
            extendStatics(d, b);
            function __() { this.constructor = d; }
            d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
        };
    })();
    var TravelEvents = /** @class */ (function (_super) {
        __extends(TravelEvents, _super);
        function TravelEvents(marker) {
            var _this = _super.call(this) || this;
            _this.onEvent = _this.registerEvent();
            _this.marker = marker;
            _this.marker.setEventEmitter(_this);
            return _this;
        }
        TravelEvents.prototype.emitEvent = function (event, data) {
            this.emit(this.onEvent, event, data);
        };
        return TravelEvents;
    }(EventEmitter));

    /**
     * A google maps library to replay gps locations with animations.
     * @author Manpreet Singh
     * @description A google maps library to replay gps locations with animations.
     * @class TravelMarker
     * * **npm package**: `travel-marker`
     */
    var TravelMarker = /** @class */ (function () {
        /**
         * Creates an instance of TravelMarker.
         *
         *   ### Example
         *
         * Create default marker
         *
         *  ```ts
         *   // options
         *   const options = {
         *     map: map,  // map object
         *     speed: 50,  // default 10 , animation speed
         *     interval: 30, // default 10, marker refresh time
         *     speedMultiplier: 1, // default 1, for fast-forward/rewind
         *     cameraOnMarker: false,  // default false, move camera with marker
         *     markerOptions: { title: "Travel Marker" }
         *   };
         *   let marker = new TravelMarker(options);
         *   ```
         *
         *   Create Overlay marker
         *
         *   ```ts
         *   // options
         *   const options = {
         *     map: map,  // map object
         *     speed: 50,  // default 10 , animation speed
         *     interval: 30, // default 10, marker refresh time
         *     speedMultiplier: 1, // default 1, for fast-forward/rewind
         *     cameraOnMarker: false,  // default false, move camera with marker
         *     markerType: 'overlay',  // default: 'default'
         *     overlayOptions: {
         *       offsetX: 0, // default: 0, x-offset for overlay
         *       offsetY: 0, // default: 0, y-offset for overlay
         *       offsetAngle: 0, // default: 0, rotation-offset for overlay
         *       imageUrl: 'https://i.stack.imgur.com/lDrin.png', // image used for overlay
         *       imageWidth: 36, // image width of overlay
         *       imageHeight: 58, // image height of overlay
         *     }
         *   };
         *   let marker = new TravelMarker(options);
         *   ```
         * @param {TravelMarkerOptions} options
         */
        function TravelMarker(options) {
            /**
             * Defaults for TravelMarkerOptions for constructor
             * @private
            */
            this.defaultOptions = {
                map: null,
                speed: 35,
                interval: 20,
                speedMultiplier: 1,
                markerType: 'default',
                cameraOnMarker: false,
                markerOptions: {
                    position: { lat: 0, lng: 0 }
                },
                overlayOptions: {
                    offsetX: 0,
                    offsetY: 0,
                    offsetAngle: 0,
                    imageUrl: 'https://i.stack.imgur.com/lDrin.png',
                    imageWidth: 36,
                    imageHeight: 58,
                },
                line: null
            };
            this.defaultMarkerOptions = {
                draggable: false,
            };
            this.path = [];
            this.marker = null;
            /** Tells whether animation is playing or not */
            this.playing = false;
            this.numDelta = 0;
            this.delta = null;
            this.index = 0;
            this.deltaIndex = 0;
            this.deltaCurr = null;
            this.deltaLast = null;
            this.angle = 0;
            /**
             * Use events to subscribe to animation events
             *
             * ### Example
             * ```ts
             * //  EventType = 'play' | 'paused' | 'finished' | 'reset' | 'checkpoint';
             * // checkpoint - when marker arrives on a location present in locationArray
             * // TravelData = {
             * //  location: LatLng; // marker current location
             * //  playing: boolean; // is animation playing?
             * //  index: number;  // index in locationArray
             * //  status: 'reset' | 'playing' | 'paused' | 'finished';  // animation status
             * // }
             * marker.event.onEvent((event: EventType, data: TravelData) => {
             *   // .... do something
             *  });
             * ```
             */
            this.event = null;
            if (options.map === null) {
                console.error('map cannot be null');
                return;
            }
            options = Object.assign(this.defaultOptions, options);
            options.markerOptions = Object.assign(options.markerOptions, this.defaultMarkerOptions);
            options.markerOptions.map = options.map;
            // check all parmas
            if (this.isValidOptions) {
                this.options = options;
            }
            else {
                console.error('Invalid options');
            }
            return this;
        }
        TravelMarker.prototype.isValidOptions = function (options) {
            return !isNaN(options.speed) && !isNaN(options.interval) &&
                (options.markerType === 'default' || options.markerType === 'symbol' || options.markerType === 'overlay') &&
                typeof options.line === 'object';
        };
        TravelMarker.prototype.setListener = function () {
            var _this = this;
            this.event = new TravelEvents(this.marker);
            this.event.onEvent(function (event, data) {
                _this.playing = data.playing;
            });
        };
        /**
         * Get TravelMarkerOptions used at creation
         * ### Example
         * ```ts
         *  marker.getOptions();
         * ```
         * @returns {TravelMarkerOptions}
         */
        TravelMarker.prototype.getOptions = function () {
            return JSON.parse(JSON.stringify(this.options));
        };
        /**
         * Return Current position of the marker aa LatLng object.
         * ### Example
         * ```ts
         * marker.getPosition(); // returns LatLng object
         * ```
         * @returns {(LatLng)} returns LatLng object
         */
        TravelMarker.prototype.getPosition = function () {
            return this.marker ? this.marker.getPosition() : null;
        };
        /**
         * Add Location points for animation
         * ### Example
         * ```ts
         * const locationArray = [new google.maps.Latlng(74,23), new google.maps.LatLng(74.02,23.02), new google.maps.LatLng(74.04, 23.04)];
         *
         * marker.addLocation(locationArray);
         * ```
         * @param {LatLng[]} [locationArray=[]]
         */
        TravelMarker.prototype.addLocation = function (locationArray) {
            var _this = this;
            if (locationArray === void 0) { locationArray = []; }
            locationArray.forEach(function (location) {
                if (location.lat && location.lng) {
                    _this.path.push(location);
                }
            });
            if (!this.marker && this.path.length) {
                if (this.options.markerType === 'default') {
                    var markerOptions = Object.assign(this.options.markerOptions, { position: { lat: this.path[0].lat(), lng: this.path[0].lng() } });
                    this.marker = new DefaultMarker(markerOptions, this.options.speed, this.options.interval, this.options.speedMultiplier, this.path, this.options.cameraOnMarker);
                }
                else if (this.options.markerType === 'overlay') {
                    this.marker = new CustomOverlayMarker(this.options.map, this.options.overlayOptions, this.options.speed, this.options.interval, this.options.speedMultiplier, this.path, this.options.cameraOnMarker);
                }
                this.setListener();
            }
            else if (this.marker) {
                this.marker.addLocation(locationArray);
            }
            else {
                console.error('Please insert valid location Array');
            }
        };
        /**
         * Play Animation
         * ### Example
         * ```ts
         *   marker.play();
         * ```
         */
        TravelMarker.prototype.play = function () {
            this.playing = true;
            this.marker.play();
        };
        /**
         * Pause Animation
         * ### Example
         * ```ts
         *   marker.pause();
         * ```
         */
        TravelMarker.prototype.pause = function () {
            this.playing = false;
            this.marker.pause();
        };
        /**
         * Reset marker to the starting point
         * ### Example
         * ```ts
         *   marker.reset();
         * ```
         */
        TravelMarker.prototype.reset = function () {
            this.playing = false;
            this.marker.reset();
        };
        /**
         * Go to next location
         * ### Example
         * ```ts
         *   marker.next();
         * ```
         */
        TravelMarker.prototype.next = function () {
            this.marker.next();
        };
        /**
         * Go to Previous location
         * ### Example
         * ```ts
         *   marker.prev();
         * ```
         */
        TravelMarker.prototype.prev = function () {
            this.marker.prev();
        };
        /**
         * Set Maker Update interval
         * ### Example
         * ```ts
         *   marker.setInterval(30);
         * ```
         * @param {number} [interval=this.options.interval]
         */
        TravelMarker.prototype.setInterval = function (interval) {
            if (interval === void 0) { interval = this.options.interval; }
            this.options.interval = interval;
            this.marker.setInterval(interval);
        };
        /**
         * Set speed multiplier to control animation speed
         * ### Example
         * Fast-Forward by 2X
         * ```ts
         * marker.setSpeedMultiplier(2);
         * ```
         *
         * Rewind/Slow by 0.5X
         * ```ts
         * marker.setSpeedMultiplier(0.5);
         * ```
         * @param {number} multiplier
         */
        TravelMarker.prototype.setSpeedMultiplier = function (multiplier) {
            this.options.speedMultiplier = multiplier;
            this.marker.setSpeedMultiplier(multiplier);
        };
        /**
         * Set Animation Speed
         * ### Example
         * ```ts
         *   marker.setSpeed(100);
         * ```
         * @param {number} [speed=this.options.speed]
         */
        TravelMarker.prototype.setSpeed = function (speed) {
            if (speed === void 0) { speed = this.options.speed; }
            this.options.speed = speed;
            this.marker.setSpeed(speed);
        };
        /**
         * Set Marker options like opacity etc. Only applicable for default marker types.
         * Returns false if not applicable
         *  ### Example
         * ```ts
         *  marker.setMarkerOptions({ opacity: 0.8 });
         * ```
         * @param {MarkerOptions} [options=this.options.markerOptions]
         * @returns {boolean}  returns false if not applicable
         */
        TravelMarker.prototype.setMarkerOptions = function (options) {
            if (options === void 0) { options = this.options.markerOptions; }
            if (this.options.markerType === 'default') {
                this.options.markerOptions = Object.assign(this.options.markerOptions, options);
                this.marker.updateOptions(this.options.markerOptions);
                return true;
            }
            else {
                return false;
            }
        };
        /**
         * Set Overlay Options like offsets. Only applicable for overlay.
         * Returns false if not applicable
         * ### Example
         * ```ts
         *   marker.setOverlayOptions({ offsetAngle: 90 });
         * ```
         * @param {OverlayOptions} options  Overlay Options
         * @returns {boolean}  returns false if not applicable
         */
        TravelMarker.prototype.setOverlayOptions = function (options) {
            if (this.options.markerType === 'overlay') {
                this.options.overlayOptions = Object.assign(this.options.overlayOptions, options);
                this.marker.updateOptions(this.options.overlayOptions);
                return true;
            }
            else {
                return false;
            }
        };
        /**
         * Set map of marker. Useful for show/hide and deletion.
         * ### Example
         * ```ts
         *   marker.setMap(null);
         * ```
         * @param {GoogleMap} map
         */
        TravelMarker.prototype.setMap = function (map) {
            this.marker.setMap(map);
        };
        /**
         * Add Listener to maker events like click, mouseover etc.
         *
         * ### Example - Listen for click events
         * ```ts
         * marker.addListener('click', () => {
         *     // do something...
         *   })
         * ```
         * @param {string} eventName - click,mousover,mouseout etc.
         * @param {Function} handler handler function
         */
        TravelMarker.prototype.addListener = function (eventName, handler) {
            var _this = this;
            if (!this.marker) {
                setTimeout(function () { return _this.addListener(eventName, handler); }, 300);
            }
            else {
                this.marker.addListener(eventName, handler);
            }
        };
        return TravelMarker;
    }());

    exports.CustomOverlayMarker = CustomOverlayMarker;
    exports.DefaultMarker = DefaultMarker;
    exports.TravelEvents = TravelEvents;
    exports.TravelMarker = TravelMarker;

    Object.defineProperty(exports, '__esModule', { value: true });

})));
