<?php

/**
 * HopeUI\Utility\Customizer\WP_Customize_Control class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Customizer\WP_Custom_Control;

use HopeUI\Utility\Customizer\HopeUI_Customize_Control;
use function HopeUI\Utility\hopeui;

/**
 * WP_Typography
 *
 * @version 1.0.0
 */
class WP_Typography extends HopeUI_Customize_Control
{
	/**
	 * @var string $type Controls Type
	 */
	public $type = 'hopeui_php_typography';

	/**
	 * The list of Google Fonts
	 */
	private $fontList = false;
	/**
	 * The saved font values decoded from json
	 */
	private $fontValues = [];
	/**
	 * The index of the saved font within the list of Google fonts
	 */
	private $fontListIndex = 0;
	/**
	 * The number of fonts to display from the json file. Either positive integer or 'all'. Default = 'all'
	 */
	private $fontCount = 'all';
	/**
	 * The font list sort order. Either 'alpha' or 'popular'. Default = 'alpha'
	 */
	private $fontOrderBy = 'alpha';
	/**
	 * Get our list of fonts from the json file
	 */
	public function __construct($manager, $id, $args = array(), $options = array())
	{
		parent::__construct($manager, $id, $args);
		// Get the font sort order
		if (isset($this->input_attrs['orderby']) && strtolower($this->input_attrs['orderby']) === 'popular') {
			$this->fontOrderBy = 'popular';
		}
		// Get the list of Google fonts
		if (isset($this->input_attrs['font_count'])) {
			if ('all' != strtolower($this->input_attrs['font_count'])) {
				$this->fontCount = (abs((int) $this->input_attrs['font_count']) > 0 ? abs((int) $this->input_attrs['font_count']) : 'all');
			}
		}
		$this->fontList = $this->hopeui_php_getGoogleFonts('all');
		// Decode the default json font value
		$this->fontValues = json_decode($this->value());
		// Find the index of our default font within our list of Google fonts
		$this->fontListIndex = $this->hopeui_php_getFontIndex($this->fontList, !empty($this->fontValues->font) ?  $this->fontValues->font : '');
	}
	/**
	 * Enqueue our scripts and styles
	 */
	public function enqueue()
	{
		wp_enqueue_script('hopeui_style-select2-js', get_parent_theme_file_uri('assets/js/select2.min.js'), array('jquery'), hopeui()->get_asset_version(get_parent_theme_file_uri('assets/js/select2.min.js')), true);
		wp_enqueue_style('hopeui_style-select2-css', get_parent_theme_file_uri('assets/css/select2.min.css'), array(), hopeui()->get_asset_version(get_parent_theme_file_uri('assets/css/select2.min.css')), 'all');
	}
	/**
	 * Export our List of Google Fonts to JavaScript
	 */
	public function to_json()
	{
		parent::to_json();
		$this->json['hopeui_scriptfontslist'] = $this->fontList;
	}
	/**
	 * Render the control in the customizer
	 */
	public function render_content()
	{
		$fontCounter = 0;
		$isFontInList = false;
		$fontListStr = '';

		if (!empty($this->fontList)) {
?>
			<div class="hopeui_style-typography">
				<div class="hopeui_style-typography-control-title">
					<?php if (!empty($this->label)) { ?>
						<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
					<?php } ?>
					<?php if (!empty($this->description)) { ?>
						<span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
					<?php } ?>
				</div>

				<span class="dashicons dashicons-edit hopeui_style-typography-dropdown-button"></span>
			</div>


			<div class="google_fonts_select_control hopeui_style-typography-dropdown">

				<input type="hidden" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($this->value()); ?>" class="customize-control-google-font-selection" <?php $this->link(); ?> />
				<div class="hopeui_style-font-family-wrapper">
					<div class="customize-control-title"><?php esc_html_e('Select Font Family', 'hopeui') ?></div>
					<div class="google-fonts">
						<select class="google-fonts-list" control-name="<?php echo esc_attr($this->id); ?>">
							<?php
							foreach ($this->fontList as $key => $value) {
								$fontCounter++;
								$fontListStr .= '<option value="' . $value->family . '" ' . selected($this->fontValues->font, $value->family, false) . '>' . $value->family . '</option>';
								if ($this->fontValues->font === $value->family) {
									$isFontInList = true;
								}
								if (is_int($this->fontCount) && $fontCounter === $this->fontCount) {
									break;
								}
							}
							if (!$isFontInList && $this->fontListIndex) {
								$fontListStr = '<option value="' . $this->fontList[$this->fontListIndex]->family . '" ' . selected($this->fontValues->font, $this->fontList[$this->fontListIndex]->family, false) . '>' . $this->fontList[$this->fontListIndex]->family . ' (default)</option>' . $fontListStr;
							}
							echo wp_kses($fontListStr,array('option'=>array('value'=>true)));
							?>
						</select>
					</div>
				</div>
				<div class="hopeui_style-weight-wrapper">
					<div class="customize-control-title"><?php esc_html_e('Select Font Weight', 'hopeui') ?> </div>
					<div class="weight-style">
						<select class="google-fonts-boldweight-style">
							<?php
							$optionCount = 0;
							foreach ($this->fontList[$this->fontListIndex]->variants as $key => $value) {
								// Only add options that aren't italic
								if (strpos($value, 'italic') === false) {
									echo '<option value="' . esc_attr($value) . '" ' . selected($this->fontValues->boldweight, $value, false) . '>' . esc_html($value) . '</option>';
									$optionCount++;
								}
							}
							// This should never evaluate as there'll always be at least a 'regular' weight
							if ($optionCount == 0) {
								echo '<option value="">Not Available for this font</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="hopeui_style-regularweight-wrapper">
					<div class="customize-control-title"><?php esc_html_e('Select Font Style', 'hopeui') ?></div>
					<div class="weight-style">
						<select class="google-fonts-regularweight-style">
							<?php
							if (in_array("italic", $this->fontList[$this->fontListIndex]->variants)) { ?>
								<option value="italic"><?php esc_html_e('Italic', 'hopeui') ?></option>
								<option value="normal"><?php esc_html_e('Normal', 'hopeui') ?></option>
							<?php  } else {
							?>
								<option value="normal"><?php esc_html_e('Normal', 'hopeui') ?></option>
							<?php
							} ?>

						</select>
					</div>
				</div>

				<div class="google-fonts-size-wrapper">
					<span class="customize-control-title"><?php echo esc_html('Text Size', 'hopeui'); ?></span>
					<div class="hopeui_style-input-text-control-wrapper">
						<input type="number" class="google-fonts-size" value="<?php echo esc_attr(str_replace($this->input_attrs['size']['unit'], '', $this->fontValues->size)); ?>" data-unit="<?php echo esc_attr($this->input_attrs['size']['unit']) ?>">
						<span class="unit"><?php echo esc_html($this->input_attrs['size']['unit']) ?></span>
					</div>
				</div>
				<input type="hidden" class="google-fonts-category" value="<?php echo esc_attr($this->fontValues->category) ?>">
			</div>
<?php
		}
	}

	/**
	 * Find the index of the saved font in our multidimensional array of Google Fonts
	 */
	public function hopeui_php_getFontIndex($haystack, $needle)
	{
		foreach ($haystack as $key => $value) {
			if ($value->family == $needle) {
				return $key;
			}
		}
		return false;
	}

	/**
	 * Return the list of Google Fonts from our json file. Unless otherwise specfied, list will be limited to 30 fonts.
	 */
	public function hopeui_php_getGoogleFonts($count = 30)
	{
		// Google Fonts json generated from https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=YOUR-API-KEY
		$fontFile = get_template_directory_uri() . '/assets/google-fonts/google-fonts-alphabetical.json';
		if ($this->fontOrderBy === 'popular') {
			$fontFile = get_template_directory_uri() . '/assets/google-fonts/google-fonts-popularity.json';
		}
		$request = wp_remote_get($fontFile);
		if (is_wp_error($request)) {
			return "";
		}

		$body = wp_remote_retrieve_body($request);
		$content = json_decode($body);

		if ($count == 'all') {
			return $content->items;
		} else {
			return array_slice($content->items, 0, $count);
		}
	}
}
