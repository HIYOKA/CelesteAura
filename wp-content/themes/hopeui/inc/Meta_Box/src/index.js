import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';
import { registerPlugin } from '@wordpress/plugins';
import { __ } from '@wordpress/i18n';
import Setting from './pages/Setting';
import Banner from './pages/Banner';
import PanelContainer from './components/PanelContainer';
import { Fragment } from '@wordpress/element';
import { withSelect } from "@wordpress/data";
import HopeUISVG from './components/HopeUISVG';

function HopeUIPageSettings({ postType }) {
	if (postType != 'page') return null;
	return (
		<Fragment>
			<PluginSidebarMoreMenuItem target="hopeui-page-setting">HopeUI Page Settings</PluginSidebarMoreMenuItem>
			<PluginSidebar name="hopeui-page-setting" title="Page Settings" icon={<HopeUISVG />}>
				<PanelContainer>
					<div className={'hopeui_style-hopeui-panel-body'}>
						<Banner />
						<Setting />
					</div>
				</PanelContainer>
			</PluginSidebar>
		</Fragment>
	);
}


const HopeUIPageSettingswithSelect = withSelect((select) => {
	return {
		postType: select('core/editor').getCurrentPostType(),
	}
})(HopeUIPageSettings)

registerPlugin('hopeui', {
	render: HopeUIPageSettingswithSelect,
});