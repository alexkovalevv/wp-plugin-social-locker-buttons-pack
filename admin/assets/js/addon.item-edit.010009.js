/**
 * Модернизированный файл item-edit.js основного плагина
 * @author Alex Kovalev <alex.kovalevv@gmail.com>
 * @copyright Alex Kovalev 23.04.2017
 * @version 1.0
 */

if( !window.bizpanda ) {
	window.bizpanda = {};
}
if( !window.bizpanda.lockerEditor ) {
	window.bizpanda.lockerEditor = {};
}

(function($) {

	window.bizpanda.lockerEditor = {

		init: function() {
			this.item = $('#opanda_item').val();

			this.basicOptions.init(this, this.item);

			this.trackInputChanges();
			this.updatePreview();

			if( !onp_lang('tr_TR') ) {
				this.initStyleRollerButton();
			}
		},

		/**
		 * Inits a button which offers to buy the StyleRoller Add-on.
		 */
		initStyleRollerButton: function() {
			if( window.window.onp_sl_styleroller || !window.onp_sl_show_styleroller_offer ) {
				return;
			}
			var $button = $("<a target='_blank' class='btn btn-default' id='onp-sl-styleroller-btn' href='" + window.onp_sl_styleroller_offer_url + "'><i class='fa fa-flask'></i>" + window.onp_sl_styleroller_offer_text + "</a>");
			$("#opanda_style").add('#opanda_style__dropdown').after($button);

		},

		/**
		 * Starts to track user input to refresh the preview.
		 */
		trackInputChanges: function() {
			var self = this;

			var tabs = [
				"#OPanda_BasicOptionsMetaBox",
				"#OPanda_SocialOptionsMetaBox",
				"#OPanda_AdvancedOptionsMetaBox",
				"#OPanda_ConnectOptionsMetaBox",
				'#OPanda_SubscriptionOptionsMetaBox'
			];

			tabs = $.bizpanda.filters.run('opanda-track-metaboxes', [tabs]);

			for( var index in tabs ) {
				$('select', tabs[index]).off();

				$(tabs[index]).on('change keyup', "input, select, textarea", function(e) {
					if( $(e.target).attr('id') == 'opanda_overlap' ) {
						return;
					}
					self.refreshPreview();
				});
			}
		},

		/**
		 * Binds the change event of the WP editor.
		 */
		bindWpEditorChange: function(ed) {
			var self = this;

			var changed = function() {
				tinyMCE.activeEditor.save();
				self.refreshPreview();
			};

			if( tinymce.majorVersion <= 3 ) {
				ed.onChange.add(function() {
					changed();
				});
			} else {
				ed.on("change", function() {
					changed();
				});
			}
		},

		/**
		 * Refreshes the preview after short delay.
		 */
		refreshPreview: function(force) {
			var self = this;

			if( this.timerOn && !force ) {
				this.timerAgain = true;
				return;
			}

			this.timerOn = true;
			setTimeout(function() {

				if( self.timerAgain ) {
					self.timerAgain = false;
					self.refreshPreview(true);
				} else {
					self.timerAgain = false;
					self.timerOn = false;
					self.updatePreview();
				}

			}, 500);
		},

		/**
		 * Recreates the preview, submmits forms to the preview frame.
		 */
		recreatePreview: function() {
			var url = $("#lock-preview-wrap").data('url');
			var options = this.getPreviewOptions();

			$.bizpanda.hooks.run('opanda-refresh-preview');
			window.bizpanda.preview.create(url, 'preview', options, 'onp_sl_update_preview_height');
		},

		updatePreview: function() {
			var url = $("#lock-preview-wrap").data('url');
			var options = this.getPreviewOptions();

			$.bizpanda.hooks.run('opanda-refresh-preview');
			window.bizpanda.preview.refresh(url, 'preview', options, 'onp_sl_update_preview_height');
		},

		/**
		 * Gets options for the preview to submit into the frame.
		 */
		getPreviewOptions: function() {

			var options = this.getCommonOptions();
			var options = $.bizpanda.filters.run('opanda-preview-options', [options]);

			if( window.bizpanda.lockerEditor.filterOptions ) {
				options = window.bizpanda.lockerEditor.filterOptions(options);
			}

			$(document).trigger('onp-sl-filter-preview-options', [options]);

			return options;
		},

		getCommonOptions: function() {

			var timer = parseInt($("#opanda_timer").val());
			var showDelay = parseInt($("#opanda_locker_show_delay").val());

			if( Number.isInteger(showDelay) ) {
				showDelay *= 1000;
			} else {
				showDelay = 0;
			}

			var showCloseButtonDelay = parseInt($("#opanda_close_button_show_delay").val());

			if( Number.isInteger(showCloseButtonDelay) ) {
				showCloseButtonDelay *= 1000;
			} else {
				showCloseButtonDelay = 0;
			}

			var options = {

				text: {
					header: $("#opanda_header").val(),
					message: $("#opanda_message").val()
				},

				theme: 'secrets',

				overlap: {
					mode: $("#opanda_overlap").val(),
					position: $("#opanda_overlap_position").val()
				},
				effects: {
					highlight: $("#opanda_highlight").is(':checked')
				},

				locker: {
					showDelay: showDelay,
					timer: ( !timer || timer === 0 ) ? null : timer,
					close: $("#opanda_close").is(':checked'),
					showCloseButtonDelay: showCloseButtonDelay,
					mobile: $("#opanda_mobile").is(':checked')
				},

				proxy: window.opanda_proxy_url
			};

			if( !options.text.header && options.text.message ) {
				options.text = options.text.message;
			}

			var themeName = $("#opanda_style").val() || $("#opanda_style__dropdown").val();

			options.theme = {};
			options.theme['name'] = themeName;

			var themeColorsSelector = 'input[type="radio"][name="opanda_style__colors"]';

			if( $(themeColorsSelector).length ) {
				options.theme['style'] = $(themeColorsSelector + ':checked').val();
			}

			if( themeName == 'input-popup' ) {
				options.theme['thanksLink'] = $('#opanda_input_popup_available_link').is(':checked');
				options.theme['thanksText'] = $('#opanda_input_popup_text_link').val();
			}

			if( window.bizpanda.previewGoogleFonts ) {
				options.theme['fonts'] = window.bizpanda.previewGoogleFonts;
			}

			return options;
		},

		// --------------------------------------
		// Basic Metabox
		// --------------------------------------

		basicOptions: {

			init: function(editor) {
				this.editor = editor;

				this.initThemeSelector();
				this.initCloseButtonOptions();
				this.initOverlapModeButtons();
			},

			initThemeSelector: function() {

				var showThemePreview = function() {
					var select = $("#opanda_style").length ? $("#opanda_style") : $("#opanda_style__dropdown");
					var $item = select.find("option:selected");
					var preview = $item.data('preview');
					var previewHeight = $item.data('previewheight');

					var $wrap = $("#lock-preview-wrap");

					if( preview ) {
						$wrap.find("iframe").hide();
						$wrap.css('height', previewHeight ? previewHeight + 'px' : '300px');
						$wrap.css('background', 'url("' + preview + '") center center no-repeat');
					} else {
						$wrap.find("iframe").show();
						$wrap.css('height', 'auto');
						$wrap.css('background', 'none');
					}
				};

				showThemePreview();

				var checkAvailableInputPopUp = function() {
					var theme = $("#opanda_style").val() || $("#opanda_style__dropdown").val();

					if( theme == 'input-popup' ) {
						$('#OPanda_BasicOptionsMetaBox .factory-control-input_popup_text_link').fadeIn();
						$('#OPanda_AdvancedOptionsMetaBox .factory-control-input_popup_available_link').fadeIn();
					} else {
						$('#OPanda_BasicOptionsMetaBox .factory-control-input_popup_text_link').fadeOut();
						$('#OPanda_AdvancedOptionsMetaBox .factory-control-input_popup_available_link').fadeOut();
					}
				};

				checkAvailableInputPopUp();

				if( document.getElementById('opanda_style__dropdown') != undefined ) {
					document.getElementById('opanda_style__dropdown').onchange = function() {
						checkAvailableInputPopUp();
					};
				}

				if( document.getElementById('opanda_style') != undefined ) {
					document.getElementById('opanda_style').onchange = function() {
						checkAvailableInputPopUp();
					};
				}

				$.bizpanda.hooks.add('opanda-refresh-preview', function() {
					showThemePreview();
				});
			},

			initCloseButtonOptions: function() {
				function checkStateCloseButton() {
					var isChecked = $('#opanda_close').prop('checked');
					if( isChecked ) {
						$('#bp-advanced-close-button-options').fadeIn();
					} else {
						$('#bp-advanced-close-button-options').fadeOut();
					}
				}

				checkStateCloseButton();

				$('#opanda_close').change(function() {
					checkStateCloseButton();
				});
			},

			initOverlapModeButtons: function() {
				var self = this;

				var $overlapControl = $("#OPanda_BasicOptionsMetaBox .factory-control-overlap .factory-buttons-group");
				var $positionControl = $("#OPanda_BasicOptionsMetaBox .factory-control-overlap_position");
				var $position = $("#opanda_overlap_position");

				$overlapControl.after($("<div id='opanda_overlap_position_wrap'></div>").append($position));

				var checkPositionControlVisability = function() {
					var value = $("#opanda_overlap").val();

					if( value === 'full' ) {
						$("#opanda_overlap_position_wrap").css("display", "none");
					} else {
						$("#opanda_overlap_position_wrap").css("display", "inline-block");
					}
				};

				var toggleAjaxOption = function() {
					var value = $("#opanda_overlap").val();

					if( value === 'full' ) {
						$("#opanda-ajax-disabled").hide();
					} else {
						$("#opanda-ajax-disabled").fadeIn();
					}
				};

				checkPositionControlVisability();
				toggleAjaxOption();

				$("#opanda_overlap").change(function() {
					self.editor.recreatePreview();
					checkPositionControlVisability();
					toggleAjaxOption();
				});

				$position.change(function() {
					self.editor.recreatePreview();
				});
			}
		}
	};

	$(function() {
		window.bizpanda.lockerEditor.init();
	});

})(jQuery)

function opanda_editor_callback(e) {
	if( e.type == 'keyup' ) {
		tinyMCE.activeEditor.save();
		window.bizpanda.lockerEditor.refreshPreview();
	}
	return true;
}


