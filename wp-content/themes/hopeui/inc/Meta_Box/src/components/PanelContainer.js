import { useState } from '@wordpress/element';
import { PanelContext } from '../hooks/PanelContext';
import Button from 'react-bootstrap/Button';
import { Dashicon } from '@wordpress/components';

export default function PanelContainer({ children }) {

    const [panelContext, setpanelContext] = useState(false);
    return (
        <PanelContext.Provider value={{ panelContext, setpanelContext }} >

            <div className={panelContext !== false ? ' hopeui-panel-open hopeui-panel-container ' : 'hopeui-panel-container '}
                style={{ transition: 'transform 0.2s ease-in-out' }}
            >
                {children}
            </div>
            {panelContext && (
                <div className="panel-wrapper hopeui_style-hopeui-panel-body">
                    <div class="hopeui-panel-actions">
                        <Button variant="secondary" size="sm" className={"components-button "} onClick={() => {
                            setpanelContext(false);
                        }}>
                            <Dashicon icon="arrow-left-alt2" style={{ fontSize: '1em' }} className={'hopeui-dashicon'} />
                            <label className={'m-0'}>{panelContext.title}</label>
                        </Button>
                    </div>
                    <div className="hopeui-panel-options">
                        {panelContext.children}
                    </div>

                </div>
            )}

        </PanelContext.Provider>
    )
}
