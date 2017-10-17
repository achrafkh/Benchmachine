$(document).ready(function() {

	/*
	-----------------------------------------
	Tooltip
	-----------------------------------------
	*/

	$('[data-toggle="tooltip"]').tooltip();

	/*
	-----------------------------------------
	Waves
	-----------------------------------------
	*/

	$.ripple('[waves-hover]', {
		on: 'mouseenter',
		multi: true
	});

	$.ripple('[waves-hover]', {
		multi: true
	});

	$.ripple('[waves-click]', {
		multi: true
	});

	/*
	-----------------------------------------
	Bootstrap Table
	-----------------------------------------
	*/

	$('#table').bootstrapTable();

	/*
	-----------------------------------------
	Focus
	-----------------------------------------
	*/

	var index = 1;
	var nb = ['First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth'];

	$(document).on('focus', '.fb-input', function(){
		var parent = $(this).parents('.fb-box');
		$('.fb-box').removeClass('focused');
		parent.addClass('focused');
		if(parent.index() == index && index < 9){
			$('.fb-wrap').append(
				'<div class="media fb-box">\
					<div class="media-left fb-icon">\
						<i class="icon-facebook"></i>\
					</div>\
					<div class="media-body fb-inner">\
						<h4 class="fb-nb">'+ nb[index] +' page</h4>\
						<input id="fb_page_'+ (index +1) +'" class="fb-input" type="text" name="accounts[]" placeholder="https://www.facebook.com/exemple">\
					</div>\
				</div>'
			)
			index++
		}
	})

	/*
	-----------------------------------------
	Charts
	-----------------------------------------
	*/

	window.chartColors = {
		red: 'rgb(255, 99, 132)',
		orange: 'rgb(255, 159, 64)',
		yellow: 'rgb(255, 205, 86)',
		green: 'rgb(75, 192, 192)',
		blue: 'rgb(54, 162, 235)',
		purple: 'rgb(153, 102, 255)',
		grey: 'rgb(201, 203, 207)'
	};


	(function(global) {
		var Months = [
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December'
		];

		var COLORS = [
			'#4dc9f6',
			'#f67019',
			'#f53794',
			'#537bc4',
			'#acc236',
			'#166a8f',
			'#00a950',
			'#58595b',
			'#8549ba'
		];

		var Samples = global.Samples || (global.Samples = {});
		var Color = global.Color;

		Samples.utils = {
			// Adapted from http://indiegamr.com/generate-repeatable-random-numbers-in-js/
			srand: function(seed) {
				this._seed = seed;
			},

			rand: function(min, max) {
				var seed = this._seed;
				min = min === undefined ? 0 : min;
				max = max === undefined ? 1 : max;
				this._seed = (seed * 9301 + 49297) % 233280;
				return min + (this._seed / 233280) * (max - min);
			},

			numbers: function(config) {
				var cfg = config || {};
				var min = cfg.min || 0;
				var max = cfg.max || 1;
				var from = cfg.from || [];
				var count = cfg.count || 8;
				var decimals = cfg.decimals || 8;
				var continuity = cfg.continuity || 1;
				var dfactor = Math.pow(10, decimals) || 0;
				var data = [];
				var i, value;

				for (i = 0; i < count; ++i) {
					value = (from[i] || 0) + this.rand(min, max);
					if (this.rand() <= continuity) {
						data.push(Math.round(dfactor * value) / dfactor);
					} else {
						data.push(null);
					}
				}

				return data;
			},

			labels: function(config) {
				var cfg = config || {};
				var min = cfg.min || 0;
				var max = cfg.max || 100;
				var count = cfg.count || 8;
				var step = (max - min) / count;
				var decimals = cfg.decimals || 8;
				var dfactor = Math.pow(10, decimals) || 0;
				var prefix = cfg.prefix || '';
				var values = [];
				var i;

				for (i = min; i < max; i += step) {
					values.push(prefix + Math.round(dfactor * i) / dfactor);
				}

				return values;
			},

			months: function(config) {
				var cfg = config || {};
				var count = cfg.count || 12;
				var section = cfg.section;
				var values = [];
				var i, value;

				for (i = 0; i < count; ++i) {
					value = Months[Math.ceil(i) % 12];
					values.push(value.substring(0, section));
				}

				return values;
			},

			color: function(index) {
				return COLORS[index % COLORS.length];
			},

			transparentize: function(color, opacity) {
				var alpha = opacity === undefined ? 0.5 : 1 - opacity;
				return Color(color).alpha(alpha).rgbString();
			}
		};

		window.randomScalingFactor = function() {
			return Math.round(Samples.utils.rand(-100, 100));
		};
		Samples.utils.srand(Date.now());

	}(this));

	var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	var config = {
		type: 'line',
		data: {
			labels: ["January", "February", "March", "April", "May", "June", "July"],
			datasets: [{
				label: "Cocacola",
				borderColor: window.chartColors.red,
				backgroundColor: window.chartColors.red,
				data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ],
			}, {
				label: "Pepsi",
				borderColor: window.chartColors.blue,
				backgroundColor: window.chartColors.blue,
				data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ],
			}, {
				label: "Sprite",
				borderColor: window.chartColors.green,
				backgroundColor: window.chartColors.green,
				data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ],
			}, {
				label: "Fanta",
				borderColor: window.chartColors.yellow,
				backgroundColor: window.chartColors.yellow,
				data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ],
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: true,
			title:{
				display:false,
			},
			legend: {
                position: 'bottom',
            },
			tooltips: {
				mode: 'index',
			},
			hover: {
				mode: 'index'
			},
			scales: {
				yAxes: [{
					stacked: true,
				}]
			}
		}
	};

	window.onload = function() {
		for (var i = 0; i < 2; i++) {
			var ctx = document.getElementById("canvas-" + i).getContext("2d");
			window.myLine = new Chart(ctx, config);
		}
	};
	
});