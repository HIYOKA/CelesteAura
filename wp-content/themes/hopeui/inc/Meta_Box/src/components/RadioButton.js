import Figure from 'react-bootstrap/Figure';
import ToggleButton from 'react-bootstrap/ToggleButton';
import ToggleButtonGroup from 'react-bootstrap/ToggleButtonGroup';
import 'bootstrap/dist/css/bootstrap-grid.min.css';
import { OverlayTrigger, Tooltip } from 'react-bootstrap';

export default function RadioButton({ showTitle, showImg, buttonsList, name, ...props }, state) {
    return (
        <ToggleButtonGroup type="radio"
            size={'lg'}
            {...props}
            name
        >
            {buttonsList.map((item, key) => (

                <ToggleButton id={name + "-check-" + key} value={item['slug']} className={showImg ? "p-0 w-50 hopeui-img-btn" : "p-0 w-50"} 
                >
                    {showImg && (
                        <OverlayTrigger
                            key={name + "-check-" + key}
                            placement={'top'}
                            overlay={
                                <Tooltip>
                                    <strong>{item['title']}</strong>
                                </Tooltip>
                            }

                        >
                            <Figure.Image src={item['img_url']} />
                        </OverlayTrigger>

                    )}
                    {showTitle && (
                        <span>
                            {item['title']}
                        </span>
                    )}
                </ToggleButton>

            ))
            }
        </ToggleButtonGroup >
    )
}