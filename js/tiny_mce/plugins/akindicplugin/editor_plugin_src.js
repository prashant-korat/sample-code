/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('akindicplugin');

	tinymce.create('tinymce.plugins.akindicpluginPlugin', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(init) {
		var m = this._menu,showMenu, indic_script, i;

		if (!tinyMCE.hasMenus("indicmenu")) {
			m.init({});
			tinyMCE.addMenu("indicmenu", m);
		}
		this._buildMenu(inst.editorId);
		// load script from cookie
		cookie_script = this._getCookie('indic_script');
		for(i=0; i<this._scripts.length; ++i) {
			if (this._scripts[i] == cookie_script) {
				this._setScript(inst.editorId, i);
				break;
			}
		}
		this._scriptNames = [
			tinyMCE.getLang('lang_indic_script_english'),
			tinyMCE.getLang('lang_indic_script_devanagari'),
			tinyMCE.getLang('lang_indic_script_bengoli'),
			tinyMCE.getLang('lang_indic_script_gujarati'),
			tinyMCE.getLang('lang_indic_script_kannada'),
			tinyMCE.getLang('lang_indic_script_malayalam'),
			tinyMCE.getLang('lang_indic_script_gurumukhi'),
			tinyMCE.getLang('lang_indic_script_telugu'),
			tinyMCE.getLang('lang_indic_script_urdu')
		];
	},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
	_turnedOn: false,
//	_menu: new TinyMCE_Menu(),
	_scripts: ['__roman__', '__devanagari__', '__bengoli__', '__gujarati__', '__kannada__', '__malayalam__', '__gurumukhi__', '__telugu__', '__urdu__' ],
	_scriptNames: [],
	_current: 0,
	_gamabhana: false,
    getInfo : function() {
        return {
            longname : 'akIndicPlugin',
            author : 'Amit Singh',
            authorurl : 'http://amiworks.co.in/talk',
            infourl : 'http://amiworks.co.in/talk/akindicplugin-transliteration-in-indian-lanuguages-for-tinymce/',
            version : "1.0"
        };
    },
	getControlHTML : function(cn) {
		switch (cn) {
			case'akindicplugin':
				return tinyMCE.getMenuButtonHTML(cn, 'lang_indic_toggle_indic_transliteration', '{$pluginurl}/indic.gif', 'indicToggleMenu', 'indicToggleMenu');
		}
		return '';
	},
	_getGamabhanaObject : function(editor_id) {
		if ('object' == typeof this._gamabhana) {
			return this._gamabhana;
		}
		this._gamabhana = new gamabhanaPhoneticHandler(editor_id, '__roman__', '__devanagari__', '#gamabhana#');
		return this._gamabhana;
	},
	_setScript : function(editor_id, script_id) {
		var g = this._getGamabhanaObject(editor_id);
		g.SetLanguage(this._scripts[script_id]);
		this._current = script_id;
		// save current script in a cookie for a month 
		var expires = new Date();
		expires.setTime(expires.getTime() + 1000*3600*24*30);
		this._setCookie('indic_script', this._scripts[script_id], expires);
	},
	initInstance : function(inst) {
		var m = this._menu, indic_script, i;
		if (!tinyMCE.hasMenu("indicmenu")) {
			m.init({});
			tinyMCE.addMenu("indicmenu", m);
		}
		this._buildMenu(inst.editorId);
		// load script from cookie
		cookie_script = this._getCookie('indic_script');
		for(i=0; i<this._scripts.length; ++i) {
			if (this._scripts[i] == cookie_script) {
				this._setScript(inst.editorId, i);
				break;
			}
		}
		this._scriptNames = [
			tinyMCE.getLang('lang_indic_script_english'),
			tinyMCE.getLang('lang_indic_script_devanagari'),
			tinyMCE.getLang('lang_indic_script_bengoli'),
			tinyMCE.getLang('lang_indic_script_gujarati'),
			tinyMCE.getLang('lang_indic_script_kannada'),
			tinyMCE.getLang('lang_indic_script_malayalam'),
			tinyMCE.getLang('lang_indic_script_gurumukhi'),
			tinyMCE.getLang('lang_indic_script_telugu'),
			tinyMCE.getLang('lang_indic_script_urdu')
		];
	},
	execCommand : function(editor_id, element, command, user_interface, value) {
		switch (command) {
			case 'indicToggleMenu':
				this._toggleMenu(editor_id);
				return true;
		}
		return false;
	},
	_toggleMenu : function(editor_id) {
		var m = this._menu;
		var e = document.getElementById(editor_id + '_akindicplugin');
		if (m.isVisible()) {
			console.log('visible');
			m.hide();
			return;
		}
		this._buildMenu(editor_id);
		m.moveRelativeTo(e, 'bl');
		m.moveBy(tinyMCE.isMSIE && !tinyMCE.isOpera ? 0 : 1, -1);
		if (tinyMCE.isOpera) m.moveBy(0, -2);
		m.show();
	},
	_onMenuClick : function(editor_id, script_id) {
		this._setScript(editor_id, script_id);
		this._menu.hide();
	},
	_buildMenu : function(editor_id) {
		var m = this._menu, i, c;
		m.clear();
		m.addTitle(tinyMCE.getLang('lang_indic_choose_script'));
		for(i=0; i<this._scripts.length; ++i) {
			c = (this._current == i)? 'mceMenuSelectedItem'  : 'mceMenuCheckItem';
			m.add({text: this._scriptNames[i], js: 'tinyMCE.plugins.akindicplugin._onMenuClick("'+editor_id+'", '+i+');', class_name: c});
		}
	},
	_loadGamabhana : function() {
	
		pth=tinyMCE.baseURL + '/plugins/akindicplugin';
		tinyMCE.loadScript(pth+'/jscripts/GA1000.js');
		tinyMCE.loadScript(pth+'/jscripts/GA0010.js');
		tinyMCE.loadScript(pth+'/jscripts/gamabhanaLib.js');
	},
	// these two were taken from advanced theme 
    _getCookie : function(name) {
        var dc = document.cookie;
        var prefix = name + "=";
        var begin = dc.indexOf("; " + prefix);

        if (begin == -1) {
            begin = dc.indexOf(prefix);

            if (begin != 0)
                return null;
        } else
            begin += 2;

        var end = document.cookie.indexOf(";", begin);

        if (end == -1)
            end = dc.length;

        return unescape(dc.substring(begin + prefix.length, end));
    },

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Example plugin',
				author : 'Some author',
				authorurl : 'http://tinymce.moxiecode.com',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/akindicplugin',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('akindicplugin', tinymce.plugins.ExamplePlugin);
})();