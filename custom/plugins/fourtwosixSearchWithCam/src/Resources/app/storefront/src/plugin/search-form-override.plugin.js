import SearchWidgetPlugin from 'src/plugin/header/search-widget.plugin';
import DomAccess from 'src/helper/dom-access.helper';
const { BrowserMultiFormatReader, BarcodeFormat, DecodeHintType } = require('./../library/zxing-library-0.19.1.min.js');

export default class SearchFormBarcodePlugin extends SearchWidgetPlugin {
	
	static options = {
		...SearchWidgetPlugin.options,
		barcodeTriggerSelector: '[data-barcode-trigger]',
		barcodeModalSelector: '[data-barcode-modal]',
		barcodeVideoSelector: '[data-barcode-video]',
	};
	
	/**
	 * Added barcode trigger event
	 */
	init() {
		super.init()
		
		this._barcodeTrigger = DomAccess.querySelector(this.el, this.options.barcodeTriggerSelector)
		this._barcodeModal = DomAccess.querySelector(this.el, this.options.barcodeModalSelector)
		this._barcodeVideo = DomAccess.querySelector(this.el, this.options.barcodeVideoSelector)
		$(this._barcodeTrigger).on('click', this._handleBarcodeEvent.bind(this))
		$(this._barcodeModal).on('hide.bs.modal', this._handleBarcodeFinish.bind(this))

		/* Move modal into body, since header fixed causes problems */
		$(this._barcodeModal).appendTo('body')
		this._consoleLog = console.log
	}
	/**
	 * Opens the camera and reads the barcode. Sets the field in the search and submit the form
	 */
	_handleBarcodeEvent(event) {
		event.preventDefault();
		event.stopPropagation();
		this._codeReader = new BrowserMultiFormatReader()

		// Bad but works... since the library outputs too many logs, we'll disable until the library is active
		console.log = () => {}

		this._codeReader.getVideoInputDevices().then((videoInputDevices) => {
			// Open modal
			$(this._barcodeModal).modal()
			try {
				// Ask for permission and decode results
				this._codeReader.decodeOnceFromVideoDevice(null, this._barcodeVideo).then((result) => {
					this._handleBarcodeSuccess(result.text)
				})
			} catch (e) {}
		}).catch((err) => {
			this._handleBarcodeFinish()
		})
	}

	/**
	 * Set the value, calls any eventual function, then proceed to layout cleaning (modal etc)
	 */
	_handleBarcodeSuccess(value) {
		$(this._barcodeModal).modal("hide")
		window.location = value
		this._inputField.value = value
		this._handleInputEvent()
		this._handleBarcodeFinish()
	}
	_handleBarcodeFinish() {
		try { this._codeReader.reset() } catch(e) {}
		this._codeReader = null
		console.log = this._consoleLog
	}
}