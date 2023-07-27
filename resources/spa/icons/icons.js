/* import the fontawesome core */
import {library} from '@fortawesome/fontawesome-svg-core';

/* import specific icons */
import {
    faUserSecret,
    faSignInAlt,
    faHome,
    faUser,
    faSignOutAlt,
    faBars,
    faTimes,
    faCaretDown,
    faChevronUp,
    faCaretRight,
    faChevronLeft,
    faChevronRight,
    faAngleDoubleLeft,
    faAngleDoubleRight,
    faSearch,
    faPlus,
    faMinus,
    faTrash,
    faPencilAlt,
    faQuestionCircle, faDashboard
} from '@fortawesome/free-solid-svg-icons';

/* add icons to the library */
library.add(
    faUserSecret, faSearch, faSignInAlt, faSignOutAlt, faHome, faUser, faBars, faTimes, faCaretDown,
    faCaretRight, faChevronUp, faChevronLeft, faChevronRight, faAngleDoubleLeft, faAngleDoubleRight,
    faPlus, faMinus, faTrash, faPencilAlt, faQuestionCircle, faDashboard
);

export default library;
