(function (jQuery) {
	"use strict";
	/**
	 * File customizer.js.
	 *
	 * Theme Customizer enhancements for a better user experience.
	 *
	 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
	 */
	let hopeui_script_bodyClass = document.getElementsByTagName("body");
	let hopeui_script_slider = document.querySelectorAll('.custom-nav-hopeui_script_slider');

	let hopeui_script_navBarToggler = document.querySelector('.ham-toggle');
	let hopeui_script_customToggler = document.querySelector('.close-custom-toggler');
	let hopeui_script_menu_toggler_btn = document.querySelectorAll('.hopeui_style-menu-toggle')

	let hopeui_script_backToTop = document.getElementById("back-to-top");
	let hopeui_script_PrevFocus;

	function hopeui_script_getKeyboardFocusableElements(element = document) {
		return [
			...element.querySelectorAll(
				'a[href], button, input, textarea, select, details,[tabindex]:not([tabindex="-1"])'
			)
		].filter(
			el => !el.hasAttribute('disabled') && !el.getAttribute('aria-hidden')
		)
	}



	Element.prototype.slideUp = function (duration = 300) {
		this.style.transitionProperty = 'height, margin, padding';
		this.style.transitionDuration = duration + 'ms';
		this.style.boxSizing = 'border-box';
		this.style.height = this.offsetHeight + 'px';
		this.offsetHeight;
		this.style.overflow = 'hidden';
		this.style.height = 0;
		this.style.paddingTop = 0;
		this.style.paddingBottom = 0;
		this.style.marginTop = 0;
		this.style.marginBottom = 0;
		window.setTimeout(() => {
			this.style.display = 'none';
			this.style.removeProperty('height');
			this.style.removeProperty('padding-top');
			this.style.removeProperty('padding-bottom');
			this.style.removeProperty('margin-top');
			this.style.removeProperty('margin-bottom');
			this.style.removeProperty('overflow');
			this.style.removeProperty('transition-duration');
			this.style.removeProperty('transition-property');
		}, duration);
	}
	Element.prototype.slideDown = function (duration = 300) {
		this.style.removeProperty('display');
		let display = window.getComputedStyle(this).display;

		if (display === 'none')
			display = 'block';

		this.style.display = display;
		let height = this.offsetHeight;
		this.style.overflow = 'hidden';
		this.style.height = 0;
		this.style.paddingTop = 0;
		this.style.paddingBottom = 0;
		this.style.marginTop = 0;
		this.style.marginBottom = 0;
		this.offsetHeight;
		this.style.boxSizing = 'border-box';
		this.style.transitionProperty = "height, margin, padding";
		this.style.transitionDuration = duration + 'ms';
		this.style.height = height + 'px';
		this.style.removeProperty('padding-top');
		this.style.removeProperty('padding-bottom');
		this.style.removeProperty('margin-top');
		this.style.removeProperty('margin-bottom');
		window.setTimeout(() => {
			this.style.removeProperty('height');
			this.style.removeProperty('overflow');
			this.style.removeProperty('transition-duration');
			this.style.removeProperty('transition-property');
		}, duration);

	}
	Element.prototype.slideToggle = function (duration = 300) {
		if (window.getComputedStyle(this).display === 'none') {
			return this.slideDown(duration);
		} else {
			return this.slideUp(duration);
		}
	}
	Element.prototype.getAllSiblings = function () {
		let children = [...this.parentElement.children];
		return children.filter(child => child !== this);
	}
	/**
	 * Toggle Class From Element 
	 * @function elementClassToggler
	 * @param  {Object.DOM} element Element To Toggle Class
	 * @param  {Array.String} togglerClass Array Of Classes
	 */

	/**
		* elementClassToggler
		* @name Element#elementClassToggler
		* @function
		*/
	Element.prototype.elementClassToggler = function (togglerClass) {
		togglerClass.forEach(e_class => this.classList.toggle(e_class));
	}

	/**
	 * Has Class From Element 
	 * @function elementHasClass
	 * @param  {Object.DOM} element DOM Element To Check has Class
	 * @param  {String} hasClass Class
	 */
	Element.prototype.elementHasClass = function (hasClass, condition_true_fn = false, condition_false_fn = false) { this.classList.contains(hasClass) ? condition_true_fn && condition_true_fn(this) : condition_false_fn && condition_false_fn(this) }

	/**
	 * Closest Class From Element 
	 * @function elementHasClosest
	 * @param  {Object.DOM} element DOM Element To Check has Closest Parent 
	 * @param  {String} selectors Class
	 * @param {function} fn_callback Call function with Closest Element as Argument  when Closest Element is found
	 * @returns {void||false} Return False When Closest Element Not Found
	 */
	Element.prototype.elementHasClosest = function (selector, fn_callback = () => { }) {
		if (this === null) return false;
		let Closest = this.closest(selector);
		return Closest !== 'null' ? fn_callback(Closest) : false;
	}

	/**
	 * Remove And Add Class From Body 
	 * @function hopeui_script_bodyClassToggler
	 * @param  {Array.String} addClass Array Of Class To Append In Body
	 * @param  {Array.String} RemoveClass Array Of Class To Prepand In Body
	 */
	const hopeui_script_bodyClassToggler = (addClass = [], RemoveClass = []) => {
		hopeui_script_elementClassAdd(hopeui_script_bodyClass[0], addClass);
		hopeui_script_elementClassRemove(hopeui_script_bodyClass[0], RemoveClass);
	}

	/**
	 * Add Class From Element 
	 * @function hopeui_script_elementClassAdd
	 * @param  {Object.DOM} element Element To Append Class
	 * @param  {Array.String} togglerClass Array Of Classes 
	 */
	const hopeui_script_elementClassAdd = (element, addClass) => {
		addClass.forEach(e_class => element.classList.add(e_class));
	}

	/**
	 * Remove Class From Element 
	 * @function hopeui_script_elementClassRemove
	 * @param  {Object.DOM} element Element To Prepand Class
	 * @param  {Array.String} togglerClass Array Of Classes  
	 */
	const hopeui_script_elementClassRemove = (element, removeClass) => {
		removeClass.forEach(e_class => element?.classList?.remove(e_class));
	}

	Element.prototype.getSiblings = function () {
		// for collecting siblings
		let siblings = [];
		// if no parent, return no sibling
		if (!this.parentNode) {
			return siblings;
		}
		// first child of the parent node
		let sibling = this.parentNode.firstChild;
		// collecting siblings
		while (sibling) {
			if (sibling.nodeType === 1 && sibling !== this) {
				siblings.push(sibling);
			}
			sibling = sibling?.nextSibling;
		}
		return siblings;
	};


	if (hopeui_script_backToTop !== null && hopeui_script_backToTop !== undefined) {
		let hopeui_script_backToTopHandler = () => {
			hopeui_script_backToTop.style.opacity = document.documentElement.scrollTop > 150 ? "1" : "0";
		}
		window.addEventListener('scroll', (e) => hopeui_script_backToTopHandler());
		hopeui_script_backToTopHandler();
		// scroll body to 0px on click
		document.querySelector('#top').addEventListener('click', (e) => {
			e.preventDefault()
			window.scrollTo({
				top: 0,
				behavior: 'smooth'
			});
		});
	}


	window.addEventListener('resize', function () {

		if (window.outerWidth > 1200) {
			hopeui_script_bodyClass[0].elementHasClass("overflow-hidden", (e) => {
				hopeui_script_elementClassRemove(e, ["overflow-hidden"]);
			})
		} else {
			hopeui_script_navBarToggler !== null && hopeui_script_navBarToggler.elementHasClass("moblie-menu-active", (e) => {
				hopeui_script_elementClassAdd(hopeui_script_bodyClass[0], ["overflow-hidden"]);
			})
		}

	});

	/*------------------------
	 main menu toggle
	--------------------------*/

	hopeui_script_menu_toggler_btn.forEach(btn => {
		btn.addEventListener('click', function (e) {
			this.setAttribute('aria-dropdown', this.getAttribute('aria-dropdown') == "false");
			this.closest('.hopeui_style-menu-item-wrapper')?.nextElementSibling?.elementClassToggler(['active'])
		})
	})

	document.querySelectorAll('.navbar-nav a ,.navbar-nav button').forEach(item => {
		item.addEventListener('focus', function (event) {
			if (typeof hopeui_script_PrevFocus !== "undefined") {
				let _thisFocus = this.closest('.sub-menu.active');
				let prevClosestFocus = hopeui_script_PrevFocus.closest('.sub-menu.active');
				if (prevClosestFocus !== null && !prevClosestFocus?.isSameNode(_thisFocus)) {
					if (_thisFocus === null) {
						hopeui_script_elementClassRemove(prevClosestFocus, ['active'])
					} else {
						if (!prevClosestFocus?.isSameNode(_thisFocus) && _thisFocus.parentElement.closest('.sub-menu.active') === null) {
							hopeui_script_elementClassRemove(prevClosestFocus, ['active'])
						}
					}
				}
			}
			hopeui_script_PrevFocus = this;
		})
	})

	const navBarTogglerEvent = (element) => {
		element.addEventListener('click', (event) => {
			if (window.outerWidth < 1200) { hopeui_script_bodyClassToggler(["overflow-hidden"]) }
			document.querySelector('.hopeui_style-mobile-menu').elementClassToggler(["menu-open"]);
			hopeui_script_navBarToggler.elementClassToggler(["is-active"]);
		});
	}

	const customTogglerEvent = (e) => {
		e.addEventListener('click', (event) => {
			closeMenu();
		});
	}
	const closeMenu = () => {
		if (window.outerWidth < 1200) { hopeui_script_elementClassRemove(hopeui_script_bodyClass[0], ["overflow-hidden"]) }
		hopeui_script_elementClassRemove(document.querySelector('.hopeui_style-mobile-menu'), ["menu-open"]);
		hopeui_script_navBarToggler?.elementClassToggler(["is-active"]);
	}
	hopeui_script_navBarToggler && navBarTogglerEvent(hopeui_script_navBarToggler);
	hopeui_script_customToggler && customTogglerEvent(hopeui_script_customToggler);

	document.documentElement.addEventListener('click', (event) => {
		if (event.target.closest('.hopeui_style-mobile-menu.menu-open') === null) {
			closeMenu();
		}
	}, true);

	// Close modal on escape key press.
	document.addEventListener('keydown', function (event) {
		if (event.keyCode === 27) {
			event.preventDefault();
			closeMenu();
		}
	}.bind(this));


	jQuery(window).on('load', function (e) {

		/*------------------------
		Page Loader
		--------------------------*/
		jQuery("#load").fadeOut();
		jQuery("#loading").delay(0).fadeOut("slow");

		/*---------------------------
		Vertical Menu
		---------------------------*/

		const mobileMenu = document.querySelector('nav.mobile-menu .top-menu');
		mobileMenu?.addEventListener('click', (e) => {
			let target = e.target;
			if (target.elementHasClosest('a')) e.preventDefault();
			let getLink = target.getAttribute('href');
			let checkClass = ("#" == getLink || "javascript:void(0)" == getLink) ? "a" : ".hopeui_style-menu-toggle";
			target.elementHasClosest(checkClass, (closestElement) => {
				closestElement !== null && closestElement.elementHasClosest('li', (closestLI) => {
					e.preventDefault();
					closestLI.getSiblings().forEach(function (item) {
						if (item.classList.contains('active')) {
							item.querySelector('.hopeui_style-menu-toggle').click();
						}
					})
					closestLI.classList.toggle('active');
					closestLI.querySelector('.sub-menu').slideToggle();
				});
			});
		});

		// let mobileMenuFocusableElement = hopeui_script_getKeyboardFocusableElements(document.querySelector('.hopeui_style-mobile-menu'));

		// document.querySelector('.hopeui_style-mobile-menu').addEventListener('transitionstart', function (e) {
		// 	if (document.querySelector(":focus")?.closest('.hopeui_style-mobile-menu') === null) {
		// 		if(e.target == mobileMenuFocusableElement[mobileMenuFocusableElement.length - 1] || e.target == this){
		// 			mobileMenuFocusableElement[0].focus();
		// 		}else{
		// 			mobileMenuFocusableElement[mobileMenuFocusableElement.length - 1].focus();
		// 		}
		// 	}
		// })
	});


	const input_quantity_fn = () => {
		document.querySelectorAll('button.plus, button.minus').forEach(item => {
			item.addEventListener('click', function () {
				document.querySelector('button[name="update_cart"]')?.removeAttribute('disabled');
				var qty = this.closest('.quantity').querySelector('.qty');
				if (qty.value == '') {
					qty.value = 0;
				}
				var val = parseFloat(qty.value);
				var max = parseFloat(qty.getAttribute('max'));
				var min = parseFloat(qty.getAttribute('min'));
				var step = parseFloat(qty.getAttribute('step'));
				if (this.classList.contains('plus')) {
					if (max && (max <= val)) {
						qty.value = max;
					} else {
						qty.value = val + step;
					}
				} else {
					if (min && (min >= val)) {
						qty.value = min;
					} else if (val >= 1) {
						qty.value = val - step;
					}
				}
			});
		});
	}
	input_quantity_fn();
	jQuery(document).on('updated_cart_totals', input_quantity_fn);

	jQuery(document).on("click", function (event) {
		var jQuerytrigger = jQuery(".dropdown-menu-mini-cart");
		if (jQuerytrigger !== event.target && !jQuerytrigger.has(event.target).length) {
			jQuery(".dropdown-menu-mini-cart").collapse('hide');
		}
	});


	jQuery(document).ready(function () {
		/*------------------------
			Search Bar
		--------------------------*/
		if (jQuery(".btn-search").length > 0) {
			jQuery(document).on('click', '.btn-search', function () {
				jQuery(this).parent().find('.hopeui_style-search').toggleClass('search--open');
			});
			jQuery(document).on('click', '.btn-search-close', function () {
				jQuery(this).closest('.hopeui_style-search').toggleClass('search--open');
			});
		}

		/*-----------------------------------------------------------------------
								Select2 
		-------------------------------------------------------------------------*/
		if (jQuery('select').length > 0) {
			jQuery('select').each(function () {
				jQuery(this).select2({
					width: '100%',
				});
			});
			jQuery('.select2-container').addClass('wide');
		}

	});

}(jQuery));