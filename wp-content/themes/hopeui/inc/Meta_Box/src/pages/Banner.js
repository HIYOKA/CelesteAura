import { PanelRow } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import Panel from '../components/Panel';
import { compose } from "@wordpress/compose";
import { withSelect, withDispatch } from "@wordpress/data";
import RadioButton from '../components/RadioButton';
import { useState } from '@wordpress/element';

function Banner({ postType, postMeta, setPostMeta }) {

    const [isCustomBanner, setisCustomBanner] = useState(postMeta.page_banner == 'custom')
    const page_banner_option = [
        {
            slug: 'inherit',
            title: __('Inherit', 'hopeui')
        },
        {
            slug: 'disable',
            title: __('Disable', 'hopeui')
        },

    ];

    return (
        <PanelRow>
            <Panel title={__('Page Banner', 'hopeui')}>
                <div>
                    <RadioButton buttonsList={page_banner_option} onChange={(val) => {
                        setPostMeta({ page_banner: val });
                        setisCustomBanner(val == 'custom')
                    }}
                        defaultValue={postMeta.page_banner}
                        showImg={false}
                        showTitle={true}
                        name={"page_banner"}

                    />
                </div>
            </Panel>
        </PanelRow>
    )
}

export default compose([
    withSelect((select) => {
        return {
            postMeta: select('core/editor').getEditedPostAttribute('meta'),
            postType: select('core/editor').getCurrentPostType(),
        };
    }),
    withDispatch((dispatch) => {
        return {
            setPostMeta(newMeta) {
                dispatch('core/editor').editPost({ meta: newMeta });
            }
        };
    })
])(Banner);