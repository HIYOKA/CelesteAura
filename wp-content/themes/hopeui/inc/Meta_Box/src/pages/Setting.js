import { PanelBody, PanelRow } from '@wordpress/components';
import Tab from 'react-bootstrap/Tab';
import Tabs from 'react-bootstrap/Tabs';
import RadioButton from '../components/RadioButton';
import "./../assets/css/tab.css";
import { __ } from '@wordpress/i18n';
import single_img from './../assets/images/single-column.png';
import default_img from './../assets/images/default.png';
import left_sidebar from './../assets/images/left-side.png';
import right_sidebar from './../assets/images/right-side.png';
import { compose } from "@wordpress/compose";
import { withSelect, withDispatch } from "@wordpress/data";
import { __experimentalHeading as Heading, ColorPalette } from '@wordpress/components';
import { useState } from '@wordpress/element';


function Setting({ postType, postMeta, setPostMeta }) {

    const [showPageContainer, setshowPageContainer] = useState(postMeta?.page_container_source === "custom")
    const [color, setColor] = useState(postMeta?.hopeui_php_page_bg_color)
    const colors = [
        { name: __('Primary', 'hopeui'), color: '#f9f9f9' },
        { name: __('Secondary', 'hopeui'), color: '#f1f3f5' },
        { name: __('Light', 'hopeui'), color: '#f7f7f7' },
    ];

    const page_structure = [
        {
            slug: 'default',
            img_url: default_img,
            title: __('Default','hopeui') 
        },
        {
            slug: 'no_sidebar',
            img_url: single_img,
            title: __('No SideBar','hopeui') 
        },
        {
            slug: 'left_sidebar',
            img_url: left_sidebar,
            title: __('Left SideBar','hopeui')
        },
        {
            slug: 'right_sidebar',
            img_url: right_sidebar,
            title: __('Right SideBar','hopeui')
        },
    ];
    const page_container_source = [
        {
            slug: 'inherit',
            title: __('Inherit', 'hopeui')
        },
        {
            slug: 'custom',
            title: __('Custom', 'hopeui')
        },
    ];
    const page_container = [
        {
            slug: 'container',
            title: __('Container', 'hopeui')
        },
        {
            slug: 'fluid',
            title: __('Full Width', 'hopeui')
        },
    ];

    const setPagestructureSetting = (value) => {
        setPostMeta({ page_structure: value });
    }


    return (
        <PanelRow >
            <div className='hopeui-tab tab-bottom-bordered' style={{width:"100%"}} >
                <label>{__('Page Structure', 'hopeui')}</label>
                <Tabs
                    defaultActiveKey="structure"
                    transition={false}
                    id="hopeui-pagesetting"
                    className="m-0 justify-content-between"
                >
                    <Tab eventKey="structure" title="Structure" className='tab-bottom-bordered'>
                        <RadioButton buttonsList={page_structure} onChange={(val) => {
                            setPagestructureSetting(val)
                        }}
                            defaultValue={postMeta.page_structure}
                            showImg={true}
                            name={"page_structure"}
                        />
                        <Heading>{__('Page Container', 'hopeui')}</Heading>
                        <RadioButton buttonsList={page_container_source} onChange={(val) => {
                            setPostMeta({ page_container_source: val });
                            setshowPageContainer(val == 'custom')

                        }}
                            defaultValue={postMeta.page_container_source}
                            showImg={false}
                            showTitle={true}
                            name={"page_container_source"}

                        />
                        {showPageContainer && (
                            <RadioButton buttonsList={page_container} onChange={(val) => {
                                setPostMeta({ page_container: val });
                            }}
                                className={'fade'}
                                defaultValue={postMeta.page_container}
                                showImg={false}
                                showTitle={true}
                                name={"page_container"}
                            />
                        )}

                    </Tab>

                    <Tab eventKey="style" title={__("Style", 'hopeui')}>
                        <ColorPalette
                            colors={colors}
                            value={color}
                            onChange={(color) => {
                                setColor(color);
                                setPostMeta({hopeui_php_page_bg_color:color});
                            }}
                        />
                    </Tab>
                </Tabs>
            </div>
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
])(Setting);