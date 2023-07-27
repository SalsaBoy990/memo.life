import Alpine from 'alpinejs';
import {data} from "./clean/modules/data";
import {dropdownData} from "./clean/modules/dropdownData";
import {offCanvasMenuData} from "./clean/modules/offCanvasMenuData";


window.Alpine = Alpine;

Alpine.data('data', data);
Alpine.data('dropdownData', dropdownData);
Alpine.data('offCanvasMenuData', offCanvasMenuData);

Alpine.start();






