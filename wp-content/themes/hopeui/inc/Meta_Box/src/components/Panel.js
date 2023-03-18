import { __ } from '@wordpress/i18n';
import { Dashicon } from '@wordpress/components';
import { useContext } from '@wordpress/element';
import './../assets/css/panel.css';
import { PanelContext } from '../hooks/PanelContext';
export default function Panel(props) {

    const { panelContext, setpanelContext } = useContext(PanelContext);
    const openPanel = (e) => {
        setpanelContext({ children: props.children, title: props.title })
    }


    props.hasToggler = true;
    return (
        <div className="hopeui-panel-component" >
            <header>
                <label onClick={openPanel}>{__("Page Banner", 'hopeui')}</label>
            </header>
            {
                props?.hasToggler && (
                    <section>
                        <div>
                            <span onClick={openPanel}>
                                <Dashicon icon="arrow-right-alt2" style={{ fontSize: '1em' }} className={'hopeui-dashicon'} />
                            </span>
                        </div>
                    </section>
                )
            }

        </div>
    )
}
